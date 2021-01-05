<?php

include_once 'database.php';
include_once 'constants.php';

class saq_technical {
    
    public $id,$technology;
    private $table_name = 'saq_technical';
    
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
            array_push($array, array(
                'id' => $row['id'],
                'technology' => $row['technology']
            ));
        }
        return $array;
    }
}

