<?php

include_once 'database.php';
include_once 'constants.php';

class saq_employee {
    public $id,$name,$address,$mobile,$email,$status,$saq_department_id;
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
    }
}

?>

