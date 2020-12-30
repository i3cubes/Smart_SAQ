<?php

include_once '../class/cls_site_model.php';
include_once '../class/cls_tree_node.php';

$tree_node_obj = new tree_node();
$saq_site_model_obj = new site_model();

$saq_site_model_obj->name = $_REQUEST['name'];
$saq_site_model_obj->parent_id = $_REQUEST['parent_model_id'];


switch ($_REQUEST['option']) {
    case 'ADD':
        $result = $saq_site_model_obj->save();
        if(is_int($result)) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'VIEW':        
        break;
    case 'DELETE':

        break;
    default :
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}
?>