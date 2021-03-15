<?php

include_once 'database.php';
include_once 'constants.php';

include_once 'cls_saq_employee.php';

class saq_dns_depot {
    
    public $id,$depot_name,$status,$saq_district_id;
    private $table_name = 'dns_depot';

    public function __construct($id = '') {
        $this->id = $id;
    }
    
    public function getData() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->depot_name = $row['name']; 
        $this->status = $row['status'];
//        $this->saq_district_id = $row['saq_district_id'];
    }
    function addNew (){
        $depot_name = getStringFormatted($this->depot_name);
        $str = "INSERT INTO $this->table_name (`name`,`status`) VALUES ($depot_name,'".constants::$ACTIVE."')";
        $res = dbQuery($str);
        if($res){
            return true;
        }else {
            return false;
        }
    }
    function edit(){
        $ary_sql = array();
        if($this->depot_name !=""){
            array_push($ary_sql, "`name`='$this->depot_name'");
        }
        
        if(count($ary_sql)>0){
            $string = implode(", ", $ary_sql);
            $str = "UPDATE $this->table_name SET $string WHERE id ='$this->id'";
            //print $str;
            $res = dbQuery($str);
            if($res){
                return true;
            }else {
                return false;
            }
        }
    }
    public function getAll() {
        $ary_sql = array();
        if($this->depot_name !=""){
            array_push($ary_sql, "t1.saq_district_id='$this->depot_name'");
        }
        
        if($this->status !=""){
            array_push($ary_sql, "t1.`status`='$this->status'");
        }else {
            array_push($ary_sql, "t1.`status`='".constants::$ACTIVE."'");
        }
        
        if(count($ary_sql)>0){
            $WHERE = " WHERE ".implode(" AND ", $ary_sql);
        }
        $array = array();
        $string = "SELECT t1.* FROM `$this->table_name` AS t1 $WHERE;";
        //print $string;
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $saq_dns_depot_obj = new saq_dns_depot($row['id']);
            $saq_dns_depot_obj->getData();
            array_push($array, $saq_dns_depot_obj);
        }
        return $array;
    }
    
    /*public function getRegionEmployees() {
        $array = array();
        $string = "SELECT t2.saq_employee_id FROM `saq_region` AS `t1` INNER JOIN "
                . "`saq_region_employee` AS `t2` ON t1.id = t2.saq_region_id WHERE t1.id = $this->id;";
//        print $string;
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $saq_emp_obj = new saq_employee($row['saq_employee_id']);
            $saq_emp_obj->getData();
            array_push($array, $saq_emp_obj);
        }
        return $array;
    }*/
}

?>

