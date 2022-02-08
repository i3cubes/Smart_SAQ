<?php

include_once 'database.php';
include_once 'constants.php';

class saq_payment_mode {

    public $id, $name, $status;
    private $table_name = 'saq_payment_mode';

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

    public function add() {
        $string = "INSERT INTO `$this->table_name` (`name`) VALUES (" . getStringFormatted($this->name) . ");";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function edit() {
        $string = "UPDATE `$this->table_name` SET `name` = " . getStringFormatted($this->name) . " WHERE `id` = $this->id;";
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
        $string = "SELECT * FROM `$this->table_name` WHERE `status` = " . constants::$active . ";";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $saq_payment_mode_obj = new saq_payment_mode($row['id']);
            $saq_payment_mode_obj->getData();
            array_push($array, $saq_payment_mode_obj);
        }
        return $array;
    }

}
