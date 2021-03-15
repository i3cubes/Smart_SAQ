<?php

include_once 'database.php';
include_once 'constants.php';

class saq_employee {
    public $id,$name,$address,$mobile,$email,$status,$saq_department_id,$designtion_id;
    public $designation,$department;
    private $table_name = 'saq_employee';
    
    public function __construct($id = '') {
        $this->id = $id;
    }
    
    public function getData() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->address = $row['address'];
        $this->mobile = $row['$mobile'];
        $this->email = $row['email'];
        $this->status = $row['status'];
        $this->saq_department_id = $row['saq_department_id'];
        $this->designtion_id = $row['saq_designation_id'];
    }
    public function getAll(){
        $ary_sql = array();
        if($this->name != ""){
            array_push($ary_sql, "t1.`name` LIKE '%$this->name%'");
        }
        if($this->saq_department_id != ""){
            array_push($ary_sql, "t1.`saq_department_id` = '$this->saq_department_id'");
        }
        if($this->designtion_id != ""){
            array_push($ary_sql, "t1.`saq_designation_id` IN ('$this->designtion_id')");
        }
        if(count($ary_sql)>0){
            $WHERE = " WHERE ".implode(" AND ", $ary_sql);
        }
        $str = "SELECT t1.*, t2.dept, t3.designation FROM $this->table_name AS t1 LEFT JOIN saq_department AS t2 ON t1.saq_department_id = t2.id"
                . " LEFT JOIN saq_designation AS t3 ON t1.saq_designation_id = t3.id $WHERE ";
        $res = dbQuery($str);
        $results = array();
        while ($row = dbFetchAssoc($res)) {
            
            $saq_employee_obj = new saq_employee();
            $saq_employee_obj->id = $row['id'];
        $saq_employee_obj->name = $row['name'];
        $saq_employee_obj->address = $row['address'];
        $saq_employee_obj->mobile = $row['$mobile'];
        $saq_employee_obj->email = $row['email'];
        $saq_employee_obj->status = $row['status'];
        $saq_employee_obj->saq_department_id = $row['saq_department_id'];
        $saq_employee_obj->designtion_id = $row['saq_designation_id'];
        $saq_employee_obj->designtion = $row['designation'];
        $saq_employee_obj->department = $row['dept'];
            
            array_push($results, $saq_employee_obj);
        }
        return $results;
    }

    public function insert() {
        $name = getStringFormatted($this->name);
        $address = getStringFormatted($this->address);
        $mobile = getStringFormatted($this->mobile);
        $email = getStringFormatted($this->email);
        $dept = getStringFormatted($this->saq_department_id);
        $des  = getStringFormatted($this->designtion_id);
        //id, name, address, mobile, email, status, saq_department_id, saq_designation_id
        $str ="INSERT INTO $this->table_name (name, address, mobile, email, status, saq_department_id, saq_designation_id) "
                . "VALUES ($name, $address, $mobile, $email, '1', $dept, $des)";
        
        $res = dbQuery($str);
        if($res){
            return true;
        } else {
            return false;    
        }
    }
    function updateEmp (){
        $ary_sql = array();
        $name = ($this->name);
        $address = ($this->address);
        $mobile = ($this->mobile);
        $email = ($this->email);
        $dept = ($this->saq_department_id);
        $des  = ($this->designtion_id);
        
        if($name !=""){
            array_push($ary_sql, "name =". getStringFormatted($name));
        }
        if($address !=""){
            array_push($ary_sql, "address =". getStringFormatted($address));
        }
        if($mobile !=""){
            array_push($ary_sql, "mobile =". getStringFormatted($mobile));
        }
        if($email !=""){
            array_push($ary_sql, "email =". getStringFormatted($email));
        }
        if($dept !=""){
            array_push($ary_sql, "saq_department_id =". getStringFormatted($dept));
        }
        if($des !=""){
            array_push($ary_sql, "saq_designation_id =". getStringFormatted($name));
        }
        
        if(count($ary_sql)>0){
            $updStr = implode( ", ", $ary_sql);
            $str = "UPDATE $this->table_name SET $updStr WHERE id='$this->id'";
            $res = dbQuery($str);
            if($res){
                return true; 
            }else {
                return false;
            }
        }
    }
}

?>

