<?php

include_once 'database.php';
include_once 'constants.php';
include_once 'cls_employees.php';

class employee_manager {
    public $business_customer_id;
    
    public function __construct($id = '') {
        $this->business_customer_id = $id;
    }
    
    public function getAll($emp_id,$flag = '') { 
//        print 'asad' . $emp_id;
        $return_array = array();
        $emp_data=new employees($emp_id);
        $emp_data->getDetails();
        if($emp_data->designation_id== constants::$business_customer || $flag == 0){
            $string = "SELECT t1.*,t2.designation FROM ".$emp_data->table_name ." as t1 left join designation as t2 on t1.designation_id=t2.id WHERE t1.status = '" 
                    . constants::$active . "'  AND t1.designation_id <> '".constants::$business_customer.
                    "' AND t1.designation_id <> '".constants::$doctor."' AND t1.business_customer_id='".$emp_data->business_customer_id."' ORDER BY t1.id DESC;";
            
        }                
       
//        print $string;
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $emp=new employees($row['id']);
            $emp->id=$row['id'];
            $emp->name=$row['name'];
            $emp->first_name=$row['first_name'];
            $emp->last_name=$row['last_name'];
            $emp->address=$row['address'];
            $emp->email=$row['email'];
            $emp->contact_no=$row['home_number'];
            $emp->designation_id=$row['designation_id'];
            $emp->business_customer_id=$row['business_customer_id'];
            $emp->designation=$row['designation'];
            array_push($return_array,$emp);
        }
        return $return_array;
    }
    
    public function getReceivedSMS($emp_id,$start_date,$end_date) {
        $emp_obj = new employees($emp_id);
        $emp_obj->getDetails();
        $emp_mobile = $emp_obj->mobile_number;
        if($emp_mobile!='') {
            $string = "SELECT `id` FROM `sms_que` WHERE `mobile` = '$emp_mobile' AND `date_time` >= '".$start_date . ' 00:00:00'."' AND `date_time` <= '".$end_date. ' 23:59:59'."' AND `status` = ".constants::$sent.";";
//            print $string;
            $result = dbQuery($string);
            if(dbNumRows($result)>0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}

?>