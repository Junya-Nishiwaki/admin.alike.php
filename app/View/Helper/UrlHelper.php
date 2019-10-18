<?php

/**
 * URLヘルパー
 * @package       app.View.Helper
 */
class UrlHelper extends AppHelper {

    /**
     * ダッシュボードURL取得
     * @return string
     */
    public function dashBoard() {
        return $this->base() . $this->url(array('controller' => 'dashboard', 'action' => 'index'));
    }

    /**
     * 契約店舗一覧URL取得
     * @param string $searchType_ 表示タイプ(all:全て/wait_activate:アクティベート待ち店舗/activate:アクティベーション済店舗)
     * @return string
     */
    public function contractList($searchType_ = 'all') {
        return $this->base() . $this->url(array('controller' => 'contract', 'action' => 'index', '?' => array('search_type' => $searchType_)));
    }

    /**
     * 契約店舗詳細URL取得
     * @param array $tenant_ 店舗情報
     * @return string
     */
    public function contractDetail($tenant_) {
        return $this->base() . $this->url(array('controller' => 'contract', 'action' => 'detail', 'id' => $tenant_['id']));
    }

    /**
     * 契約店舗アクティベーションURL取得
     * @param array $tenant_ 店舗情報
     * @return string
     */
    public function contractActivate($tenant_) {
        return $this->base() . $this->url(array('controller' => 'contract', 'action' => 'activate', 'id' => $tenant_['id']));
    }

    /**
     * 代理店一覧URL取得
     * @return string
     */
    public function agencyList() {
        return $this->base() . $this->url(array('controller' => 'agency', 'action' => 'index'));
    }

    /**
     * 代理店詳細URL取得
     * @return string
     */
    public function agencyDetail($agency_) {
        return $this->base() . $this->url(array('controller' => 'agency', 'action' => 'detail', 'id' => $agency_['id']));
    }

    /**
     * お知らせ一覧URL取得
     * @return string
     */
    public function informationList() {
        return $this->base() . $this->url(array('controller' => 'information', 'action' => 'index'));
    }

    /**
     * お知らせ詳細URL取得
     * @return string
     */
    public function informationDetail($information_) {
        return $this->base() . $this->url(array('controller' => 'information', 'action' => 'detail', 'id' => $information_['id']));
    }

    /**
     * お知らせ追加URL取得
     * @return string
     */
    public function informationAdd() {
        return $this->base() . $this->url(array('controller' => 'information', 'action' => 'add'));
    }

    /**
     * お知らせ編集URL取得
     * @return string
     */
    public function informationEdit($information_) {
        return $this->base() . $this->url(array('controller' => 'information', 'action' => 'edit', 'id' => $information_['id']));
    }

    /**
     * お知らせ削除URL取得
     * @return string
     */
    public function informationDelete($information_) {
        return $this->base() . $this->url(array('controller' => 'information', 'action' => 'delete', 'id' => $information_['id']));
    }

    /**
     * かっトク一覧URL取得
     * @return string
     */
    public function kattoqList($word_ = null, $page_ = null, $order_ = null, $conditions_ = null) {
        $params = array();
        
        if ($word_) {
            $params['word'] = $word_;
        }
        if ($page_) {
            $params['page'] = $page_;
        }
        if ($order_) {
            $params['order'] = $order_;
        }
        if ($conditions_) {
            if (is_array($conditions_)) {
                $conditionsStr = implode(',', $conditions_);
            }
            else {
                $conditionsStr = $conditions_;
            }
            $params['conditions'] = $conditionsStr;
        }
        
        return $this->base() . $this->url(array('controller' => 'kattoq', 'action' => 'index', '?' => $params));
    }

    /**
     * かっトククーポン詳細URL取得
     * @return string
     */
    public function kattoqDetail($kattoq_, $query_ = null) {
        $params = array();

        if ($query_) {
            $params = $query_;
        }

        return $this->base() . $this->url(array('controller' => 'kattoq', 'action' => 'detail', 'id' => $kattoq_['id'], '?' => $params));
    }

    /**
     * ユーザー検索URL取得
     * @return string
     */
    public function userSearch($word_ = null, $order_ = null, $page_ = null) {
        $params = array();
        if (!empty($word_)) {
            $params['word'] = $word_;
        }
        if (!empty($order_)) {
            $params['order'] = $order_;
        }
        if (!empty($page_)) {
            $params['page'] = $page_;
        }
        
        return $this->base() . $this->url(array('controller' => 'user', 'action' => 'index', '?' => $params));
    }

    /**
     * ユーザー詳細URL取得
     * @return string
     */
    public function userDetail($user_) {
        return $this->base() . $this->url(array('controller' => 'user', 'action' => 'detail', 'id' => $user_['id']));
    }

    /**
     * ステマ疑惑ユーザー一覧URL取得
     * @return string
     */
    public function stealthMarketingList() {
        return $this->base() . $this->url(array('controller' => 'user', 'action' => 'stealth_marketing'));
    }

    /**
     * ダイレクトメール一覧URL取得
     * @return string
     */
    public function directmailList() {
        return $this->base() . $this->url(array('controller' => 'directmail', 'action' => 'index'));
    }

    /**
     * ダイレクトメール詳細URL取得
     * @return string
     */
    public function directmailDetail($directmail_) {
        return $this->base() . $this->url(array('controller' => 'directmail', 'action' => 'detail', 'id' => $directmail_['id']));
    }

    /**
     * ダイレクトメール追加URL取得
     * @return string
     */
    public function directmailAdd() {
        return $this->base() . $this->url(array('controller' => 'directmail', 'action' => 'add'));
    }

    /**
     * ダイレクトメール更新URL取得
     * @return string
     */
    public function directmailUpdate($directmail_) {
        return $this->base() . $this->url(array('controller' => 'directmail', 'action' => 'update', 'id' => $directmail_['id']));
    }

    /**
     * ダイレクトメール削除URL取得
     * @return string
     */
    public function directmailDelete($directmail_) {
        return $this->base() . $this->url(array('controller' => 'directmail', 'action' => 'delete', 'id' => $directmail_['id']));
    }

    /**
     * 店舗検索URL取得
     * @return string
     */
    public function tenantSearch($word_ = null, $page_ = null) {
        $params = array();
        if (!empty($word_)) {
            $params['word'] = $word_;
        }
        if (!empty($page_)) {
            $params['page'] = $page_;
        }
        
        return $this->base() . $this->url(array('controller' => 'tenant', 'action' => 'index', '?' => $params));
    }

    /**
     * 店舗詳細URL取得
     * @return string
     */
    public function tenantDetail($tenant_) {
        return $this->base() . $this->url(array('controller' => 'tenant', 'action' => 'detail', 'id' => $tenant_['id']));
    }

    /**
     * 店舗編集URL取得
     * @return string
     */
    public function tenantEdit($tenant_) {
        return $this->base() . $this->url(array('controller' => 'tenant', 'action' => 'edit', 'id' => $tenant_['id']));
    }

    /**
     * 店舗閉店URL取得
     * @return string
     */
    public function tenantClose($tenant_) {
        return $this->base() . $this->url(array('controller' => 'tenant', 'action' => 'close', 'id' => $tenant_['id']));
    }

    /**
     * 店舗削除URL取得
     * @return string
     */
    public function tenantDelete($tenant_) {
        return $this->base() . $this->url(array('controller' => 'tenant', 'action' => 'delete', 'id' => $tenant_['id']));
    }

    /**
     * 重複店舗一覧URL取得
     * @return string
     */
    public function duplicationTenantList() {
        return $this->base() . $this->url(array('controller' => 'tenant', 'action' => 'duplication'));
    }

    /**
     * NGワードクリップ一覧URL取得
     * @return string
     */
    public function ngWordClipList() {
        return $this->base() . $this->url(array('controller' => 'clip', 'action' => 'ng_word'));
    }

    /**
     * メッセージ送信URL取得
     * @return string
     */
    public function message($user_) {
        return $this->base() . $this->url(array('controller' => 'user', 'action' => 'message', 'id' => $user_['id']));
    }

    /**
     * ここからAjax
     */
    public function userConditionsList() {
        return $this->base() . $this->url(array('controller' => 'ajax', 'action' => 'user_conditions_list'));
    }
    
    public function ajaxTenantSearch() {
        return $this->base() . $this->url(array('controller' => 'ajax', 'action' => 'tenant_search'));
    }
    
    /**
     * ここからPCサイト
     */
    /**
     * 店舗ページURL取得
     * @param array $tenant_ 店舗情報
     * @return string
     */
    public function tenantPcSite($tenant_) {
        return $this->basePcSite($tenant_['category']['id']) . '/area/' . $tenant_['areas'][0]['name_en'] . '/' . $tenant_['areas'][1]['id'] . '/' . $tenant_['areas'][2]['id'] . '/' . $tenant_['id'];
    }
    
    /**
     * クリップ詳細ページURL取得
     * @param array $clip_ クリップ情報
     * @return string
     */
    public function clipPcSite($clip_) {
        return $this->tenantPcSite($clip_['tenant']) . '/clips/' . $clip_['id'];
    }
    
    /**
     * ユーザーページURL取得
     * @param array $user_ ユーザー情報
     * @return string
     */
    public function userPcSite($user_) {
        return $this->basePcSite() . '/users/' . $user_['id'] . '/profile';
    }
    
    /**
     * ここから店舗ツール
     */
    /**
     * 店舗ツールワンタイムログインページURL取得
     * @param array $tenant_ 店舗情報
     * @return string
     */
    public function tenantToolOnetimeLogin() {
        return $this->baseTenantTool() . '/onetime_login';
    }
}
