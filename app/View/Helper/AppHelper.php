<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
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
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AppHelper extends Helper {
    /**
     * 管理ツールベースURL
     * @return string
     */
    public function base() {
        return 'https://' . env('SERVER_NAME');
    }
    
    /**
     * PCサイトベースURL
     */
    public function basePcSite($categoryId_ = CATEGORY_GOURMET) {
        $url = '';
        $pre = ENV == ENV_LOCAL ? 'local.stage-' : (ENV == ENV_STAGE ? 'stage-' : '');
        switch ($categoryId_) {
            case CATEGORY_GOURMET:
                $url = 'http://' . $pre . 'alike.jp';
                break;
            case CATEGORY_BEAUTY:
                $url = 'http://beauty.' . $pre . 'alike.jp';
                break;
            case CATEGORY_HOTEL:
                $url = 'http://hotel.' . $pre . 'alike.jp';
                break;
        }
        
        return $url;
    }
    
    /**
     * 店舗ツールベースURL
     */
    public function baseTenantTool() {
        $pre = ENV == ENV_LOCAL ? 'local.stage-' : (ENV == ENV_STAGE ? 'stage-' : '');
        $url = 'https://tool.' . $pre . 'alike.jp';
        
        return $url;
    }
}
