<?php

include_once 'database.php';
include_once 'constants.php';

class saq_other_operator {
    
    public $id,$name;
    private $table_name = 'saq_other_operator';
    
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
            $other_operator_obj = new saq_other_operator($row['id']);
            $other_operator_obj->getData();
            array_push($array, $other_operator_obj);
        }
        return $array;
    }
}
