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
<form action="<?php echo AdminUrl::agencyList(); ?>" method="get" id="search_form">
    <div class="row-fluid">
        <div class="span12">
            <div class="control-group">
                <div class="controls">
                    <div class="input-append">
                        <input type="text" value="<?php echo $word; ?>" id="word" name="word" class="input-xlarge focused" placeholder="電話番号・住所・契約者名・代理店名">
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
        <div class="box span12">
            <div class="box-header well">
                <h2> 代理店一覧</h2>
            </div>
            <div class="box-content">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>代理店名</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($agencies as $agency) { ?>
                        <tr>
                            <td><?php echo $this->Util->matchWordHightlight($word, $agency['name']); ?></td>
                            <td><a class="btn" href="<?php echo AdminUrl::agencyDetail($agency); ?>">詳細</a></td>
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
        $('#search_button').click(function() {
            return false;
        });
    });
</script>
