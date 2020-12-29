<?php

include_once '../class/cls_saq_site_images.php';

$saq_site_img_obj = new saq_site_images();



switch ($_REQUEST['option']) {
    case 'ADD':
        // upload file if uploded
        if (!empty($_FILES)) {
            $test = explode(".", $_FILES['file']['name']);
            $extension = end($test);
            $newName = time() . rand(100, 999) . "." . $extension;
            $location = "../saq_site_images/" . $newName;
            $file_name = $_FILES['file']['name'];
            if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
                $saq_site_img_obj->base_path = $location;
                $saq_site_img_obj->name = $file_name;
                $saq_site_img_obj->saq_sites_id = $_REQUEST['saq_site_id'];

                $result = $saq_site_img_obj->add();
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
        $view_saq_site_image = $saq_site_img_obj->view($_REQUEST['saq_site_id']);
        echo json_encode($view_saq_site_image);
        break;
    case 'DELETE':

        break;
    default :
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}
?>