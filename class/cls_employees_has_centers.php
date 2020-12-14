<?php

include_once 'database.php';
include_once 'constants.php';

class employees_has_centers {
    public $id,$employee_id,$centers_id;
    private $table_name = 'employees_has_centers';


    public function __construct($id = 0) {
        $this->id = $id;
    }
    
    public function view($employee_id) {
        $array = array();
        $string = "SELECT * FROM `$this->table_name` WHERE `employees_id` = $employee_id;";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            array_push($array, $row['centers_id']);
        }
        return $array;
    }


    public function add($employee_id, $center_id) {
        $employee_id = getStringFormatted($employee_id);
        $center_id = getStringFormatted($center_id);
        
        $string = "INSERT INTO `$this->table_name` (`employees_id`,`centers_id`) VALUES ($employee_id, $center_id);";
//        print $string;
        $result = dbQuery($string);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function delete($employee_id) {
        $string = "DELETE FROM `$this->table_name` WHERE `employees_id` = $employee_id;";
        $result = dbQuery($string);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
    
}

?>