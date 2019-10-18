<?php

/**
 * 店舗ヘルパー
 * @package       app.View.Helper
 */
class TenantHelper extends AppHelper {
    /**
     * 店舗ステータスHTMLコード取得
     * @param array $tenant_ 店舗情報
     * @return string
     */
    public function getStatusHtml($tenant_) {
        $html = '';
        
        switch ($tenant_['status']) {
            case Tenant::STATUS_NORMAL:
                $html = '<span class="label label-success">通常</span>';
                break;
            case Tenant::STATUS_CLOSED:
                $html = '<span class="label label-warning">閉店</span>';
                break;
            case Tenant::STATUS_SUSPEND_BUSINESS:
                $html = '<span class="label>休業</span>';
                break;
            case Tenant::STATUS_MOVED:
                $html = '<span class="label label-info">移転</span>';
                break;
            case Tenant::STATUS_PRIVATE:
                $html = '<span class="label label-inverse">非表示</span>';
                break;
        }
        
        return $html;
    }
}
