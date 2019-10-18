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
<div class="row-fluid">
    <div class="span12">
        <a href="<?php echo AdminUrl::informationAdd(); ?>" class="btn btn-large btn-primary">
            <i class="icon-plus icon-white"></i>
            お知らせを追加する
        </a>
    </div><!-- span -->
</div><!-- row -->
<br />
<form action="<?php echo AdminUrl::informationList(); ?>" method="get" id="search_form">
    <div class="row-fluid">
        <div class="span12">
            <input type="text" id="type" name="type" value="<?php echo $isAll ? 'all' :
                                                                        ($isPc ? 'pc' :
                                                                        ($isMobile ? 'mobile' :
                                                                        ($isSmartPhone ? 'smartphone' :
                                                                        ($isSmartPhoneApp ? 'smartphone_all' :
                                                                        ($isTenantTool ? 'tenant_tool' :
                                                                        ($isAgencyTool ? 'agency_tool' : '')))))); ?>" style="display: none">
            <ul class="menu">
                <li>
                    <?php if (!$isAll) { ?><a href="#" data-type="all"><?php } ?>
                        全て
                    <?php if (!$isAll) { ?></a><?php } ?>
                </li>
                <li>
                    <?php if (!$isPc) { ?><a href="#" data-type="pc"><?php } ?>
                        PCサイト
                    <?php if (!$isPc) { ?></a><?php } ?>
                </li>
                <li>
                    <?php if (!$isMobile) { ?><a href="#" data-type="mobile"><?php } ?>
                        モバイルサイト
                    <?php if (!$isMobile) { ?></a><?php } ?>
                </li>
                <li>
                    <?php if (!$isSmartPhone) { ?><a href="#" data-type="smartphone"><?php } ?>
                        スマートフォンサイト
                    <?php if (!$isSmartPhone) { ?></a><?php } ?>
                </li>
                <li>
                    <?php if (!$isSmartPhoneApp) { ?><a href="#" data-type="smartphone_app"><?php } ?>
                        スマートフォンアプリ
                    <?php if (!$isSmartPhoneApp) { ?></a><?php } ?>
                </li>
                <li>
                    <?php if (!$isTenantTool) { ?><a href="#" data-type="tenant_tool"><?php } ?>
                        店舗ツール
                    <?php if (!$isTenantTool) { ?></a><?php } ?>
                </li>
                <li>
                    <?php if (!$isAgencyTool) { ?><a href="#" data-type="agency_tool"><?php } ?>
                        代理店ツール
                    <?php if (!$isAgencyTool) { ?></a><?php } ?>
                </li>
            </ul>
        </div>
    </div>
    <div class="row-fluid">
        <div class="box span12">
            <div class="box-header well">
                <h2> お知らせ一覧</h2>
            </div>
            <div class="box-content">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>タイトル</th>
                            <th>種別</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($informations as $information) { ?>
                        <tr>
                            <td><?php echo h($information['title']); ?></td>
                            <td><?php echo h($information['type_text']); ?></td>
                            <td><a class="btn" href="<?php echo AdminUrl::informationDetail($information); ?>">詳細</a></td>
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
                            <a href="#" data-page="<?php echo $page - 1; ?>">Prev</a>
                        </li>
                        <?php } ?>
                        <?php $lastPage = floor(($total / $limit + intval(($total % $limit) != 0))); ?>
                        <?php for ($p = $page; $p <= $page + 10 && $p <= $lastPage; ++$p) { ?>
                        <li<?php echo $p == $page ? ' class="active"' : ''; ?>>
                            <a href="#" data-page="<?php echo $p; ?>"><?php echo $p; ?></a>
                        </li>
                        <?php } ?>
                        <?php if ($lastPage > $page) { ?>
                        <li>
                            <a href="#" data-page="<?php echo $page + 1; ?>">Next</a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div><!--/span-->
    </div><!--/row-->
</form>
<script>
    $(function() {
        // 種別
        $('.menu li a, #search_button, .pagination li a').click(function() {
            if ($(this)[0].tagName == 'A') {
                if ($(this).parents('ul').hasClass('menu')) {
                    $('#type').val($(this).data('type'));
                }
                else if ($(this).parents('div').hasClass('pagination')) {
                    $('#page').val($(this).data('page'));
                }
            }

            $('#search_form').submit();
            
            return false;
        });
        
        $('#search_button').click(function() {
            return false;
        });
    });
</script>
