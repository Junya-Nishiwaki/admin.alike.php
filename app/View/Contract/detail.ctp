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
            <h2> 契約店舗詳細</h2>
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
                        <td>店舗名</td>
                        <td><a href="<?php echo PcUrl::tenantPcSite($tenant); ?>" target="_blank"><?php echo h($tenant['name']); ?></a></td>
                    </tr>
                    <tr>
                        <td>カテゴリ</td>
                        <td><?php echo $tenant['category']['name']; ?></td>
                    </tr>
                    <tr>
                        <td>契約者名</td>
                        <td><?php echo h($contract['backoffice']['contract_name']); ?></td>
                    </tr>
                    <tr>
                        <td>契約者郵便番号</td>
                        <td><?php echo h($contract['backoffice']['contract_zipcode']); ?></td>
                    </tr>
                    <tr>
                        <td>契約者住所</td>
                        <td><?php echo h($contract['backoffice']['contract_addr_city']) . ' ' .
                                        h($contract['backoffice']['contract_addr_street']) . ' ' .
                                        h($contract['backoffice']['contract_addr_building']); ?></td>
                    </tr>
                    <tr>
                        <td>契約者電話番号</td>
                        <td><?php echo h($contract['backoffice']['contract_phone']); ?></td>
                    </tr>
                    <tr>
                        <td>契約者FAX番号</td>
                        <td><?php echo h($contract['backoffice']['contract_fax']); ?></td>
                    </tr>
                    <tr>
                        <td>担当者名</td>
                        <td><?php echo h($contract['backoffice']['contact_name']); ?></td>
                    </tr>
                    <tr>
                        <td>担当者 E-Mail</td>
                        <td><?php echo h($contract['backoffice']['contact_email']); ?></td>
                    </tr>
                    <tr>
                        <td>担当者電話番号</td>
                        <td><?php echo h($contract['backoffice']['contact_phone']); ?></td>
                    </tr>
                    <tr>
                        <td>担当代理店名</td>
                        <td><?php echo h($agency['name']); ?></td>
                    </tr>
                    <tr>
                        <td>利用プラン</td>
                        <td><?php echo $contract['contract']['service_name']; ?></td>
                    </tr>
                    <tr>
                        <td>登録日時</td>
                        <td><?php echo $contract['contract']['begin_time']; ?></td>
                    </tr>
                    <tr>
                        <td>現在の状態</td>
                        <td>
                            <?php echo $contract['status_text']; ?>
                            <?php // TODO 定数化 ?>
                            <?php if (!$contract['contract']['is_active'] && $contract['status'] == 2) { ?>
                            <a href="<?php echo AdminUrl::contractActivate($tenant); ?>" class="btn btn-primary">利用権限付与</a>
                            <?php } ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="span12">
            <form method="post" action="<?php echo PcUrl::tenantToolOnetimeLogin(); ?>" target="_blank">
                <input type="hidden" name="tenant_id" value="<?php echo $tenant['id']; ?>">
                <input type="submit" class="btn btn-primary" value="店舗ツールワンタイムログイン">
            </form>
        </div>
    </div><!--/span-->
</div><!--/row-->

