<?php

include_once 'database.php';
include_once 'constants.php';

include_once 'cls_saq_employee.php';

class saq_site_type {
    
    public $id,$type,$status,$like_format;
    private $table_name = 'saq_site_types';

    public function __construct($id = '') {
        $this->id = $id;
    }
    
    public function getData() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->type = $row['name']; 
        $this->status = $row['status'];
       
    }
    function addNew (){
        $type = getStringFormatted($this->type);
        $str = "INSERT INTO $this->table_name (`name`) VALUES ($type)";
//        print $str;
        $res = dbQuery($str);
        if($res){
            return dbInsertId();
        }else {
            return false;
        }
    }
    function edit(){
        $ary_sql = array();
//        if($this->saq_district_id !=""){
//            array_push($ary_sql, "saq_district_id='$this->saq_district_id'");
//        }
        if($this->type !=""){
            array_push($ary_sql, "`name`='$this->type'");
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
        
        if($this->type !=""){
            if ($this->like_format =="="){
                array_push($ary_sql, "name = '$this->type'");
            }else if ($this->like_format =="%A%"){
                array_push($ary_sql, "name LIKE '%$this->type%'");
            }else if ($this->like_format =="A%"){
                array_push($ary_sql, "name LIKE '$this->type%'");
            }else if ($this->like_format =="%A"){
                array_push($ary_sql, "name LIKE '%$this->type'");
            } else {
                array_push($ary_sql, "name LIKE '$this->type'");
            }
            
        }
        if($this->status !=""){
            array_push($ary_sql, "`status`='$this->status'");
        }else {
            array_push($ary_sql, "`status`='".constants::$ACTIVE."'");
        }
        
        if(count($ary_sql)>0){
            $WHERE = " WHERE ".implode(" AND ", $ary_sql);
        }
        $array = array();
        $string = "SELECT * FROM `$this->table_name` $WHERE;";
        //print $string;
        $result = dbQuery($string);
        $array= array();
        while ($row = dbFetchAssoc($result)) {
            $saq_site_type_obj = new saq_site_type($row['id']);
            $saq_site_type_obj->getData();
            array_push($array, $saq_site_type_obj);
        }
        return $array;
    }
    

}

?>

