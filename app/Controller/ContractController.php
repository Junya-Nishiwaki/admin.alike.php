<?php

class ContractController extends AppController {
    public function beforeFilter() {
        parent::beforeFilter();
    }

    /**
     * 契約店舗一覧
     */
    public function index() {
        $isAll = true;
        $isWaitActivate = false;
        $isActivate = false;
        $word = '';
        $offset = 1;
        $limit = 20;
        $page = 1;
        
        // パンくず
        $breadcrumbs = array(
            array('title' => '契約店舗一覧')
        );

        // 表示タイプ
        if (array_key_exists('search_type', $this->request->query)) {
            if ($this->request->query['search_type'] == 'all') {
                $isAll = true;
                $isWaitActivate = $isActivate = false;
            }
            else if ($this->request->query['search_type'] == 'wait_activate') {
                $isWaitActivate = true;
                $isAll = $isActivate = false;
            }
            else if ($this->request->query['search_type'] == 'activate') {
                $isActivate = true;
                $isAll = $isWaitActivate = false;
            }
        }
        
        // 検索ワード
        if (array_key_exists('word', $this->request->query)) {
            $word = $this->request->query['word'];
        }
        
        // 検索位置
        if (array_key_exists('page', $this->request->query)) {
            $page = $this->request->query['page'];
            $offset = ($page - 1) * 20 + 1;
        }

        // 契約店舗一覧
        $type = $isAll ? null :
                ($isWaitActivate ? Admin::GETLISTCONTRACT_WAITACTIVATE :
                ($isActivate ? Admin::GETLISTCONTRACT_ACTIVATE : null));
        $getListContractResponse = Admin::getListContract($type, $offset, $limit, $word);
        if (!$getListContractResponse || !$getListContractResponse->isSuccess()) {
            $this->setErrMsg('契約店舗一覧取得エラー');
        }
        else {
            $getListContractData = $getListContractResponse->getData()['admin_tool'];
            $total = $getListContractData['total'];
            $contracts = array();
            foreach ($getListContractData['tenants'] as $contract) {
                $contracts[] = $this->formatObject($contract);
            }
        }
        
        $this->set(compact('breadcrumbs', 'isAll', 'isWaitActivate', 'isActivate', 'total', 'contracts', 'offset', 'limit', 'word', 'page'));
    }

    /**
     * 契約店舗詳細
     */
    public function detail() {
        // 代理店情報
        $agency = array();
        // 契約者情報
        $contract = array();
        // 店舗情報
        $tenant = array();
        
        // パンくず
        $breadcrumbs = array(
            array('url' => AdminUrl::contractList(), 'title' => '契約店舗一覧'),
            array('title' => '契約店舗詳細'),
        );
        
        $tenantId = $this->request->params['id'];
        $detailContractTenantResponse = Admin::detailContractTenant($tenantId);
        if (!$detailContractTenantResponse || !$detailContractTenantResponse->isSuccess()) {
            $this->setErrMsg('契約店舗詳細取得エラー');
        }
        else {
            $detailContractTenantData = $detailContractTenantResponse->getData()['admin_tool'];
            $agency = $this->formatObject($detailContractTenantData['backoffice']['agency']);
            $contract['backoffice'] = $this->formatObject($detailContractTenantData['backoffice']);
            $contract['contract'] = $this->formatObject($detailContractTenantData['contract']);
            $contract['status'] = $this->formatObject($detailContractTenantData['status']);
            $contract['status_text'] = $this->formatObject($detailContractTenantData['status_text']);
            $tenant = $this->formatObject($detailContractTenantData['tenant']);
        }
        
        $this->set(compact('breadcrumbs', 'agency', 'contract', 'tenant'));
    }

    /**
     * 契約店舗アクティベーション
     */
    public function activate() {
        $this->autoRender = false;
        
        $tenantId = $this->request->params['id'];
        $activateResponse = Admin::activate($tenantId);
        if (!$activateResponse || !$activateResponse->isSuccess()) {
            $this->setErrMsg('契約店舗詳細取得エラー');
        }
        else {
            // 店舗詳細
            $detailResponse = Admin::detail($tenantId);
            if (!$detailResponse || !$detailResponse->isSuccess()) {
                $this->setErrMsg('店舗詳細取得エラー');
            }

            $tenant = $this->formatObject($detailResponse->getData()['tenant']);

            $this->redirect(AdminUrl::contractDetail($tenant));
        }
    }
}
?>