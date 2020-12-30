<?php

include_once '../class/cls_agreement_model.php';
//include_once '../class/cls_tree_node.php';

//$tree_node_obj = new tree_node();
$saq_agreement_model_obj = new agreement_model();

$saq_agreement_model_obj->name = $_REQUEST['name'];
$saq_agreement_model_obj->parent_id = $_REQUEST['parent_agreement_id'];


switch ($_REQUEST['option']) {
    case 'ADD':
        $result = $saq_agreement_model_obj->save();
        if($result) {
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