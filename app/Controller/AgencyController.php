<?php

class AgencyController extends AppController {
    public function beforeFilter() {
        parent::beforeFilter();
    }

    /**
     * 代理店一覧
     */
    public function index() {
        $offset = 1;
        $limit = 20;
        $page = 1;
        $word = '';
        
        // パンくず
        $breadcrumbs = array(
            array('title' => '代理店一覧')
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

        // 代理店一覧
        $getListAgencyResponse = Admin::getListAgency($word, $offset, $limit);
        if (!$getListAgencyResponse || !$getListAgencyResponse->isSuccess()) {
            $this->setErrMsg('代理店一覧取得エラー');
        }
        else {
            $total = $getListAgencyResponse->getData()['admin_tool']['total'];
            $agencies = array();
            foreach ($getListAgencyResponse->getData()['admin_tool']['agencies'] as $agency) {
                $agencies[] = $this->formatObject($agency);
            }
        }
        
        $this->set(compact('breadcrumbs', 'total', 'agencies', 'offset', 'limit', 'word', 'page'));
    }

    /**
     * 代理店詳細
     */
    public function detail() {
        // パンくず
        $breadcrumbs = array(
            array('url' => AdminUrl::agencyList(), 'title' => '代理店一覧'),
            array('title' => '代理店詳細'),
        );
        
        $agencyId = $this->request->params['id'];
        $detailAgencyResponse = Admin::detailAgency($agencyId);
        if (!$detailAgencyResponse || !$detailAgencyResponse->isSuccess()) {
            $this->setErrMsg('代理店詳細取得エラー');
        }
        else {
            $agency = $this->formatObject($detailAgencyResponse->getData()['admin_tool']['agency']);
        }
        
        $this->set(compact('breadcrumbs', 'agency'));
    }

}
?>