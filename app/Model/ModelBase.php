<?php
/**
 * Description of ModelBase
 *
 * @package model
 */
App::uses('ApiResponse', 'Model');
App::uses('ModelLog', 'Model/Behavior');

require_once('HTTP/Request2.php');

class ModelBase {
    /** APIバージョン */
    static private $apiVersion = 'v2';
    /** TODO Alike運営管理局アクセストークン */
    const ACCESS_TOKEN = '9e4e70e654bcbbc0c23234cd636e2c90';
    
    /**
     * 真偽値のAlikeAPI用キャラクター変換
     * @param boolean $value_
     * @return string true:t/false:f
     */
    static public function getBooleanToCaracter($value_) {
        return $value_ === true ? 't' : 'f';
    }
    
    /**
     * 真偽値のAlikeAPI用キャラクター変換
     * @param boolean $value_
     * @return string true:t/false:f
     */
    static public function getCaracterToBoolean($value_) {
        return $value_ === 't' ? true : false;
    }
    
    /**
     * APIオプショナルパラメータ追加
     * @param array $params_ APIに渡すパラメータ郡
     * @param string $name_ キー名
     * @param mixed $value_ 値
     * @return boolean true:追加/false:追加していない
     */
    static public function addOptionalParam(&$params_, $name_, $value_) {
        $ret = false;

        if (is_bool($value_)) {
            $params_[$name_] = self::getBooleanToCaracter($value_);
            $ret = true;
        }
        else if ($value_ === 'true') {
            $params_[$name_] = self::getBooleanToCaracter(true);
            $ret = true;
        }
        else if ($value_ === 'false') {
            $params_[$name_] = self::getBooleanToCaracter(false);
            $ret = true;
        }
        else {
            if (!is_null($value_)) {
                if (is_array($value_)) {
                    $params_[$name_] = implode(',', $value_);
                }
                else {
                    $params_[$name_] = $value_;
                }

                $ret = true;
            }
        }
        
        return $ret;
    }
    
    /**
     * get
     *
     * @param string $endpoint_ APIのエンドポイント
     * @param array $params_ リクエストパラメータ
     * @param boolean $secure_ SSL使用フラグ(true:SSL/false:非SSL)
     * @return array レスポンスデータ
     */
    static protected function get($endpoint_, $params_ = array(), $secure_ = false) {
        return self::request('GET', $endpoint_, $params_, $secure_);
    }

    /**
     * post
     *
     * @param string $endpoint_ APIのエンドポイント
     * @param array $params_ リクエストパラメータ
     * @param boolean $secure_ SSL使用フラグ(true:SSL/false:非SSL)
     * @return array レスポンスデータ
     */
    static protected function post($endpoint_, $params_ = array(), $secure_ = false) {
        return self::request('POST', $endpoint_, $params_, $secure_);
    }

    /**
     * put
     *
     * @param string $endpoint_ APIのエンドポイント
     * @param array $params_ リクエストパラメータ
     * @param boolean $secure_ SSL使用フラグ(true:SSL/false:非SSL)
     * @return array レスポンスデータ
     */
    static protected function put($endpoint_, $params_ = array(), $secure_ = false) {
        return self::request('PUT', $endpoint_, $params_, $secure_);
    }

    /**
     * delete
     *
     * @param string $endpoint_ APIのエンドポイント
     * @param array $params_ リクエストパラメータ
     * @param boolean $secure_ SSL使用フラグ(true:SSL/false:非SSL)
     * @return array レスポンスデータ
     */
    static protected function delete($endpoint_, $params_ = array(), $secure_ = false) {
        return self::request('DELETE', $endpoint_, $params_, $secure_);
    }

    /**
     * ファイルアップロード
     *
     * @param string $endpoint_ APIのエンドポイント
     * @param array  $file ファイル
     * @param array $params_ リクエストパラメータ
     * @param boolean $secure_ SSL使用フラグ(true:SSL/false:非SSL)
     * @return array レスポンスデータ
     */
    static protected function upload($endpoint_, $files_, $params_ = array(), $secure_ = false) {
        return self::request('POST', $endpoint_, $params_, $secure_, $files_);
    }

    /**
     * リクエスト
     *
     * @param string $method HTTPリクエストメソッド
     * @param string $endpoint_ APIのエンドポイント
     * @param array $params_ リクエストパラメータ
     * @param boolen $tokenFlg パラメータにtokenをを含むかのフラグ
     * @param array ファイル
     * @return array レスポンスデータ
     */
    static private function request($method_, $endpoint_, $params_, $secure_, $files_ = null) {
        $scheme = $secure_ ? 'https://' : 'http://';
        $url = $scheme . self::getHost() . '/' . $endpoint_;

        try {
            $request = new HTTP_Request2();
            $request->setConfig(array(
                'ssl_verify_host' => false,
                'ssl_verify_peer' => false,
            ));

            // APIキー生成
            $apiKey = self::createApiKey();
            $params = array_merge((array)$params_, $apiKey);
            
            if ($method_ == 'POST') {
                foreach ($params as $key => $value) {
                    $request->addPostParameter($key, $value);
                }

                if (!empty($files_)) {
                    foreach ($files_ as $key => $value) {
                        $request->addUpload($key, $value);
                    }
                }
            }
            else if ($method_ == 'PUT') {
                $paramStr = '';
                foreach ($params as $key => $value) {
                    $paramStr .= $key . '=' . $value . '&';
                }
                $request->setBody($paramStr);
            }
            else {
                $url = $url . '?' . http_build_query($params, '', '&');
            }

            @$request->setUrl($url);
            $request->setMethod($method_);
            // リクエスト送信
            $response = $request->send();
            ModelLog::output_log_D($response->getBody());
            if (200 != $response->getStatus()) {
                ModelLog::output_log_E('API HTTP エラー status [' . $response->getStatus() . ']');
                return false;
            }

            $json = json_decode($response->getBody(), true);

            if ($json['meta']['status'] != '200') {
                ModelLog::output_log_E('API エラー status [' . $json['meta']['status'] . '] message [' . $json['meta']['message'] . ']');
            }
        }
        catch (Exception $e) {
            ModelLog::output_log_E('例外発生 message [' . $e->getMessage() . ']');
            return false;
        }
        
        return new ApiResponse($json);
    }
    
    /**
     * APIキー生成
     * @return string APIキー
     */
    static private function createApiKey() {
        $encServiceId = hash_hmac('md5', API_SERVICEID, API_SECRETKEY, false);
        // タイムスタンプ
        $timestamp = date('YmdHis');
        // APIキー
        $str = API_SERVICEID . $timestamp;
        $apikey = hash_hmac('sha1', $str, API_SECRETKEY, false);

        return array('service_id' => $encServiceId, 'apikey' => $apikey, 'timestamp' => $timestamp);
    }

    /**
     * APIホスト名取得
     * @return string APIホスト名
     */
    static private function getHost() {
        return 'localhost/' . self::$apiVersion;
    }
}

?>
