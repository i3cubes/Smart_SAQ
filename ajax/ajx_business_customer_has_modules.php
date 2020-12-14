<?php

include_once '../class/cls_business_customer_has_modules.php';
//print_r($_REQUEST['data']);
$bchm_obj = new business_customer_has_modules();
switch ($_POST['option']) {
    case 'ADD':
        if (isset($_REQUEST['modules'])) {            
            if (is_string($_REQUEST['modules'])) {
                $_REQUEST['modules'] = array($_REQUEST['modules']);
            }
            $bchm_obj->business_customer_id = $_REQUEST['business_customer_id'];
            $bchm_obj->delete();
            foreach ($_REQUEST['modules'] as $module) {                                
                $bchm_obj->modules_id = $module;                
                $bchm_obj->add();
            }
            print json_encode(array('msg' => 1));
        } else {
            print json_encode(array('msg' => 0));
        }
        
        break;
    default :
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}
?>