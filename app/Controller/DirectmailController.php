<?php

class DirectmailController extends AppController {
    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->Security->validatePost = false;
        $this->Security->csrfCheck = false;
    }

    /**
     * ダイレクトメール一覧
     */
    public function index() {
        $offset = 1;
        $limit = 20;
        $page = 1;
        
        // パンくず
        $breadcrumbs = array(
            array('title' => 'ダイレクトメール一覧')
        );

        // 検索位置
        if (array_key_exists('page', $this->request->query)) {
            $page = $this->request->query['page'];
            $offset = ($page - 1) * 20 + 1;
        }

        $getListDirectMailResponse = Admin::getListDirectMail($offset, $limit);
        if (!$getListDirectMailResponse || !$getListDirectMailResponse->isSuccess()) {
            $this->setErrMsg('ダイレクトメール一覧取得エラー');
        }
        $total = $getListDirectMailResponse->getData()['admin_tool']['total'];
        $directmails = array();
        foreach ($getListDirectMailResponse->getData()['admin_tool']['directmails'] as $directmail) {
            $directmails[] = $this->formatObject($directmail);
        }

        $this->set(compact('breadcrumbs', 'total', 'directmails', 'offset', 'limit', 'page'));
    }

    /**
     * ダイレクトメール詳細
     */
    public function detail() {
        $directmailId = $this->request->params['id'];

        // ダイレクトメール詳細
        $directmailDetailResponse = Admin::detailDirectMail($directmailId);
        if (!$directmailDetailResponse || !$directmailDetailResponse->isSuccess()) {
            $this->setErrMsg('ダイレクトメール取得エラー');
        }

        $directmail = $this->formatObject($directmailDetailResponse->getData()['admin_tool']['directmail']);
        
        // パンくず
        $breadcrumbs = array(
            array('url' => AdminUrl::directmailList(), 'title' => 'ダイレクトメール一覧'),
            array('title' => $directmail['title']),
        );
        
        // エリア
        $area = null;
        if (!empty($directmail['area_id'])) {
            $getAreasResponse = Master::getAreas();
            if (!$getAreasResponse || !$getAreasResponse->isSuccess()) {
                $this->setErrMsg('エリア取得エラー');
            }
            foreach ($getAreasResponse->getData()['areas']['items'] as $item) {
                if ($item['id'] == $directmail['area_id']) {
                    $area = $item;
                    break;
                }
            }
        }
        
        // 職業
        $work = null;
        if (!empty($directmail['work_id'])) {
            $getWorksResponse = Master::getWorks();
            if (!$getWorksResponse || !$getWorksResponse->isSuccess()) {
                $this->setErrMsg('職業取得エラー');
            }
            foreach ($getWorksResponse->getData()['works']['items'] as $item) {
                if ($item['id'] == $directmail['work_id']) {
                    $work = $item;
                    break;
                }
            }
        }

        $this->set(compact('breadcrumbs', 'directmail', 'area', 'work'));
    }
    
    /**
     * ダイレクトメール作成
     */
    public function add() {
        $gender = '';
        $generation = '';
        $bloodType = '';
        $areaId = '';
        $workId = '';
        $title = '';
        $body = '';
        
        if ($this->request->isPost()) {
            $data = $this->request->data;

            $year = sprintf('%04d', $data['year']);
            $month = sprintf('%02d', $data['month']);
            $day = sprintf('%02d', $data['day']);
            $hour = sprintf('%02d', $data['hour']);
            $minute = sprintf('%02d', $data['minute']);
            $gender = $data['gender'];
            $generation = $data['generation'];
            $bloodType = $data['blood_type'];
            $areaId = $data['area_id'];
            $workId = $data['work_id'];
            $title = $data['directmail_title'];
            $body = $data['directmail_body'];

            $addDirectmailResponse = Admin::addDirectMail($title, $body, date('YmdHis', strtotime($year . $month . $day . $hour . $minute . '00')), $gender, $generation, $bloodType, $areaId, $workId);
            if (!$addDirectmailResponse || !$addDirectmailResponse->isSuccess()) {
                $this->setErrMsg('ダイレクトメール作成エラー');
            }
            else {
                $this->redirect(AdminUrl::directmailDetail($addDirectmailResponse->getData()['admin_tool']['directmail']));
            }
        }

        // パンくず
        $breadcrumbs = array(
            array('url' => AdminUrl::directmailList(), 'title' => 'ダイレクトメール一覧'),
            array('title' => 'ダイレクトメール作成'),
        );

        $getAreasResponse = Master::getAreas();
        if (!$getAreasResponse || !$getAreasResponse->isSuccess()) {
            $this->setErrMsg('エリア取得エラー');
        }
        $areas = array();
        foreach ($getAreasResponse->getData()['areas']['items'] as $area) {
            $areas[] = $this->formatObject($area);
        }
        
        $getWorkResponse = Master::getWorks();
        if (!$getWorkResponse || !$getWorkResponse->isSuccess()) {
            $this->setErrMsg('職業取得エラー');
        }
        $works = array();
        foreach ($getWorkResponse->getData()['works']['items'] as $work) {
            $works[] = $this->formatObject($work);
        }
        
        $userConditionsListResponse = Admin::userConditionsList($gender, $generation, $bloodType, $areaId, $workId, null, true, 1, 1, Admin::USERCONDITIONSLIST_ORDER_LATEST);
        if (!$userConditionsListResponse || !$userConditionsListResponse->isSuccess()) {
            $this->setErrMsg('ユーザー数取得エラー');
        }
        $userConditionsNum = $userConditionsListResponse->getData()['admin_tool']['total'];
        
        $this->set(compact('breadcrumbs', 'sendTime', 'gender', 'generation', 'bloodType', 'areaId', 'workId', 'title', 'body', 'areas', 'works', 'userConditionsNum'));
    }

    /**
     * ダイレクトメール更新
     */
    public function update() {
        $directmailId = $this->request->params['id'];
        
        if ($this->request->isPost()) {
            $data = $this->request->data;

            $year = sprintf('%04d', $data['year']);
            $month = sprintf('%02d', $data['month']);
            $day = sprintf('%02d', $data['day']);
            $hour = sprintf('%02d', $data['hour']);
            $minute = sprintf('%02d', $data['minute']);
            $gender = $data['gender'];
            $generation = $data['generation'];
            $bloodType = $data['blood_type'];
            $areaId = $data['area_id'];
            $workId = $data['work_id'];
            $title = $data['directmail_title'];
            $body = $data['directmail_body'];

            $updateDirectmailResponse = Admin::updateDirectMail($directmailId,
                    $title, $body, date('YmdHis', strtotime($year . $month . $day . $hour . $minute . '00')), $gender, $generation, $bloodType, $areaId, $workId);
            if (!$updateDirectmailResponse || !$updateDirectmailResponse->isSuccess()) {
                $this->setErrMsg('ダイレクトメール更新エラー');
            }
            else {
                $this->redirect(AdminUrl::directmailDetail($updateDirectmailResponse->getData()['admin_tool']['directmail']));
            }
        }

        // ダイレクトメール詳細
        $directmailDetailResponse = Admin::detailDirectMail($directmailId);
        if (!$directmailDetailResponse || !$directmailDetailResponse->isSuccess()) {
            $this->setErrMsg('ダイレクトメール取得エラー');
        }

        $directmail = $this->formatObject($directmailDetailResponse->getData()['admin_tool']['directmail']);
        
        // パンくず
        $breadcrumbs = array(
            array('url' => AdminUrl::directmailList(), 'title' => 'ダイレクトメール一覧'),
            array('url' => AdminUrl::directmailDetail($directmail), 'title' => $directmail['title']),
            array('title' => 'ダイレクトメール編集'),
        );
        
        $gender = $directmail['gender'];
        $generation = $directmail['generation'];
        $bloodType = $directmail['blood_type'];
        $areaId = $directmail['area_id'];
        $workId = $directmail['work_id'];
        $title = $directmail['title'];
        $body = $directmail['body'];
        $year = date('Y', strtotime($directmail['send_order_time']));
        $month = date('m', strtotime($directmail['send_order_time']));
        $day = date('d', strtotime($directmail['send_order_time']));
        $hour = date('H', strtotime($directmail['send_order_time']));
        $minute = date('i', strtotime($directmail['send_order_time']));

        $getAreasResponse = Master::getAreas();
        if (!$getAreasResponse || !$getAreasResponse->isSuccess()) {
            $this->setErrMsg('エリア取得エラー');
        }
        $areas = array();
        foreach ($getAreasResponse->getData()['areas']['items'] as $area) {
            $areas[] = $this->formatObject($area);
        }
        
        $getWorkResponse = Master::getWorks();
        if (!$getWorkResponse || !$getWorkResponse->isSuccess()) {
            $this->setErrMsg('職業取得エラー');
        }
        $works = array();
        foreach ($getWorkResponse->getData()['works']['items'] as $work) {
            $works[] = $this->formatObject($work);
        }

        $userConditionsListResponse = Admin::userConditionsList($gender, $generation, $bloodType, $areaId, $workId, null, true, 1, 1, Admin::USERCONDITIONSLIST_ORDER_LATEST);
        if (!$userConditionsListResponse || !$userConditionsListResponse->isSuccess()) {
            $this->setErrMsg('ユーザー数取得エラー');
        }
        $userConditionsNum = $userConditionsListResponse->getData()['admin_tool']['total'];
        
        $this->set(compact('breadcrumbs', 'sendTime', 'gender', 'generation', 'bloodType', 'areaId', 'workId', 'title', 'body', 'areas', 'works', 'userConditionsNum',
                                'year', 'month', 'day', 'hour', 'minute'));
    }
    
    /**
     * ダイレクトメール削除
     */
    public function delete() {
        $directmailId = $this->request->params['id'];
        $this->autoLayout = false;
        $this->autoRender = false;

        $deleteDirectmailResponse = Admin::deleteDirectMail($directmailId);
        if (!$deleteDirectmailResponse || !$deleteDirectmailResponse->isSuccess()) {
            $this->setErrMsg('ダイレクトメール削除エラー');
        }
        else {
            // 一覧ページへリダイレクト
            $this->redirect(AdminUrl::directmailList());
        }
    }
 }
?>