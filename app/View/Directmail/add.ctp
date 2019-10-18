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
            <h2><i class="icon-plus"></i> ダイレクトメール作成</h2>
        </div>
        <div class="box-content">
            <form class="form-horizontal" method="post">
                <fieldset>
                    <div class="control-group">
                        <div class="control-group">
                            <label for="gender" class="control-label">性別</label>
                            <div class="controls">
                                <select id="gender" name="gender">
                                    <option value="">選択してください</option>
                                    <option value="1" <?php echo $gender == 1 ? 'selected' : ''; ?>>
                                        男性
                                    </option>
                                    <option value="2" <?php echo $gender == 2 ? 'selected' : ''; ?>>
                                        女性
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="generation" class="control-label">年代</label>
                            <div class="controls">
                                <select id="generation" name="generation">
                                    <option value="">選択してください</option>
                                    <option value="10" <?php echo $generation == 10 ? 'selected' : ''; ?>>
                                        <?php echo generationText(10); ?>
                                    </option>
                                    <option value="20" <?php echo $generation == 20 ? 'selected' : ''; ?>>
                                        <?php echo generationText(20); ?>
                                    </option>
                                    <option value="25" <?php echo $generation == 25 ? 'selected' : ''; ?>>
                                        <?php echo generationText(25); ?>
                                    </option>
                                    <option value="30" <?php echo $generation == 30 ? 'selected' : ''; ?>>
                                        <?php echo generationText(30); ?>
                                    </option>
                                    <option value="35" <?php echo $generation == 35 ? 'selected' : ''; ?>>
                                        <?php echo generationText(35); ?>
                                    </option>
                                    <option value="40" <?php echo $generation == 40 ? 'selected' : ''; ?>>
                                        <?php echo generationText(40); ?>
                                    </option>
                                    <option value="45" <?php echo $generation == 45 ? 'selected' : ''; ?>>
                                        <?php echo generationText(45); ?>
                                    </option>
                                    <option value="50" <?php echo $generation == 50 ? 'selected' : ''; ?>>
                                        <?php echo generationText(50); ?>
                                    </option>
                                    <option value="55" <?php echo $generation == 55 ? 'selected' : ''; ?>>
                                        <?php echo generationText(55); ?>
                                    </option>
                                    <option value="60" <?php echo $generation == 60 ? 'selected' : ''; ?>>
                                        <?php echo generationText(60); ?>
                                    </option>
                                    <option value="65" <?php echo $generation == 65 ? 'selected' : ''; ?>>
                                        <?php echo generationText(65); ?>
                                    </option>
                                    <option value="70" <?php echo $generation == 70 ? 'selected' : ''; ?>>
                                        <?php echo generationText(70); ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="blood_type" class="control-label">血液型</label>
                            <div class="controls">
                                <select id="blood_type" name="blood_type">
                                    <option value="">選択してください</option>
                                    <option value="1" <?php echo $bloodType == 1 ? 'selected' : ''; ?>>
                                        <?php echo bloodTypeText(1); ?>
                                    </option>
                                    <option value="2" <?php echo $bloodType == 2 ? 'selected' : ''; ?>>
                                        <?php echo bloodTypeText(2); ?>
                                    </option>
                                    <option value="4" <?php echo $bloodType == 4 ? 'selected' : ''; ?>>
                                        <?php echo bloodTypeText(4); ?>
                                    </option>
                                    <option value="8" <?php echo $bloodType == 8 ? 'selected' : ''; ?>>
                                        <?php echo bloodTypeText(8); ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="area_id" class="control-label">都道府県</label>
                            <div class="controls">
                                <select id="area_id" name="area_id">
                                    <option value="">選択してください</option>
                                    <?php foreach ($areas as $area) { ?>
                                    <option value="<?php echo $area['id']; ?>" <?php echo $areaId == $area['id'] ? 'selected' : ''; ?>>
                                        <?php echo $area['name']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="work_id" class="control-label">職業</label>
                            <div class="controls">
                                <select id="work_id" name="work_id">
                                    <option value="">選択してください</option>
                                    <?php foreach ($works as $work) { ?>
                                    <option value="<?php echo $work['id']; ?>" <?php echo $workId == $work['id'] ? 'selected' : ''; ?>>
                                        <?php echo $work['name']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="target_user_count" class="control-label">対象ユーザー数</label>
                            <div class="controls">
                                <input type="text" id="condition_user_num" value="<?php echo number_format($userConditionsNum); ?> 人"  class="input-small" disabled style="text-align: right;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="year" class="control-label">送信日時</label>
                        <div class="controls">
                            <select id="year" name="year" class="input-small"></select>年&nbsp;
                            <select id="month" name="month" class="input-mini"></select>月&nbsp;
                            <select id="day" name="day" class="input-mini"></select>日&nbsp;
                            &nbsp;&nbsp;&nbsp;
                            <select id="hour" name="hour" class="input-mini"></select>時&nbsp;
                            <select id="minute" name="minute" class="input-mini"></select>分&nbsp;
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="directmail_title" class="control-label">タイトル</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $title; ?>" id="directmail_title" name="directmail_title" class="input-xxlarge focused" required>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="directmail_body">本文</label>
                        <div class="controls">
                            <textarea class="cleditor" id="directmail_body" name="directmail_body" rows="3"><?php echo $body; ?></textarea>
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
        var date = new Date();
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var hour = date.getHours();

        for (var i = year; i <= year + 1; ++i) {
            if(i === year) {
                $('#year').append('<option value="' + i + '" selected>' + i + '</option>');
            } else {
                $('#year').append('<option value="' + i + '">' + i + '</option>');
            }
        }
        for (var i = 1; i <= 12; ++i) {
            if (i === month) {
                $('#month').append('<option value="' + i + '" selected>' + i + '</option>');
            }
            else {
                $('#month').append('<option value="' + i + '">' + i + '</option>');
            }
        }
        for (var i = 1; i <= new Date(year, month + 1, 0).getDate(); ++i) {
            if (i === day) {
                $('#day').append('<option value="' + i + '" selected>' + i + '</option>');
            }
            else {
                $('#day').append('<option value="' + i + '">' + i + '</option>');
            }
        }
        for (var i = 0; i <= 23; ++i) {
            if (i === hour) {
                $('#hour').append('<option value="' + i + '" selected>' + i + '</option>');
            }
            else {
                $('#hour').append('<option value="' + i + '">' + i + '</option>');
            }
        }
        for (var i = 0; i <= 60; i += 15) {
            $('#minute').append('<option value="' + i + '">' + i + '</option>');
        }

        
        $('select#year').change(function(){
            leapYearCheck();
        });
        $('select#month').change(function(){
            leapYearCheck();
        });

        $('form select').change(function() {
            $.ajax({
                type : 'POST',
                async : true,
                url : '<?php echo AdminUrl::userConditionsList(); ?>',
                data : {
                    directmail_flg : 1,
                    gender : $('#gender').val(),
                    generation : $('#generation').val(),
                    blood_type : $('#blood_type').val(),
                    area_id : $('#area_id').val(),
                    work_id : $('#work_id').val(),
                    offset : 1,
                    limit : 1
                },
                success : function(data, textStatus, jqXHR) {
                    var jsonObj = $.parseJSON(data);
                    
                    if (jsonObj.result != 'success') {
                        alert('エラーが発生しました');
                        location.reload();
                        return false;
                    }
                    
                    $('#condition_user_num').val(jsonObj.total + ' 人');
                },
                error : function(jqXHR, textStatus, errorThrown) {
                    alert('エラーが発生しました');
                    location.reload();
                    return false;
                }
            });
            
            return false;
        });
    });
    
    // うるう年判定して日付を表示
    function leapYearCheck(){
    $('#day').empty();
        var y = $("#year").val();
        var m = $("#month").val();
        if (2 == m && (0 == y % 400 || (0 == y % 4 && 0 != y % 100))) {
          var last = 29;
        } else {
          var last = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31)[m - 1];
        }
        for (var i = 1; i <= last; i++) {
            $('#day').append('<option value="' + i + '">' + i + '</option>');
        }
    }
</script>
