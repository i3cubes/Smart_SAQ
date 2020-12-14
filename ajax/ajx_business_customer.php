<?php

include_once '../class/cls_business_customer.php';

if (array_key_exists('data', $_REQUEST)) {
    $data = json_decode($_REQUEST['data'], true);
    $bc_obj = new business_customer($data['id']);

    $bc_obj->name = $data['name'];
    $bc_obj->address = $data['address'];
    $bc_obj->br_number = $data['br_number'];
    $bc_obj->contact_number = $data['contact_number'];
    $bc_obj->fax = $data['fax'];
    $bc_obj->email = $data['email'];
    $bc_obj->contact_person_name = $data['contact_person_name'];
    $bc_obj->contact_person_email_address = $data['contact_person_email_address'];
    $bc_obj->contact_person_mobile = $data['contact_person_mobile'];
    $bc_obj->no_of_employees = $data['no_of_employees'];

    $option = $data['option'];
} else {
    $bc_obj = new business_customer($_POST['id']);

    $bc_obj->name = $_POST['name'];
    $bc_obj->address = $_POST['address'];
    $bc_obj->br_number = $_POST['br_number'];
    $bc_obj->contact_number = $_POST['contact_number'];
    $bc_obj->fax = $_POST['fax'];
    $bc_obj->email = $_POST['email'];
    $bc_obj->contact_person_name = $_POST['contact_person_name'];
    $bc_obj->contact_person_email_address = $_POST['contact_person_email_address'];
    $bc_obj->contact_person_mobile = $_POST['contact_person_mobile'];
    $bc_obj->no_of_employees = $_POST['no_of_employees'];
    
    $option = $_POST['option'];
}

if (!empty($_FILES)) {
    $test = explode(".", $_FILES['file']['name']);
    $extension = end($test);
    $newName = time() . rand(100, 999) . "." . $extension;
    $location = "../bc_logos/" . $newName;
    $file_name = $_FILES['file']['name'];
    if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
        $bc_obj->logo = $location;
    }
}

switch ($option) {
    case 'ADD':
        $result = $bc_obj->add();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'EDIT':
        $result = $bc_obj->edit();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'DELETE':
        $result = $bc_obj->delete($_REQUEST['status']);
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