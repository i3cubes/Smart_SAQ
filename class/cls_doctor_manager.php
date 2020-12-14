<?php

include_once 'database.php';
include_once 'constants.php';
include_once 'cls_doctor.php';

class doctor_manager {
    public $business_customer_id;
    
    public function __construct($id) {
        $this->business_customer_id = $id;
    }
    public function getAll() { 
        $return_array=array();
        if($this->business_customer_id!=""){
            $string = "SELECT t1.id as employee_id,t1.*,t2.designation,t3.* FROM employees as t1 left join designation as t2 on t1.designation_id=t2.id left join doctor_data as t3 on t3.employees_id=t1.id WHERE t1.status <> '" 
                    . constants::$DELETED . "'  AND t1.designation_id = '".constants::$doctor.
                    "' AND t1.business_customer_id='".$this->business_customer_id."' ORDER BY t1.first_name;";
            //print $string;
            $result = dbQuery($string);
            while ($row = dbFetchAssoc($result)) {
                $emp=new doctor($row['employee_id']);
                $emp->title=$row['title'];
                $emp->name=$row['name'];
                $emp->first_name=$row['first_name'];
                $emp->last_name=$row['last_name'];
                $emp->address=$row['address'];
                $emp->email=$row['email'];
                $emp->contact_no=$row['contact_no'];
                $emp->designation_id=$row['designation_id'];
                $emp->business_customer_id=$row['business_customer_id'];
                $emp->designation=$row['designation'];
                $emp->contract_id=$row['contract_id'];
                $emp->contract_end_date=$row['contract_end_date'];
                $emp->date_of_join=$row['date_of_join'];
                $emp->company_name=$row['company_name'];
                $emp->qualifications=$row['qualifications'];
                $emp->abn=$row['abn'];
                $emp->mobile_number=$row['mobile_number'];
                $emp->contact_no=$row['home_number'];
                $emp->status=$row['status'];
                array_push($return_array,$emp);
            } 
        }
        return $return_array;
    }
    public function getAllActive() { 
        $return_array=array();
        if($this->business_customer_id!=""){
            $string = "SELECT t1.id as employee_id,t1.*,t2.designation,t3.* FROM employees as t1 left join designation as t2 on t1.designation_id=t2.id left join doctor_data as t3 on t3.employees_id=t1.id WHERE t1.status <> '" 
                    . constants::$DELETED ."' AND t1.status<>'". constants::$DISABALED. "'  AND t1.designation_id = '".constants::$doctor.
                    "' AND t1.business_customer_id='".$this->business_customer_id."' ORDER BY t1.first_name;";
            //print $string;
            $result = dbQuery($string);
            while ($row = dbFetchAssoc($result)) {
                $emp=new doctor($row['employee_id']);
                $emp->title=$row['title'];
                $emp->name=$row['name'];
                $emp->first_name=$row['first_name'];
                $emp->last_name=$row['last_name'];
                $emp->address=$row['address'];
                $emp->email=$row['email'];
                $emp->contact_no=$row['contact_no'];
                $emp->designation_id=$row['designation_id'];
                $emp->business_customer_id=$row['business_customer_id'];
                $emp->designation=$row['designation'];
                $emp->contract_id=$row['contract_id'];
                $emp->contract_end_date=$row['contract_end_date'];
                $emp->date_of_join=$row['date_of_join'];
                $emp->company_name=$row['company_name'];
                $emp->qualifications=$row['qualifications'];
                $emp->abn=$row['abn'];
                $emp->mobile_number=$row['mobile_number'];
                $emp->contact_no=$row['home_number'];
                $emp->status=$row['status'];
                array_push($return_array,$emp);
            } 
        }
        return $return_array;
    }

}

?>