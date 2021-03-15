<?php

include_once 'database.php';
include_once 'constants.php';

class saq_permission_type {

    public $id, $permission_type;
    private $table_name = 'saq_access_permission_type';

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getData() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->permission_type = $row['permission_type'];
    }

    public function add() {
        $string = "INSERT INTO `$this->table_name` (`permission_type`) VALUES (" . getStringFormatted($this->permission_type) . ");";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function edit() {
        $string = "UPDATE `$this->table_name` SET `permission_type` = " . getStringFormatted($this->permission_type) . " WHERE `id` = $this->id;";
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
            $saq_permission_type_obj = new saq_permission_type($row['id']);
            $saq_permission_type_obj->getData();
            array_push($array, $saq_permission_type_obj);
        }
        return $array;
    }

}
