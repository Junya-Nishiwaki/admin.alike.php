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
        <a href="<?php echo AdminUrl::informationEdit($information); ?>" class="btn btn-large btn-success">
            <i class="icon-edit icon-white"></i>  
            編集
        </a>
        <a href="<?php echo AdminUrl::informationDelete($information); ?>" class="btn btn-large btn-danger" onClick="return confirm('削除しますか？'); ">
            <i class="icon-trash icon-white"></i>
            削除
        </a>
    </div><!--/span-->
</div><!--/row-->
<div class="row-fluid">
    <div class="box span12">
        <div class="box-header well">
            <h2> お知らせ詳細</h2>
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
                        <td>タイトル</td>
                        <td><?php echo h($information['title']); ?></a></td>
                    </tr>
                    <tr>
                        <td>種別</td>
                        <td><?php echo $information['type_text']; ?></td>
                    </tr>
                    <tr>
                        <td>作成日</td>
                        <td><?php echo h($information['created_at']); ?></td>
                    </tr>
                    <tr>
                        <td>更新日</td>
                        <td><?php echo h($information['updated_at']); ?></td>
                    </tr>
                    <tr>
                        <td>本文</td>
                        <td><?php echo $information['body']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div><!--/span-->
</div><!--/row-->
