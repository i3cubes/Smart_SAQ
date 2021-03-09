<?php

session_start();

//array("Display Name" => "URL");
$breadcrumbs = array(
    "Home" => APP_URL
);

    $ary_navi = array("dashboard" => array(
        "title" => "HOME",
        "url" => APP_URL . "/home",
        "icon" => "fa-home"
        ));


$ary_samples = array("samples" => array(
        "title" => "SAMPLES",
        "icon" => "fa fa-inbox",        
        "sub" => array(
                "agreements" => array(
                    "title" => "AGREEMENTS",
                    "url" => APP_URL . "/samples/agreements"
                ),
                "site" => array(
                    "title" => "SITE",
                    "url" => APP_URL . "/samples/site"
                )
            )
        ));

$ary_navi = array_merge($ary_navi, $ary_samples);

$ary_sites = array("view" => array(
        "title" => "SITES",
        "icon" => "fa fa-inbox",
        "url" => APP_URL . "/sites/view"
        ));

$ary_navi = array_merge($ary_navi, $ary_sites);
$ary_sites_data = array("site_data" => array(
        "title" => "SITES DATA",
        "icon" => "fa fa-inbox",
        "sub" => array(
                    "technical" => array(
                        "title" => "TECNOLOGIES",
                        "url" => APP_URL . "/sites/site_data_technical"
                    ),
                    "operators" => array(
                        "title" => "OPERATORS",
                        "url" => APP_URL . "/sites/operators"
                    )
                ),
       // "url" => APP_URL . "/sites/view"
        ));

$ary_navi = array_merge($ary_navi, $ary_sites_data);

$ary_saq_guidelines = array("saq_guidelines" => array(
        "title" => "SAQ GUIDELINES",
        "icon" => "fa fa-inbox",
        "url" => APP_URL . "/saq/saq_guideline"
        ));

$ary_navi = array_merge($ary_navi, $ary_saq_guidelines);

$ary_user_management = array("user_management" => array(
        "title" => "USER MANAGEMENT",
        "icon" => "fa fa-inbox",
        "url" => APP_URL . "/user/user_management"
        ));

$ary_navi = array_merge($ary_navi, $ary_user_management);

///"url_target"=> "_blank"


$page_nav = $ary_navi;
//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
?>