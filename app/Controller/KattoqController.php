<?php

class KattoqController extends AppController {
    public function beforeFilter() {
        parent::beforeFilter();

        $this->Security->validatePost = false;
        $this->Security->csrfCheck = false;
    }

    /**
     * かっトククーポン一覧
     */
    public function index() {
        $offset = 1;
        $limit = 20;
        $page = 1;
        $word = '';
        $order = Admin::GETLISTKATTOQ_ORDER_IMPORT_NEW;
        $conditions = array();
        $categoryId = null;
        $editState = null;
        $query = $this->request->query;
        
        // パンくず
        $breadcrumbs = array(
            array('title' => 'かっトククーポン一覧')
        );

        // 検索ワード
        if (array_key_exists('word', $query)) {
            $word = $query['word'];
        }

        // 検索位置
        if (array_key_exists('page', $query)) {
            $page = $query['page'];
            $offset = ($page - 1) * $limit + 1;
        }

        // 並び替え
        if (array_key_exists('order', $query)) {
            $order = $query['order'];
        }
        
        // 絞り込み
        if (array_key_exists('conditions', $query)) {
            $conditions = preg_split('/,/', $query['conditions']);
            foreach ($conditions as $condition) {
                if (preg_match('/^c_\d/', $condition)) {
                    $categoryId = preg_replace('/^c_/', '', $condition);
                }
                if (preg_match('/^s_\d/', $condition)) {
                    $editState = preg_replace('/^s_/', '', $condition);
                }
            }
        }
        
        $total = 0;
        $kattoqs = array();
        // かっトククーポン一覧
        $getListKattoqResponse = Admin::getListKattoq($word, $offset, $limit, $order, $categoryId, $editState);
        if (!$getListKattoqResponse || !$getListKattoqResponse->isSuccess()) {
            $this->setErrMsg('かっトククーポン取得エラー');
        }
        else {
            $total = $getListKattoqResponse->getData()['admin_tool']['total'];
            foreach ($getListKattoqResponse->getData()['admin_tool']['kattoqs'] as $kattoq) {
                $kattoqs[] = $this->formatObject($kattoq);
            }
        }

        $this->set(compact('breadcrumbs', 'total', 'kattoqs', 'offset', 'limit', 'word', 'page', 'order', 'conditions', 'query'));
    }

    /**
     * かっトククーポン詳細
     */
    public function detail() {
        $kattoqId = $this->request->params['id'];
        $query = $this->request->query;
        
        // 更新
        if ($this->request->isPost()) {
            $data = $this->request->data;
            
            $updateKattoqResponse = Admin::updateKattoq($kattoqId, $data['tenant_id'], $data['activated'] == 1, $data['orig_title'], $data['orig_use_option'], $data['orig_note'], $data['memo']);
            if (!$updateKattoqResponse || !$updateKattoqResponse->isSuccess()) {
                $this->setErrMsg('かっトククーポン更新エラー');
            }
        }
        
        // クーポン詳細
        $detailKattoqResponse = Admin::detailKattoq($kattoqId);
        if (!$detailKattoqResponse || !$detailKattoqResponse->isSuccess()) {
            $this->setErrMsg('かっトククーポン詳細取得エラー');
        }

        $kattoq = $this->formatObject($detailKattoqResponse->getData()['admin_tool']['kattoq']);

        // パンくず
        $breadcrumbs = array(
            array('url' => AdminUrl::kattoqList(), 'title' => 'かっトククーポン一覧'),
            array('title' => $kattoq['orig_title']),
        );
        
        $this->set(compact('breadcrumbs', 'kattoq', 'query'));
    }
    
    /**
     * 店舗紐付け
     */
    public function tenant_search() {
        $this->autoLayout = false;
        
        if (array_key_exists('id', $this->request->query)) {
            $detailResponse = Admin::detail($this->request->query['id']);
            if (!$detailResponse || !$detailResponse->isSuccess()) {
                $this->setErrMsg('店舗詳細取得エラー');
            }
            
            $this->set(array('tenant' => $this->formatObject($detailResponse->getData()['tenant'])));
        }
    }
}
?>