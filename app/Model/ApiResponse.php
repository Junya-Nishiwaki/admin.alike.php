<?php
/**
 * AlikeAPIレスポンスインスタンス
 * 
 * @package Model
 */

class ApiResponse {
    /** レスポンスデータ */
    private $data;
    /** ステータス */
    private $status;
    /** エラーコード */
    private $code;
    /** エラーメッセージ */
    private $message;

    /**
     * コンストラクタ
     * @param string $json AlikeAPIレスポンス
     */
    public function __construct($json) {
        $this->status = (int)$json['meta']['status'];
        $this->code = array_key_exists('code', $json['meta']) ? (int)$json['meta']['code'] : null;
        $this->message = array_key_exists('message', $json['meta']) ? (string)$json['meta']['message'] : null;
        $this->data = (array)$json['data'];
    }

    /**
     * API結果チェック
     * @return boolean true:成功/false:失敗
     */
    public function isSuccess() {
        return $this->status == 200;
    }
    
    /**
     * レスポンスデータ取得
     * @return array レスポンスデータ
     */
    public function getData() {
        return $this->data;
    }
    
    /**
     * ステータス取得
     * @return int ステータス
     */
    public function getStatus() {
        return $this->status;
    }
    
    /**
     * エラーコード取得
     * @return int エラーコード
     */
    public function getCode() {
        return $this->code;
    }
    
    /**
     * エラーメッセージ取得
     * @return string エラーメッセージ
     */
    public function getMessage() {
        return $this->message;
    }
}
