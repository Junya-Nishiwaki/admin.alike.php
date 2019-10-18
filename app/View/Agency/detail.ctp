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
    <div class="box span12">
        <div class="box-header well">
            <h2> 代理店詳細</h2>
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
                        <td>代理店名</td>
                        <td><?php echo h($agency['name']); ?></a></td>
                    </tr>
                    <tr>
                        <td>代理店コード</td>
                        <td><?php echo $agency['code']; ?></td>
                    </tr>
                    <tr>
                        <td>代理店タイプ</td>
                        <td><?php echo $agency['agency_type']; ?></td>
                    </tr>
                    <tr>
                        <td>郵便番号</td>
                        <td><?php echo h($agency['zipcode']); ?></td>
                    </tr>
                    <tr>
                        <td>住所</td>
                        <td><?php echo h(implode(' ', array($agency['areas'][0]['name'], $agency['addr_city'], $agency['addr_street'], $agency['addr_building']))); ?></td>
                    </tr>
                    <tr>
                        <td>電話番号</td>
                        <td><?php echo h($agency['phone']); ?></td>
                    </tr>
                    <tr>
                        <td>FAX番号</td>
                        <td><?php echo h($agency['fax']); ?></td>
                    </tr>
                    <tr>
                        <td>担当者名</td>
                        <td><?php echo h($agency['contact_name']); ?></td>
                    </tr>
                    <tr>
                        <td>担当者 E-Mail</td>
                        <td><?php echo h($agency['contact_email']); ?></td>
                    </tr>
                    <tr>
                        <td>担当者 モバイルE-Mail</td>
                        <td><?php echo h($agency['contact_email_mobile']); ?></td>
                    </tr>
                    <tr>
                        <td>担当者 電話番号</td>
                        <td><?php echo h($agency['contact_phone']); ?></td>
                    </tr>
                    <tr>
                        <td>口座情報</td>
                        <td><?php echo $agency['bank_account']; ?></td>
                    </tr>
                    <tr>
                        <td>作成日</td>
                        <td><?php echo $agency['created_at']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div><!--/span-->
</div><!--/row-->

