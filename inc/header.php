<!DOCTYPE html>
<html lang="en-us" <?php
session_start();
if (!isset($index_page)) {
    if (!isset($_SESSION['UID'])) {
        $url = ASSETS_URL . "/";
        header("Location: $url");
    }
}
echo implode(' ', array_map(function($prop, $value) {
            return $prop . '="' . $value . '"';
        }, array_keys($page_html_prop), $page_html_prop));
?>>
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

        <title> <?php echo $page_title != "" ? $page_title: ""; ?></title>
        <meta name="description" content="">
        <meta name="author" content="">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Basic Styles -->
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/font-awesome.min.css">

        <!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/smartadmin-production.min.css">
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/smartadmin-skins.min.css">

        <!-- SmartAdmin RTL Support is under construction-->
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/smartadmin-rtl.min.css">

        <!-- We recommend you use "your_style.css" to override SmartAdmin
                 specific styles this will also ensure you retrain your customization with each SmartAdmin update.-->
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/ngs.css">

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
        <link href="<?php echo ASSETS_URL; ?>/jeegoopopup/skins/blue/style.css" rel="Stylesheet" type="text/css" />
        <link href="<?php echo ASSETS_URL; ?>/jeegoopopup/skins/round/style.css" rel="Stylesheet" type="text/css" />
        <link href="<?php echo ASSETS_URL; ?>/css/jquery-ui.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/styles.css" type="text/css" media="screen, print"/>
        <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/site_styles.css" type="text/css" media="screen, print"/>
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
                document.write('<script src="<?php echo ASSETS_URL; ?>/js/libs/jquery-ui-1.10.3.min.js"><\/script>');
        }
</script>

        -->
        <script src="<?php echo ASSETS_URL; ?>/js/libs/jquery-ui.min.js">
        </script>
        <script type="text/javascript">

            $(document).ready(function () {
//               loading();
            });
            function loading() {
                $('#preloader').css("display", "block");
            }

            function stoploading() {
                $('#preloader').css("display", "none");
            }
        </script>
        <?php $page_body_prop['class'] = 'body_back smart-style-3'; ?>
    </head>
    <body onload=""<?php
    echo implode(' ', array_map(function($prop, $value) {
                return $prop . '="' . $value . '"';
            }, array_keys($page_body_prop), $page_body_prop));
    ?>>
        <!--        <div id="preloader" style="display:  none;">
                    <div id="status1"><h3 id="text">Please Wait</h3></div>
                </div>-->
        <!-- POSSIBLE CLASSES: minified, fixed-ribbon, fixed-header, fixed-width
                 You can also add different skin classes such as "smart-skin-1", "smart-skin-2" etc...-->
        <?php
        if (!$no_main_header) {
            ?>
            <!-- HEADER -->
            <header id="header" style="width: 100%; height: 100px; border-bottom: 1px solid #6d307b;background: linear-gradient(114deg, rgba(202,85,139,1) 15%, rgba(78,40,88,1) 65%);">   
                <section class="col-sm-4 col-lg-4 col-xs-4 col-md-4">
                    <div id="logo-group" style="height: 95px;">
                        <span id="" style="height: inherit;width: inherit; margin-left: 15px;"> <img src="<?php echo ASSETS_URL; ?>/img/logo.png" alt="Alswh" class="img-responsive" style="height:inherit;width:inherit;"> </span>
                    </div>
                </section>
                <section class="col-sm-5 col-lg-5 col-xs-5 col-md-5">

                    <!-- projects dropdown -->
                    <div class="" style="text-align: center;">
                        <h4 style="font-size: 28px; font-weight: bolder; color: white;padding-top: 25px;">Admin Portal</h4> 
                    </div>
                </section>
                <!-- end projects dropdown -->
                <section class="col-sm-3 col-lg-3 col-xs-3 col-md-3">
                    <!-- pulled right: nav area -->
                    <div class="pull-right" style="width: 300px;margin-top: 25px;">                                          

                        <!-- collapse menu button -->
                        <div id="hide-menu" class="btn-header pull-right">
                            <span> <a href="javascript:void(0);" title="Collapse Menu" data-action="toggleMenu"><i class="fa fa-reorder"></i></a> </span>
                        </div>
                        <!-- end collapse menu -->


                        <!-- logout button -->
                        <div id="logout" class="btn-header transparent pull-right">
                            <span> <a href="<?php echo ASSETS_URL; ?>" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser" onclick="logOut()"><i class="fa fa-sign-out"></i></a> </span>
                        </div>        

                        <!-- collapse menu button -->

                        <!-- end collapse menu -->


                    </div>
                    <?php 
                        if($_SESSION['subscription']!='1') {
                    ?>
                    <div id="hide-menu" class="pull-right">
                        <!--<span> <a href="javascript:addSubscription(<?php //print $_SESSION['UID'] ?>);" style="font-size: 11px;"><b>Subscribe for project's updates</b></a> </span>-->
                    </div>
                        <?php } ?>
                    <!-- end pulled right: nav area -->
                </section>    
            </header>           
            <!-- END HEADER -->

            <!-- END SHORTCUT AREA -->

            <?php
        }
        ?>