<?php
    session_start();
    include_once '../class/dataase.php';
    include_once '../class/constants.php';
    include_once '../class/cls_employees.php';
    
    $emp_data=new employees($_REQUEST['emp_id']);
    $emp_data->getDetails();
    $txt = $_REQUEST['term'];
    
    $string = "SELECT * FROM centers as t1 WHERE name LIKE '%".$txt."%' AND status = '" 
                    . constants::$active . "' AND business_customer_id='".$emp_data->business_customer_id."';";  
    //print $string;
    
    $result = dbQuery($string);   
    while ($row = dbFetchAssoc($result)) {
        $json[] = array(
            'id' => $row['id'],
            'value' => $row['name'],
            'name' => $row['name']
        );
    }
    
    print json_encode($json);
?>