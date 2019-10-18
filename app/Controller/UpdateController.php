<?php

// use App\Controller\AppController;
// use Cake\Datasource\ConnectionManager;

class UpdateController extends AppController {
  public function beforeFilter() {
      parent::beforeFilter();

      $this->Security->validatePost = false;
      $this->Security->csrfCheck = false;
  }

  public function index() {
    $this->set('tenants', $this->Tenants->find('all'));
  }

  public function edit() {
    $sql = 'update'
    $connection = ConnectionManager::get('default');
  }
}


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
