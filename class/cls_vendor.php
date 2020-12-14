<?php

include_once 'database.php';
include_once 'constants.php';

class vendor {
    public $id,$name,$address,$contact,$email,$status,$business_customer_id;
    private $table_name = 'vendor';


    public function __construct($id) {
        $this->id = $id;
    }
    
    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->address = $row['address'];
        $this->contact = $row['contact'];
        $this->email = $row['email'];
        $this->status = $row['status'];
        $this->business_customer_id = $row['business_customer_id'];
    }
    
    public function add() {
        $this->name = getStringFormatted($this->name);
        $this->address = getStringFormatted($this->address);
        $this->contact = getStringFormatted($this->contact);
        $this->email = getStringFormatted($this->email);
        $this->business_customer_id = getStringFormatted($this->business_customer_id);
        
        $string = "INSERT INTO `$this->table_name` (`name`,`address`,`contact`,`email`,`status`,`business_customer_id`) VALUES ("
                . "$this->name,"
                . "$this->address,"
                . "$this->contact,"
                . "$this->email,"
                . "".constants::$active.","
                . "$this->business_customer_id"
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
        $this->name = getStringFormatted($this->name);
        $this->address = getStringFormatted($this->address);
        $this->contact = getStringFormatted($this->contact);
        $this->email = getStringFormatted($this->email);
        $this->status = getStringFormatted($this->status);
        $this->business_customer_id = getStringFormatted($this->business_customer_id);
        
        if($this->name != 'NULL') {
            array_push($update_array, "`name`=$this->name");
        }
        if($this->address != 'NULL') {
            array_push($update_array, "`address`=$this->address");
        }
        if($this->contact != 'NULL') {
            array_push($update_array, "`contact`=$this->contact");
        }
        if($this->email != 'NULL') {
            array_push($update_array, "`email`=$this->email");
        }
        if($this->status != 'NULL') {
            array_push($update_array, "`status`=$this->status");
        }
        if($this->business_customer_id != 'NULL') {
            array_push($update_array, "`business_customer_id`=$this->business_customer_id");
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