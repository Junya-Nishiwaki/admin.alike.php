<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::connect('/', array('controller' => 'dashboard', 'action' => 'index'));

/**
 * 契約店舗
 */
Router::connect('/contract/:id', array('controller' => 'contract', 'action' => 'detail'),
        array('id' => '\d+'));
Router::connect('/contract/:id/activate', array('controller' => 'contract', 'action' => 'activate'),
        array('id' => '\d+'));

/**
 * 代理店
 */
Router::connect('/agency/:id', array('controller' => 'agency', 'action' => 'detail'),
        array('id' => '\d+'));

/**
 * お知らせ
 */
Router::connect('/information/:id', array('controller' => 'information', 'action' => 'detail'),
        array('id' => '\d+'));
Router::connect('/information/:id/edit', array('controller' => 'information', 'action' => 'edit'),
        array('id' => '\d+'));
Router::connect('/information/:id/delete', array('controller' => 'information', 'action' => 'delete'),
        array('id' => '\d+'));

/**
 * ユーザー
 */
Router::connect('/user/:id', array('controller' => 'user', 'action' => 'detail'),
        array('id' => '\d+'));
Router::connect('/user/:id/message', array('controller' => 'user', 'action' => 'message'),
        array('id' => '\d+'));

/**
 * ダイレクトメール
 */
Router::connect('/directmail/:id', array('controller' => 'directmail', 'action' => 'detail'),
        array('id' => '\d+'));
Router::connect('/directmail/:id/update', array('controller' => 'directmail', 'action' => 'update'),
        array('id' => '\d+'));
Router::connect('/directmail/:id/delete', array('controller' => 'directmail', 'action' => 'delete'),
        array('id' => '\d+'));

/**
 * 店舗
 */
Router::connect('/tenant/:id', array('controller' => 'tenant', 'action' => 'detail'),
        array('id' => '\d+'));
Router::connect('/tenant/:id/edit', array('controller' => 'tenant', 'action' => 'edit'),
        array('id' => '\d+'));
Router::connect('/tenant/:id/close', array('controller' => 'tenant', 'action' => 'close'),
        array('id' => '\d+'));
Router::connect('/tenant/:id/delete', array('controller' => 'tenant', 'action' => 'delete'),
        array('id' => '\d+'));

/**
 * かっトク
 */
Router::connect('/kattoq/:id', array('controller' => 'kattoq', 'action' => 'detail'),
        array('id' => '\d+'));

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
