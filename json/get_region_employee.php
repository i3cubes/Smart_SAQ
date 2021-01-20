<?php

include_once '../class/cls_saq_region.php';
include_once '../class/cls_saq_employee.php';

//$json = array();
$region_id = $_REQUEST['region_id'];

$region_obj = new saq_region($region_id);
$region_obj->getData();
if($region_obj->manager_id != '') {
    $emp_obj = new saq_employee($region_obj->manager_id);
}

echo json_encode(array('saq_emp' => $region_obj->getRegionEmployees(),'rm_name' => $emp_obj->name));
?>

