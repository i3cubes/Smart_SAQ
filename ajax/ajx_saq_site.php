<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
session_start();

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once('../vendor/autoload.php');

include_once '../class/constants.php';

include_once '../class/cls_site.php';
include_once '../class/cls_saq_technical.php';
include_once '../class/cls_saq_other_operator.php';
include_once '../class/cls_saq_approvals.php';
include_once '../class/ngs_date.php';

if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    if (!preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
        header('HTTP/1.0 400 Bad Request');
        echo 'Token not found in request';
        exit;
    }
    $jwt = $matches[1];
    if (!$jwt) {
        // No token was able to be extracted from the authorization header
        header('HTTP/1.0 400 Bad Request');
        exit;
    }

    $secretKey = constants::$secretKey;
    if ($jwt != 'undefined') {
        try {
            $token = JWT::decode($jwt, new Key($secretKey, 'HS512'));
        } catch (\Firebase\JWT\ExpiredException $e) {
            echo json_encode(array('msg' => 'Session expired!!!', 'result' => 1));
            session_destroy();
            exit();
        }
    }
    $now = new DateTimeImmutable();
    $serverName = constants::$serverName;

    if ($token->iss !== $serverName ||
            $token->nbf > $now->getTimestamp() ||
            $token->exp < $now->getTimestamp()) {
        header('HTTP/1.1 401 Unauthorized');
        exit;
    }
} else {
    echo json_encode(array('msg' => 'Session expired!!!', 'result' => 1));
    session_destroy();
}

$ngs_date = new ngs_date();
$site_obj = new site($_REQUEST['id']);
// tab general
$site_obj->code = $_REQUEST['site_code'];
$site_obj->name = $_REQUEST['site_name'];
$site_obj->address = $_REQUEST['site_address'];
$site_obj->dns_deport = $_REQUEST['dns_deport'];
$site_obj->other_operator_id = $_REQUEST['other_operator_id'];
$site_obj->district_id = $_REQUEST['district_id'];
$site_obj->province_id = $_REQUEST['province_id'];
$site_obj->ds_id = $_REQUEST['ds_id'];
$site_obj->la_id = $_REQUEST['la_id'];
$site_obj->police_station_id = $_REQUEST['police_station_id'];
$site_obj->region_id = $_REQUEST['region_id'];
$site_obj->divisional_secretariat = $_REQUEST['divisional_secretariat'];
$site_obj->local_authority = $_REQUEST['local_authority'];
$site_obj->gs_division = $_REQUEST['gs_division'];
$site_obj->police_station_id = $_REQUEST['police_station'];
$site_obj->dns_office_id = $_REQUEST['dns_region'];
//$site_obj->
$site_obj->site_ownership = $_REQUEST['site_ownership'];
$site_obj->operator_name = $_REQUEST['operator_name'];
//$site_obj->other_operator_id = $_REQUEST[''];
$site_obj->type = $_REQUEST['site_type'];
$site_obj->tower_height = $_REQUEST['tower_height'];
$site_obj->building_height = $_REQUEST['building_height'];
$site_obj->land_area = $_REQUEST['land_area'];
$site_obj->status = $_REQUEST['site_status'];
$site_obj->on_air_date = $_REQUEST['on_air_date'] == "" ? "" : $ngs_date->transform_date($_REQUEST['on_air_date']);
$site_obj->category = $_REQUEST['site_category'];
$site_obj->lon = $_REQUEST['longitude'];
$site_obj->lat = $_REQUEST['latitude'];
$site_obj->access_type = $_REQUEST['access_type'];
$site_obj->manual_distance = $_REQUEST['manual_distance'];
$site_obj->access_permision_type = $_REQUEST['access_permission_type'];
$site_obj->pg_installation_possibility = $_REQUEST['pg_installation_possibility'];
$site_obj->regional_manager_id = $_REQUEST['rm_id']; //add by thara
$site_obj->saq_region_employee_id = $_REQUEST['select_saq_officer_id']; //add by thara
$site_obj->saq_officer_id = $_REQUEST['select_saq_officer_id']; //add by thara
$site_obj->saq_dns_employee_id = $_REQUEST['dns_officer_id']; //add by thara
// tab contact
$site_obj->lo_name = $_REQUEST['land_owner_name'];
$site_obj->lo_email = $_REQUEST['email_address'];
$site_obj->lo_address = $_REQUEST['land_owner_address'];
$site_obj->lo_nic_brc = $_REQUEST['land_owner_nic'];
$site_obj->lo_mobile = $_REQUEST['land_owner_mobile_number'];
$site_obj->lo_land_number = $_REQUEST['land_owner_land_number'];
$site_obj->contact_person_number = $_REQUEST['contact_person_number'];
$site_obj->contact_person = $_REQUEST['contact_person'];
$site_obj->lo_fax = $_REQUEST['fax'];

// tab technical
$site_obj->technical = $_REQUEST['technologies'];
$site_obj->other_operators = $_REQUEST['other_operators'];

// tab agreement & payments
$site_obj->agreement_data = $_REQUEST;
$site_obj->assessment_data = array($_REQUEST['2018'], $_REQUEST['2019'], $_REQUEST['2020'], $_REQUEST['2021']);

// tab approvals
$site_obj->approvals = $_REQUEST['approvals'];

switch ($_REQUEST['option']) {
    case 'ADD':
        $result = $site_obj->add($_REQUEST['tab'], 'WEB');
        if ($result) {
            echo json_encode(array('msg' => 1, 'site_id' => $site_obj->id, 'agreement_data_id' => $site_obj->agreement_data_id));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'EDIT':
        $result = $site_obj->update($_REQUEST['tab'], 'WEB');
        if ($result) {
            echo json_encode(array('msg' => 1, 'site_id' => $site_obj->id, 'agreement_data_id' => $site_obj->agreement_data_id));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'ADDTECH':
        $saq_technical_obj = new saq_technical();
        $saq_technical_obj->technology = $_REQUEST['technology'];

        $result = $saq_technical_obj->add();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'EDITTECH':
        $saq_technical_obj = new saq_technical($_REQUEST['id']);
        $saq_technical_obj->technology = $_REQUEST['technology'];

        $result = $saq_technical_obj->edit();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'DELETETECH':
        $id = $_REQUEST['id'];
        $saq_technical_obj = new saq_technical($id);
//        $saq_technical_obj->technology = $_REQUEST['technology'];

        $result = $saq_technical_obj->delete();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'ADDOPERATOR':
        $saq_other_operator_obj = new saq_other_operator();
        $saq_other_operator_obj->name = $_REQUEST['operator'];

        $result = $saq_other_operator_obj->add();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'EDITOPERATOR':
        $saq_other_operator_obj = new saq_other_operator($_REQUEST['id']);
        $saq_other_operator_obj->name = $_REQUEST['operator'];

        $result = $saq_other_operator_obj->edit();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'DELETEOPERATOR':
        $id = $_REQUEST['id'];
        $saq_other_operator_obj = new saq_other_operator($id);
//        $saq_technical_obj->technology = $_REQUEST['technology'];

        $result = $saq_other_operator_obj->delete();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'ADDAPPROVAL':
        $saq_approvals_obj = new saq_approvals();
        $saq_approvals_obj->requirement = $_REQUEST['requirement'];
        $saq_approvals_obj->description = $_REQUEST['approval_name'];
        $saq_approvals_obj->code = $_REQUEST['short_name'];

        $result = $saq_approvals_obj->add();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'EDITAPPROVAL':
        $saq_approvals_obj = new saq_approvals($_REQUEST['id']);
        $saq_approvals_obj->requirement = $_REQUEST['requirement'];
        $saq_approvals_obj->description = $_REQUEST['approval_name'];
        $saq_approvals_obj->code = $_REQUEST['short_name'];

        $result = $saq_approvals_obj->edit();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'DELETEAPPROVAL':
        $id = $_REQUEST['id'];
        $saq_approvals_obj = new saq_approvals($id);
//        $saq_technical_obj->technology = $_REQUEST['technology'];

        $result = $saq_approvals_obj->delete();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'BULKDELETE':
//        var_dump($_REQUEST['values']);
        $array = $_REQUEST['values'];
//        var_dump($array);
        $saq_site = new site();
        $result = $saq_site->bulkDelete($array);
        if ($result) {
            echo json_encode(array('result' => 1, 'msg' => 'Successfully Deleted'));
        } else {
            echo json_encode(array('result' => 0, 'msg' => 'Failure in Deletion'));
        }
        break;
    default :
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}
?>