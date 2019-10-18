<?php
$this->Html->css(array('bootstrap-cerulean', 'bootstrap-responsive', 'charisma-app', 'jquery-ui-1.8.21.custom', 'fullcalendar', 'fullcalendar.print', 'chosen', 'uniform.default',
                            'colorbox', 'jquery.cleditor', 'jquery.noty', 'noty_theme_default', 'elfinder.min', 'elfinder.theme', 'jquery.iphone.toggle', 'opa-icons', 'uploadify',
        ),
        null, array('inline' => false));
$this->Html->script(array('jquery-1.7.2.min', 'jquery-ui-1.8.21.custom.min', 'bootstrap-transition', 'bootstrap-alert', 'bootstrap-modal', 'bootstrap-dropdown', 'bootstrap-scrollspy', 'bootstrap-tab',
                        'bootstrap-tooltip', 'bootstrap-popover', 'bootstrap-button', 'bootstrap-collapse', 'bootstrap-carousel', 'bootstrap-typeahead', 'bootstrap-tour', 'jquery.cookie',
                        'fullcalendar.min', 'jquery.dataTables.min', 'excanvas', 'jquery.flot.min', 'jquery.flot.pie.min', 'jquery.flot.stack', 'jquery.flot.resize.min', 'jquery.chosen.min',
                        'jquery.uniform.min', 'jquery.colorbox.min', 'jquery.cleditor.min', 'jquery.noty', 'jquery.elfinder.min', 'jquery.raty.min', 'jquery.iphone.toggle',
                        'jquery.autogrow-textarea', 'jquery.uploadify-3.1.min', 'jquery.history', 'charisma',
                        // TODO 共通化
                        'https://maps.googleapis.com/maps/api/js?key=' . getGoogleApiKey() . '&sensor=false&libraries=geometry'
        ),
        array('inline' => false));
?>
<style type="text/css">
#mapmodal {
	display: none;
	position: absolute;
    top: 0px;
    left: 0px;
	width: 100%;
	height: 100%;
}
#mapmodal_background {
	position: absolute;
    top: 0px;
    left: 0px;
	width: 100%;
	height: 100%;
	background-color: #000000;
	opacity: 0.75;
	filter: alpha(opacity=75);
	-ms-filter: 'alpha(opacity=75)';
}
#mapmodal_buttons {
	position: absolute;
    top: 0px;
    left: 0px;
    z-index: 1;
}
#mapmodal_container {
	position: absolute;
    top: 0px;
    left: 0px;
	width: 600px;
	height: 600px;
}

ul.genres {
    list-style-type: none;
    margin: 0 2px;
    padding: 2px;
    width: 25%;
    float: left;
    min-height: 1.5em;
    height: 200px;
    overflow: auto;
}
ul.genres li {
    margin: 3px;
    padding: 0.3em;
    padding-left: 1em;
    font-size: 15px;
    font-weight: bold;
    cursor: move;
}
ul.genres li.title {
    background: #369bd7;
    color: #fff;
}
</style>
<div id="mapmodal">
    <div id="mapmodal_background"></div>
    <div id="mapmodal_buttons" class="btn-group">
        <div id="mapmodal_reset" class="btn btn-minimize btn-success">リセット</div>
        <div id="mapmodal_cancel" class="btn btn-minimize btn-warning">キャンセル</div>
        <div id="mapmodal_close" class="btn btn-minimize btn-primary">決定</div>
    </div>
    <iframe id="mapmodal_container" src=""></iframe>
</div><!-- modal -->
<div class="row-fluid">
    <div class="box span12">
        <div class="box-header well">
            <h2> 店舗情報編集</h2>
        </div>
        <div class="box-content">
            <form class="form-horizontal" method="post" id="edit_form">
                <fieldset>
                    <div class="control-group">
                        <label for="name" class="control-label">店舗名</label>
                        <div class="controls">
                            <input type="text" id="name" value="<?php echo h($tenant['name']); ?>" name="name" class="input-xlarge focused" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="name_kana" class="control-label">店舗名かな(ヨミ)</label>
                        <div class="controls">
                            <input type="text" id="name_kana" value="<?php echo array_key_exists('name_kana', $tenant) ?
                                    h($tenant['name_kana']) : ''; ?>" name="name_kana" class="input-xlarge focused">
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="telno" class="control-label">電話番号</label>
                        <div class="controls">
                            <input type="text" id="telno" value="<?php echo array_key_exists('telno', $tenant) ?
                                    h($tenant['telno']) : ''; ?>" name="telno" class="input-xlarge focused">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="tel_open_flg" class="control-label">電話番号非公開</label>
                        <div class="controls">
                            <input type="checkbox" id="tel_open_flg"
                                   value="1" name="tel_open_flg" class="input-xlarge focused" <?php echo !$tenant['tel_open_flg'] ? 'checked' : '';?>>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="address_1" class="control-label">住所1</label>
                        <div class="controls">
                            <input type="text" id="address_1" value="<?php echo h($tenant['address_1']); ?>" name="address_1" class="input-xlarge focused" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="address_2" class="control-label">住所2</label>
                        <div class="controls">
                            <input type="text" id="address_2" value="<?php echo array_key_exists('address_2', $tenant) ?
                                    h($tenant['address_2']) : ''; ?>" name="address_2" class="input-xlarge focused">
                        </div>
                    </div>
                    
                    <input type="text" value="<?php echo $tenant['lat']; ?>" id="lat" name="lat" class="input-xlarge focused" required style="display: none;">
                    <input type="text" value="<?php echo $tenant['lng']; ?>" id="lng" name="lng" class="input-xlarge focused" required style="display: none;">
                    <div class="control-group">
                        <label for="map" class="control-label">地図</label>
                        <div class="controls">
                            <a id="map" href="/tenant/map" class="btn btn-info">地図を編集する</a>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="url" class="control-label">公式ホームページ</label>
                        <div class="controls">
                            <input type="text" id="url" value="<?php echo array_key_exists('url', $tenant) ?
                                    h($tenant['url']) : ''; ?>" name="url" class="input-xlarge focused">
                        </div>
                    </div>
                    
                    <?php if ($tenant['category']['id'] == CATEGORY_GOURMET) { ?>
                    <div class="control-group">
                        <label for="budget_1" class="control-label">予算(ランチ)</label>
                        <div class="controls">
                            <select id="budget_1" name="budget_1">
                                <option value="0">-</option>
                                <?php
                                foreach ($budgetMasters as $budget) {
                                    if ($budget['type'] == BUDGET_TYPE_LUNCH) {
                                        $selected = '';
                                        if (array_key_exists('budgets', $tenant)) {
                                            foreach ($tenant['budgets'] as $b) {
                                                if ($b['type'] == BUDGET_TYPE_LUNCH && $b['id'] == $budget['id']) {
                                                    $selected = 'selected';
                                                    break;
                                                }
                                            }
                                        }
                                ?>
                                <option value="<?php echo $budget['id']; ?>" <?php echo $selected; ?>><?php echo $budget['range']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="budget_2" class="control-label">予算(ディナー)</label>
                        <div class="controls">
                            <select id="budget_2" name="budget_2">
                                <option value="0">-</option>
                                <?php
                                foreach ($budgetMasters as $budget) {
                                    if ($budget['type'] == BUDGET_TYPE_DINNER) {
                                        $selected = '';
                                        if (array_key_exists('budgets', $tenant)) {
                                            foreach ($tenant['budgets'] as $b) {
                                                if ($b['type'] == BUDGET_TYPE_DINNER && $b['id'] == $budget['id']) {
                                                    $selected = 'selected';
                                                    break;
                                                }
                                            }
                                        }
                                ?>
                                <option value="<?php echo $budget['id']; ?>" <?php echo $selected; ?>><?php echo $budget['range']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="budget_3" class="control-label">予算(その他)</label>
                        <div class="controls">
                            <select id="budget_3" name="budget_3">
                                <option value="0">-</option>
                                <?php
                                foreach ($budgetMasters as $budget) {
                                    if ($budget['type'] == BUDGET_TYPE_OTHER) {
                                        $selected = '';
                                        if (array_key_exists('budgets', $tenant)) {
                                            foreach ($tenant['budgets'] as $b) {
                                                if ($b['type'] == BUDGET_TYPE_OTHER && $b['id'] == $budget['id']) {
                                                    $selected = 'selected';
                                                    break;
                                                }
                                            }
                                        }
                                ?>
                                <option value="<?php echo $budget['id']; ?>" <?php echo $selected; ?>><?php echo $budget['range']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php } else if ($tenant['category']['id'] == CATEGORY_BEAUTY) { ?>
                    <div class="control-group">
                        <label for="budget_1" class="control-label">予算</label>
                        <div class="controls">
                            <select id="budget_1" name="budget_1">
                                <option value="0">-</option>
                                <?php foreach ($budgetMasters as $budget) { ?>
                                <?php
                                        $selected = '';
                                        if (array_key_exists('budgets', $tenant)) {
                                            foreach ($tenant['budgets'] as $b) {
                                                if ($b['type'] == BUDGET_TYPE_BEAUTY && $b['id'] == $budget['id']) {
                                                    $selected = 'selected';
                                                    break;
                                                }
                                            }
                                        }
                                ?>
                                <option value="<?php echo $budget['id']; ?>" <?php echo $selected; ?>><?php echo $budget['range']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php } else if ($tenant['category']['id'] == CATEGORY_HOTEL) { ?>
                    <div class="control-group">
                        <label for="budget_1" class="control-label">予算(宿泊)</label>
                        <div class="controls">
                            <select id="budget_1" name="budget_1">
                                <option value="0">-</option>
                                <?php
                                foreach ($budgetMasters as $budget) {
                                    if ($budget['type'] == BUDGET_TYPE_DAY) {
                                        $selected = '';
                                        if (array_key_exists('budgets', $tenant)) {
                                            foreach ($tenant['budgets'] as $b) {
                                                if ($b['type'] == BUDGET_TYPE_DAY && $b['id'] == $budget['id']) {
                                                    $selected = 'selected';
                                                    break;
                                                }
                                            }
                                        }
                                ?>
                                <option value="<?php echo $budget['id']; ?>" <?php echo $selected; ?>><?php echo $budget['range']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="budget_2" class="control-label">予算(日帰り)</label>
                        <div class="controls">
                            <select id="budget_2" name="budget_2">
                                <option value="0">-</option>
                                <?php
                                foreach ($budgetMasters as $budget) {
                                    if ($budget['type'] == BUDGET_TYPE_STAY) {
                                        $selected = '';
                                        if (array_key_exists('budgets', $tenant)) {
                                            foreach ($tenant['budgets'] as $b) {
                                                if ($b['type'] == BUDGET_TYPE_STAY && $b['id'] == $budget['id']) {
                                                    $selected = 'selected';
                                                    break;
                                                }
                                            }
                                        }
                                ?>
                                <option value="<?php echo $budget['id']; ?>" <?php echo $selected; ?>><?php echo $budget['range']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <div class="control-group">
                        <label for="note_hour" class="control-label">営業時間</label>
                        <div class="controls">
                            <textarea id="note_hour" name="note_hour" class="autogrow focused span6"><?php echo array_key_exists('note_hour', $tenant) ? h($tenant['note_hour']) : ''; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="note_holiday" class="control-label">定休日</label>
                        <div class="controls">
                            <textarea id="note_holiday" name="note_holiday" class="autogrow focused span6"><?php echo array_key_exists('note_holiday', $tenant) ? h($tenant['note_holiday']) : ''; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="genres" class="control-label">ジャンル</label>

                        <?php $hasGenreId = array(); ?>
                        <div class="controls">
                            <ul id="set_genres" class="genres">
                                <li class="ui-state-default title">
                                  設定するジャンル
                                </li>
                                <?php foreach ($tenant['genres'] as $genre) { ?>
                                <?php $hasGenreId[] = $genre['id']; ?>
                                <li class="ui-state-default" value="<?php echo $genre['id']; ?>">
                                    <?php echo $genre['name']; ?>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                        
                        <div class="controls">
                            <ul class="genres">
                                <li class="ui-state-default title">
                                  ジャンル一覧
                                </li>
                                <?php
                                foreach ($genreMasters as $genre) {
                                    // 小ジャンルのみ
                                    if ($genre['type'] == GENRELEVEL_SMALL) {
                                        // 既に所持しているジャンルは表示しない
                                        if (in_array($genre['id'], $hasGenreId)) continue;
                                ?>
                                <li class="ui-state-default" value="<?php echo $genre['id']; ?>">
                                    <?php echo $genre['name']; ?>
                                </li>
                                <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>

                    <?php if (array_key_exists('situations', $tenant)) { ?>
                    <?php foreach ($tenant['situations']['items'] as $situation) { ?>
                    <input type="hidden" id="situations[]" name="situations[]" value="<?php echo $situation['id']; ?>">
                    <?php } ?>
                    <?php } ?>
                    <input type="hidden" id="category" name="category" value="<?php echo $tenant['category']['id']; ?>">
                    <div class="form-actions">
                        <button class="btn btn-primary" type="submit">保存</button>
                        <a class="btn" type="reset" onclick="location.href = '<?php echo AdminUrl::tenantDetail($tenant); ?>'; return false;">キャンセル</a>
                    </div>
                </fieldset>
            </form>
        </div>
    </div><!--/span-->
</div><!--/row-->
<script>
    var scroll = 0;
    
    $(function() {
        $('.genres').sortable({
            connectWith: '.genres',
            cancel : '.title'
        });
        $('.genres').disableSelection();

        $('#edit_form button[type=submit]').click(function() {
            var eleList = $('#set_genres li:not(.title)');

            if (eleList.length === 0) {
                alert('ジャンルを設定してください');
                return false;
            }

            eleList.each(function() {
                $('#edit_form').append('<input type="hidden" id="genres[]" name="genres[]" value="' + $(this).val() + '">');
            });
        });
        setModal();
    });
    
    function setModal() {
        $('#mapmodal').height($(document).height());
        
        $(window).scroll(function() {
            scroll = $(this).scrollTop();
        });
        
        // リンクがクリックされた時にAjaxでコンテンツを読み込む
        $('#map').click(function() {
            $('#mapmodal #mapmodal_container').attr('src', $(this).attr('href') + '?' +
                'lat=' + $('#lat').val() + '&lng=' + $('#lng').val());

            // コンテンツの読み込み完了時にモーダルウィンドウを開く
            $('#mapmodal #mapmodal_container').load(function() {
                displayModal(true);
                $('#mapmodal_close').click(function() {
                    $('#lat').val($('#mapmodal_container').contents().find('#lat').val());
                    $('#lng').val($('#mapmodal_container').contents().find('#lng').val());
                    
                    displayModal(false);
                    
                    return false;
                });
                
                $('#mapmodal_reset').click(function() {
                    $('#mapmodal_container').contents().find('#lat').val(<?php echo $tenant['lat']; ?>).change();
                    $('#mapmodal_container').contents().find('#lng').val(<?php echo $tenant['lng']; ?>).change();
                    $('#lat').val($('#mapmodal_container').contents().find('#lat').val());
                    $('#lng').val($('#mapmodal_container').contents().find('#lng').val());
                    
                    displayModal(false);
                    
                    return false;
                });
                
                $('#mapmodal_background,#mapmodal_cancel').click(function() {                    
                    displayModal(false);
                    
                    return false;
                });

            });

            return false;
        });
    }
    
    // モーダルウィンドウを開く
    function displayModal(sign) {
        if (sign) {
            adjustCenter('#mapmodal #mapmodal_container');

            $('#mapmodal_buttons').css('top', parseInt($('#mapmodal_container').css('top')) + 15);
            $('#mapmodal_buttons').css('left',
                parseInt($('#mapmodal_container').css('left')) + (parseInt($('#mapmodal_container').css('width')) * 0.6));

            $('#mapmodal').fadeIn(500);
        } else {
            $('#mapmodal').fadeOut(250);
        }
    }
    
    // ウィンドウの位置をセンターに調整
    function adjustCenter(target) {
        var marginTop = ($(window).height() - $(target).height()) / 2 + 15 + scroll;
        var marginLeft = ($(window).width() - $(target).width()) / 2;
        
        $(target).css({top: marginTop + 'px', left: marginLeft + 'px'});
    }
</script>