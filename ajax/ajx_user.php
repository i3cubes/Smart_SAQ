<?php

session_start();
include_once '../class/cls_user.php';
$u_obj = new user($_POST['id']);

$u_obj->name = $_POST['username'];
$u_obj->password = $_POST['password'];
$u_obj->saq_us_role_id = $_POST['role'];


switch ($_POST['option']) {
    case 'LOGIN':
        $result = $u_obj->loginUser();
        if ($result === true) {
            echo json_encode(array('msg' => 1));
        } else if ($result == 100) {
            echo json_encode(array('msg' => 100));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'ADDUSER':
        $result = $u_obj->add();       
        if ($result === true) {
            echo json_encode(array('msg' => 1));
        } else if($result == 100){
            echo json_encode(array('msg' => 2));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'EDITUSER':
        $result = $u_obj->edit();
        if ($result === true) {
            echo json_encode(array('msg' => 1));
        } else if($result == 100){
            echo json_encode(array('msg' => 2));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'PASSWORDRESET':
        $result = $u_obj->edit();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'CHANGESTATUS':
        $uid = $_POST['id'];
        $status = $_POST['status'];

        if ($status == 'D') {
            $u_obj->status = constants::$DELETED;
            $u_obj->wrong_attempt = '5';
        } else if ($status == 'E') {
            $u_obj->status = constants::$active;
            $u_obj->wrong_attempt = '0';
        }
        $result = $u_obj->edit();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    default :
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}
?>