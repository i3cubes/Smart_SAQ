<?php

include_once '../class/cls_site_model.php';

$site_model_obj = new site_model($_REQUEST['id']);



switch ($_REQUEST['option']) {
    case 'ADD':
        // upload file if uploded
        if (!empty($_FILES)) {
            $test = explode(".", $_FILES['file']['name']);
            $extension = end($test);
            $newName = time() . rand(100, 999) . "." . $extension;
            $location = "files/site_images/" . $newName;
            $save_to = "../files/site_images/" . $newName;
            $file_name = $_FILES['file']['name'];
            if (move_uploaded_file($_FILES['file']['tmp_name'], $save_to)) {               
                $result = $site_model_obj->addImage($_FILES['file']['type'],$file_name,$location);
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
        $view_saq_site_image = $site_model_obj->getImages();
        echo json_encode($view_saq_site_image);
        break;
    case 'DELETE':

        break;
    default :
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}
?>