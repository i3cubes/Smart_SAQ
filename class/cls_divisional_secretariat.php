<?php

include_once 'database.php';
include_once 'constants.php';

class saq_ds {
    
    public $id,$name;
    private $table_name = 'saq_ds';

    public function __construct($id) {
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
            $saq_ds_obj = new saq_ds($row['id']);
            $saq_ds_obj->getData();
            array_push($array, $saq_ds_obj);
        }
        return $array;
    }
}

?>

