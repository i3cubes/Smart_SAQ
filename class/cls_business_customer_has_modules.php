<?php

include_once 'database.php';
include_once 'constants.php'; 

class business_customer_has_modules {
    public $id,$status,$business_customer_id,$modules_id;
    private $table_name = 'business_customer_has_modules';
    
    public function __construct($id = 0) {
        $this->id = $id;
    }
    
    public function view($bc_id) {
        $array = array();
        $string = "SELECT * FROM `$this->table_name` WHERE `business_customer_id` = $bc_id;";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            array_push($array, $row['modules_id']);
        }
        return $array;
    }
    
    public function viewAll($bc_id) {
        $array = array();
        $string = "SELECT t2.* FROM `$this->table_name` AS `t1` LEFT JOIN `modules` AS `t2` ON t1.modules_id = t2.id WHERE t1.business_customer_id = $bc_id;";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            array_push($array, array(
                'id' => $row['id'],
                'name' => $row['name'],
                'path' => $row['path'],
                'url' => $row['url'],
                'status' => $row['status']
            ));
        }
        return $array;
    }

        public function add() {
        $string = "INSERT INTO `$this->table_name` (`business_customer_id`,`modules_id`,`status`) VALUES ("
                . "'$this->business_customer_id',"
                . "'$this->modules_id',"
                . "'".constants::$ACTIVE."'"
                . ");";
//        print $string;
        $result = dbQuery($string);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function edit() {
        
    }
    
    public function delete() {
        $string = "DELETE FROM `$this->table_name` WHERE `business_customer_id` = $this->business_customer_id;";
        $result = dbQuery($string);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
}
?>