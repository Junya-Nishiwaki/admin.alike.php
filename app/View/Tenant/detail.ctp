<?php
$this->Html->css(['bootstrap-cerulean', 'bootstrap-responsive', 'charisma-app', 'jquery-ui-1.8.21.custom', 'fullcalendar', 'fullcalendar.print', 'chosen', 'uniform.default',
                            'colorbox', 'jquery.cleditor', 'jquery.noty', 'noty_theme_default', 'elfinder.min', 'elfinder.theme', 'jquery.iphone.toggle', 'opa-icons', 'uploadify',
        ],
        null, ['inline' => false]);
$this->Html->script(['jquery-1.8.3.min', 'jquery-ui-1.8.21.custom.min', 'bootstrap-transition', 'bootstrap-alert', 'bootstrap-modal', 'bootstrap-dropdown', 'bootstrap-scrollspy', 'bootstrap-tab',
                        'bootstrap-tooltip', 'bootstrap-popover', 'bootstrap-button', 'bootstrap-collapse', 'bootstrap-carousel', 'bootstrap-typeahead', 'bootstrap-tour', 'jquery.cookie',
                        'fullcalendar.min', 'jquery.dataTables.min', 'excanvas', 'jquery.flot.min', 'jquery.flot.pie.min', 'jquery.flot.stack', 'jquery.flot.resize.min', 'jquery.chosen.min',
                        'jquery.uniform.min', 'jquery.colorbox.min', 'jquery.cleditor.min', 'jquery.noty', 'jquery.elfinder.min', 'jquery.raty.min', 'jquery.iphone.toggle',
                        'jquery.autogrow-textarea', 'jquery.uploadify-3.1.min', 'jquery.history', 'charisma',
        ],
        ['inline' => false]);
?>
<style type="text/css">
#delete_modal {
	display: none;
	position: absolute;
    top: 0px;
    left: 0px;
	width: 100%;
	height: 100%;
}
#delete_modal_background {
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
#delete_modal_buttons {
	position: absolute;
    top: 0px;
    left: 0px;
    z-index: 1;
}
#tenant_delete_form {
	position: absolute;
    top: 0px;
    left: 0px;
	width: 600px;
	height: 600px;
}
</style>
<div id="delete_modal">
    <div id="delete_modal_background"></div>
    <form method="post" action="<?php echo AdminUrl::tenantDelete($tenant); ?>" id="tenant_delete_form">
        <textarea id="tenant_delete_memo" name="tenant_delete_memo" placeholder="削除理由を記載してください" rows="4"></textarea><br>
        <a href="#" class="btn btn-minimize btn-danger" id="tenant_delete_complete">
            <i class="icon-trash icon-white"></i>
            削除する
        </a>
        <div id="delete_modal_cancel" class="btn btn-minimize btn-warning">
            キャンセル
        </div>
    </form>
</div><!-- modal -->

<div class="row-fluid">
    <div class="span1">
        <a href="<?php echo AdminUrl::tenantEdit($tenant); ?>" class="btn btn-large btn-primary" id="edit">
            <i class="icon-edit icon-white"></i>
            編集する
        </a>
    </div><!--/span-->
    <?php // 契約店舗でなければ ?>
    <?php if (!$tenant['is_contractor']) { ?>
    <div class="span1">
        <a href="<?php echo AdminUrl::tenantClose($tenant); ?>" class="btn btn-large btn-warning" id="tenant_close">
            <i class="icon-remove icon-white"></i>
            閉店処理
        </a>
    </div><!--/span-->
    <div class="span1">
        <a href="#" class="btn btn-large btn-danger" id="tenant_delete">
            <i class="icon-trash icon-white"></i>
            削除する
        </a>
    </div><!--/span-->
    <?php } ?>
</div>
<div class="row-fluid">
    <div class="box span12">
        <div class="box-header well">
            <h2> 店舗詳細</h2>
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
                        <td>店舗ID</td>
                        <td><?php echo $tenant['id']; ?></a></td>
                    </tr>
                    <tr>
                        <td>店舗名</td>
                        <td><a href="<?php echo PcUrl::tenantPcSite($tenant); ?>" target="_blank"><?php echo h($tenant['name']); ?></a></td>
                    </tr>
                    <tr>
                        <td>店舗名かな</td>
                        <td><?php echo array_key_exists('name_kana', $tenant) ? h($tenant['name_kana']) : ''; ?></td>
                    </tr>
                    <tr>
                        <td>カテゴリ</td>
                        <?php $categoryName = $tenant['category']['id'] == CATEGORY_GOURMET ? 'グルメ' : ($tenant['category']['id'] == CATEGORY_BEAUTY ? 'リラクゼーション＆ビューティ' : 'ホテル'); ?>
                        <td><?php echo $categoryName; ?></td>
                    </tr>
                    <tr>
                        <td>電話番号</td>
                        <td><?php echo array_key_exists('telno', $tenant) ? h($tenant['telno']) : ''; ?></td>
                    </tr>
                    <tr>
                        <td>電話番号公開/非公開</td>
                        <td><?php echo $tenant['tel_open_flg'] ? '公開' : '非公開'; ?></td>
                    </tr>
                    <tr>
                        <td>住所1</td>
                        <td><?php echo array_key_exists('address_1', $tenant) ? h($tenant['address_1']) : ''; ?></td>
                    </tr>
                    <tr>
                        <td>住所2</td>
                        <td><?php echo array_key_exists('address_2', $tenant) ? h($tenant['address_2']) : ''; ?></td>
                    </tr>
                    <tr>
                        <td>予算</td>
                        <td>
                            <?php
                            if (array_key_exists('budgets', $tenant)) {
                                $budgetNme = [1 => 'ランチ', 2 => 'ディナー', 3 => 'その他', 5 => 'ビューティ', 6 => '宿泊', 7 => '日帰り'];
                                foreach ($tenant['budgets'] as $budget) {
                            ?>
                            <?php echo $budgetNme[$budget['id']]; ?>：<?php echo $budget['range']; ?><br />
                            <?php
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>営業時間</td>
                        <td><?php echo array_key_exists('note_hour', $tenant) ? h($tenant['note_hour']) : ''; ?></td>
                    </tr>
                    <tr>
                        <td>定休日</td>
                        <td><?php echo array_key_exists('note_holiday', $tenant) ? h($tenant['note_holiday']) : ''; ?></td>
                    </tr>
                    <tr>
                        <td>状態</td>
                        <td><?php echo $this->Tenant->getStatusHtml($tenant); ?></td>
                    </tr>
                    <tr>
                        <td>店舗ホームページ</td>
                        <td><?php echo array_key_exists('url', $tenant) ? h($tenant['url']) : ''; ?></td>
                    </tr>
                    <tr>
                        <td>登録ユーザー</td>
                        <td>
                            <?php if (array_key_exists('created_user', $tenant)) { ?>
                            <a href="<?php echo $this->Url->userDetail($tenant['created_user']);?>" target="_blank">
                                <?php echo h($tenant['created_user']['nickname']); ?>
                            </a>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>最終更新ユーザー</td>
                        <td>
                            <?php if (array_key_exists('updated_user', $tenant)) { ?>
                            <a href="<?php echo $this->Url->userDetail($tenant['updated_user']);?>" target="_blank">
                                <?php echo h($tenant['updated_user']['nickname']); ?>
                            </a>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>クリップ数</td>
                        <td><?php echo $tenant['num_clips']; ?></td>
                    </tr>
                    <tr>
                        <td>フォト数</td>
                        <td><?php echo $tenant['num_photos']; ?></td>
                    </tr>
                    <tr>
                        <td>メニュー数</td>
                        <td><?php echo $tenant['num_menus']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php // 契約店舗ならば ?>
        <?php if ($tenant['is_contractor']) { ?>
        <div class="span12">
            <form method="post" action="<?php echo PcUrl::tenantToolOnetimeLogin(); ?>" target="_blank">
                <input type="hidden" name="tenant_id" value="<?php echo $tenant['id']; ?>">
                <input type="submit" class="btn btn-primary" value="店舗ツールワンタイムログイン">
            </form>
        </div>
        <?php } ?>
    </div><!--/span-->
</div><!--/row-->
<script>
    var scroll = 0;
    
    $(function() {
        $('#tenant_close').click(function() {
            if (confirm('閉店処理を実行しますか？')) {
                return true;
            } 
            else {
                return false;
            }
        });
        
        $('#tenant_delete_complete').click(function() {
            if ($('#tenant_delete_memo').val().length == 0) {
                return false;
            }
            
            $('#tenant_delete_form').submit();
            
            return false;
        });
        
        setModal();
    });
    
    
    function setModal() {
        $('#delete_modal').height($(document).height());
        
        $(window).scroll(function() {
            scroll = $(this).scrollTop();
        });
        
        $('#tenant_delete').click(function() {
            displayModal(true);

            $('#delete_modal_background, #delete_modal_cancel').click(function() {
                $('#tenant_delete_memo').val('');
                
                displayModal(false);

                return false;
            });

            return false;
        });
    }
    
    // モーダルウィンドウを開く
    function displayModal(sign) {
        if (sign) {
            adjustCenter('#delete_modal #tenant_delete_form');

            $('#delete_modal_buttons').css('top', parseInt($('#tenant_delete_form').css('top')) + 15);
            $('#delete_modal_buttons').css('left',
                parseInt($('#tenant_delete_form').css('left')) + (parseInt($('#tenant_delete_form').css('width')) * 0.6));

            $('#delete_modal').fadeIn(500);
        } else {
            $('#delete_modal').fadeOut(250);
        }
    }
    
    // ウィンドウの位置をセンターに調整
    function adjustCenter(target) {
        var marginTop = ($(window).height() - $(target).height()) / 2 + 15 + scroll;
        var marginLeft = ($(window).width() - $(target).width()) / 2;
        
        $(target).css({top: marginTop + 'px', left: marginLeft + 'px'});
    }
</script>