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
    <div class="box span3">
        <div class="box-header well">
            <h2> アクティベーション待ち件数</h2>
        </div>
        <div class="box-content">
            <a href="<?php echo AdminUrl::contractList('wait_activate'); ?>"><?php echo $activationCount; ?> 件</a>
        </div>
    </div>
    <div class="box span3">
        <div class="box-header well">
            <h2> 契約店舗数</h2>
        </div>
        <div class="box-content">
            <a href="<?php echo AdminUrl::contractList('all'); ?>"><?php echo $contractCount; ?> 件</a>
        </div>
    </div>
    <div class="box span3">
        <div class="box-header well">
            <h2> 代理店数</h2>
        </div>
        <div class="box-content">
            <a href="<?php echo AdminUrl::agencyList(); ?>"><?php echo $agencyCount; ?> 件</a>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="box span3">
        <div class="box-header well">
            <h2> グルメ最新クリップ</h2>
        </div>
        <div class="box-content">
            <?php foreach ($gourmetClips as $clip) { ?>
            <div class="box">
            <div class="box-header well">
                <h2> <a href="<?php echo PcUrl::clipPcSite($clip); ?>" target="_blank"><?php echo h($clip['tenant']['name']); ?></a></h2>
            </div>
            <div class="box-content">
                <?php echo mb_strimwidth(h($clip['review_comment']), 0, 60, '…', 'UTF-8'); ?>
                &nbsp;/&nbsp;
                <a href="<?php echo PcUrl::userPcSite($clip['user']); ?>" target="_blank"><?php echo h($clip['user']['nickname']); ?></a>
            </div>
            </div>
            <?php } ?>
            <a href="#" class="more_clips" data-category_id="<?php echo CATEGORY_GOURMET; ?>">もっとみる</a>
        </div>
    </div>
    <div class="box span3">
        <div class="box-header well">
            <h2> ビューティ最新クリップ</h2>
        </div>
        <div class="box-content">
            <?php foreach ($beautyClips as $clip) { ?>
            <div class="box">
            <div class="box-header well">
                <h2> <a href="<?php echo PcUrl::clipPcSite($clip); ?>" target="_blank"><?php echo h($clip['tenant']['name']); ?></a></h2>
            </div>
            <div class="box-content">
                <?php echo mb_strimwidth(h($clip['review_comment']), 0, 60, '…', 'UTF-8'); ?>
                &nbsp;/&nbsp;
                <a href="<?php echo PcUrl::userPcSite($clip['user']); ?>" target="_blank"><?php echo h($clip['user']['nickname']); ?></a>
            </div>
            </div>
            <?php } ?>
            <a href="#" class="more_clips" data-category_id="<?php echo CATEGORY_BEAUTY; ?>">もっとみる</a>
        </div>
    </div>
    <div class="box span3">
        <div class="box-header well">
            <h2> ホテル最新クリップ</h2>
        </div>
        <div class="box-content">
            <?php foreach ($hotelClips as $clip) { ?>
            <div class="box">
            <div class="box-header well">
                <h2> <a href="<?php echo PcUrl::clipPcSite($clip); ?>" target="_blank"><?php echo h($clip['tenant']['name']); ?></a></h2>
            </div>
            <div class="box-content">
                <?php echo mb_strimwidth(h($clip['review_comment']), 0, 60, '…', 'UTF-8'); ?>
                &nbsp;/&nbsp;
                <a href="<?php echo PcUrl::userPcSite($clip['user']); ?>" target="_blank"><?php echo h($clip['user']['nickname']); ?></a>
            </div>
            </div>
            <?php } ?>
            <a href="#" class="more_clips" data-category_id="<?php echo CATEGORY_HOTEL; ?>">もっとみる</a>
        </div>
    </div>
</div>


<?php if (false) { ?>
<div class="row-fluid">
    <div class="box span3">
        <div class="box-header well">
            <h2> ステマ疑惑ユーザー数</h2>
        </div>
        <div class="box-content">
            <a href="<?php echo AdminUrl::stealthMarketingList(); ?>"><?php echo ''; ?> 件</a>
        </div>
    </div>
    <div class="box span3">
        <div class="box-header well">
            <h2> 重複店舗数</h2>
        </div>
        <div class="box-content">
            <a href="<?php echo AdminUrl::duplicationTenantList(); ?>"><?php echo ''; ?> 件</a>
        </div>
    </div>
    <div class="box span3">
        <div class="box-header well">
            <h2> NGワードクリップ数</h2>
        </div>
        <div class="box-content">
            <a href="<?php echo AdminUrl::ngWordClipList(); ?>"><?php echo ''; ?> 件</a>
        </div>
    </div>
</div>
<?php } ?>
<script>
    $(function() {
        var offsets = {
            <?php echo CATEGORY_GOURMET; ?>: <?php echo $clipLimit; ?> + 1,
            <?php echo CATEGORY_BEAUTY; ?>: <?php echo $clipLimit; ?> + 1,
            <?php echo CATEGORY_HOTEL; ?>: <?php echo $clipLimit; ?> + 1
        };
        var loading = false;
        
        $('.more_clips').click(function() {
            if (loading) return false;
            loading = true;
            
            var moreLink = $(this);
            
            $.ajax({
                    type : 'POST',
                    async : true,
                    url : '<?php echo AdminUrl::ajaxGetClipList(); ?>',
                    data : {
                        category_id : moreLink.data('category_id'),
                        offset : offsets[moreLink.data('category_id')],
                        limit : <?php echo $clipLimit; ?>
                    },
                    success : function(data, textStatus, jqXHR) {
                        var jsonObj = $.parseJSON(data);

                        if (jsonObj.result != 'success') {
                            alert('エラーが発生しました');
                            location.reload();
                            return false;
                        }

                        var clips = jsonObj.clips;
                        for (var index in clips) {
                            moreLink.before(
                                '<div class="box">' +
                                    '<div class="box-header well">' +
                                        '<h2>' +
                                            '<a href="' + clips[index].options.clip_url + '" target="_blank">' +
                                                clips[index].tenant.name +
                                            '</a>' +
                                        '</h2>' +
                                    '</div>' +
                                    '<div class="box-content">' +
                                        clips[index].options.review_comment + '&nbsp;/&nbsp;' +
                                        '<a href="' + clips[index].options.user_url + '" target="_blank">' +
                                            clips[index].user.nickname +
                                        '</a>' +
                                    '</div>' +
                                '</div>'
                            );
                        }
                        offsets[moreLink.data('category_id')] += <?php echo $clipLimit; ?>;
                    },
                    error : function(jqXHR, textStatus, errorThrown) {
                        alert('エラーが発生しました');
                        location.reload();
                        return false;
                    },
                    complete : function(XMLHttpRequest, textStatus){
                        loading = false;
                    }
            });

            return false;
        });
    });
</script>
