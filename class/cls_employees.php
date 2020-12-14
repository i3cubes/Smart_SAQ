<?php

session_start();
include_once 'database.php';
include_once 'constants.php';
include_once 'cls_employee_center.php';
include_once 'cls_employees_has_centers.php';
include_once 'cls_user.php';

class employees {

    public $id,
            $title,
            $first_name,
            $last_name,
            $username,
            $user_id,
            $date_of_join,
            $rate_per_hour,
            $office_number,
            $mobile_number,
            $home_address,
            $work_address,
            $work_function,
            $path,
            $address,
            $email,
            $contact_no,
            $contract_id,
            $center_id,
            $company_name,
            $contract_end_date,
            $country,
            $area_of_interest,
            $status,
            $designation_id,
            $designation,
            $business_customer_id,
            $health_identifier,
            $default_center_id,
            $centers,
            $abn;
    public $table_name = 'employees';

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = '$this->id';";
        //print $string;
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        // get user credentials
        $user_obj = new user();
        $user_obj->getDetailsByEmployeeId($this->id);
        $this->username = constants::removeNull($user_obj->name);
        $this->user_id = $user_obj->id;
        $this->title = constants::removeNull($row['title']);
        $this->first_name = constants::removeNull($row['first_name']);
        $this->last_name = constants::removeNull($row['last_name']);
        $this->date_of_join = constants::removeNull($row['date_of_join']);
        $this->rate_per_hour = constants::removeNull($row['rate_per_hour']);
        $this->office_number = constants::removeNull($row['office_number']);
        $this->mobile_number = constants::removeNull($row['mobile_number']);
        $this->home_address = constants::removeNull($row['home_address']);
        $this->work_address = constants::removeNull($row['work_address']);
        $this->work_function = constants::removeNull($row['work_function']);
        $this->path = constants::removeNull($row['path']);
        $this->address = constants::removeNull($row['address']);        
        $this->email = constants::removeNull($row['email']);
        $this->contact_no = constants::removeNull($row['contact_no']);
        $this->contract_id = constants::removeNull($row['contract_id']);
        $this->company_name = constants::removeNull($row['company_name']);
        $this->contract_end_date = constants::removeNull($row['contract_end_date']);
        $this->country = constants::removeNull($row['country']);
        $this->area_of_interest = constants::removeNull($row['area_of_interest']);
        $this->status = $row['status'];
        $this->designation_id = $row['designation_id'];
        $this->business_customer_id = $row['business_customer_id'];
        $this->health_identifier = $row['health_identifier'];
        $this->default_center_id = $row['default_center_id'];
        $empcen = new employees_has_centers();        
        $this->centers = $empcen->view($this->id);
    }

    public function add() {
        $string = "INSERT INTO `$this->table_name` ("
                . "`title`,"
                . "`name`,"
                . "`address`,"
                . "`email`,"
                . "`home_number`,"
                . "`first_name`,"
                . "`last_name`,"
                . "`date_of_join`,"
                . "`rate_per_hour`,"
                . "`office_number`,"
                . "`mobile_number`,"
                . "`home_address`,"
                . "`work_address`,"
                . "`work_function`,"
                . "`path`,"
                . "`status`,"
                . "`designation_id`,"
                . "`health_identifier`,"
                . "`default_center_id`,"
                . "`business_customer_id`"
                . ") VALUES ("
                . getStringFormatted($this->title).","
                . getStringFormatted($this->name).","
                . getStringFormatted($this->address).","
                . getStringFormatted($this->email).","
                . getStringFormatted($this->contact_no).","
                . getStringFormatted($this->first_name).","
                . getStringFormatted($this->last_name).","
                . getStringFormatted(constants::convertDate($this->date_of_join)).","
                . getStringFormatted($this->rate_per_hour).","
                . getStringFormatted($this->office_number).","
                . getStringFormatted($this->mobile_number).","
                . getStringFormatted($this->home_address).","
                . getStringFormatted($this->work_address).","
                . getStringFormatted($this->work_function).","
                . getStringFormatted($this->path).","
                . "'" . constants::$active . "','"
                . $this->designation_id."',"
                . getStringFormatted($this->health_identifier).","
                . getStringFormatted($this->default_center_id).",$this->business_customer_id);";
//        print $string;
        $result = dbQuery($string);
        if ($result) {
            $this->id=dbInsertId();
            return dbInsertId();
        } else {
            return false;
        }
    }

    public function edit() {
        $query_array = array();
        if($this->id!=""){
            $str = "UPDATE `$this->table_name` SET name="
                . getStringFormatted($this->name).",title="
                . getStringFormatted($this->title).",address="
                . getStringFormatted($this->address).",email="
                . getStringFormatted($this->email).",home_number="
                . getStringFormatted($this->home_number).",first_name="
                . getStringFormatted($this->first_name).",last_name="
                . getStringFormatted($this->last_name).",date_of_join="
                . getStringFormatted(constants::convertDate($this->date_of_join)).",rate_per_hour="
                . getStringFormatted($this->rate_per_hour).",office_number="
                . getStringFormatted($this->office_number).",mobile_number="
                . getStringFormatted($this->mobile_number).",home_address="
                . getStringFormatted($this->home_address).",work_address="
                . getStringFormatted($this->work_address).",country="
                . getStringFormatted($this->country).",area_of_interest="
                . getStringFormatted($this->area_of_interest).",work_function="
                . getStringFormatted($this->work_function).",path="
                . getStringFormatted($this->path).",health_identifier="
                . getStringFormatted($this->health_identifier).",default_center_id="
                . getStringFormatted($this->default_center_id).",designation_id='"
                . $this->designation_id."'"
                . " WHERE id='$this->id';";
//            print $str;
            $result = dbQuery($str);
            if($result) {
                $empcen = new employees_has_centers();
                $empcen->delete($this->id);
//                var_dump($this->center_id);
                if(count($this->center_id)>0) {
                    foreach ($this->center_id as $center) {
                        $empcen->add($this->id, $center);
                    }
                }
                return true;
            } else {
                return false;
            }            
        }
        else{
            return false;
        }

    }

    public function delete() {
        $string = "UPDATE `$this->table_name` SET `status` = " . constants::$DELETED . " WHERE `id` = $this->id;";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function deActivate() {
        $string = "UPDATE `$this->table_name` SET `status` = " . constants::$DISABALED . " WHERE `id` = $this->id;";
//        print $string;
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function Activate() {
        $string = "UPDATE `$this->table_name` SET `status` = " . constants::$ACTIVE . " WHERE `id` = $this->id;";        
//        print $string;
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    function addCenters(){
        if(is_array($this->centers)){
            $emp_center=new employee_center();
            foreach ($this->centers as $emp_center){
                $this->addCenter($emp_center->cenetr_id, $emp_center->provider_no);
            }
        }
    }
    function addCenter($c_id,$p_no){
        $str="INSERT INTO employee_center VALUES(NULL,'$this->id','$c_id','$p_no');";
        //print $str;
        $result = dbQuery($str);
        if ($result) {
            return dbInsertId();
        } else {
            return false;
        }
    }
    function deleteCenters(){
        $str="DELETE FROM employee_center WHERE employees_id='$this->id';";
        $result = dbQuery($str);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    function getCenters(){
        $str="SELECT t1.*,t2.name FROM employee_center as t1 left join centers as t2 on t1.centers_id=t2.id WHERE employees_id='$this->id';";
        $result = dbQuery($str);
        $this->centers=array();
        while ($row = dbFetchAssoc($result)) {
            $emp_center=new employee_center($row['id']);
            $emp_center->cenetr_id=$row['centers_id'];
            $emp_center->provider_no=$row['provider_no'];
            $emp_center->cenetr_name=$row['name'];
            array_push($this->centers, $emp_center);
        }
    }        

}

?>