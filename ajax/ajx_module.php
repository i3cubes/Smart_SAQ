<?php

include_once '../class/cls_modules.php';
//include_once '../class/cls_user.php';

if (array_key_exists('data', $_REQUEST)) {
    $data = json_decode($_REQUEST['data'], true);
    $m_obj = new modules($data['id']);
    $m_obj->name = $data['name'];
    $m_obj->url = $data['url'];
    $option = $data['option'];
} else {
    $m_obj = new modules($_POST['id']);    
    $m_obj->name = $_POST['name'];
    $m_obj->url = $_POST['url'];
    $option = $_POST['option'];
}
// upload file if uploded
if (!empty($_FILES)) {
    $test = explode(".", $_FILES['file']['name']);
    $extension = end($test);
    $newName = time() . rand(100, 999) . "." . $extension;
    $location = "img/home_icon/" . $newName;
    $file_name = $_FILES['file']['name'];
    if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
        $m_obj->path = $location;
    }
}

//print($option);
switch ($option) {
    case 'ADD':     
        $result = $m_obj->add();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'EDIT':        
        $result = $m_obj->edit();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'DELETE':
        $result = $m_obj->delete();
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