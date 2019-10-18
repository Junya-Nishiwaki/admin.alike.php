<?php
/**
 * PCサイトのURL生成ユーティリティ
 * 
 * @package util
 */
class PcUrl {
    /**
     * 店舗ページURL取得
     * @param array $tenant_ 店舗情報
     * @return string
     */
    public static function tenantPcSite($tenant_) {
        return self::urlBase(getDomain($tenant_['category']['id'])) . '/area/' . $tenant_['areas'][0]['name_en'] . '/' . $tenant_['areas'][1]['id'] . '/' . $tenant_['areas'][2]['id'] . '/' . $tenant_['id'];
    }
    
    /**
     * クリップ詳細ページURL取得
     * @param array $clip_ クリップ情報
     * @return string
     */
    public static function clipPcSite($clip_) {
        return self::tenantPcSite($clip_['tenant']) . '/clips/' . $clip_['id'];
    }
    
    /**
     * ユーザーページURL取得
     * @param array $user_ ユーザー情報
     * @return string
     */
    public static function userPcSite($user_) {
        return self::urlBase(DOMAIN_GOURMET) . '/users/' . $user_['id'] . '/profile';
    }
    
    /**
     * ここから店舗ツール
     */
    /**
     * 店舗ツールワンタイムログインページURL取得
     * @param array $tenant_ 店舗情報
     * @return string
     */
    public static function tenantToolOnetimeLogin() {
        return self::urlBaseTenantTool() . '/onetime_login';
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
    private static function urlBase($domain_ = null) {
        return 'http://' . ($domain_ ? $domain_ : DOMAIN_GOURMET);
    }

    /**
     * URLベース(SSL)
     * 
     * @return  string      URL
     */
    private static function urlBaseSsl($domain_ = null) {
        return 'https://' . ($domain_ ? $domain_ : DOMAIN_GOURMET);
    }
    
    /**
     * 店舗ツールベースURL
     */
    private static function urlBaseTenantTool() {
        $pre = ENV == ENV_LOCAL ? 'local.stage-' : (ENV == ENV_STAGE ? 'stage-' : '');
        $url = 'https://tool.' . $pre . 'alike.jp';
        
        return $url;
    }
}
?>
