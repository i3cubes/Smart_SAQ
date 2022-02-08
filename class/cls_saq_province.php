<?php

include_once 'database.php';
include_once 'constants.php';

class saq_province {
    
    public $id,$name;
    private $table_name = 'saq_province';

    public function __construct($id = '') {
        $this->id = $id;
    }
    
    public function getData() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->name = $row['name'];        
    }
    
    public function getAll() {
        $array = array();
        $string = "SELECT * FROM `$this->table_name`;";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $saq_province_obj = new saq_province($row['id']);
            $saq_province_obj->getData();
            array_push($array, $saq_province_obj);
        }
        return $array;
    }
}

?>

