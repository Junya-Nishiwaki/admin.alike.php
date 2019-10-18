<?php

/**
 * マスター系API
 *
 * @package Model
 */
App::uses('ModelBase', 'Model');

class Master extends ModelBase {
    /** エンドポイント */
    const ENDPOINT = 'master/list/%s';

    /**
     * エリアマスタ取得
     * @return array エリアリスト
     */
    static public function getAreas($areaId_ = null) {
        // 必須項目
        $params = array();
        // オプション項目
        self::addOptionalParam($params, 'area_id', $areaId_);

        return self::get(sprintf(self::ENDPOINT, 'area'), $params);
    }

    /**
     * 職業マスタ取得
     * @return array 職業リスト
     */
    static public function getWorks() {
        // 必須項目
        // オプション項目

        return self::get(sprintf(self::ENDPOINT, 'work'));
    }

    /**
     * ジャンルマスタ取得
     * @return array ジャンルリスト
     */
    static public function getGenres($categoryId_ = null) {
        // 必須項目
        $params = array();
        // オプション項目
        self::addOptionalParam($params, 'category_id', $categoryId_);

        return self::get(sprintf(self::ENDPOINT, 'genre'), $params);
    }

    /**
     * 予算マスタ取得
     * @return array 予算リスト
     */
    static public function getBudgets($categoryId_ = null) {
        // 必須項目
        $params = array();
        // オプション項目
        self::addOptionalParam($params, 'category_id', $categoryId_);

        return self::get(sprintf(self::ENDPOINT, 'budget'), $params);
    }

    /**
     * シチュエーションマスタ取得
     * @return array シチュエーションリスト
     */
    static public function getSituations($categoryId_ = null) {
        // 必須項目
        $params = array();
        // オプション項目
        self::addOptionalParam($params, 'category_id', $categoryId_);

        return self::get(sprintf(self::ENDPOINT, 'situation'), $params);
    }
}

?>
