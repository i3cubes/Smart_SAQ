

<?php

include_once 'database.php';
include_once 'constants.php';

class saq_access_type {

    public $id, $access_type;
    private $table_name = 'saq_access_type';

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getData() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->access_type = $row['access_type'];
    }

    public function add() {
        $string = "INSERT INTO `$this->table_name` (`access_type`) VALUES (" . getStringFormatted($this->access_type) . ");";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function edit() {
        $string = "UPDATE `$this->table_name` SET `access_type` = " . getStringFormatted($this->access_type) . " WHERE `id` = $this->id;";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getAll() {
        $array = array();
        $string = "SELECT * FROM `$this->table_name`;";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $saq_access_type_obj = new saq_access_type($row['id']);
            $saq_access_type_obj->getData();
            array_push($array, $saq_access_type_obj);
        }
        return $array;
    }

}
