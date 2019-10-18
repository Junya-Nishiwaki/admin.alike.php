<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

App::uses('Admin', 'Model');
App::uses('Master', 'Model');
App::uses('Tenant', 'Model');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $helper = array('Url', 'Util');
    public $components = array('Security');
    public $layout = 'admin';
    private $msg = '';
    private $errMsg = '';

    public function beforeFilter() {
        parent::beforeFilter();

        $this->Security->blackHoleCallback = 'forceSSL';
        $this->Security->requireSecure();
        $title_for_layout = 'Alike管理ツール';
        $msg = array_key_exists('msg', $this->request->query) ? $this->request->query['msg'] : '';
        $errMsg = array_key_exists('err_msg', $this->request->query) ? $this->request->query['err_msg'] : '';

        $this->set(compact('title_for_layout', 'msg', 'errMsg'));
    }

    /**
     * 強制SSL
     */
    protected function forceSSL() {
        $this->redirect('https://' . env('SERVER_NAME') . $this->here);
    }

    /**
     * URL生成
     * @param type $url
     * @param type $full
     * @return type
     */
    protected function url($url = null, $full = false) {
        return h(Router::url($url, $full));
    }

    /**
     * メッセージ設定
     * @param string $msg_ メッセージ
     */
    protected function setMsg($msg_) {
        $this->msg .= $msg_ . '<br />';

        $this->set('msg', $this->msg);
    }

    /**
     * エラーメッセージ設定
     * @param string $errMsg_ エラーメッセージ
     */
    protected function setErrMsg($errMsg_) {
        $this->errMsg .= $errMsg_ . '<br />';

        $this->set('errMsg', $this->errMsg);
    }

    /**
     * APIの最小オブジェクトの整形(真偽値文字をbooleanにそれ以外をそのまま移行する)
     * @param array $obj_ オブジェクト
     * @return array 整形済みオブジェクト
     */
    protected function formatObject($obj_) {
        $format = array();
        if (is_array($obj_)) {
            foreach ($obj_ as $key => $value) {
                if (is_array($value)) {
                    $format[$key] = $this->formatObject($value);
                }
                else {
                    if ($value === 't' || $value === 'f') {
                        $format[$key] = ModelBase::getCaracterToBoolean($value);
                    }
                    else {
                        $format[$key] = $value;
                    }
                }
            }
        }
        else {
            if ($obj_ === 't' || $obj_ === 'f') {
                $format = ModelBase::getCaracterToBoolean($obj_);
            }
            else {
                $format = $obj_;
            }
        }
        
        return $format;
    }
}
