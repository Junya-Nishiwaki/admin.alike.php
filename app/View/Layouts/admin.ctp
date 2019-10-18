<!DOCTYPE html>
<html lang="ja">
    <head>
        <!--
                Charisma v1.0.0

                Copyright 2012 Muhammad Usman
                Licensed under the Apache License v2.0
                http://www.apache.org/licenses/LICENSE-2.0

                http://usman.it
                http://twitter.com/halalit_usman
        -->
        <?php echo $this->Html->charset(); ?>
        <?php echo $this->fetch('meta'); ?>
        <title><?php echo $title_for_layout; ?></title>
        
        <!-- The styles -->
        <?php echo $this->fetch('css'); ?>
        <style type="text/css">
            body {
                padding-bottom: 40px;
            }
            .sidebar-nav {
                padding: 9px 0;
            }
        </style>
        <?php echo $this->fetch('script'); ?>
        <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!-- The fav icon -->
        <link rel="shortcut icon" href="img/favicon.ico">
    </head>
    <body>
        <!-- topbar starts -->
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a href="<?php echo AdminUrl::dashboard(); ?>">
                        <span style="color: white; font-size: 21px;">Alike管理ツール</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- topbar ends -->
        <div class="container-fluid">
            <div class="row-fluid">

                <!-- left menu starts -->
                <div class="span2 main-menu-span">
                    <?php echo $this->element('common/GlobalMenu'); ?>
                </div><!--/span-->
                <!-- left menu ends -->

                <noscript>
                <div class="alert alert-block span10">
                    <h4 class="alert-heading">Warning!</h4>
                    <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
                </div>
                </noscript>

                <div id="content" class="span10">
                    <!-- content starts -->
                    <?php echo $this->element('common/Breadcrumb'); ?>
                    <?php echo $this->fetch('content'); ?>
                    <!-- content ends -->
                </div><!--/#content.span10-->
            </div><!--/fluid-row-->
            <button id="flash_msg" class="btn btn-primary noty" data-noty-options='{"text":"<?php echo $msg; ?>","layout":"top","type":"success"}' style="display: none;"></button>
            <button id="err_flash_msg" class="btn btn-primary noty" data-noty-options='{"text":"<?php echo $errMsg; ?>","layout":"top","type":"error"}' style="display: none;"></button>
            <hr>

            <footer>
                <p class="pull-left">&copy; <a href="http://usman.it" target="_blank">Muhammad Usman</a> 2012</p>
                <p class="pull-right">Powered by: <a href="http://usman.it/free-responsive-admin-template">Charisma</a></p>
            </footer>
        </div><!--/.fluid-container-->
        <script>
            <?php if (!empty($msg)) { ?>
                $(function() {
                    $('#flash_msg').click();
                });
            <?php } ?>
            <?php if (!empty($errMsg)) { ?>
                $(function() {
                    $('#err_flash_msg').click();
                });
            <?php } ?>
        </script>    
    </body>
</html>
