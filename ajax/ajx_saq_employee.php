<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Firebase\JWT\JWT;

//
require_once('../vendor/autoload.php');

include_once '../class/cls_saq_employee.php';
include_once '../class/cls_saq_region.php';
include_once '../class/cls_user.php';

include_once '../class/constants.php';

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
            $token = JWT::decode($jwt, $secretKey, ['HS512']);
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

$REQUEST_METHOD = $_SERVER["REQUEST_METHOD"];
$SID = $_REQUEST['SID'];

switch ($REQUEST_METHOD) {
    case "POST":
        switch ($SID) {
            case 200://get emp
                $emp = new saq_employee();
                $designation_id = $_POST['designation_id'];
                $name = $_POST['name'];
                $department_id = $_POST['department_id'];
                $emp->designtion_id = $designation_id;
                $emp_all = $emp->getAll();

                if (count($emp_all) > 0) {
                    echo json_encode(array('result' => 1, "data" => $emp_all));
                } else {
                    echo json_encode(array('result' => 0, "data" => $emp_all));
                }
                break;
            case 201://add
                $name = $_POST['emp_name'];
                $designation = $_POST['emp_designation'];
                $reigion = $_POST['emp_region'];
                $emp_dns_region = $_POST['emp_dns_region'];
                $saq_district_id = $_POST['saq_district_id'];
                $districts = $_POST['saq_district_ids'];
                $user_id = $_POST['user_id'];

                $emp = new saq_employee();
                $emp->name = $name;
                $emp->designtion_id = $designation;
                $emp->region_id = $reigion;
                $emp->dns_region_id = $emp_dns_region;
                $emp->districts = $districts;
//        if(isset($_POST['emp_region'])){
//            $emp_region = $_POST['emp_region'];
//            
//        }
                $addNew = $emp->insert();
                if ($addNew) {
                    if ($user_id != '') {
                        $user_obj = new user($user_id);
                        $user_obj->saq_employee_id = $emp->id;
                        $user_obj->edit();
                    }

                    echo json_encode(array('result' => 1, 'msg' => "Successfully Added"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Save Failed"));
                }

                break;
            case 202:
                $id = $_REQUEST['id'];
                $name = $_POST['emp_name'];
                $designation = $_POST['emp_designation'];
                $reigion = $_POST['emp_region'];
                $emp_dns_region = $_POST['emp_dns_region'];
                $districts = $_POST['saq_district_ids'];
                $user_id = $_POST['user_id'];

                $emp = new saq_employee($id);
                $emp->name = $name;
                $emp->designtion_id = $designation;
                $emp->region_id = $reigion;
                $emp->dns_region_id = $emp_dns_region;
                $emp->districts = $districts;
                if (isset($_POST['emp_region'])) {
                    $emp_region = $_POST['emp_region'];
                }
                $edit = $emp->updateEmp();
                if ($edit) {
                    if ($user_id != '') {
                        $user_obj = new user($user_id);
                        $user_obj->saq_employee_id = $emp->id;
                        $user_obj->edit();
                    }

                    echo json_encode(array('result' => 1, 'msg' => "Successfully Edited"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Update Failed"));
                }
                break;

            case 203://
                $region_id = $_POST['region_id'];
                $region_obj = new saq_region($region_id);
                $regionEmployee = $region_obj->getRegionEmployees();
                //echo json_encode($regionEmployee);
                if (count($regionEmployee) > 0) {
                    echo json_encode(array('result' => 1, "data" => $regionEmployee));
                } else {
                    echo json_encode(array('result' => 0, "data" => $regionEmployee));
                }
                break;
            case 204:
                $eid = $_POST['id'];
                $status = $_POST['status'];

                $emp_obj = new saq_employee($eid);

                if ($status == 'D') {
                    $emp_obj->status = constants::$DELETED;
                } else if ($status == 'E') {
                    $emp_obj->status = constants::$active;
                }
                $result = $emp_obj->updateEmp();
                if ($result) {
                    echo json_encode(array('msg' => 1));
                } else {
                    echo json_encode(array('msg' => 0));
                }
                break;

            default :// default SID
                return false;
                break;
        }
        break;

    default :
        return false;
        break;
}

