<?php

include_once 'database.php';
include_once 'constants.php';

class saq_ds {
    
    public $id,$name,$staus;
    private $table_name = 'saq_ds';

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
        $string = "SELECT * FROM `$this->table_name` WHERE `status` = ".constants::$active.";";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $saq_ds_obj = new saq_ds($row['id']);
            $saq_ds_obj->getData();
            array_push($array, $saq_ds_obj);
        }
        return $array;
    }
    
    public function add() {
        if ($this->name != '') { 
            $count_string = "SELECT COUNT(id) AS `id` FROM `$this->table_name`;";
            $result_count = dbQuery($count_string);
            $row = dbFetchAssoc($result_count);
            $id = ((int) $row['id']) + 1;
            $string = "INSERT INTO `$this->table_name` (`id`,`name`) VALUES ('$id'," . getStringFormatted($this->name) . ");";
//            print $string;
            $result = dbQuery($string);
            if ($result) {
                return true;
            } else {
                return false;
            }
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
}

?>

