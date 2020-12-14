<?php

session_start();
$url = APP_URL . '/class/constants.php';
//print $url;
$url_array = explode('/', $_SERVER['REQUEST_URI']);
if ($url_array[count($url_array) - 1] == 'home' || $url_array[count($url_array) - 1] == '') {
    $url = './class/constants.php';
} else {
    $url = '../class/constants.php';
}
include_once($url);

//array("Display Name" => "URL");
$breadcrumbs = array(
    "Home" => APP_URL
);

$ary_navi = array("dashboard" => array(
        "title" => "HOME",
        "url" => APP_URL . "/home"
//        "icon" => "fa-home"
        ));


$ary_employee = array("doctor" => array(
        "title" => "DOCTOR",
//        "icon" => "fa fa-inbox",
        "url" => APP_URL . "/doctor_pay/doctor"
        ));

$ary_roster = array("roster" => array(
        "title" => "ROSTER",
//        "icon" => "fa fa-calendar",
        "url" => APP_URL . "/roster/doctor_roster"
        ));


$ary_report = array("report" => array(
        "title" => "REPORTS",
        "sub" => array(
            "center" => array(
                "title" => "Center",
                "url" => APP_URL . "/doctor_pay/report_center"
            ),
            "doctor" => array(
                "title" => "Doctor",
                "url" => APP_URL . "/doctor_pay/report_doctor"
            )
        )
        ));



$ary_doc_payment = array("doc_pay" => array(
        "title" => "PAYMENT",
        "url" => APP_URL . "/doctor_pay/search"
        ));

$ary_centers = array("centers" => array(
        "title" => "CENTERS",
//        "icon" => "fa fa-inbox",
        "url" => APP_URL . "/doctor_pay/centers"
        ));

if ($_SESSION['DESIGNATION'] == constants::$business_customer) {
    $ary_navi = array_merge($ary_navi, $ary_employee);
    $ary_navi = array_merge($ary_navi, $ary_centers);
    $ary_navi = array_merge($ary_navi, $ary_roster);
    $ary_navi = array_merge($ary_navi, $ary_report);
    $ary_navi = array_merge($ary_navi, $ary_doc_payment);
    
}
$page_nav = $ary_navi;
//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
?>