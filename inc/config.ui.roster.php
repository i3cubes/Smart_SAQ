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

$ary_business_customer = array("business_customer" => array(
        "title" => "BUSINESS CUSTOMER",
//        "icon" => "fa fa-inbox",
        "url" => APP_URL . "/admin/list_business_customer"
        ));



$ary_centers = array("centers" => array(
        "title" => "CENTER",
//        "icon" => "fa fa-inbox",
        "url" => APP_URL . "/admin/centers"
        ));


$ary_employee = array("employee" => array(
        "title" => "EMPLOYEE",
//        "icon" => "fa fa-inbox",
        "url" => APP_URL . "/admin/employee"
        ));

$ary_roster = array("roster" => array(
        "title" => "ROSTER",
//        "icon" => "fa fa-calendar",
        "url" => APP_URL . "/roster/weekly_roster"
        ));

$ary_roster_approve = array("roster_approve" => array(
        "title" => "TIMESHEET",
//        "icon" => "fa fa-calendar",
        "url" => APP_URL . "/roster/weekly_roster?f=a"
        ));

$ary_profile = array("profile" => array(
        "title" => "PROFILE",
//        "icon" => "fa fa-user",
        "url" => APP_URL . "/employee/profile"
        ));

$ary_report = array("report" => array(
        "title" => "REPORTS",
        "sub" => array(
            "employee" => array(
                "title" => "Employee",
                "url" => APP_URL . "/report/employee"
            ),
            "center" => array(
                "title" => "Center",
                "url" => APP_URL . "/report/center"
            )
        )
        ));


$ary_report_emp = array("report" => array(
        "title" => "REPORT",
        "url" => APP_URL . "/report/employee_report"
        ));



if ($_SESSION['DESIGNATION'] == constants::$admin) {
    $ary_navi = array_merge($ary_navi, $ary_business_customer);
    //$ary_navi = array_merge($ary_navi, $ary_centers);
    // $ary_navi = array_merge($ary_navi, $ary_customer);
    //$ary_navi = array_merge($ary_navi, $ary_employee);
} else if ($_SESSION['DESIGNATION'] == constants::$business_customer) {
    $ary_navi = array_merge($ary_navi, $ary_centers);
    $ary_navi = array_merge($ary_navi, $ary_employee);
    $ary_navi = array_merge($ary_navi, $ary_roster);
    $ary_navi = array_merge($ary_navi, $ary_roster_approve);
    $ary_navi = array_merge($ary_navi, $ary_report);
} else if ($_SESSION['DESIGNATION'] == constants::$employee || 
        $_SESSION['DESIGNATION'] == constants::$nurse || 
        $_SESSION['DESIGNATION'] == constants::$Receptionest || 
        $_SESSION['DESIGNATION'] == constants::$other || 
        $_SESSION['DESIGNATION'] == constants::$doctor) {
    $ary_navi = array_merge($ary_navi, $ary_roster);
    $ary_navi = array_merge($ary_navi, $ary_report_emp);
    $ary_navi = array_merge($ary_navi, $ary_profile);
}

///"url_target"=> "_blank"


$page_nav = $ary_navi;
//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
?>