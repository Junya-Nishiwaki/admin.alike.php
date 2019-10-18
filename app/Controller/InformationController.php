<?php

class InformationController extends AppController {
    public function beforeFilter() {
        parent::beforeFilter();

        $this->Security->validatePost = false;
        $this->Security->csrfCheck = false;
    }

    /**
     * お知らせ一覧
     */
    public function index() {
        $offset = 1;
        $limit = 20;
        $page = 1;
        $isAll = false;
        $isPc = false;
        $isMobile = false;
        $isSmartPhone = false;
        $isSmartPhoneApp = false;
        $isTenantTool = false;
        $isAgencyTool = false;
        $type = null;
        
        // パンくず
        $breadcrumbs = array(
            array('title' => 'お知らせ一覧')
        );

        // 表示タイプ
        if (array_key_exists('type', $this->request->query)) {
            switch ($this->request->query['type']) {
                case 'all':
                    $isAll = true;
                    $type = null;
                    break;
                case 'pc':
                    $isPc = true;
                    $type = Admin::INFORMATIONTYPE_PC;
                    break;
                case 'mobile':
                    $isMobile = true;
                    $type = Admin::INFORMATIONTYPE_MOBILE;
                    break;
                case 'smartphone':
                    $isSmartPhone = true;
                    $type = Admin::INFORMATIONTYPE_SMARTPHONE;
                    break;
                case 'smartphone_app':
                    $isSmartPhoneApp = true;
                    $type = Admin::INFORMATIONTYPE_SMARTPHONE_APP;
                    break;
                case 'tenant_tool':
                    $isTenantTool = true;
                    $type = Admin::INFORMATIONTYPE_TENANT_TOOL;
                    break;
                case 'agency_tool':
                    $isAgencyTool = true;
                    $type = Admin::INFORMATIONTYPE_AGENCY_TOOL;
                    break;
            }
        }
        else {
            $isAll = true;
            $type = null;
        }
        
        // 検索位置
        if (array_key_exists('page', $this->request->query)) {
            $page = $this->request->query['page'];
            $offset = ($page - 1) * 20 + 1;
        }

        // お知らせ一覧
        $getListInformationResponse = Admin::getListInformation($type, $offset, $limit);
        if (!$getListInformationResponse || !$getListInformationResponse->isSuccess()) {
            $this->setErrMsg('お知らせ一覧取得エラー');
        }
        else {
            $total = $getListInformationResponse->getData()['admin_tool']['total'];
            $informations = array();
            foreach ($getListInformationResponse->getData()['admin_tool']['informations'] as $information) {
                $informations[] = $this->formatObject($information);
            }
        }
        
        $this->set(compact('breadcrumbs', 'total', 'informations', 'offset', 'limit', 'page',
                'isAll', 'isPc', 'isMobile', 'isSmartPhone', 'isSmartPhoneApp', 'isTenantTool', 'isAgencyTool'));
    }

    /**
     * お知らせ詳細
     */
    public function detail() {
        // パンくず
        $breadcrumbs = array(
            array('url' => AdminUrl::informationList(), 'title' => 'お知らせ一覧'),
            array('title' => 'お知らせ詳細'),
        );

        $informationId = $this->request->params['id'];
        $detailInformationResponse = Admin::detailInformation($informationId);
        if (!$detailInformationResponse || !$detailInformationResponse->isSuccess()) {
            $this->setErrMsg('お知らせ詳細取得エラー');
        }
        else {
            $information = $this->formatObject($detailInformationResponse->getData()['admin_tool']['information']);
        }
        
        $this->set(compact('breadcrumbs', 'information'));
    }

    /**
     * お知らせ作成
     */
    public function add() {
        $informationTitle = null;
        $type = null;
        $informationBody = null;
        
        // パンくず
        $breadcrumbs = array(
            array('url' => AdminUrl::informationList(), 'title' => 'お知らせ一覧'),
            array('title' => 'お知らせ作成'),
        );

        if ($this->request->isPost()) {
            $addInformationResponse = Admin::addInformation($this->request->data['information_title'], $this->request->data['information_body'], $this->request->data['type']);
            if (!$addInformationResponse || !$addInformationResponse->isSuccess()) {
                $this->setErrMsg('お知らせ作成エラー');
                $informationTitle = $this->request->data['information_title'];
                $type = $this->request->data['type'];
                $informationBody = $this->request->data['information_body'];
            }
            else {
                // 詳細ページへリダイレクト
                $this->redirect(AdminUrl::informationDetail($addInformationResponse->getData()['admin_tool']['information']));
            }
        }

        $this->set(compact('breadcrumbs', 'informationTitle', 'type', 'informationBody'));
    }
    
    /**
     * お知らせ編集
     */
    public function edit() {
        $informationId = $this->request->params['id'];
        $informationTitle = null;
        $type = null;
        $informationBody = null;
        
        // パンくず
        $breadcrumbs = array(
            array('url' => AdminUrl::informationList(), 'title' => 'お知らせ一覧'),
            array('title' => 'お知らせ編集'),
        );

        if ($this->request->isPost()) {
            $updateInformationResponse = Admin::updateInformation($informationId, $this->request->data['information_title'], $this->request->data['information_body']);
            if (!$updateInformationResponse || !$updateInformationResponse->isSuccess()) {
                $this->setErrMsg('お知らせ更新エラー');
                $informationTitle = $this->request->data['information_title'];
                $type = $this->request->data['type'];
                $informationBody = $this->request->data['information_body'];
            }
            else {
                // 詳細ページへリダイレクト
                $this->redirect(AdminUrl::informationDetail($updateInformationResponse->getData()['admin_tool']['information']));
            }
        }
        else {
            $detailInformationResponse = Admin::detailInformation($informationId);
            if (!$detailInformationResponse || !$detailInformationResponse->isSuccess()) {
                $this->setErrMsg('お知らせ詳細取得エラー');
            }
            else {
                $information = $this->formatObject($detailInformationResponse->getData()['admin_tool']['information']);
                $informationTitle = $information['title'];
                $informationBody = $information['body'];
                $type = $information['type'];
            }
        }
        
        $this->set(compact('breadcrumbs', 'informationTitle', 'type', 'informationBody'));
    }

    /**
     * お知らせ削除
     */
    public function delete() {
        $informationId = $this->request->params['id'];
        $this->autoLayout = false;
        $this->autoRender = false;

        $deleteInformation = Admin::deleteInformation($informationId);
        if (!$deleteInformation || !$deleteInformation->isSuccess()) {
            $this->setErrMsg('お知らせ削除エラー');
        }
        else {
            // 一覧ページへリダイレクト
            $this->redirect(AdminUrl::informationList());
        }
    }
}
?>