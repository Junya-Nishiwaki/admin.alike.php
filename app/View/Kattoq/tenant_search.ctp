<?php
$loading = '<div class="ajax-loader">' . $this->Html->image('ajax-loaders/ajax-loader-9.gif') . '</div>';
$tenantCell = '<div class="tenant-cell" data-id="[id]" data-name="[name]" data-url="[url]"><a href="[url]" target="blank_">[name]</a> ([category_name]) ([area_0_name]/[area_2_name])</div>';
?>
<html>
    <head>
        <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
        <style>
            input[type=text]{
                border-radius: 5px;
                -moz-border-radius: 5px;
                -webkit-border-radius: 5px;
                -o-border-radius: 5px;
                -ms-border-radius: 5px;
                border:#a9a9a9 1px solid;
                -moz-box-shadow: inset 0 0 5px rgba(0,0,0,0.2),0 0 2px rgba(0,0,0,0.3);
                -webkit-box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2),0 0 2px rgba(0,0,0,0.3);
                box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2),0 0 2px rgba(0,0,0,0.3);
                width:250px;
                height:25px;
                padding:0 3px;
            }
                
            input[type=text]:focus {
                border:solid 1px #20b2aa;
            }
                
            input[type=text], select { 
                outline: none;
            }
            
            .tenant-list-box {
                height: 450px;
                margin-top: 20px;
                padding: 20px;
                border: 1px solid #f0f0f0;
                -moz-box-shadow: 0 3px 5px rgba(0, 0, 0, .3);
                -webkit-box-shadow: 0 3px 5px rgba(0, 0, 0, .3);
                box-shadow:0 3px 5px rgba(0, 0, 0, 0.3);
                filter: progid:DXImageTransform.Microsoft.Shadow(color=#777777, direction=0, strength=3, enabled=true);
                /* IE以外なら丸角も！ */
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                overflow: scroll;
            }
            
            .tenant-cell {
                color: #000000;
                text-decoration: none;
                border-bottom: 1px solid #cccccc;
                margin-bottom: 15px;
            }

            .ajax-loader {
                text-align: center;
                background: #FFF;
            }

        </style>
    </head>
    <body style="background: #fff;">
        <div style="margin-top: 15px;">
            <input type="text" placeholder="店舗名・店舗名よみ・電話番号" id="word">
            <button id="search">検索</button>
        </div>
        <div class="tenant-list-box">
        </div>
    </body>
</html>

<script>
    $('#search').click(function() {
        $('.tenant-list-box').children().remove();
        $('.tenant-list-box').append('<?php echo $loading; ?>');
        
        $.ajax({
            type : 'POST',
            async : true,
            url : '<?php echo AdminUrl::ajaxTenantSearch(); ?>',
            data : {
                word : $('#word').val()
            },
            success : function(data, textStatus, jqXHR) {
                $('.tenant-list-box').children().remove();
                
                var jsonObj = $.parseJSON(data);

                if (jsonObj.result != 'success') {
                    alert('エラーが発生しました');
                    location.reload();
                    return false;
                }

                jsonObj.tenants.forEach(function(v){
                    $('.tenant-list-box').append(
                        '<?php echo $tenantCell; ?>'.replace(/\[id\]/g, v.id)
                                                    .replace(/\[url\]/g, v.url)
                                                    .replace(/\[name\]/g, v.name)
                                                    .replace(/\[category_name\]/g, v.category.name)
                                                    .replace(/\[area_0_name\]/g, v.areas[0].name)
                                                    .replace(/\[area_2_name\]/g, v.areas[2].name));
                });
            },
            error : function(jqXHR, textStatus, errorThrown) {
                $('.tenant-list-box').children().remove();
                
                alert('エラーが発生しました');
                location.reload();
                return false;
            }
        });
    });
    
    $(document).on('click', '.tenant-cell', function() {
        $('.tenant-cell').each(function() {
            $(this).css('background', '#FFF');
        });
        $(this).css('background', '#FFFF66');
    });
</script>