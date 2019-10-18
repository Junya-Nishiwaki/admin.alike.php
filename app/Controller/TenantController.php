<?php

class TenantController extends AppController {
    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->Security->validatePost = false;
        $this->Security->csrfCheck = false;
    }

    /**
     * 店舗検索
     */
    public function index() {
        $offset = 1;
        $limit = 20;
        $page = 1;
        $word = '';
        
        // パンくず
        $breadcrumbs = [
            ['title' => '店舗検索']
        ];

        // 検索ワード
        if (array_key_exists('word', $this->request->query)) {
            $word = $this->request->query['word'];
        }

        // 検索位置
        if (array_key_exists('page', $this->request->query)) {
            $page = $this->request->query['page'];
            $offset = ($page - 1) * 20 + 1;
        }

        $total = 0;
        $tenants = [];
        $detail = [];
        if (is_numeric($word)) {
            // 店舗詳細
            $detailResponse = Admin::detail($word);
            if (!$detailResponse || !$detailResponse->isSuccess()) {
                if ($detailResponse->getStatus() != 404) {
                    $this->setErrMsg('店舗検索エラー');
                }
            }
            else {
                $total = 1;
                $tenants[] = $this->formatObject($detailResponse->getData()['tenant']);
                $detail = $this->formatObject($detailResponse->getData()['tenant']);
            }
        }

        // 店舗一覧
        $tenantListResponse = Tenant::tenantList(null, null, null, null, null, null, null, null, null, null,
            null, null, null, null, null, $word, null, null, null, $offset, $limit);
        if (!$tenantListResponse || !$tenantListResponse->isSuccess()) {
            $this->setErrMsg('店舗検索エラー');
        }
        else {
            $total += $tenantListResponse->getData()['tenants']['total'];
            foreach ($tenantListResponse->getData()['tenants']['items'] as $tenant) {
                if (!empty($detail)) {
                    if ($detail['id'] != $tenant['id']) {
                        $tenants[] = $this->formatObject($tenant);
                    }
                    else {
                        --$total;
                    }
                }
                else {
                    $tenants[] = $this->formatObject($tenant);
                }
            }
        }

        $this->set(compact('breadcrumbs', 'total', 'tenants', 'offset', 'limit', 'word', 'page'));
    }

    /**
     * 店舗詳細
     */
    public function detail() {
        $tenantId = $this->request->params['id'];
        // 店舗詳細
        $detailResponse = Admin::detail($tenantId);
        if (!$detailResponse || !$detailResponse->isSuccess()) {
            $this->setErrMsg('店舗詳細取得エラー');
        }

        $tenant = $this->formatObject($detailResponse->getData()['tenant']);

        // パンくず
        $breadcrumbs = [
            ['url' => AdminUrl::tenantSearch(), 'title' => '店舗検索'],
            ['title' => $tenant['name']],
        ];
        
        $this->set(compact('breadcrumbs', 'tenant'));
    }
    
    /**
     * 店舗編集
     */
    public function edit() {
        $tenantId = $this->request->params['id'];
        
        if ($this->request->isPost()) {
            $data = $this->request->data;

            $name = getArrayValueFromKey($data, 'name');
            $nameKana = getArrayValueFromKey($data, 'name_kana');
            $categoryId = getArrayValueFromKey($data, 'category');
            $genres = getArrayValueFromKey($data, 'genres');
            $telno = getArrayValueFromKey($data, 'telno');
            $telOpenFlg = getArrayValueFromKey($data, 'tel_open_flg', 'on') === 'on';
            $address1 = getArrayValueFromKey($data, 'address_1');
            $address2 = getArrayValueFromKey($data, 'address_2');
            $lat = getArrayValueFromKey($data, 'lat');
            $lng = getArrayValueFromKey($data, 'lng');
            $url = getArrayValueFromKey($data, 'url');
            $budget1 = getArrayValueFromKey($data, 'budget_1');
            $budget2 = getArrayValueFromKey($data, 'budget_2');
            $budget3 = getArrayValueFromKey($data, 'budget_3');
            $noteHour = getArrayValueFromKey($data, 'note_hour');
            $noteHoliday = getArrayValueFromKey($data, 'note_holiday');
            $situations = getArrayValueFromKey($data, 'situations');

            $budgetTypes = [];
            $budgetIds = [];
            switch ($categoryId) {
                case CATEGORY_GOURMET:
                    if ($budget1) {
                        $budgetTypes[] = BUDGET_TYPE_LUNCH;
                        $budgetIds[] = $budget1;
                    }
                    if ($budget2) {
                        $budgetTypes[] = BUDGET_TYPE_DINNER;
                        $budgetIds[] = $budget2;
                    }
                    if ($budget3) {
                        $budgetTypes[] = BUDGET_TYPE_OTHER;
                        $budgetIds[] = $budget3;
                    }
                    break;
                case CATEGORY_BEAUTY:
                    if ($budget1) {
                        $budgetTypes[] = BUDGET_TYPE_BEAUTY;
                        $budgetIds[] = $budget1;
                    }
                    break;
                case CATEGORY_HOTEL:
                    if ($budget1) {
                        $budgetTypes[] = BUDGET_TYPE_DAY;
                        $budgetIds[] = $budget1;
                    }
                    if ($budget2) {
                        $budgetTypes[] = BUDGET_TYPE_STAY;
                        $budgetIds[] = $budget2;
                    }
                    break;
            }

            $updateResponse = Tenant::update($tenantId, ModelBase::ACCESS_TOKEN, $name, $nameKana, $address1, $address2, $lat, $lng, $telno, $telOpenFlg,
                                                $categoryId, $genres, $noteHour, $noteHoliday, $situations, $url, $budgetTypes, $budgetIds, Tenant::STATUS_NORMAL);
            if (!$updateResponse || !$updateResponse->isSuccess()) {
                $this->setErrMsg('店舗更新エラー');
            }
        }
        
        // 店舗詳細
        $detailResponse = Admin::detail($tenantId);
        if (!$detailResponse || !$detailResponse->isSuccess()) {
            $this->setErrMsg('店舗詳細取得エラー');
        }
        $tenant = $this->formatObject($detailResponse->getData()['tenant']);

        // ジャンルマスタ
        $getGenresResponse = Master::getGenres($tenant['category']['id']);
        if (!$getGenresResponse || !$getGenresResponse->isSuccess()) {
            $this->setErrMsg('ジャンルマスタ取得エラー');
        }
        $genreMasters = [];
        foreach ($getGenresResponse->getData()['genres']['items'][0]['genres'] as $genre) {
            $genreMasters[] = $this->formatObject($genre);
        }
        
        // 予算マスタ
        $getBudgetResponse = Master::getBudgets($tenant['category']['id']);
        if (!$getBudgetResponse || !$getBudgetResponse->isSuccess()) {
            $this->setErrMsg('予算マスタ取得エラー');
        }
        $budgetMasters = [];
        foreach ($getBudgetResponse->getData()['budgets']['items'][0]['budgets'] as $budget) {
            $budgetMasters[] = $this->formatObject($budget);
        }

        // パンくず
        $breadcrumbs = [
            ['url' => AdminUrl::tenantSearch(), 'title' => '店舗検索'],
            ['url' => AdminUrl::tenantDetail($tenant), 'title' => $tenant['name']],
            ['title' => '店舗情報編集'],
        ];

        $this->set(compact('breadcrumbs', 'tenant', 'genreMasters', 'budgetMasters'));
    }
    
    /**
     * 店舗閉店
     */
    public function close() {
        $tenantId = $this->request->params['id'];
        // 店舗詳細
        $detailResponse = Admin::detail($tenantId);
        if (!$detailResponse || !$detailResponse->isSuccess()) {
            $this->setErrMsg('店舗詳細取得エラー');
        }
        $tenant = $this->formatObject($detailResponse->getData()['tenant']);
        // 店舗閉店
        $url = getArrayValueFromKey($tenant, 'url');
        $noteHour = getArrayValueFromKey($tenant, 'note_hour');
        $noteHoliday = getArrayValueFromKey($tenant, 'note_holiday');
        $address2 = getArrayValueFromKey($tenant, 'address_2');
        $nameKana = getArrayValueFromKey($tenant, 'name_kana');
        $genres = [];
        foreach ($tenant['genres'] as $g) {
            $genres[] = $g['id'];
        }
        $situations = [];
        if (array_key_exists('situations', $tenant)) {
            foreach ($tenant['situations']['items'] as $s) {
                $situations[] = $s['id'];
            }
        }
        $budgetIds = [];
        $budgetTypes = [];
        if (array_key_exists('budgets', $tenant)) {
            foreach ($tenant['budgets'] as $budget) {
                $budgetIds = $budget['id'];
                $budgetTypes = $budget['type'];
            }
        }

        $updateResponse = Tenant::update($tenantId, ModelBase::ACCESS_TOKEN, '【閉店】' . $tenant['name'], $nameKana, $tenant['address_1'], $address2, $tenant['lat'], $tenant['lng'],
                                            null, false, $tenant['category']['id'], $genres, $noteHour, $noteHoliday, $situations, $url, $budgetTypes, $budgetIds, Tenant::STATUS_CLOSED);
        if (!$updateResponse || !$updateResponse->isSuccess()) {
            $this->setErrMsg('店舗更新エラー');
        }

        $this->redirect(AdminUrl::tenantDetail($tenant));
    }

    /**
     * 店舗削除
     */
    public function delete() {
        if (!$this->request->isPost()) {
            $this->redirect(AdminUrl::tenantSearch());
        }

        $tenantId = $this->request->params['id'];
        $memo = $this->request->data['tenant_delete_memo'];

        // 店舗削除
        $deleteResponse = Admin::deleteTenant($tenantId, $memo);
        if (!$deleteResponse || !$deleteResponse->isSuccess()) {
            $this->redirect($this->url(['controller' => 'tenant', 'action' => 'detail', 'id' => $tenantId, '?' => ['err_msg' => '店舗削除エラー']]));
        }

        $this->redirect($this->url(['controller' => 'tenant', 'action' => 'index', '?' => ['msg' => '店舗削除完了しました']]));
    }

    /**
     * 店舗地図編集
     */
    public function map() {
        $this->autoLayout = false;
        
        $this->set(['lat' => $this->request->query['lat'], 'lng' => $this->request->query['lng']]);
    }
}
?>