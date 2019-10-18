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

$isSameTimeCoupons = array_key_exists('same_time_coupons', $kattoq);
// 同一期間に同一店舗のクーポンあり
if ($isSameTimeCoupons) {
    $noticeMessage = '<ul>';
    foreach ($kattoq['same_time_coupons'] as $k) {
        $noticeMessage .= '<li><a href="' . AdminUrl::kattoqDetail($k) . '" target="_blank">' . $k['title'] . '</a></li>';
    }
    $noticeMessage .= '</ul>';
}

$indexUrl = AdminUrl::kattoqList(array_key_exists('word', $query) ? $query['word'] : null,
                                    array_key_exists('page', $query) ? $query['page'] : null,
                                    array_key_exists('order', $query) ? $query['order'] : null,
                                    array_key_exists('conditions', $query) ? $query['conditions'] : null);
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
</style>

<?php if ($isSameTimeCoupons) { ?>
<div class="alert alert-block alert-success">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>本クーポンと販売期間が重複しているクーポンがあります。確認してください</strong><br />
    <?php echo $noticeMessage; ?>
</div>
<?php } ?>
<div id="mapmodal">
    <div id="mapmodal_background"></div>
    <div id="mapmodal_buttons" class="btn-group">
        <div id="mapmodal_unlink" class="btn btn-minimize btn-success">紐付け解除</div>
        <div id="mapmodal_cancel" class="btn btn-minimize btn-warning">キャンセル</div>
        <div id="mapmodal_close" class="btn btn-minimize btn-primary">決定</div>
    </div>
    <iframe id="mapmodal_container" src=""></iframe>
</div><!-- modal -->

<div class="row-fluid">
    <a href="<?php echo $indexUrl; ?>" class="btn btn-default">
        <i class="icon-chevron-left"></i>
        一覧に戻る
    </a>
</div>

<div class="row-fluid">
    <div class="box span12">
        <div class="box-header well">
            <h2> かっトククーポン詳細</h2>
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
                        <td>ステータス</td>
                        <td>
                            <?php
                            $label = 'label';
                            // 公開
                            if ($kattoq['activated']) {
                                // 店舗紐付け済み
                                if (array_key_exists('tenant', $kattoq)) {
                                    switch ($kattoq['status']) {
                                        // 販売中・クーポン成立
                                        case Admin::KATTOQ_STATE_REGULAR:
                                        case Admin::KATTOQ_STATE_SUCCESS:
                                            $label = 'label-success';
                                            break;
                                        // クーポン不成立・販売終了
                                        case Admin::KATTOQ_STATE_FAILURE:
                                        case Admin::KATTOQ_STATE_EXPIRE:
                                            $label = '';
                                            break;
                                        // 完売
                                        default:
                                            $label = 'label-info';
                                            break;
                                    }
                                }
                                else {
                                    $label = 'label-warning';
                                }
                            }
                            // 公開停止
                            else {
                                // 既読
                                if ($kattoq['read_flg']) {
                                    $label = 'label-inverse';
                                }
                                // 未読
                                else {
                                    $label = 'label-important';
                                }
                            }
                            ?>
                            <span class="label <?php echo $label; ?>">
                                <?php echo $kattoq['open_status_text']; ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>販売期間</td>
                        <td><?php echo date('Y/n/j H:i:s', strtotime($kattoq['start'])); ?> - <?php echo date('Y/n/j H:i:s', strtotime($kattoq['expire'])); ?></td>
                    </tr>
                    <tr>
                        <td>価格</td>
                        <td><?php echo number_format($kattoq['price']); ?> 円 (通常価格：<?php echo number_format($kattoq['fixed_price']); ?> 円)</td>
                    </tr>
                    <tr>
                        <td>ラ・クーポン クーポンID</td>
                        <td><?php echo $kattoq['sh_coupon_id']; ?></td>
                    </tr>
                    <tr>
                        <td>ラ・クーポン 店舗名</td>
                        <td><?php echo $kattoq['shop_name']; ?></td>
                    </tr>
                    <tr>
                        <td>ラ・クーポン 電話番号</td>
                        <td><?php echo $kattoq['shop_tel']; ?></td>
                    </tr>
                    <tr>
                        <td>ラ・クーポン 住所</td>
                        <td><?php echo $kattoq['shop_address1']; ?></td>
                    </tr>
                    <tr>
                        <td>ラ・クーポン 営業時間</td>
                        <td><?php echo $kattoq['shop_open_hours']; ?></td>
                    </tr>
                    <tr>
                        <td>ラ・クーポン 定休日</td>
                        <td><?php echo $kattoq['shop_horiday']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="box-content">
            
            <form class="form-horizontal" method="post" id="kattoq_update_form">
                <fieldset>
                    <div class="control-group">
                        <label class="control-label" for="tenant_name">店舗</label>
                        <div class="controls" >
                            <input type="hidden" id="tenant_id" name="tenant_id" value="<?php echo array_key_exists('tenant', $kattoq) ? $kattoq['tenant']['id'] : ''; ?>" >
                            <a id="tenant_name" href="<?php echo array_key_exists('tenant', $kattoq) ? PcUrl::tenantPcSite($kattoq['tenant']) : ''; ?>" target="blank_">
                                <?php echo array_key_exists('tenant', $kattoq) ? $kattoq['tenant']['name'] . '&nbsp;&nbsp;&nbsp;' : ''; ?>
                            </a>
                            <a class="btn btn-info" href="/kattoq/tenant_search<?php echo array_key_exists('tenant', $kattoq) ? '?id=' . $kattoq['tenant']['id'] : ''; ?>" id="tenant_search">
                                店舗紐付
                            </a>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="orig_title">タイトル</label>
                        <div class="controls" >
                            <textarea class="span12" id="title" name="orig_title" rows="2"><?php echo $kattoq['orig_title']; ?></textarea>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="orig_use_option">利用条件</label>
                        <div class="controls" >
                            <textarea class="span12" id="use_option" name="orig_use_option" rows="10"><?php echo $kattoq['orig_use_option']; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="orig_note">内容</label>
                        <div class="controls" >
                            <textarea class="span12" id="note" name="orig_note" rows="10"><?php echo $kattoq['orig_note']; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="memo">メモ<br />※表示されません</label>
                        <div class="controls" >
                            <textarea class="span12" id="memo" name="memo" rows="4"><?php echo $kattoq['memo']; ?></textarea>
                        </div>
                    </div>
                    
                    <input type="hidden" id="activated" name="activated" value="<?php echo $kattoq['activated'] ? 1 : 0; ?>">
                    
                    <div class="form-actions">
                        <button class="btn btn-primary" type="button" id="save_button">保存</button>
                        <button class="btn btn-warning" type="button" id="stop_button">公開停止</button>
                        <button class="btn" type="reset">キャンセル</button>
                    </div>
                </fieldset>
            </form>
            
        </div>
    </div><!--/span-->
</div><!--/row-->
<div class="row-fluid">
    <a href="<?php echo $indexUrl; ?>" class="btn btn-default">
        <i class="icon-chevron-left"></i>
        一覧に戻る
    </a>
</div>


<script>
    var scroll = 0;
    $(function() {
        // 店舗紐付けクリック
        $('#tenant_search').click(function() {
            return false;
        });
        // 保存
        $('#save_button').click(function() {
            $('#activated').val(1);
            $('#kattoq_update_form').submit();
            
            return false;
        });
        // 公開停止
        $('#stop_button').click(function() {
            $('#activated').val(0);
            $('#kattoq_update_form').submit();
            
            return false;
        });
        
        setModal();
    });
    
    function setModal() {
        $('#mapmodal').height($(document).height());
        
        $(window).scroll(function() {
            scroll = $(this).scrollTop();
        });
        
        // リンクがクリックされた時にAjaxでコンテンツを読み込む
        $('#tenant_search').click(function() {
            $('#mapmodal #mapmodal_container').attr('src', $(this).attr('href'));

            // コンテンツの読み込み完了時にモーダルウィンドウを開く
            $('#mapmodal #mapmodal_container').load(function() {
                displayModal(true);
                $('#mapmodal_close').click(function() {
                    // 選択した店舗情報取得
                    $('#mapmodal_container').contents().find('.tenant-list-box').children().each(function() {
                        // 選択している店舗
                        // GoogleChrome、Firefox、Safari仕様
                        if ($(this).css('background-color') == 'rgb(255,255,102)' ||
                            // IE仕様
                            $(this).css('background-color') == 'rgb(255, 255, 102)' ||
                            // Opera仕様
                            $(this).css('background-color') == '#FFFF66') {
                            $('#tenant_id').val($(this).data('id'));
                            $('#tenant_name').text($(this).data('name'));
                            $('#tenant_name').attr('href', $(this).data('url'));

                            return false;
                        }
                    });
                    
                    displayModal(false);
                    
                    return false;
                });
                
                $('#mapmodal_background,#mapmodal_unlink').click(function() {                    
                    $('#tenant_id').val(-1);
                    $('#tenant_name').text('');
                    $('#tenant_name').attr('href', '');

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
            $('#mapmodal_buttons').css('left', parseInt($('#mapmodal_container').css('left')) + (parseInt($('#mapmodal_container').css('width')) * 0.6));

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