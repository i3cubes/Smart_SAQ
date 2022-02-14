<?php

include_once 'database.php';
include_once 'constants.php';

class saq_gs {
    
    public $id,$gs_name,$saq_district_id,$staus;
    private $table_name = 'saq_gs';

    public function __construct($id = '') {
        $this->id = $id;
    }
    
    public function getData() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->gs_name = $row['gs_name'];     
        $this->saq_district_id = $row['saq_district_id'];
        $this->staus = $row['status'];
    }
    
    public function getAll() {
        $array = array();
        $string = "SELECT * FROM `$this->table_name` WHERE `status` = ".constants::$active.";";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $saq_gs_obj = new saq_gs($row['id']);
            $saq_gs_obj->getData();
            array_push($array, $saq_gs_obj);
        }
        return $array;
    }
    
    public function add() {
        if ($this->gs_name != '') { 
            $count_string = "SELECT COUNT(id) AS `id` FROM `$this->table_name`;";
            $result_count = dbQuery($count_string);
            $row = dbFetchAssoc($result_count);
            $id = ((int) $row['id']) + 1;
            $string = "INSERT INTO `$this->table_name` (`id`,`gs_name`,`saq_district_id`,`status`) VALUES ('$id'," . getStringFormatted($this->gs_name) . ",'$this->saq_district_id','".constants::$active."');";
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
        $string = "UPDATE `$this->table_name` SET "
                . "`gs_name` = " . getStringFormatted($this->gs_name) . ","
                . "`saq_district_id` = '$this->saq_district_id'"
                . " WHERE `id` = $this->id;";
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

