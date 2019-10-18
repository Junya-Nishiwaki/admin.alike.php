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
    <div class="span10">
        <div class="control-group">
            <div class="controls">
                <div class="input-append">
                    <form method="get" id="search_form">
                        <input type="text" value="<?php echo $word; ?>" id="word" name="word" class="input-xlarge focused" placeholder="店舗ID・店舗名・店舗名よみ・電話番号・住所">
                        <button class="btn btn-primary" type="submit" id="search_button">
                            <i class="icon-search icon-white"></i>
                            検索
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="span2">
        <a href="#" class="btn btn-success">
            <i class="icon-plus icon-white"></i>
            店舗を追加する
        </a>
    </div>
</div>
<div class="row-fluid">
    <div class="box span12">
        <div class="box-header well">
            <h2> 店舗検索</h2>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="width: 100px;">店舗ID</th>
                        <th>店舗名</th>
                        <th>店舗名かな</th>
                        <th>カテゴリ</th>
                        <th>住所</th>
                        <th style="width: 100px;">電話番号</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tenants as $tenant) { ?>
                    <?php $categoryName = $tenant['category']['id'] == CATEGORY_GOURMET ? 'グルメ' : ($tenant['category']['id'] == CATEGORY_BEAUTY ? 'リラクゼーション＆ビューティ' : 'ホテル'); ?>
                    <tr>
                        <td><?php echo $this->Util->matchWordHightlight($word, $tenant['id']); ?></td>
                        <td><a href="<?php echo PcUrl::tenantPcSite($tenant); ?>" target="_blank"><?php echo $this->Util->matchWordHightlight($word, $tenant['name']); ?></a></td>
                        <td><?php echo array_key_exists('name_kana', $tenant) ? $this->Util->matchWordHightlight($word, $tenant['name_kana']) : ''; ?></td>
                        <td><?php echo $categoryName; ?></td>
                        <td><?php echo $this->Util->matchWordHightlight($word, $tenant['address_1']) . $this->Util->matchWordHightlight($word, $tenant['address_2']); ?></td>
                        <td><?php echo array_key_exists('telno', $tenant) ? $this->Util->matchWordHightlight($word, $tenant['telno']) : ''; ?></td>
                        <td><a class="btn" href="<?php echo AdminUrl::tenantDetail($tenant); ?>">詳細</a></td>
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
                        <a href="<?php echo AdminUrl::tenantSearch($word, $page - 1); ?>">Prev</a>
                    </li>
                    <?php } ?>
                    <?php $lastPage = floor(($total / $limit + intval(($total % $limit) != 0))); ?>
                    <?php for ($p = $page; $p <= $page + 10 && $p <= $lastPage; ++$p) { ?>
                    <li<?php echo $p == $page ? ' class="active"' : ''; ?>>
                        <a href="<?php echo AdminUrl::tenantSearch($word, $p); ?>"><?php echo $p; ?></a>
                    </li>
                    <?php } ?>
                    <?php if ($lastPage > $page) { ?>
                    <li>
                        <a href="<?php echo AdminUrl::tenantSearch($word, $page + 1); ?>">Next</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div><!--/span-->
</div><!--/row-->
