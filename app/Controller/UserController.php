<?php

class UserController extends AppController {
    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->Security->validatePost = false;
        $this->Security->csrfCheck = false;
    }

    /**
     * ユーザー検索
     */
    public function index() {
        $offset = 1;
        $limit = 20;
        $page = 1;
        $word = '';
        $order = null;
        
        // パンくず
        $breadcrumbs = array(
            array('title' => 'ユーザー検索')
        );

        // 検索ワード
        if (array_key_exists('word', $this->request->query)) {
            $word = $this->request->query['word'];
        }

        // 検索位置
        if (array_key_exists('page', $this->request->query)) {
            $page = $this->request->query['page'];
            $offset = ($page - 1) * 20 + 1;
        }

        // 並び順
        if (array_key_exists('order', $this->request->query)) {
            $order = $this->request->query['order'];
        }

        $total = 0;
        $users = array();
        $detail = array();
        if (is_numeric($word)) {
            // ユーザー詳細
            $userDetailResponse = Admin::userDetail($word);
            if (!$userDetailResponse || !$userDetailResponse->isSuccess()) {
                if ($userDetailResponse->getStatus() != 404) {
                    $this->setErrMsg('ユーザー検索エラー');
                }
            }
            else {
                $total = 1;
                $users = array($this->formatObject($userDetailResponse->getData()['admin_tool']['user']));
                $detail = $this->formatObject($userDetailResponse->getData()['admin_tool']['user']);
            }
        }

        // ユーザー一覧
        $userConditionsListResponse = Admin::userConditionsList(null, null, null, null, null, $word, null, $offset, $limit, $order);
        if (!$userConditionsListResponse || !$userConditionsListResponse->isSuccess()) {
            $this->setErrMsg('ユーザー検索エラー');
        }
        else {
            $total += $userConditionsListResponse->getData()['admin_tool']['total'];
            foreach ($userConditionsListResponse->getData()['admin_tool']['users'] as $user) {
                if (!empty($detail)) {
                    if ($detail['id'] != $user['id']) {
                        $users[] = $this->formatObject($user);
                    }
                    else {
                        --$total;
                    }
                }
                else {
                    $users[] = $this->formatObject($user);
                }
            }
        }

        $this->set(compact('breadcrumbs', 'total', 'users', 'offset', 'limit', 'word', 'order', 'page'));
    }

    /**
     * ユーザー詳細
     */
    public function detail() {
        $userId = $this->request->params['id'];
        // ユーザー詳細
        $userDetailResponse = Admin::userDetail($userId);
        if (!$userDetailResponse || !$userDetailResponse->isSuccess()) {
            $this->setErrMsg('ユーザー検索エラー');
        }

        $user = $userDetailResponse->getData()['admin_tool']['user'];

        // パンくず
        $breadcrumbs = array(
            array('url' => AdminUrl::userSearch(), 'title' => 'ユーザー検索'),
            array('title' => $user['nickname']),
        );
        
        $this->set(compact('breadcrumbs', 'user'));
    }
    
    /**
     * メッセージ送信
     */
    public function message() {
        $subject = '';
        $message = '';
        
        
        $userId = $this->request->params['id'];
        // ユーザー詳細
        $userDetailResponse = Admin::userDetail($userId);
        if (!$userDetailResponse || !$userDetailResponse->isSuccess()) {
            $this->setErrMsg('ユーザー検索エラー');
        }

        $user = $userDetailResponse->getData()['admin_tool']['user'];

        if ($this->request->isPost()) {
            $data = $this->request->data;
            
            $subject = $data['message_subject'];
            $message = $data['message_body'];
            $createMessageResponse = Admin::createMessage($data['id'], $subject, $message);
            if (!$createMessageResponse || !$createMessageResponse->isSuccess()) {
                $this->setErrMsg('メッセージ送信エラー');
            }
            else {
                $this->redirect(AdminUrl::userDetail($user));
            }
        }
        
        // パンくず
        $breadcrumbs = array(
            array('url' => AdminUrl::userSearch(), 'title' => 'ユーザー検索'),
            array('url' => AdminUrl::userDetail($user['id']), 'title' => $user['nickname']),
            array('title' => 'メッセージ送信'),
        );

        $this->set(compact('breadcrumbs', 'user', 'subject', 'message'));
    }
}
?>