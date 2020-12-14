<?php
    session_start();
    include_once '../class/dataase.php';
    include_once '../class/constants.php';
    include_once '../class/cls_employees.php';
    
    $emp_data=new employees($_SESSION['EMPID']);
    $emp_data->getDetails();
    $emp_id = $_REQUEST['employee'];

    $json[] = array(
        'rate' => 0.3,
        'facility_fee' => 60
    );
    print json_encode($json);
?>