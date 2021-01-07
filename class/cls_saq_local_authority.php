<?php

include_once 'database.php';
include_once 'constants.php';

class saq_la {
    
    public $id,$name;
    private $table_name = 'saq_la';

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
            $saq_la_obj = new saq_la($row['id']);
            $saq_la_obj->getData();
            array_push($array, $saq_la_obj);
        }
        return $array;
    }
}

?>

