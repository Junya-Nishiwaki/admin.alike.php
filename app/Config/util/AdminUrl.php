<?php
/**
 * PCサイトのURL生成ユーティリティ
 * 
 * @package util
 */
class AdminUrl {

    /**
     * ダッシュボードURL取得
     * @return string
     */
    public static function dashBoard() {
        return self::urlBaseSsl() . self::url(array('controller' => 'dashboard', 'action' => 'index'));
    }

    /**
     * 契約店舗一覧URL取得
     * @param string $searchType_ 表示タイプ(all:全て/wait_activate:アクティベート待ち店舗/activate:アクティベーション済店舗)
     * @return string
     */
    public static function contractList($searchType_ = 'all') {
        return self::urlBaseSsl() . self::url(array('controller' => 'contract', 'action' => 'index', '?' => array('search_type' => $searchType_)));
    }

    /**
     * 契約店舗詳細URL取得
     * @param array $tenant_ 店舗情報
     * @return string
     */
    public static function contractDetail($tenant_) {
        return self::urlBaseSsl() . self::url(array('controller' => 'contract', 'action' => 'detail', 'id' => $tenant_['id']));
    }

    /**
     * 契約店舗アクティベーションURL取得
     * @param array $tenant_ 店舗情報
     * @return string
     */
    public static function contractActivate($tenant_) {
        return self::urlBaseSsl() . self::url(array('controller' => 'contract', 'action' => 'activate', 'id' => $tenant_['id']));
    }

    /**
     * 代理店一覧URL取得
     * @return string
     */
    public static function agencyList() {
        return self::urlBaseSsl() . self::url(array('controller' => 'agency', 'action' => 'index'));
    }

    /**
     * 代理店詳細URL取得
     * @return string
     */
    public static function agencyDetail($agency_) {
        return self::urlBaseSsl() . self::url(array('controller' => 'agency', 'action' => 'detail', 'id' => $agency_['id']));
    }

    /**
     * お知らせ一覧URL取得
     * @return string
     */
    public static function informationList() {
        return self::urlBaseSsl() . self::url(array('controller' => 'information', 'action' => 'index'));
    }

    /**
     * お知らせ詳細URL取得
     * @return string
     */
    public static function informationDetail($information_) {
        return self::urlBaseSsl() . self::url(array('controller' => 'information', 'action' => 'detail', 'id' => $information_['id']));
    }

    /**
     * お知らせ追加URL取得
     * @return string
     */
    public static function informationAdd() {
        return self::urlBaseSsl() . self::url(array('controller' => 'information', 'action' => 'add'));
    }

    /**
     * お知らせ編集URL取得
     * @return string
     */
    public static function informationEdit($information_) {
        return self::urlBaseSsl() . self::url(array('controller' => 'information', 'action' => 'edit', 'id' => $information_['id']));
    }

    /**
     * お知らせ削除URL取得
     * @return string
     */
    public static function informationDelete($information_) {
        return self::urlBaseSsl() . self::url(array('controller' => 'information', 'action' => 'delete', 'id' => $information_['id']));
    }

    /**
     * かっトク一覧URL取得
     * @return string
     */
    public static function kattoqList($word_ = null, $page_ = null, $order_ = null, $conditions_ = null) {
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
        
        return self::urlBaseSsl() . self::url(array('controller' => 'kattoq', 'action' => 'index', '?' => $params));
    }

    /**
     * かっトククーポン詳細URL取得
     * @return string
     */
    public static function kattoqDetail($kattoq_, $query_ = null) {
        $params = array();

        if ($query_) {
            $params = $query_;
        }

        return self::urlBaseSsl() . self::url(array('controller' => 'kattoq', 'action' => 'detail', 'id' => $kattoq_['id'], '?' => $params));
    }

    /**
     * ユーザー検索URL取得
     * @return string
     */
    public static function userSearch($word_ = null, $order_ = null, $page_ = null) {
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
        
        return self::urlBaseSsl() . self::url(array('controller' => 'user', 'action' => 'index', '?' => $params));
    }

    /**
     * ユーザー詳細URL取得
     * @return string
     */
    public static function userDetail($user_) {
        return self::urlBaseSsl() . self::url(array('controller' => 'user', 'action' => 'detail', 'id' => $user_['id']));
    }

    /**
     * ステマ疑惑ユーザー一覧URL取得
     * @return string
     */
    public static function stealthMarketingList() {
        return self::urlBaseSsl() . self::url(array('controller' => 'user', 'action' => 'stealth_marketing'));
    }

    /**
     * ダイレクトメール一覧URL取得
     * @return string
     */
    public static function directmailList() {
        return self::urlBaseSsl() . self::url(array('controller' => 'directmail', 'action' => 'index'));
    }

    /**
     * ダイレクトメール詳細URL取得
     * @return string
     */
    public static function directmailDetail($directmail_) {
        return self::urlBaseSsl() . self::url(array('controller' => 'directmail', 'action' => 'detail', 'id' => $directmail_['id']));
    }

    /**
     * ダイレクトメール追加URL取得
     * @return string
     */
    public static function directmailAdd() {
        return self::urlBaseSsl() . self::url(array('controller' => 'directmail', 'action' => 'add'));
    }

    /**
     * ダイレクトメール更新URL取得
     * @return string
     */
    public static function directmailUpdate($directmail_) {
        return self::urlBaseSsl() . self::url(array('controller' => 'directmail', 'action' => 'update', 'id' => $directmail_['id']));
    }

    /**
     * ダイレクトメール削除URL取得
     * @return string
     */
    public static function directmailDelete($directmail_) {
        return self::urlBaseSsl() . self::url(array('controller' => 'directmail', 'action' => 'delete', 'id' => $directmail_['id']));
    }

    /**
     * 店舗検索URL取得
     * @return string
     */
    public static function tenantSearch($word_ = null, $page_ = null) {
        $params = array();
        if (!empty($word_)) {
            $params['word'] = $word_;
        }
        if (!empty($page_)) {
            $params['page'] = $page_;
        }
        
        return self::urlBaseSsl() . self::url(array('controller' => 'tenant', 'action' => 'index', '?' => $params));
    }

    /**
     * 店舗詳細URL取得
     * @return string
     */
    public static function tenantDetail($tenant_) {
        return self::urlBaseSsl() . self::url(array('controller' => 'tenant', 'action' => 'detail', 'id' => $tenant_['id']));
    }

    /**
     * 店舗編集URL取得
     * @return string
     */
    public static function tenantEdit($tenant_) {
        return self::urlBaseSsl() . self::url(array('controller' => 'tenant', 'action' => 'edit', 'id' => $tenant_['id']));
    }

    /**
     * 店舗閉店URL取得
     * @return string
     */
    public static function tenantClose($tenant_) {
        return self::urlBaseSsl() . self::url(array('controller' => 'tenant', 'action' => 'close', 'id' => $tenant_['id']));
    }

    /**
     * 店舗削除URL取得
     * @return string
     */
    public static function tenantDelete($tenant_) {
        return self::urlBaseSsl() . self::url(array('controller' => 'tenant', 'action' => 'delete', 'id' => $tenant_['id']));
    }

    /**
     * 重複店舗一覧URL取得
     * @return string
     */
    public static function duplicationTenantList() {
        return self::urlBaseSsl() . self::url(array('controller' => 'tenant', 'action' => 'duplication'));
    }

    /**
     * NGワードクリップ一覧URL取得
     * @return string
     */
    public static function ngWordClipList() {
        return self::urlBaseSsl() . self::url(array('controller' => 'clip', 'action' => 'ng_word'));
    }

    /**
     * メッセージ送信URL取得
     * @return string
     */
    public static function message($user_) {
        return self::urlBaseSsl() . self::url(array('controller' => 'user', 'action' => 'message', 'id' => $user_['id']));
    }

    /**
     * ここからAjax
     */
    public static function userConditionsList() {
        return self::urlBaseSsl() . self::url(array('controller' => 'ajax', 'action' => 'user_conditions_list'));
    }
    
    public static function ajaxTenantSearch() {
        return self::urlBaseSsl() . self::url(array('controller' => 'ajax', 'action' => 'tenant_search'));
    }
    
    public static function ajaxGetClipList() {
        return self::urlBaseSsl() . self::url(array('controller' => 'ajax', 'action' => 'get_clip_list'));
    }
    
    /**
     * URL生成
     * 
     * @param   string      $url_       URL
     * @param   boolean     $full_      true:完全なURL/false:ドメイン以下
     * @return  string                  URL
     */
	private static function url($url = null, $full = false) {
		return h(Router::url($url, $full));
	}

    /**
     * URLベース
     * 
     * @return  string      URL
     */
    private static function urlBase() {
        return 'http://' . env('SERVER_NAME');
    }

    /**
     * URLベース(SSL)
     * 
     * @return  string      URL
     */
    private static function urlBaseSsl() {
        return 'https://' . env('SERVER_NAME');
    }
}
?>
