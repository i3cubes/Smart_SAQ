<?php
    session_start();
    include_once '../class/dataase.php';
    include_once '../class/constants.php';
    include_once '../class/cls_employees.php';
    
    $emp_data=new employees($_SESSION['EMPID']);
    $emp_data->getDetails();
    $designation_id=$_REQUEST['designation'];
    if($designation_id==''){
        $designation_id= constants::$admin;
    }
    $txt = $_REQUEST['term'];
    
    $string = "SELECT t1.*,t2.designation FROM ".$emp_data->table_name ." as t1 left join designation as t2 on t1.designation_id=t2.id "
            . "WHERE t1.first_name LIKE '%".$txt."%' AND t1.status = '" 
                    . constants::$active . "'  AND t1.designation_id <> '".$designation_id.
                    "' AND t1.designation_id <> '".constants::$business_customer."' AND t1.designation_id <> '".constants::$doctor."' AND t1.business_customer_id='".$emp_data->business_customer_id."';";  
    
    $result = dbQuery($string);   
    while ($row = dbFetchAssoc($result)) {
        $json[] = array(
            'id' => $row['id'],
            'value' => $row['first_name'] . ' ' . $row['last_name'],
            'name' => $row['first_name'] . ' ' . $row['last_name']
        );
    }
    
    print json_encode($json);
?>