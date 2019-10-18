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

<div class="row-fluid">
    <div class="span10">
        <div class="control-group">
            <div class="controls">
                <div class="input-append">
                    <form method="get" id="search_form">
                        <div style="float: left; width: 250px;">
                            <div class="control-group">
                                <label class="control-label" for="conditions">絞り込み</label>
                                <div class="controls">
                                    <select id="conditions" multiple data-rel="chosen">
                                        <optgroup label="カテゴリ">
                                            <option value="c_<?php echo CATEGORY_GOURMET; ?>" <?php echo in_array('c_' . CATEGORY_GOURMET, $conditions) ? 'selected' : ''; ?>>グルメ</option>
                                            <option value="c_<?php echo CATEGORY_BEAUTY; ?>" <?php echo in_array('c_' . CATEGORY_BEAUTY, $conditions) ? 'selected' : ''; ?>>ビューティ</option>
                                            <option value="c_<?php echo CATEGORY_HOTEL; ?>" <?php echo in_array('c_' . CATEGORY_HOTEL, $conditions) ? 'selected' : ''; ?>>ホテル</option>
                                        </optgroup>
                                        <optgroup label="ステータス">
                                            <option value="s_<?php echo Admin::GETLISTKATTOQ_CONDITIONS_UNEDITED; ?>" <?php echo in_array('s_' . Admin::GETLISTKATTOQ_CONDITIONS_UNEDITED, $conditions) ? 'selected' : ''; ?>>未編集</option>
                                            <option value="s_<?php echo Admin::GETLISTKATTOQ_CONDITIONS_EDITING; ?>" <?php echo in_array('s_' . Admin::GETLISTKATTOQ_CONDITIONS_EDITING, $conditions) ? 'selected' : ''; ?>>編集中</option>
                                            <option value="s_<?php echo Admin::GETLISTKATTOQ_CONDITIONS_OPEN; ?>" <?php echo in_array('s_' . Admin::GETLISTKATTOQ_CONDITIONS_OPEN, $conditions) ? 'selected' : ''; ?>>公開中</option>
                                            <option value="s_<?php echo Admin::GETLISTKATTOQ_CONDITIONS_PRE; ?>" <?php echo in_array('s_' . Admin::GETLISTKATTOQ_CONDITIONS_PRE, $conditions) ? 'selected' : ''; ?>>公開準備完了</option>
                                            <option value="s_<?php echo Admin::GETLISTKATTOQ_CONDITIONS_END; ?>" <?php echo in_array('s_' . Admin::GETLISTKATTOQ_CONDITIONS_END, $conditions) ? 'selected' : ''; ?>>販売終了</option>
                                            <option value="s_<?php echo Admin::GETLISTKATTOQ_CONDITIONS_NOTOPEN; ?>" <?php echo in_array('s_' . Admin::GETLISTKATTOQ_CONDITIONS_NOTOPEN, $conditions) ? 'selected' : ''; ?>>公開停止</option>
                                        </optgroup>
                                    </select>
                                    <input type="hidden" name="conditions" val="">
                                </div>
                            </div>
                        </div>
                        <div style="float: left; width: 250px;">
                            <div class="control-group">
                                <label class="control-label" for="order">並び替え</label>
                                <div class="controls">
                                    <select id="order" name="order">
                                        <option value="<?php echo Admin::GETLISTKATTOQ_ORDER_IMPORT_NEW; ?>" <?php echo Admin::GETLISTKATTOQ_ORDER_IMPORT_NEW == $order ? 'selected' : ''; ?>>取り込み日が新しい順</option>
                                        <option value="<?php echo Admin::GETLISTKATTOQ_ORDER_IMPORT_OLD; ?>" <?php echo Admin::GETLISTKATTOQ_ORDER_IMPORT_OLD == $order ? 'selected' : ''; ?>>取り込み日が古い順</option>
                                        <option value="<?php echo Admin::GETLISTKATTOQ_ORDER_START_NEW; ?>" <?php echo Admin::GETLISTKATTOQ_ORDER_START_NEW == $order ? 'selected' : ''; ?>>販売開始日が新しい順</option>
                                        <option value="<?php echo Admin::GETLISTKATTOQ_ORDER_START_OLD; ?>" <?php echo Admin::GETLISTKATTOQ_ORDER_START_OLD == $order ? 'selected' : ''; ?>>販売開始日が古い順</option>
                                        <option value="<?php echo Admin::GETLISTKATTOQ_ORDER_EXPIRE_NEW; ?>" <?php echo Admin::GETLISTKATTOQ_ORDER_EXPIRE_NEW == $order ? 'selected' : ''; ?>>販売終了日が新しい順</option>
                                        <option value="<?php echo Admin::GETLISTKATTOQ_ORDER_EXPIRE_OLD; ?>" <?php echo Admin::GETLISTKATTOQ_ORDER_EXPIRE_OLD == $order ? 'selected' : ''; ?>>販売終了日が古い順</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div style="clear: both;"></div>
                        <input type="text" value="<?php echo $word; ?>" id="word" name="word" class="input-xlarge focused" placeholder="店舗名・店舗名よみ・電話番号・クーポンタイトル">
                        <button class="btn btn-primary" type="submit" id="search_button">
                            <i class="icon-search icon-white"></i>
                            検索
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="box span12">
        <div class="box-header well">
            <h2> かっトククーポン一覧</h2>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="width: 200px;">店舗名</th>
                        <th style="width: 100px;">カテゴリ</th>
                        <th style="width: 120px;">クーポン販売開始日</th>
                        <th style="width: 120px;">クーポン販売終了日</th>
                        <th>タイトル</th>
                        <th style="width: 70px;">ステータス</th>
                        <th style="width: 60px;">更新済</th>
                        <th style="width: 50px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kattoqs as $kattoq) { ?>
                    <?php
                    // 店舗名
                    $tenantName = '';
                    // カテゴリ名
                    $categoryName = '';
                    if (array_key_exists('tenant', $kattoq)) {
                        $tenantName = mb_strimwidth($kattoq['tenant']['name'], 0, 30, '…', 'UTF-8');
                        $categoryName = $kattoq['tenant']['category']['name'];
                    }
                    ?>
                    <tr>
                        <td><?php echo $tenantName; ?></td>
                        <td><?php echo $categoryName; ?></td>
                        <td><?php echo date('Y年n月j日', strtotime($kattoq['start'])); ?></td>
                        <td><?php echo date('Y年n月j日', strtotime($kattoq['expire'])); ?></td>
                        <td><?php echo $kattoq['title']; ?></td>
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
                        <td <?php echo $kattoq['read_flg'] ? '  class="btn-success"' : ''; ?>></td>
                        <td><a class="btn" href="<?php echo AdminUrl::kattoqDetail($kattoq, $query); ?>">詳細</a></td>
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
                        <a href="<?php echo AdminUrl::kattoqList($word, $page - 1, $order, $conditions); ?>">Prev</a>
                    </li>
                    <?php } ?>
                    <?php $lastPage = floor(($total / $limit + intval(($total % $limit) != 0))); ?>
                    <?php for ($p = $page; $p <= $page + 10 && $p <= $lastPage; ++$p) { ?>
                    <li<?php echo $p == $page ? ' class="active"' : ''; ?>>
                        <a href="<?php echo AdminUrl::kattoqList($word, $p, $order, $conditions); ?>"><?php echo $p; ?></a>
                    </li>
                    <?php } ?>
                    <?php if ($lastPage > $page) { ?>
                    <li>
                        <a href="<?php echo AdminUrl::kattoqList($word, $page + 1, $order, $conditions); ?>">Next</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div><!--/span-->
</div><!--/row-->
<script>
    $(function() {
        $('#search_button').click(function() {
            console.log($('#conditions').val());
            $('input[name=conditions]').val($('#conditions').val());

            return true;
        });
    });
</script>