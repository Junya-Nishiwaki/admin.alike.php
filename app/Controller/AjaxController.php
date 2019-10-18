<?php

class AjaxController extends AppController {
    public $components = array('RequestHandler');
    public $layout = 'ajax';

    public function beforeFilter() {
        $this->Security->validatePost = false;
        $this->Security->csrfCheck = false;
        
        // Ajax処理では親のbeforeFilterは呼ばない

        // Ajax以外からのアクセスは許可しない
        if (!$this->RequestHandler->isAjax()) {
            exit();
        }

        // デバッグ情報の出力を抑制
        Configure::write('debug', 0);

        $this->view = 'result';
        $result = '';
        $this->set(compact('result'));
    }

    /**
     * ユーザー検索
     */
    public function user_conditions_list() {
        $gender = array_key_exists('gender', $this->request->data) ? $this->request->data['gender'] : null;
        $generation = array_key_exists('generation', $this->request->data) ? $this->request->data['generation'] : null;
        $bloodType = array_key_exists('blood_type', $this->request->data) ? $this->request->data['blood_type'] : null;
        $areaId = array_key_exists('area_id', $this->request->data) ? $this->request->data['area_id'] : null;
        $workId = array_key_exists('work_id', $this->request->data) ? $this->request->data['work_id'] : null;
        $word = array_key_exists('word', $this->request->data) ? $this->request->data['word'] : null;
        $directmailFlg = array_key_exists('directmail_flg', $this->request->data) ? $this->request->data['directmail_flg'] == 1 : null;
        $offset = array_key_exists('offset', $this->request->data) ? $this->request->data['offset'] : null;
        $limit = array_key_exists('limit', $this->request->data) ? $this->request->data['limit'] : null;
        
        $userConditionsListResponse = Admin::userConditionsList($gender, $generation, $bloodType, $areaId, $workId, $word, $directmailFlg, $offset, $limit);
        if (!$userConditionsListResponse || !$userConditionsListResponse->isSuccess()) {
            $result = json_encode(array('result' => 'error'));
        } else {
            $users = array();
            $total = $userConditionsListResponse->getData()['admin_tool']['total'];
            foreach ($userConditionsListResponse->getData()['admin_tool']['users'] as $user) {
                $users[] = $this->formatObject($user);
            }
            
            $result = json_encode(array('result' => 'success', 'total' => $total, 'users' => $users));
        }

        $this->set(compact('result'));
    }
    
    /**
     * 店舗検索
     */
    public function tenant_search() {
        $word = array_key_exists('word', $this->request->data) ? $this->request->data['word'] : null;
        
        $tenantListResponse = Tenant::tenantList(null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, $word, null, null, null, 1, 100);
        if (!$tenantListResponse || !$tenantListResponse->isSuccess()) {
            $result = json_encode(array('result' => 'error'));
        } else {
            $tenants = array();
            foreach ($tenantListResponse->getData()['tenants']['items'] as $tenant) {
                $formatTenant = $this->formatObject($tenant);
                $formatTenant['url'] = PcUrl::tenantPcSite($formatTenant);
                $tenants[] = $formatTenant;
            }
            
            $result = json_encode(array('result' => 'success', 'tenants' => $tenants));
        }

        $this->set(compact('result'));
    }
    
    /**
     * クリップ一覧取得
     */
    public function get_clip_list() {
        $categoryId = array_key_exists('category_id', $this->request->data) ? $this->request->data['category_id'] : null;
        $offset = array_key_exists('offset', $this->request->data) ? $this->request->data['offset'] : null;
        $limit = array_key_exists('limit', $this->request->data) ? $this->request->data['limit'] : null;
        
        $getClipResponse = Admin::getListClip($categoryId, $offset, $limit);
        if (!$getClipResponse || !$getClipResponse->isSuccess()) {
            $result = json_encode(array('result' => 'error'));
        }
        else {
            $clips = array();
            foreach ($getClipResponse->getData()['clips']['items'] as $clip) {
                $formatClip = $this->formatObject($clip);
                $formatClip['options'] = array(
                    'clip_url' => PcUrl::clipPcSite($clip),
                    'user_url' => PcUrl::clipPcSite($clip['user']),
                    'review_comment' => mb_strimwidth(h($clip['review_comment']), 0, 60, '…', 'UTF-8'),
                );
                $clips[] = $formatClip;
            }
            
            $result = json_encode(array('result' => 'success', 'clips' => $clips));
        }

        $this->set(compact('result'));
    }
    
    /**
     * PCサイトベースURL
     * TODO 開発URLと本番URL
     * TODO bootstrapで一本化
     */
    public function basePcSite($categoryId_ = CATEGORY_GOURMET) {
        $url = '';
        switch ($categoryId_) {
            case CATEGORY_GOURMET:
                $url = 'http://local.stage-alike.jp';
                break;
            case CATEGORY_BEAUTY:
                $url = 'http://beauty.local.stage-alike.jp';
                break;
            case CATEGORY_HOTEL:
                $url = 'http://hotel.local.stage-alike.jp';
                break;
        }
        
        return $url;
    }
}
