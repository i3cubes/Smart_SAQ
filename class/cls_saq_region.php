<?php

include_once 'database.php';
include_once 'constants.php';

class saq_region {
    
    public $id,$name,$status,$manager_id;
    private $table_name = 'saq_region';

    public function __construct($id) {
        $this->id = $id;
    }
    
    public function getData() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->name = $row['name']; 
        $this->status = $row['status'];
        $this->manager_id = $row['manager_id'];
    }
    
    public function getAll() {
        $array = array();
        $string = "SELECT * FROM `$this->table_name`;";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $saq_region_obj = new saq_region($row['id']);
            $saq_region_obj->getData();
            array_push($array, $saq_region_obj);
        }
        return $array;
    }
}

?>

