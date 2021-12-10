<?php

include_once 'database.php';
include_once 'constants.php';

class saq_technical {

    public $id, $technology, $status;
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

    public function add() {
        $string = "INSERT INTO `$this->table_name` (`technology`) VALUES (" . getStringFormatted($this->technology) . ");";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function edit() {
        $string = "UPDATE `$this->table_name` SET `technology` = " . getStringFormatted($this->technology) . " WHERE `id` = $this->id;";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function delete() {
        $string = "UPDATE `$this->table_name` SET `status` = " . constants::$inactive . " WHERE `id` = $this->id;";
//        print $string;
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getAll() {
        $array = array();
        $string = "SELECT * FROM `$this->table_name` WHERE `status` = ".constants::$active.";";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $technology_obj = new saq_technical($row['id']);
            $technology_obj->getData();
            array_push($array, $technology_obj);
        }
        return $array;
    }

    function getId($technology) {
        $str = "SELECT * FROM $this->table_name WHERE  technology = '$technology'";
        $res = dbQuery($str);
        $row = dbFetchAssoc($res);
        return $row['id'];
    }

}
