<?php

include_once 'database.php';
include_once 'constants.php';

class issue_note {
    public $id,$note,$date,$status,$business_customer_id,$customer_id,$user_id;
    private $table_name = 'issue_note';


    public function __construct($id) {
        $this->id = $id;
    }
    
    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->note = $row['note'];
        $this->date = $row['date'];
        $this->status = $row['status'];
        $this->business_customer_id = $row['business_customer_id'];
        $this->customer_id = $row['customer_id'];
        $this->user_id = $row['user_id'];
    }
    
    public function add() {
        $this->note = getStringFormatted($this->note);
        $this->date = getStringFormatted($this->date);
//        $this->business_customer_id = getStringFormatted($str)
        
        $string = "INSERT INTO `$this->table_name` (`note`,`date`,`status`,`business_customer_id`,`customer_id`,`user_id`) VALUES ("
                . "$this->note,"
                . "$this->date,"
                . "".constants::$active.","
                . "$this->business_customer_id,"
                . "$this->customer_id,"
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
        $this->note = getStringFormatted($this->note);
        $this->date = getStringFormatted($this->date);
        $this->business_customer_id = getStringFormatted($this->business_customer_id);
        $this->customer_id = getStringFormatted($this->customer_id);
        
        if($this->note != 'NULL') {
            array_push($update_array, "`note`=$this->note");
        }
        if($this->date != 'NULL') {
            array_push($update_array, "`date`=$this->date");
        }
        if($this->business_customer_id != 'NULL') {
            array_push($update_array, "`business_customer_id`=$this->business_customer_id");
        }
        if($this->customer_id != 'NULL') {
            array_push($update_array, "`customer_id`=$this->customer_id");
        }
        
        if(count($update_array)>0) {
            $update_string = implode(',', $update_array);
            $string = "UPDATE `$this->table_name` SET $update_string WHERE `id` = $this->id;";
            $result = dbQuery($string);
            if($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function delete() {
        $string = "UPDATE `$this->table_name` SET `status` = ".constants::$unactive." WHERE `id` = $this->id;";
        $result = dbQuery($string);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
}

?>