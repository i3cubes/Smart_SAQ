<?php

include_once '../class/cls_customer.php';

$c_obj = new customer($_POST['id']);

$c_obj->name = $_POST['name'];
$c_obj->address = $_POST['address'];
$c_obj->location = $_POST['location'];
$c_obj->email = $_POST['email'];
$c_obj->business_customer_id = $_POST['business_customer_id'];

switch ($_POST['option']) {
    case 'ADD': 
        $result = $c_obj->add();
        if($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'EDIT':
        $result = $c_obj->edit();
        if($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'DELETE':
        $result = $c_obj->delete();
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