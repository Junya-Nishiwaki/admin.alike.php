<?php
$this->Html->css(array('bootstrap-cerulean', 'bootstrap-responsive', 'charisma-app', 'jquery-ui-1.8.21.custom', 'fullcalendar', 'fullcalendar.print', 'chosen', 'uniform.default',
                            'colorbox', 'jquery.cleditor', 'jquery.noty', 'noty_theme_default', 'elfinder.min', 'elfinder.theme', 'jquery.iphone.toggle', 'opa-icons', 'uploadify',
        ),
        null, array('inline' => false));
$this->Html->script(array('jquery-1.8.3.min', 'jquery-ui-1.8.21.custom.min', 'bootstrap-transition', 'bootstrap-alert', 'bootstrap-modal', 'bootstrap-dropdown', 'bootstrap-scrollspy', 'bootstrap-tab',
                        'bootstrap-tooltip', 'bootstrap-popover', 'bootstrap-button', 'bootstrap-collapse', 'bootstrap-carousel', 'bootstrap-typeahead', 'bootstrap-tour', 'jquery.cookie',
                        'fullcalendar.min', 'jquery.dataTables.min', 'excanvas', 'jquery.flot.min', 'jquery.flot.pie.min', 'jquery.flot.stack', 'jquery.flot.resize.min', 'jquery.chosen.min',
                        'jquery.uniform.min', 'jquery.colorbox.min', 'jquery.cleditor.min', 'jquery.noty', 'jquery.elfinder.min', 'jquery.raty.min', 'jquery.iphone.toggle',
                        'jquery.autogrow-textarea', 'jquery.uploadify-3.1.min', 'jquery.history', 'charisma',
        ),
        array('inline' => false));
?>
<div class="row-fluid">
    <div class="span12">
        <a href="<?php echo AdminUrl::message($user); ?>" class="btn btn-large btn-primary" id="edit">
            <i class="icon-edit icon-white"></i>
            メッセージを送る
        </a>
    </div><!--/span-->
</div>
<div class="row-fluid">
    <div class="box span12">
        <div class="box-header well">
            <h2> ユーザー詳細</h2>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="width: 200px;">項目</th>
                        <th>内容</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ユーザーID</td>
                        <td><?php echo $user['id']; ?></a></td>
                    </tr>
                    <tr>
                        <td>ニックネーム</td>
                        <td><?php echo h($user['nickname']); ?></td>
                    </tr>
                    <tr>
                        <td>メールアドレス</td>
                        <td><?php echo $user['email']; ?></td>
                    </tr>
                    <tr>
                        <td>ステータス</td>
                        <td><?php echo $user['flag_close_account'] ? '退会' : ($user['regist_flg'] == Admin::USERREGISTFLG_PRE ? '仮登録' : '本登録'); ?></td>
                    </tr>
                    <tr>
                        <td>フォロー数</td>
                        <td><?php echo $user['num_follows']; ?></td>
                    </tr>
                    <tr>
                        <td>フォロワー数</td>
                        <td><?php echo $user['num_followers']; ?></td>
                    </tr>
                    <tr>
                        <td>クリップ数</td>
                        <td><?php echo $user['num_clips']; ?></td>
                    </tr>
                    <tr>
                        <td>フォト数</td>
                        <td><?php echo $user['num_photos']; ?></td>
                    </tr>
                    <tr>
                        <td>登録日時</td>
                        <td><?php echo date('Y/m/d H:i:s', strtotime($user['created_at'])); ?></td>
                    </tr>
                    <tr>
                        <td>最終ログイン日時</td>
                        <td><?php echo date('Y/m/d H:i:s', strtotime($user['last_login_date'])); ?></td>
                    </tr>
                    <tr>
                        <td>登録経路</td>
                        <td>
                            <?php
                            switch ($user['register_route']) {
                                case 0:
                                    echo $this->Html->image('common/mail_icon.png', array('width' => 32, 'height' => 32, 'alt' => 'mail'));
                                    break;
                                case EXTERNAL_SERVICE_TWITTER:
                                    echo $this->Html->image('common/twitter_icon.png', array('width' => 32, 'height' => 32, 'alt' => 'twitter'));
                                    break;
                                case EXTERNAL_SERVICE_FACEBOOK:
                                    echo $this->Html->image('common/facebook_icon.png', array('width' => 32, 'height' => 32, 'alt' => 'facebook'));
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div><!--/span-->
</div><!--/row-->
<div class="row-fluid">
    <div class="box span12">
        <div class="box-header well">
            <h2>最新クリップ</h2>
        </div>
        <div class="box-content">
            <?php if (array_key_exists('clips', $user)) { ?>
            <?php foreach ($user['clips'] as $index => $clip) { ?>
            <?php if ($index % 3 == 0) { ?>
            <div class="row-fluid">
            <?php } ?>
                <div class="box span4">
                    <div class="box-content">
                        <div class="box-header well" data-original-title="">
                            <h2></i> <a href="<?php echo PcUrl::clipPcSite($clip); ?>" target="_blank"><?php echo h($clip['tenant']['name']); ?></a></h2>
                            <div class="box-icon">
                                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-down"></i></a>
                            </div>
                        </div>
                        <div class="box-content" style="display: none;">
                            評価：
                            <?php 
                                switch($clip['rating']) {
                                    case RATING_HIGH:
                                        echo 'スキ！';
                                        break;
                                    case RATING_MIDDLE:
                                        echo 'ありかも';
                                        break;
                                    case RATING_LOW:
                                        echo 'う〜ん';
                                        break;
                                    case RATING_FAVORITE:
                                        echo 'きになる';
                                        break;
                                }
                            ?><br>
                            クリップコメント：<br>
                            <?php echo h($clip['review_comment']); ?>
                        </div>
                    </div>
                </div>
            <?php if ($index % 3 == 2 || end($user['clips']) === $clip) { ?>
            </div>
            <?php } ?>
            <?php } ?>
            <?php } ?>
        </div>
    </div><!--/span-->
</div><!--/row-->
<div class="row-fluid">
    <div class="box span12">
        <div class="box-header well">
            <h2>購入済みかっトククーポン詳細</h2>
        </div>
        <div class="box-content">
            <?php if (array_key_exists('kattoq', $user)) { ?>
            <?php foreach ($user['kattoq'] as $index => $coupon) { ?>
            <?php if ($index % 3 == 0) { ?>
            <div class="row-fluid">
            <?php } ?>
                <div class="box span4">
                    <div class="box-header well" data-original-title="">
                        <h2></i> <?php echo mb_strimwidth($coupon['coupon']['title'], 0, 40); ?></h2>
                        <div class="box-icon">
                            <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-down"></i></a>
                        </div>
                    </div>
                    <div class="box-content" style="display: none;">
                        <div class="box-content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 25%;">項目</th>
                                        <th>内容</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>店舗名</td>
                                        <td><a href="<?php echo PcUrl::tenantPcSite($coupon['coupon']['tenant']); ?>" target="_blank"><?php echo $coupon['coupon']['tenant']['name']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td>クーポンタイトル</td>
                                        <td><a href="" target="_blank"><?php echo $coupon['coupon']['title']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td>購入枚数</td>
                                        <td><?php echo $coupon['number']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td>購入金額</td>
                                        <td><?php echo number_format($coupon['price']); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td>購入日</td>
                                        <td><?php echo date('Y/m/d H:i:s', strtotime($coupon['created_at'])); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td>状態</td>
                                        <td><?php echo $coupon['status_text']; ?></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php if ($index % 3 == 2 || end($user['kattoq']) === $coupon) { ?>
            </div>
            <?php } ?>
            <?php } ?>
            <?php } ?>
        </div>
    </div><!--/span-->
</div><!--/row-->

