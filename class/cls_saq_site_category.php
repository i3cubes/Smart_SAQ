<?php

include_once 'database.php';
include_once 'constants.php';

class saq_site_category {

    public $id, $category;
    private $table_name = 'saq_site_category';

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getData() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->category = $row['category'];
    }

    public function add() {
        $string = "INSERT INTO `$this->table_name` (`category`) VALUES (" . getStringFormatted($this->category) . ");";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function edit() {
        $string = "UPDATE `$this->table_name` SET `category` = " . getStringFormatted($this->category) . " WHERE `id` = $this->id;";
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
            $saq_site_category_obj = new saq_site_category($row['id']);
            $saq_site_category_obj->getData();
            array_push($array, $saq_site_category_obj);
        }
        return $array;
    }

}
