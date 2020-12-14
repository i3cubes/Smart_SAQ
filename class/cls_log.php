<?php

include_once 'database.php';
include_once 'constants.php';

class log {
    public $id,$module,$date_time,$log,$user_id;
    private $table_name = 'log';


    public function __construct($id = '') {
        $this->id = $id;
    }
    
    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->module = $row['module'];
        $this->date_time = $row['date_time'];
        $this->log = $row['log'];
        $this->user_id = $row['user_id'];        
    }
    
    public function add() {
        $this->module = getStringFormatted($this->module);
        $this->date_time = getStringFormatted($this->date_time);
        $this->log = getStringFormatted($this->log);
        
        $string = "INSERT INTO `$this->table_name` (`module`,`date_time`,`log`,`user_id`) VALUES ("
                . "$this->module,"
                . "$this->date_time,"
                . "$this->log,"
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
        $this->module = getStringFormatted($this->module);
        $this->date_time = getStringFormatted($this->date_time);
        $this->log = getStringFormatted($this->log);
        
        if($this->module != 'NULL') {
            array_push($update_array, "`module`=$this->module");
        }
        if($this->date_time != 'NULL') {
            array_push($update_array, "`date_time`=$this->date_time");
        }
        if($this->log != 'NULL') {
            array_push($update_array, "`log`=$this->log");
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
//        $string = "UPDATE `$this->table_name` SET `status`=".constants::$unactive." WHERE `id`=$this->id;";
    }
}

?>