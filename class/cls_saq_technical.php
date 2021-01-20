<?php

include_once 'database.php';
include_once 'constants.php';

class saq_technical {
    
    public $id,$technology;
    private $table_name = 'saq_technical';
    
    public function __construct($id = '') {
        $this->id = $id;
    }


    public function getData() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->technology = $row['technology'];
    }

        public function getAll() {
        $array = array();
        $string = "SELECT * FROM `$this->table_name`;";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $technology_obj = new saq_technical($row['id']);
            $technology_obj->getData();
            array_push($array, $technology_obj);
        }
        return $array;
    }
    function getId($technology){
        $str = "SELECT * FROM $this->table_name WHERE  technology = '$technology'";
        $res = dbQuery($str);
        $row = dbFetchAssoc($res);
        return $row['id'];
        
    }
}

