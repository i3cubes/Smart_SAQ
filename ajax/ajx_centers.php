<?php

include_once '../class/cls_centers.php';
//print_r($_REQUEST['data']);
$c_obj = new centers($_POST['id']);

$c_obj->name = $_POST['name'];
$c_obj->address = $_POST['address'];
$c_obj->contact_no = $_POST['contact_no'];
$c_obj->code = $_POST['code'];
$c_obj->city = $_POST['city'];
$c_obj->postcode = $_POST['postcode'];
$c_obj->rural_remote_area = $_POST['rural_remote_area'];
$c_obj->fax = $_POST['fax'];
$c_obj->email = $_POST['email'];
$c_obj->web = $_POST['web'];
$c_obj->abn = $_POST['abn'];
$c_obj->lsp = $_POST['lsp'];
$c_obj->minor_id = $_POST['minor_id'];
$c_obj->site_id = $_POST['site_id'];
$c_obj->health_identifier = $_POST['health_identifier'];
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
    case 'SAVESETTING':
        foreach ($_REQUEST['data']['name'] as $index => $value) {
            $center_obj = new centers($value);
            $center_obj->weekly_hours = $_REQUEST['data']['value'][$index];
            $center_obj->edit();
        }        
        echo json_encode(array('msg' => 1));        
        break;
    case 'DELETE':
        $result = $c_obj->delete($_POST['status']);
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