<?php
session_start();
include_once '../class/cls_user.php';
//print_r($_REQUEST);
$u_obj = new user($_POST['id']);

$u_obj->name = $_POST['username'];
$u_obj->password = $_POST['password'];
//$u_obj->email = $_POST['email'];
//$u_obj->address = $_POST['address'];
//$u_obj->contact_no = $_POST['contact_no'];

switch ($_POST['option']) {
    case 'LOGIN': 
        $result = $u_obj->loginUser();
        if($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;   
    case 'ADDUSER':        
        $result = $u_obj->add();
        if($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'EDITUSER':
        $result = $u_obj->edit();
        if($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'PASSWORDRESET':
        $result = $u_obj->edit();
        if($result) {
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