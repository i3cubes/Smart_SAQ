<?php

include_once '../class/cls_agreement_model.php';

$agreement_model_obj = new agreement_model($_REQUEST['id']);



switch ($_REQUEST['option']) {
    case 'ADD':
        // upload file if uploded
        if (!empty($_FILES)) {
            $test = explode(".", $_FILES['file']['name']);
            $extension = end($test);
            $newName = time() . rand(100, 999) . "." . $extension;
            $location = "../saq_sample_agreement_files/" . $newName;
            $file_name = $_FILES['file']['name'];
            if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {               
                $result = $agreement_model_obj->addFile($_FILES['file']['type'],$file_name,$location);
                if ($result) {
                    echo json_encode(array('msg' => 1));
                } else {
                    echo json_encode(array('msg' => 0));
                }
            }
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'VIEW':
        $view_agreement_file = $agreement_model_obj->getFiles();
        echo json_encode($view_agreement_file);
        break;
    case 'DELETE':
        $delete_file = $agreement_model_obj->delete($_REQUEST['id']);
        if($delete_file) {
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