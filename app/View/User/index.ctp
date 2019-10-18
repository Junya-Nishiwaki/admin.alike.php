<?php
$this->Html->css(array('bootstrap-cerulean', 'bootstrap-responsive', 'charisma-app', 'jquery-ui-1.8.21.custom', 'fullcalendar', 'fullcalendar.print', 'chosen', 'uniform.default',
                            'colorbox', 'jquery.cleditor', 'jquery.noty', 'noty_theme_default', 'elfinder.min', 'elfinder.theme', 'jquery.iphone.toggle', 'opa-icons', 'uploadify',
        'admin'),
        null, array('inline' => false));
$this->Html->script(array('jquery-1.8.3.min', 'jquery-ui-1.8.21.custom.min', 'bootstrap-transition', 'bootstrap-alert', 'bootstrap-modal', 'bootstrap-dropdown', 'bootstrap-scrollspy', 'bootstrap-tab',
                        'bootstrap-tooltip', 'bootstrap-popover', 'bootstrap-button', 'bootstrap-collapse', 'bootstrap-carousel', 'bootstrap-typeahead', 'bootstrap-tour', 'jquery.cookie',
                        'fullcalendar.min', 'jquery.dataTables.min', 'excanvas', 'jquery.flot.min', 'jquery.flot.pie.min', 'jquery.flot.stack', 'jquery.flot.resize.min', 'jquery.chosen.min',
                        'jquery.uniform.min', 'jquery.colorbox.min', 'jquery.cleditor.min', 'jquery.noty', 'jquery.elfinder.min', 'jquery.raty.min', 'jquery.iphone.toggle',
                        'jquery.autogrow-textarea', 'jquery.uploadify-3.1.min', 'jquery.history', 'charisma',
        ),
        array('inline' => false));

?>
<form action="<?php echo AdminUrl::userSearch($word, $order); ?>" method="get" id="search_form">
    <div class="row-fluid">
        <div class="span12">
            <div class="control-group">
                <div class="controls">
                    <div class="input-append">
                        <input type="text" value="<?php echo $word; ?>" id="word" name="word" class="input-xlarge focused" placeholder="ユーザーID・ニックネーム・メールアドレス">
                        <button class="btn btn-primary" type="submit" id="search_button">
                            <i class="icon-search icon-white"></i>
                            検索
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <input type="text" id="order" name="order" value="<?php echo $order; ?>" style="display: none">
            <ul class="menu">
                <li>
                    並び替え：
                </li>
                <li>
                    <?php if ($order && $order != Admin::USERCONDITIONSLIST_ORDER_LATEST) { ?><a href="#" data-type="<?php echo Admin::USERCONDITIONSLIST_ORDER_LATEST; ?>"><?php } ?>
                        登録日順
                    <?php if ($order && $order != Admin::USERCONDITIONSLIST_ORDER_LATEST) { ?></a><?php } ?>
                </li>
                <li>
                    <?php if (!$order || $order != Admin::USERCONDITIONSLIST_ORDER_CLIP_DESC) { ?><a href="#" data-type="<?php echo Admin::USERCONDITIONSLIST_ORDER_CLIP_DESC; ?>"><?php } ?>
                        クリップが多い順
                    <?php if (!$order || $order != Admin::USERCONDITIONSLIST_ORDER_CLIP_DESC) { ?></a><?php } ?>
                </li>
                <li>
                    <?php if (!$order || $order != Admin::USERCONDITIONSLIST_ORDER_PHOTO_DESC) { ?><a href="#" data-type="<?php echo Admin::USERCONDITIONSLIST_ORDER_PHOTO_DESC; ?>"><?php } ?>
                        フォトが多い順
                    <?php if (!$order || $order != Admin::USERCONDITIONSLIST_ORDER_PHOTO_DESC) { ?></a><?php } ?>
                </li>
            </ul>
        </div>
    </div>
</form>
<div class="row-fluid">
    <div class="box span12">
        <div class="box-header well">
            <h2> ユーザー検索</h2>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="width: 100px;">ユーザーID</th>
                        <th>ニックネーム</th>
                        <th>メールアドレス</th>
                        <th>ステータス</th>
                        <th>登録日</th>
                        <th>登録経路</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) {;?>
                    <tr>
                        <td><?php echo $this->Util->matchWordHightlight($word, $user['id']); ?></td>
                        <td><a href="<?php echo PcUrl::userPcSite($user); ?>" target="_blank"><?php echo $this->Util->matchWordHightlight($word, $user['nickname']); ?></a></td>
                        <td><?php echo $this->Util->matchWordHightlight($word, $user['email']); ?></td>
                        <td><?php echo $user['flag_close_account'] ? '<span class="label label-important">退会</span>' :
                                                                        ($user['regist_flg'] == Admin::USERREGISTFLG_PRE ? '<span class="label label-warning">仮登録</span>' :
                                                                        '<span class="label label-success">本登録</span>'); ?></td>
                        <td><?php echo $user['created_at']; ?></td>
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
                        <td><a class="btn" href="<?php echo AdminUrl::userDetail($user); ?>">詳細</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div style="text-align: right;">
                <?php echo number_format($offset); ?> - <?php echo $total > $offset + $limit - 1 ? number_format($offset + $limit - 1) : $total; ?> 件表示中
                (全 <?php echo number_format($total); ?> 件)<br />
            </div>
            <input type="text" id="page" name="page" value="<?php echo $page; ?>" style="display: none;">
            <div class="pagination pagination-centered">
                <ul>
                    <?php if ($page > 1) { ?>
                    <li>
                        <a href="<?php echo AdminUrl::userSearch($word, $order, $page - 1); ?>">Prev</a>
                    </li>
                    <?php } ?>
                    <?php $lastPage = floor(($total / $limit + intval(($total % $limit) != 0))); ?>
                    <?php for ($p = $page; $p <= $page + 10 && $p <= $lastPage; ++$p) { ?>
                    <li<?php echo $p == $page ? ' class="active"' : ''; ?>>
                        <a href="<?php echo AdminUrl::userSearch($word, $order, $p); ?>"><?php echo $p; ?></a>
                    </li>
                    <?php } ?>
                    <?php if ($lastPage > $page) { ?>
                    <li>
                        <a href="<?php echo AdminUrl::userSearch($word, $order, $page + 1); ?>">Next</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div><!--/span-->
</div><!--/row-->
<script>
    $(function() {
        $('.menu li a, #search_button').click(function() {
            $('#order').val($(this).data('type'));

            $('#search_form').submit();
            
            return false;
        });
        
        $('#search_button').click(function() {
            return false;
        });
    });
</script>
