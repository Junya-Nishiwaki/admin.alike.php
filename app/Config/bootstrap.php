<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 *
 */

/**
 * Custom Inflector rules, can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */

/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter . By Default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 * 		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'FileLog',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'FileLog',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));

// URL関連
config('util/AdminUrl');
config('util/PcUrl');

/**
 * 性別テキスト取得
 * @param int $gender_ 性別
 * @return string 性別テキスト
 */
function genderText($gender_) {
    $text = '';

    switch ($gender_) {
        case 1:
            $text = '男性';
            break;
        case 2:
            $text = '女性';
            break;
    }

    return $text;
}

/**
 * 年代テキスト取得
 * @param type $user_
 */
function generationText($generation_) {
    $text = '';

    switch ($generation_) {
        case 10:
            $text = '20歳未満';
            break;
        case 20:
            $text = '20 - 24歳';
            break;
        case 25:
            $text = '25 - 29歳';
            break;
        case 30:
            $text = '30 - 34歳';
            break;
        case 35:
            $text = '35 - 39歳';
            break;
        case 40:
            $text = '40 - 44歳';
            break;
        case 45:
            $text = '45 - 49歳';
            break;
        case 50:
            $text = '50 - 54歳';
            break;
        case 55:
            $text = '55 - 59歳';
            break;
        case 60:
            $text = '60 - 64歳';
            break;
        case 65:
            $text = '65 - 69歳';
            break;
        case 70:
            $text = '70歳以上';
            break;
    }

    return $text;
}

/**
 * 血液型テキスト取得
 * @param type $user_
 */
function bloodTypeText($bloodType_) {
    $text = '';

    switch ($bloodType_) {
        case 1:
            $text = 'A型';
            break;
        case 2:
            $text = 'B型';
            break;
        case 4:
            $text = 'O型';
            break;
        case 8:
            $text = 'AB型';
            break;
    }

    return $text;
}

// TODO このへんはWEB側と共有できるようにする

/** カテゴリ：グルメ */
define('CATEGORY_GOURMET', 2);
/** カテゴリ：ビューティ */
define('CATEGORY_BEAUTY', 4);
/** カテゴリ：ホテル */
define('CATEGORY_HOTEL', 5);

/** エリアレベル：エリア大 */
define('AREALEVEL_LARGE', 0);
/** エリアレベル：エリア中 */
define('AREALEVEL_MEDIUM', 1);
/** エリアレベル：エリア小 */
define('AREALEVEL_SMALL', 2);

/** ジャンルレベル：ジャンル大 */
define('GENRELEVEL_LARGE', 'g0');
/** ジャンルレベル：ジャンル中 */
define('GENRELEVEL_MEDIUM', 'g1');
/** ジャンルレベル：ジャンル小 */
define('GENRELEVEL_SMALL', 'g');

/** クリップ評価：スキ */
define('RATING_HIGH', 1);
/** クリップ評価：ありかも */
define('RATING_MIDDLE', 2);
/** クリップ評価：う〜ん */
define('RATING_LOW', 3);
/** クリップ評価：気になる */
define('RATING_FAVORITE', 4);

/** 予算種別：ランチ */
define('BUDGET_TYPE_LUNCH', 1);
/** 予算種別：ディナー */
define('BUDGET_TYPE_DINNER', 2);
/** 予算種別：その他 */
define('BUDGET_TYPE_OTHER', 3);
/** 予算種別：ビューティ */
define('BUDGET_TYPE_BEAUTY', 5);
/** 予算種別：宿泊 */
define('BUDGET_TYPE_DAY', 6);
/** 予算種別：日帰り */
define('BUDGET_TYPE_STAY', 7);

/** 外部サービスID：Twitter */
define('EXTERNAL_SERVICE_TWITTER', 18);
/** 外部サービスID：Facebook */
define('EXTERNAL_SERVICE_FACEBOOK', 19);

/** 環境 */
// define('ENV', apache_getenv('ENV'));
define('ENV_PRODUCTION', 'production');
define('ENV_STAGE', 'stage');
define('ENV_LOCAL', 'local');

/** ログ */
// define('OUTPUT_LOG_LEVEL', apache_getenv('OUTPUT_LOG_LEVEL'));

/** APIキー */
switch (ENV) {
    case ENV_PRODUCTION:
        define('API_SECRETKEY', '35c778fcfcf12cb2998ec3d38570c873');
        define('API_SERVICEID', '703aab29a0442badd191815e06c5b23c');

        break;

    case ENV_STAGE:
        define('API_SECRETKEY', '56dd4814d91642925f0f56acff46db0c');
        define('API_SERVICEID', '10647de439bc1220907ab7cd7bae8996');

        break;

    case ENV_LOCAL:
        define('API_SECRETKEY', 'ce7fab358217971b75fc67fe8659913e');
        define('API_SERVICEID', 'PW001');

        break;

    default:
        define('API_SECRETKEY', 'ce7fab358217971b75fc67fe8659913e');
        define('API_SERVICEID', 'PW001');

        break;
}


/** ドメイン */
switch (ENV) {
    case ENV_PRODUCTION:
        define('DOMAIN_GOURMET', 'alike.jp');
        define('DOMAIN_BEAUTY', 'beauty.alike.jp');
        define('DOMAIN_HOTEL', 'hotel.alike.jp');
        define('DOMAIN_TENANT_TOOL', 'tool.alike.jp');
        define('DOMAIN_MAIL', 'mail.alike.jp');

        break;

    case ENV_STAGE:
        define('DOMAIN_GOURMET', 'stage-alike.jp');
        define('DOMAIN_BEAUTY', 'beauty.stage-alike.jp');
        define('DOMAIN_HOTEL', 'hotel.stage-alike.jp');
        define('DOMAIN_TENANT_TOOL', 'tool.stage-alike.jp');
        define('DOMAIN_MAIL', 'mail.stage-alike.jp');

        break;

    case ENV_LOCAL:
        define('DOMAIN_GOURMET', 'local.stage-alike.jp');
        define('DOMAIN_BEAUTY', 'beauty.local.stage-alike.jp');
        define('DOMAIN_HOTEL', 'hotel.local.stage-alike.jp');
        define('DOMAIN_TENANT_TOOL', 'tool.local.stage-alike.jp');
        define('DOMAIN_MAIL', 'mail.local.stage-alike.jp');

        break;

    default:
        define('DOMAIN_GOURMET', 'local.stage-alike.jp');
        define('DOMAIN_BEAUTY', 'beauty.local.stage-alike.jp');
        define('DOMAIN_HOTEL', 'hotel.local.stage-alike.jp');
        define('DOMAIN_TENANT_TOOL', 'tool.local.stage-alike.jp');
        define('DOMAIN_MAIL', 'mail.local.stage-alike.jp');

        break;
}

/** デバッグレベル */
switch (ENV) {
    case ENV_PRODUCTION:
        Configure::write('debug', 0);

        break;

    case ENV_STAGE:
        Configure::write('debug', 0);

        break;

    case ENV_LOCAL:
        Configure::write('debug', 2);

        break;

    default:
        Configure::write('debug', 2);

        break;
}


/**
 * ドメイン取得
 * @return type
 */
function getDomain($categoryId_ = null) {
    if ($categoryId_) {
        switch ($categoryId_) {
            case CATEGORY_GOURMET:
                return DOMAIN_GOURMET;
            case CATEGORY_BEAUTY:
                return DOMAIN_BEAUTY;
            case CATEGORY_HOTEL:
                return DOMAIN_HOTEL;
        }
    }
    else {
        return array (
            CATEGORY_GOURMET => DOMAIN_GOURMET,
            CATEGORY_BEAUTY => DOMAIN_BEAUTY,
            CATEGORY_HOTEL => DOMAIN_HOTEL
        );
    }
}

/**
 * arrayからキーを参考に値を取得する(array_key/existsと!emptyをラッパーしただけ)
 *
 * @param   array   $array_     取得元array
 * @param   mixed   $key_       参照キー
 * @param   mixed   $default_   キーが存在しない場合のデフォルト値
 * @return  mixed               値
 */
function getArrayValueFromKey($array_, $key_, $default_ = null) {
    return array_key_exists($key_, $array_) && !empty($array_[$key_]) ? $array_[$key_] : $default_;
}


/**
 * GoogleApiKey取得
 * @return string GoogleApiKey
 */
function getGoogleApiKey() {
    $key = null;
    switch (ENV) {
        case ENV_PRODUCTION:
            $key = 'AIzaSyDJ7gwODnP65tpL5OALXnZRilx-SArBrY4';

            break;

        case ENV_STAGE:
            $key = 'AIzaSyCPNGw_ier3V0uFNA2YnSkYhT-pXeyNsPM';

            break;

        case ENV_LOCAL:
            $key = 'AIzaSyCPNGw_ier3V0uFNA2YnSkYhT-pXeyNsPM';

            break;

        default:
            $key = 'AIzaSyCPNGw_ier3V0uFNA2YnSkYhT-pXeyNsPM';

            break;
    }

    return $key;
}
