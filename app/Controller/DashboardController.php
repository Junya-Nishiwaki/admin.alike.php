<?php

class DashboardController extends AppController {
    public function beforeFilter() {
        parent::beforeFilter();
    }

    /**
     * ダッシュボード
     */
    public function index() {
        // パンくず
        $breadcrumbs = array(
            array('title' => 'ダッシュボード')
        );
        
        // アクティベーション待ち件数
        $getNotActivateListContractResponse = Admin::getListContract(Admin::GETLISTCONTRACT_WAITACTIVATE, 1, 1, null);
        if (!$getNotActivateListContractResponse || !$getNotActivateListContractResponse->isSuccess()) {
            $this->setErrMsg('アクティベーション待ち件数取得エラー');
            $activationCount = 0;
        }
        else {
            $activationCount = $getNotActivateListContractResponse->getData()['admin_tool']['total'];
        }
        // 契約店舗件数
        $getActivatedListContractResponse = Admin::getListContract(null, 1, 1, null);
        if (!$getActivatedListContractResponse || !$getActivatedListContractResponse->isSuccess()) {
            $this->setErrMsg('契約店舗件数取得エラー');
            $contractCount = 0;
        }
        else {
            $contractCount = $getActivatedListContractResponse->getData()['admin_tool']['total'];
        }
        // 代理店件数
        $getListAgencyResponse = Admin::getListAgency(null, 1, 1);
        if (!$getListAgencyResponse || !$getListAgencyResponse->isSuccess()) {
            $this->setErrMsg('代理店数取得エラー');
        }
        else {
            $agencyCount = $getListAgencyResponse->getData()['admin_tool']['total'];
        }
        $clipLimit = 20;
        // グルメクリップ
        $gourmetClips = array();
        $gourmetGetClipResponse = Admin::getListClip(CATEGORY_GOURMET, 1, $clipLimit);
        if (!$gourmetGetClipResponse || !$gourmetGetClipResponse->isSuccess()) {
            $this->setErrMsg('クリップ取得エラー');
        }
        else {
            $gourmetClips = $this->formatObject($gourmetGetClipResponse->getData()['clips']['items']);
        }
        // ビューティクリップ
        $beautyClips = array();
        $beautyGetClipResponse = Admin::getListClip(CATEGORY_BEAUTY, 1, $clipLimit);
        if (!$gourmetGetClipResponse || !$gourmetGetClipResponse->isSuccess()) {
            $this->setErrMsg('クリップ取得エラー');
        }
        else {
            $beautyClips = $this->formatObject($beautyGetClipResponse->getData()['clips']['items']);
        }
        // ホテルクリップ
        $hotelClips = array();
        $hotelGetClipResponse = Admin::getListClip(CATEGORY_HOTEL, 1, $clipLimit);
        if (!$hotelGetClipResponse || !$hotelGetClipResponse->isSuccess()) {
            $this->setErrMsg('クリップ取得エラー');
        }
        else {
            $hotelClips = $this->formatObject($hotelGetClipResponse->getData()['clips']['items']);
        }
        
        $this->set(compact('breadcrumbs', 'activationCount', 'contractCount', 'agencyCount', 'gourmetClips', 'beautyClips', 'hotelClips', 'clipLimit'));
    }

}
?>
