<!DOCTYPE html>
<html lang="en-us" <?php
echo implode(' ', array_map(function($prop, $value) {
            return $prop . '="' . $value . '"';
        }, array_keys($page_html_prop), $page_html_prop));
?>>
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

        <title> <?php echo $page_title != "" ? $page_title . " - " : ""; ?>smsnow</title>
        <meta name="description" content="">
        <meta name="author" content="">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        
        
        <!-- Basic Styles -->
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/ngs.css">
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/font-awesome.min.css">

        <!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/smartadmin-production.min.css">
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/smartadmin-skins.min.css">

        <!-- SmartAdmin RTL Support is under construction-->
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/smartadmin-rtl.min.css">
        <link href="<?php echo ASSETS_URL; ?>/js/plugin/PopupWindows/themes/metro/css/jquery.msgbox.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php  echo ASSETS_URL; ?>/css/dropzone.css">
        
        
        <?php
        if ($page_css) {
            foreach ($page_css as $css) {
                echo '<link rel="stylesheet" type="text/css" media="screen" href="' . ASSETS_URL . '/css/' . $css . '">';
            }
        }
        ?>


        <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
        
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/demo.min.css">
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/jquery.datetimepicker.css">
        <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/site_styles.css" type="text/css" media="screen, print"/>
        <!-- FAVICONS -->
        <link rel="shortcut icon" href="<?php echo ASSETS_URL; ?>/img/favicon/favicon_1.ico" type="image/x-icon">
        <link rel="icon" href="<?php echo ASSETS_URL; ?>/img/favicon/favicon_1.ico" type="image/x-icon">

        <!-- GOOGLE FONT -->
        <!--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">-->

        <!-- Specifying a Webpage Icon for Web Clip
                 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
        <link rel="apple-touch-icon" href="<?php echo ASSETS_URL; ?>/img/splash/sptouch-icon-iphone.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo ASSETS_URL; ?>/img/splash/touch-icon-ipad.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo ASSETS_URL; ?>/img/splash/touch-icon-iphone-retina.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo ASSETS_URL; ?>/img/splash/touch-icon-ipad-retina.png">

        <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">

        <!-- Startup image for web apps -->
        <link rel="apple-touch-startup-image" href="<?php echo ASSETS_URL; ?>/img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
        <link rel="apple-touch-startup-image" href="<?php echo ASSETS_URL; ?>/img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
        <link rel="apple-touch-startup-image" href="<?php echo ASSETS_URL; ?>/img/splash/iphone.png" media="screen and (max-device-width: 320px)">

        <!-- NGS Addings-->
        
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/lib/jqueary-confirm/jquery-confirm.min.css">
        <link rel="stylesheet" href="../css/styles.css" type="text/css" media="screen, print"/>
        
        <!-- We recommend you use "your_style.css" to override SmartAdmin
                 specific styles this will also ensure you retrain your customization with each SmartAdmin update.-->
        
        
        <!-- NGS Addings-->

        <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
        <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script>
                if (!window.jQuery) {
                        document.write('<script src="<?php echo ASSETS_URL; ?>/js/libs/jquery-2.0.2.min.js"><\/script>');
                }
        </script>
        -->
        <script src="<?php echo ASSETS_URL; ?>/js/libs/jquery-2.0.2.min.js">
        </script>

<!--<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
        if (!window.jQuery.ui) {
                document.write('<script src="<?php //echo ASSETS_URL; ?>/js/libs/jquery-ui-1.10.3.min.js"><\/script>');
        }
</script>

        -->
        <script src="<?php echo ASSETS_URL; ?>/js/libs/jquery-ui.min.js">
             <script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/datatables.min.js"></script>
        </script>
        <script type="text/javascript">
             
            $(document).ready(function () {
//               loading();
            });         
        </script>
        <?php $page_body_prop['class'] = 'smart-style-3 desktop-detected pace-done container'; ?>
    </head>
    <body onload=""<?php
    echo implode(' ', array_map(function($prop, $value) {
                return $prop . '="' . $value . '"';
            }, array_keys($page_body_prop), $page_body_prop));
    ?>>
<!--        <div class="col-2">
            $nbsp;
        </div>
        <div class="col-8">-->
                    
<!--        <div id="preloader" style="display:  none;">
            <div id="status1"><h3 id="text">Please Wait</h3></div>
        </div>-->
        <!-- POSSIBLE CLASSES: minified, fixed-ribbon, fixed-header, fixed-width
                 You can also add different skin classes such as "smart-skin-1", "smart-skin-2" etc...-->
        <?php
        if (!$no_main_header) {
            ?>
            <!-- HEADER -->
            
            <!-- END HEADER -->

            <!-- END SHORTCUT AREA -->

            <?php
        }
        ?>