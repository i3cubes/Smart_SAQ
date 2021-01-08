<?php

include_once '../class/cls_saq_region.php';

//$json = array();
$region_id = $_REQUEST['region_id'];

$region_obj = new saq_region($region_id);

echo json_encode($region_obj->getRegionEmployees());
?>

