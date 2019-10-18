<?php
$this->Html->css(array('bootstrap-cerulean', 'bootstrap-responsive', 'charisma-app', 'jquery-ui-1.8.21.custom', 'fullcalendar', 'fullcalendar.print', 'chosen', 'uniform.default',
    'colorbox', 'jquery.cleditor', 'jquery.noty', 'noty_theme_default', 'elfinder.min', 'elfinder.theme', 'jquery.iphone.toggle', 'opa-icons', 'uploadify',
        ), null, array('inline' => false));
$this->Html->script(array('jquery-1.8.3.min', 'jquery-ui-1.8.21.custom.min', 'bootstrap-transition', 'bootstrap-alert', 'bootstrap-modal', 'bootstrap-dropdown', 'bootstrap-scrollspy', 'bootstrap-tab',
    'bootstrap-tooltip', 'bootstrap-popover', 'bootstrap-button', 'bootstrap-collapse', 'bootstrap-carousel', 'bootstrap-typeahead', 'bootstrap-tour', 'jquery.cookie',
    'fullcalendar.min', 'jquery.dataTables.min', 'excanvas', 'jquery.flot.min', 'jquery.flot.pie.min', 'jquery.flot.stack', 'jquery.flot.resize.min', 'jquery.chosen.min',
    'jquery.uniform.min', 'jquery.colorbox.min', 'jquery.cleditor.min', 'jquery.noty', 'jquery.elfinder.min', 'jquery.raty.min', 'jquery.iphone.toggle',
    'jquery.autogrow-textarea', 'jquery.uploadify-3.1.min', 'jquery.history', 'charisma',
        ), array('inline' => false));
?>
<div class="row-fluid">
    <div class="box span12">
        <div data-original-title="" class="box-header well">
            <h2><i class="icon-plus"></i> お知らせ作成</h2>
        </div>
        <div class="box-content">
            <form class="form-horizontal" method="post">
                <fieldset>
                    <div class="control-group">
                        <label for="information_title" class="control-label">タイトル</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $informationTitle; ?>" id="information_title" name="information_title" class="input-xlarge focused" required>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="type" class="control-label">お知らせ種別</label>
                        <div class="controls">
                            <select id="type" name="type" required>
                                <option value="">選択してください</option>
                                <option value="<?php echo Admin::INFORMATIONTYPE_PC; ?>" <?php echo $type == Admin::INFORMATIONTYPE_PC ? 'selected' : ''; ?>>
                                    PCサイト
                                </option>
                                <option value="<?php echo Admin::INFORMATIONTYPE_MOBILE; ?>" <?php echo $type == Admin::INFORMATIONTYPE_MOBILE ? 'selected' : ''; ?>>
                                    モバイルサイト
                                </option>
                                <option value="<?php echo Admin::INFORMATIONTYPE_SMARTPHONE; ?>" <?php echo $type == Admin::INFORMATIONTYPE_SMARTPHONE ? 'selected' : ''; ?>>
                                    スマートフォンサイト
                                </option>
                                <option value="<?php echo Admin::INFORMATIONTYPE_SMARTPHONE_APP; ?>" <?php echo $type == Admin::INFORMATIONTYPE_SMARTPHONE_APP ? 'selected' : ''; ?>>
                                    スマートフォンアプリ
                                </option>
                                <option value="<?php echo Admin::INFORMATIONTYPE_TENANT_TOOL; ?>" <?php echo $type == Admin::INFORMATIONTYPE_TENANT_TOOL ? 'selected' : ''; ?>>
                                    店舗ツール
                                </option>
                                <option value="<?php echo Admin::INFORMATIONTYPE_AGENCY_TOOL; ?>" <?php echo $type == Admin::INFORMATIONTYPE_AGENCY_TOOL ? 'selected' : ''; ?>>
                                    代理店ツール
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="information_body">本文</label>
                        <div class="controls">
                            <textarea class="cleditor" id="information_body" name="information_body" rows="3"><?php echo $informationBody; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button class="btn btn-primary" type="submit">保存</button>
                        <button class="btn" type="reset">キャンセル</button>
                    </div>
                </fieldset>
            </form>   
        </div>
    </div><!--/span-->
</div><!--/row-->
<script>
    $(function() {
    });
</script>
