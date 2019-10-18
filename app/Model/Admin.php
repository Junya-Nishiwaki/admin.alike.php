<?php

/**
 * 管理系API
 *
 * @package Model
 */
App::uses('ModelBase', 'Model');

class Admin extends ModelBase {
    /** エンドポイント */
    const ENDPOINT = 'admin_tool/%s';

    /** 契約店舗一覧取得：アクティベート待ち状態(利用権未付与) */
    const GETLISTCONTRACT_WAITACTIVATE = 1;
    /** 契約店舗一覧取得：アクティベート状態(利用権付与) */
    const GETLISTCONTRACT_ACTIVATE = 2;
    
    /** お知らせ通知先：PCサイト */
    const INFORMATIONTYPE_PC = 1;
    /** お知らせ通知先：モバイルサイト */
    const INFORMATIONTYPE_MOBILE = 2;
    /** お知らせ通知先：スマホサイト */
    const INFORMATIONTYPE_SMARTPHONE = 3;
    /** お知らせ通知先：スマホアプリ */
    const INFORMATIONTYPE_SMARTPHONE_APP = 4;
    /** お知らせ通知先：店舗ツール */
    const INFORMATIONTYPE_TENANT_TOOL = 5;
    /** お知らせ通知先：代理店ツール */
    const INFORMATIONTYPE_AGENCY_TOOL = 6;

    /** ユーザー登録状態：仮登録 */
    const USERREGISTFLG_PRE = 1;
    /** ユーザー登録状態：本登録 */
    const USERREGISTFLG_COMPLETE = 2;

    /** かっトククーポン状態： 販売中（未成立） */
    const KATTOQ_STATE_REGULAR = 1;
    /** かっトククーポン状態： クーポン成立 */
    const KATTOQ_STATE_SUCCESS = 2;
    /** かっトククーポン状態： クーポン不成立 */
    const KATTOQ_STATE_FAILURE = 3;
    /** かっトククーポン状態： 完売 */
    const KATTOQ_STATE_SOLDOUT = 4;
    /** かっトククーポン状態： 販売終了 */
    const KATTOQ_STATE_EXPIRE  = 5;

    /** かっトククーポン一覧取得：並び替え(取り込み日が新しい順) */
    const GETLISTKATTOQ_ORDER_IMPORT_NEW = 1;
    /** かっトククーポン一覧取得：並び替え(取り込み日が古い順) */
    const GETLISTKATTOQ_ORDER_IMPORT_OLD = 2;
    /** かっトククーポン一覧取得：並び替え(販売開始日が新しい順) */
    const GETLISTKATTOQ_ORDER_START_NEW = 3;
    /** かっトククーポン一覧取得：並び替え(販売開始日が古い順) */
    const GETLISTKATTOQ_ORDER_START_OLD = 4;
    /** かっトククーポン一覧取得：並び替え(販売終了日が新しい順) */
    const GETLISTKATTOQ_ORDER_EXPIRE_NEW = 5;
    /** かっトククーポン一覧取得：並び替え(販売終了日が古い順) */
    const GETLISTKATTOQ_ORDER_EXPIRE_OLD = 6;
    /** かっトククーポン一覧取得：絞り込み(編集ステータス：未編集) */
    const GETLISTKATTOQ_CONDITIONS_UNEDITED = 1;
    /** かっトククーポン一覧取得：絞り込み(編集ステータス：編集中) */
    const GETLISTKATTOQ_CONDITIONS_EDITING = 2;
    /** かっトククーポン一覧取得：絞り込み(編集ステータス：公開中) */
    const GETLISTKATTOQ_CONDITIONS_OPEN = 3;
    /** かっトククーポン一覧取得：絞り込み(編集ステータス：公開準備完了) */
    const GETLISTKATTOQ_CONDITIONS_PRE = 4;
    /** かっトククーポン一覧取得：絞り込み(編集ステータス：販売終了) */
    const GETLISTKATTOQ_CONDITIONS_END = 5;
    /** かっトククーポン一覧取得：絞り込み(編集ステータス：公開停止) */
    const GETLISTKATTOQ_CONDITIONS_NOTOPEN = 6;

    /** 条件一致ユーザー取得：並び替え(登録日降順) */
    const USERCONDITIONSLIST_ORDER_LATEST = 1;
    /** 条件一致ユーザー取得：並び替え(クリップ数降順) */
    const USERCONDITIONSLIST_ORDER_CLIP_DESC = 2;
    /** 条件一致ユーザー取得：並び替え(フォト数降順) */
    const USERCONDITIONSLIST_ORDER_PHOTO_DESC = 3;
    
    /**
     * 契約店舗一覧取得
     */
    static public function getListContract($activate_, $offset_, $limit_, $word_) {
        // 必須項目
        $params = array();
        // オプション項目
        self::addOptionalParam($params, 'activate', $activate_);
        self::addOptionalParam($params, 'word', urldecode($word_));
        self::addOptionalParam($params, 'offset', $offset_);
        self::addOptionalParam($params, 'limit', $limit_);
        
        return self::get(sprintf(self::ENDPOINT, 'contract/list'), $params, true);
    }

    /**
     * 店舗詳細取得
     *
     * @param   int     $tenantId_  店舗ID
     * @return  array               店舗情報
     */
    static public function detail($tenantId_) {
        // 必須項目
        $params = array();

        return self::get(sprintf(self::ENDPOINT, 'tenant/' . $tenantId_), $params, true);
    }

    /**
     * 店舗削除
     */
    static public function deleteTenant($tenantId_, $memo_) {
        // 必須項目
        $params = array('memo' => urlencode($memo_));
        // オプション項目
        
        return self::delete(sprintf(self::ENDPOINT, 'tenant/' . $tenantId_), $params, true);
    }

    /**
     * 代理店一覧取得
     */
    static public function getListAgency($word_, $offset_, $limit_) {
        // 必須項目
        $params = array();
        // オプション項目
        self::addOptionalParam($params, 'word', urldecode($word_));
        self::addOptionalParam($params, 'offset', $offset_);
        self::addOptionalParam($params, 'limit', $limit_);
        
        return self::get(sprintf(self::ENDPOINT, 'agency/list'), $params, true);
    }

    /**
     * 代理店詳細取得
     */
    static public function detailAgency($agencyId_) {
        // 必須項目
        $params = array();
        // オプション項目
        
        return self::get(sprintf(self::ENDPOINT, 'agency/' . $agencyId_), $params, true);
    }

    /**
     * 代理店追加
     */
    static public function addAgency() {
        // 必須項目
        $params = array();
        // オプション項目
        
        return self::post(sprintf(self::ENDPOINT, 'agency'), $params, true);
    }

    /**
     * アクティベーション
     */
    static public function activate($tenantId_) {
        // 必須項目
        $params = array();
        // オプション項目
        
        return self::post(sprintf(self::ENDPOINT, 'contract/' . $tenantId_ . '/activate'), $params, true);
    }

    /**
     * 契約店舗詳細
     */
    static public function detailContractTenant($tenantId_) {
        // 必須項目
        $params = array();
        // オプション項目
        
        return self::get(sprintf(self::ENDPOINT, 'contract/' . $tenantId_), $params, true);
    }

    /**
     * お知らせ削除
     */
    static public function deleteInformation($informationId_) {
        // 必須項目
        $params = array();
        // オプション項目
        
        return self::delete(sprintf(self::ENDPOINT, 'information/' . $informationId_), $params, true);
    }

    /**
     * お知らせ更新
     */
    static public function updateInformation($informationId_, $title_, $body_) {
        // 必須項目
        $params = array();
        // オプション項目
        self::addOptionalParam($params, 'title', urlencode($title_));
        self::addOptionalParam($params, 'body', urlencode($body_));
        
        return self::put(sprintf(self::ENDPOINT, 'information/' . $informationId_), $params, true);
    }

    /**
     * お知らせ追加
     */
    static public function addInformation($title_, $body_, $type_) {
        // 必須項目
        $params = array('title' => urlencode($title_), 'body' => urlencode($body_), 'type' => $type_);
        // オプション項目
        
        return self::post(sprintf(self::ENDPOINT, 'information'), $params, true);
    }

    /**
     * お知らせ一覧取得
     */
    static public function getListInformation($type_, $offset_, $limit_) {
        // 必須項目
        $params = array();
        // オプション項目
        self::addOptionalParam($params, 'type', $type_);
        self::addOptionalParam($params, 'offset', $offset_);
        self::addOptionalParam($params, 'limit', $limit_);
        
        return self::get(sprintf(self::ENDPOINT, 'information/list'), $params, true);
    }

    /**
     * お知らせ詳細取得
     */
    static public function detailInformation($informationId_) {
        // 必須項目
        $params = array();
        // オプション項目
        
        return self::get(sprintf(self::ENDPOINT, 'information/' . $informationId_), $params, true);
    }

    /**
     * かっトククーポン一覧取得
     */
    static public function getListKattoq($word_, $offset_, $limit_, $order_, $categoryId_, $editState_) {
        // 必須項目
        $params = array();
        // オプション項目
        self::addOptionalParam($params, 'word', urlencode($word_));
        self::addOptionalParam($params, 'offset', $offset_);
        self::addOptionalParam($params, 'limit', $limit_);
        self::addOptionalParam($params, 'order', $order_);
        self::addOptionalParam($params, 'category_id', $categoryId_);
        self::addOptionalParam($params, 'edit_state', $editState_);

        return self::get(sprintf(self::ENDPOINT, 'kattoq/list'), $params, true);
    }

    /**
     * かっトククーポン詳細取得
     */
    static public function detailKattoq($kattoqId_) {
        // 必須項目
        $params = array();
        // オプション項目
        
        return self::get(sprintf(self::ENDPOINT, 'kattoq/' . $kattoqId_), $params, true);
    }

    /**
     * かっトククーポン更新
     */
    static public function updateKattoq($kattoqId_, $tenantId_, $activate_, $origTitle_, $origUseOption_, $origNote_, $memo_) {
        // 必須項目
        $params = array();
        // オプション項目
        self::addOptionalParam($params, 'tenant_id', $tenantId_);
        self::addOptionalParam($params, 'activate', $activate_);
        self::addOptionalParam($params, 'orig_title', urlencode($origTitle_));
        self::addOptionalParam($params, 'orig_use_option', urlencode($origUseOption_));
        self::addOptionalParam($params, 'orig_note', urlencode($origNote_));
        self::addOptionalParam($params, 'memo', urlencode($memo_));
        
        return self::post(sprintf(self::ENDPOINT, 'kattoq/' . $kattoqId_), $params, true);
    }

    /**
     * ダイレクトメール一覧取得
     */
    static public function getListDirectMail($offset_, $limit_) {
        // 必須項目
        $params = array();
        // オプション項目
        self::addOptionalParam($params, 'offset', $offset_);
        self::addOptionalParam($params, 'limit', $limit_);
        
        return self::get(sprintf(self::ENDPOINT, 'directmail/list'), $params, true);
    }

    /**
     * ダイレクトメール詳細取得
     */
    static public function detailDirectMail($directMailId_) {
        // 必須項目
        $params = array();
        // オプション項目
        
        return self::get(sprintf(self::ENDPOINT, 'directmail/' . $directMailId_), $params, true);
    }

    /**
     * ダイレクトメール更新
     */
    static public function updateDirectMail($directMailId_, $title_, $body_, $sendTime_, $gender_, $generation_, $bloodType_, $areaId_, $workId_) {
        // 必須項目
        $params = array('title' => urlencode($title_), 'body' => urlencode($body_), 'send_time' => $sendTime_);
        // オプション項目
        self::addOptionalParam($params, 'gender', $gender_);
        self::addOptionalParam($params, 'generation', $generation_);
        self::addOptionalParam($params, 'blood_type', $bloodType_);
        self::addOptionalParam($params, 'area_id', $areaId_);
        self::addOptionalParam($params, 'work_id', $workId_);
        
        return self::put(sprintf(self::ENDPOINT, 'directmail/' . $directMailId_), $params, true);
    }

    /**
     * ダイレクトメール削除
     */
    static public function deleteDirectMail($directMailId_) {
        // 必須項目
        $params = array();
        // オプション項目
        
        return self::delete(sprintf(self::ENDPOINT, 'directmail/' . $directMailId_), $params, true);
    }

    /**
     * ダイレクトメール作成
     */
    static public function addDirectMail($title_, $body_, $sendTime_, $gender_, $generation_, $bloodType_, $areaId_, $workId_) {
        // 必須項目
        $params = array('title' => urlencode($title_), 'body' => urlencode($body_), 'send_time' => urlencode($sendTime_));
        // オプション項目
        self::addOptionalParam($params, 'gender', $gender_);
        self::addOptionalParam($params, 'generation', $generation_);
        self::addOptionalParam($params, 'blood_type', $bloodType_);
        self::addOptionalParam($params, 'area_id', $areaId_);
        self::addOptionalParam($params, 'work_id', $workId_);
        
        return self::post(sprintf(self::ENDPOINT, 'directmail'), $params, true);
    }

    /**
     * ユーザー検索
     */
    static public function userConditionsList($gender_, $generation_, $bloodType_, $areaId_, $work_, $word_, $directmailFlg_, $offset_, $limit_, $order_) {
        // 必須項目
        $params = array();
        // オプション項目
        self::addOptionalParam($params, 'gender', $gender_);
        self::addOptionalParam($params, 'generation', $generation_);
        self::addOptionalParam($params, 'blood_type', $bloodType_);
        self::addOptionalParam($params, 'area_id_', $areaId_);
        self::addOptionalParam($params, 'work', $work_);
        self::addOptionalParam($params, 'word', urlencode($word_));
        self::addOptionalParam($params, 'directmail_flg', $directmailFlg_);
        self::addOptionalParam($params, 'offset', $offset_);
        self::addOptionalParam($params, 'limit', $limit_);
        self::addOptionalParam($params, 'order', $order_);
        
        return self::get(sprintf(self::ENDPOINT, 'user/conditions_list'), $params, true);
    }

    /**
     * ユーザー詳細情報取得
     */
    static public function userDetail($userId_) {
        // 必須項目
        $params = array();
        // オプション項目
        
        return self::get(sprintf(self::ENDPOINT, 'user/' . $userId_), $params, true);
    }
    
    /**
     * メッセージ送信(アライクから)
     */
    static public function createMessage($userId_, $subject_, $message_) {
        // 必須項目
        $params = array('subject' => urlencode($subject_), 'message' => urlencode($message_));
        // オプション項目
        
        return self::post(sprintf(self::ENDPOINT, 'user/' . $userId_ . '/message'), $params, true);
    }
    
    /**
     * クリップ一覧取得
     */
    static public function getListClip($categoryId_, $offset_, $limit_) {
        // 必須項目
        $params = array();
        // オプション項目
        self::addOptionalParam($params, 'category_id', $categoryId_);
        self::addOptionalParam($params, 'offset', $offset_);
        self::addOptionalParam($params, 'limit', $limit_);
        
        return self::get('clip/list', $params);
    }
}

?>
