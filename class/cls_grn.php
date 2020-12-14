<?php

include_once 'database.php';
include_once 'constants.php';

class grn {
    public $id,$ref_no,$date_added,$status,$vendor_id,$business_customer_id,$centers_id,$user_id;
    private $table_name = 'grn';


    public function __construct($id) {
        $this->id = $id;
    }
    
    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->ref_no = $row['ref_no'];
        $this->date_added = $row['date_added'];
        $this->status = $row['status'];
        $this->vendor_id = $row['vendor_id'];
        $this->business_customer_id = $row['business_customer_id'];
        $this->centers_id = $row['centers_id'];
        $this->user_id = $row['user_id'];
    }
    
    public function add() {
        $this->ref_no = getStringFormatted($this->ref_no);
        $this->date_added = getStringFormatted($this->date_added);
        $this->vendor_id = getStringFormatted($this->vendor_id);
        $this->business_customer_id = getStringFormatted($this->business_customer_id);
        $this->centers_id = getStringFormatted($this->centers_id);
        $this->user_id = getStringFormatted($this->user_id);
        
        $string = "INSERT INTO `$this->table_name` (`ref_no`,`date_added`,`status`,`vendor_id`,`business_customer_id`,`centers_id`,`user_id`) VALUES ("
                . "$this->ref_no,"
                . "$this->date_added,"
                . "".constants::$active.","
                . "$this->vendor_id,"
                . "$this->business_customer_id,"
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
        $this->date_added = getStringFormatted($this->date_added);
        $this->status = getStringFormatted($this->status);
        $this->vendor_id = getStringFormatted($this->vendor_id);
        $this->business_customer_id = getStringFormatted($this->business_customer_id);
        $this->centers_id = getStringFormatted($this->centers_id);
        $this->user_id = getStringFormatted($this->user_id);
        
        if($this->ref_no != 'NULL') {
            array_push($update_array, "`ref_no`=$this->ref_no");
        }
        if($this->date_added != 'NULL') {
            array_push($update_array, "`date_added`=$this->date_added");
        }
        if($this->status != 'NULL') {
            array_push($update_array, "`status`=$this->status");
        }
        if($this->vendor_id != 'NULL') {
            array_push($update_array, "`vendor_id`=$this->vendor_id");
        }
        if($this->business_customer_id != 'NULL') {
            array_push($update_array, "`business_customer_id`=$this->business_customer_id");
        }
        if($this->centers_id != "NULL") {
            array_push($update_array, "`centers_id`=$this->centers_id");
        }
        if($this->user_id != 'NULL') {
            array_push($update_array, "`user_id`=$this->user_id");
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