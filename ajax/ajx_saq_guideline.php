<?php
session_start();
include_once '../class/cls_saq_guideline.php';
include_once '../class/cls_saq_guideline_files.php';

if (array_key_exists('data', $_REQUEST)) {
    $data = json_decode($_REQUEST['data'], true);
    $saq_obj = new saq_guideline($data['id']);
    $saq_obj->name = $data['name'];
    $saq_obj->description = $data['description'];
    $option = $data['option'];
} else {
    $saq_obj = new saq_guideline($_POST['id']);
    $saq_obj->name = $_POST['name'];
    $saq_obj->description = $_POST['description'];
    $option = $_POST['option'];
}

$saq_g_file = new saq_guideline_file('');

// upload file if uploded
if (!empty($_FILES)) {    
    $test = explode(".", $_FILES['file']['name']);
    $extension = end($test);
    $newName = time() . rand(100, 999) . "." . $extension;
    $location = "files/saq_guidelines/" . $newName;
    $save_to = "../files/saq_guidelines/" . $newName;
    $file_name = $_FILES['file']['name'];
    $file_type = $_FILES['file']['type'];
    if (move_uploaded_file($_FILES['file']['tmp_name'], $save_to)) {
        $saq_g_file->location = $location;
        $saq_g_file->name = $file_name;
        $saq_g_file->type=$file_type;
    }
}
//print $option;

switch ($option) {
    case 'ADD': 
        $saq_id = $saq_obj->add();
        if($saq_id) {
            if($saq_g_file->location != '') {                
                $saq_g_file->saq_guideline_id = $saq_id;
                $saq_g_file->add();
            }
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;   
    case 'EDIT':        
        $result = $saq_obj->edit();        
        if($result) {
            if($saq_g_file->location != '') {                
                $saq_g_file->saq_guideline_id = $saq_obj->id;
                $saq_g_file->add();
            }
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'DELETE':        
        $result = $saq_obj->delete();        
        if($result) {            
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'DELETEFILE':
        $result = $saq_obj->deleteFile($_REQUEST['id']);        
        if($result) {            
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'GETFILES':
        $result = $saq_obj->getFiles($_REQUEST['id']);                 
            echo json_encode($result);        
        break;
    default :
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}
?>