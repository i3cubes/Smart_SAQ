<?php

include_once 'database.php';
include_once 'constants.php';

class adjustments {
    public $id,$ref_no,$date,$status,$centers_id,$user_id;
    private $table_name = 'adjustments';


    public function __construct($id) {
        $this->id = $id;
    }
    
    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->ref_no = $row['ref_no'];
        $this->date = $row['date'];
        $this->status = $row['status'];
        $this->centers_id = $row['centers_id'];
        $this->user_id = $row['user_id'];
    }
    
    public function add() {
        $this->ref_no = getStringFormatted($this->ref_no);
        $this->date = getStringFormatted($this->date);
//        $this->centers_id = getStringFormatted($str)
        
        $string = "INSERT INTO `$this->table_name` (`ref_no`,`date`,`status`,`centers_id`,`user_id`) VALUES ("
                . "$this->ref_no,"
                . "$this->date,"
                . "".constants::$active.","
                . "$this->centers_id,"
                . "$this->user_id"
                . ");";
        $result = dbQuery($string);
        if($result) {
            return dbInsertId();
        } else {
            return false;
        }
    }
    
    public function edit() {
        $update_array = array();
        $this->ref_no = getStringFormatted($this->ref_no);
        $this->date = getStringFormatted($this->date);
        $this->centers_id = getStringFormatted($this->centers_id);
        $this->user_id = getStringFormatted($this->user_id);
        
        if($this->ref_no != 'NULL') {
            array_push($update_array, "`ref_no`=$this->ref_no");
        }
        if($this->date != 'NULL') {
            array_push($update_array, "`date`=$this->date");
        }
        if($this->centers_id != 'NULL') {
            array_push($update_array, "`centers_id`=$this->centers_id");
        }
        if($this->user_id != 'NULL') {
            array_push($update_array, "`user_id`=$this->user_id");
        }
        
        if (count($update_array) > 0) {
            $update_string = implode(',', $update_array);
            $string = "UPDATE `$this->table_name` SET $update_string WHERE `id` = $this->id;";
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
    
    public function delete() {
        $string = "UPDATE `$this->table_name` SET `status`=".constants::$unactive." WHERE `id` = $this->id;";
        $result = dbQuery($string);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
}

?>