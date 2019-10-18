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
            <h2> メッセージ送信</h2>
        </div>
        <div class="box-content">
            <form class="form-horizontal" method="post">
                <fieldset>
                    <div class="control-group">
                        <label for="nickname" class="control-label">送信先</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $user['nickname']; ?>" id="nickname" name="nickname" disabled>
                            <input type="text" value="<?php echo $user['id']; ?>" id="id" name="id" style="visibility: hidden;">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="message_subject" class="control-label">件名</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $subject; ?>" id="message_subject" name="message_subject" class="input-xlarge focused" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="message_body">本文</label>
                        <div class="controls">
                            <textarea class="cleditor" id="message_body" name="message_body" rows="3"><?php echo $message; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button class="btn btn-primary" type="submit">送信</button>
                        <button class="btn" type="reset">キャンセル</button>
                    </div>
                </fieldset>
            </form>   
        </div>
    </div><!--/span-->
</div><!--/row-->
