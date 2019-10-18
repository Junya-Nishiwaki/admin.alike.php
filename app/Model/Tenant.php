<?php

/**
 * 店舗系API
 *
 * @package Model
 */
App::uses('ModelBase', 'Model');

class Tenant extends ModelBase {
    /** エンドポイント */
    const ENDPOINT = 'tenant/%s';
    
    /** 店舗一覧取得ソート：評価順 */
    const TENANT_LIST_SORT_RATING = 1;
    /** 店舗一覧取得ソート：クリップ数順 */
    const TENANT_LIST_SORT_CLIP = 2;
    /** 店舗一覧取得ソート：距離の近い順 */
    const TENANT_LIST_SORT_DISTANCE = 3;
    /** 店舗一覧取得ソート：おすすめ順 */
    const TENANT_LIST_SORT_RECOMMEND = 4;
    /** 店舗一覧取得ソート：ジャンル順 */
    const TENANT_LIST_SORT_GENRE = 5;
    /** 店舗一覧取得ソート：エリア順 */
    const TENANT_LIST_SORT_AREA = 6;

    /** 店舗ステータス：通常 */
    const STATUS_NORMAL = 1;
    /** 店舗ステータス：閉店 */
    const STATUS_CLOSED = 2;
    /** 店舗ステータス：休業 */
    const STATUS_SUSPEND_BUSINESS = 3;
    /** 店舗ステータス：移転 */
    const STATUS_MOVED = 4;
    /** 店舗ステータス：非表示 */
    const STATUS_PRIVATE = 999;
    
    /**
     * 店舗一覧取得
     * @param string $token_ アクセストークン
     * @param array $categoryId_ カテゴリID
     * @param string $genreType_ ジャンル種別
     * @param array $genreId_ ジャンルID
     * @param int $areaId_ エリアID
     * @param int $lineId_ 路線ID
     * @param int $stationId_ 駅ID
     * @param int $budgetType_ 予算種別
     * @param int $budgetId_ 予算ID
     * @param array $situations_ シチュエーション・サービス
     * @param float $lat_ 緯度
     * @param float $lng_ 経度
     * @param int $range_ 指定位置からの範囲
     * @param string $tel_ 電話番号
     * @param string $wordArea_ 検索ワード(エリア・駅)
     * @param string $wordFree_ 検索ワード(フリー)
     * @param boolean $myFlg_ true:マイクリップを含める/false:含めない
     * @param boolean $couponFlg_ true:クーポン有りのみ/false:クーポン有無無視
     * @param int $sort_ ソート
     * @param int $offset_ オフセット
     * @param int $limit_ 取得最大数
     * @return array 店舗数情報
     */
    static public function tenantList($token_, $categoryId_, $genreType_, $genreId_, $areaId_, $lineId_, $stationId_, $budgetType_, $budgetId_, $situations_,
            $lat_, $lng_, $range_, $tel_, $wordArea_, $wordFree_, $myFlg_, $couponFlg_, $sort_, $offset_, $limit_) {
        // 必須項目
        $params = array();
        // オプション項目
        self::addOptionalParam($params, 'token', $token_);
        self::addOptionalParam($params, 'category_id', $categoryId_);
        self::addOptionalParam($params, 'genre_type', $genreType_);
        self::addOptionalParam($params, 'genre_id', $genreId_);
        self::addOptionalParam($params, 'area_id', $areaId_);
        self::addOptionalParam($params, 'line_id', $lineId_);
        self::addOptionalParam($params, 'station_id', $stationId_);
        self::addOptionalParam($params, 'budget_type', $budgetType_);
        self::addOptionalParam($params, 'budget_id', $budgetId_);
        self::addOptionalParam($params, 'situations', $situations_);
        self::addOptionalParam($params, 'lat', $lat_);
        self::addOptionalParam($params, 'lng', $lng_);
        self::addOptionalParam($params, 'range', $range_);
        self::addOptionalParam($params, 'tel', $tel_);
        self::addOptionalParam($params, 'word_area', urlencode($wordArea_));
        self::addOptionalParam($params, 'word_free', urlencode($wordFree_));
        // TODO そのうち削除
        self::addOptionalParam($params, 'my_flg', $myFlg_);
        self::addOptionalParam($params, 'coupon_flg', $couponFlg_);
        self::addOptionalParam($params, 'sort', $sort_);
        self::addOptionalParam($params, 'offset', $offset_);
        self::addOptionalParam($params, 'limit', $limit_);

        return self::get(sprintf(self::ENDPOINT, 'list/search'), $params);
    }
    
    /**
     * 店舗登録
     * @param string $token_ アクセストークン
     * @param string $name_ 店舗名
     * @param string $nameKana_ 店舗名カナ
     * @param string $address_1_ 住所1
     * @param string $address_2_ 住所2(建物名など)
     * @param float $lat_ 緯度
     * @param float $lng_ 経度
     * @param string $telno_ 電話番号
     * @param boolean $telOpenFlg_ true:電話番号公開/false:電話番号非公開
     * @param int $categoryId_ カテゴリID
     * @param array $genreId_ ジャンルID
     * @param string $noteHour_ 営業時間
     * @param string $noteHoliday_ 休業日
     * @param array $situations_ シチュエーション・サービス
     * @param string $url_ ホームページ
     * @return array 店舗情報
     */
    static public function add($token_, $name_, $nameKana_, $address_1_, $address_2_, $lat_, $lng_, $telno_, $telOpenFlg_, $categoryId_, $genreId_,
            $noteHour_, $noteHoliday_, $situations_, $url_) {
        // 必須項目
        $params = array(
            'token' => $token_,
            'name' => urlencode($name_),
            'address_1' => urlencode($address_1_),
            'lat' => $lat_,
            'lng' => $lng_,
            'category_id' => $categoryId_,
            'genre_id' => implode(',', $genreId_)
        );
        // オプション項目
        self::addOptionalParam($params, 'name_kana', urlencode($nameKana_));
        self::addOptionalParam($params, 'address_2', urlencode($address_2_));
        self::addOptionalParam($params, 'situations', $situations_);
        self::addOptionalParam($params, 'telno', $telno_);
        self::addOptionalParam($params, 'tel_open_flg', $telOpenFlg_);
        self::addOptionalParam($params, 'note_hour', urlencode($noteHour_));
        self::addOptionalParam($params, 'note_holiday', urlencode($noteHoliday_));
        self::addOptionalParam($params, 'url', urlencode($url_));
        
        return self::post(preg_replace('/\/\%s/', '', self::ENDPOINT), $params);
    }
    
    /**
     * 店舗更新
     * @param   int         $tenantId_          店舗ID
     * @param   string      $token_             アクセストークン
     * @param   string      $name_              店舗名
     * @param   string      $nameKana_          店舗名カナ
     * @param   string      $address_1_         住所1
     * @param   string      $address_2_         住所2(建物名など)
     * @param   float       $lat_               緯度
     * @param   float       $lng_               経度
     * @param   string      $telno_             電話番号
     * @param   boolean     $telOpenFlg_        true:電話番号公開/false:電話番号非公開
     * @param   int         $categoryId_        カテゴリID
     * @param   array       $genreId_           ジャンルID
     * @param   string      $noteHour_          営業時間
     * @param   string      $noteHoliday_       休業日
     * @param   array       $situations_        シチュエーション・サービス
     * @param   string      $url_               ホームページ
     * @param   array       $budgetTypes_       予算種別
     * @param   array       $budgetIds_         予算ID
     * @param   int         $status_            ステータス
     * @return  array                           店舗情報
     */
    static public function update($tenantId_, $token_, $name_, $nameKana_, $address_1_, $address_2_, $lat_, $lng_, $telno_, $telOpenFlg_, $categoryId_, $genreId_,
            $noteHour_, $noteHoliday_, $situations_, $url_, $budgetTypes_, $budgetIds_, $status_) {
        // 必須項目
        $params = array(
            'token' => $token_,
            'name' => urlencode($name_),
            'address_1' => urlencode($address_1_),
            'lat' => $lat_,
            'lng' => $lng_,
            'category_id' => $categoryId_,
        );
        // オプション項目
        self::addOptionalParam($params, 'name_kana', urlencode($nameKana_));
        self::addOptionalParam($params, 'address_2', urlencode($address_2_));
        self::addOptionalParam($params, 'situations', $situations_);
        self::addOptionalParam($params, 'telno', $telno_);
        self::addOptionalParam($params, 'tel_open_flg', $telOpenFlg_);
        self::addOptionalParam($params, 'genre_id', $genreId_);
        self::addOptionalParam($params, 'note_hour', urlencode($noteHour_));
        self::addOptionalParam($params, 'note_holiday', urlencode($noteHoliday_));
        self::addOptionalParam($params, 'url', urlencode($url_));
        self::addOptionalParam($params, 'budget_types', $budgetTypes_);
        self::addOptionalParam($params, 'budget_ids', $budgetIds_);
        self::addOptionalParam($params, 'status', $status_);

        return self::put(sprintf(self::ENDPOINT, $tenantId_), $params);
    }
}

?>
