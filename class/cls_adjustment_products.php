<?php

include_once 'database.php';
include_once 'constants.php';

class adjustment_products {
    public $id,$qty,$status,$products_id,$adjustment_id;
    private $table_name = 'adjustment_products';
    
    public function __construct($id) {
        $this->id = $id;
    }
    
    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->qty = $row['qty'];
        $this->status = $row['status'];
        $this->products_id = $row['products_id'];
        $this->adjustment_id = $row['adjustment_id'];
    }
    
    public function add() {
        $this->qty = getStringFormatted($this->qty);
        $string = "INSERT INTO `$this->table_name` (`qty`,`status`,`products_id`,`adjustments_id`) VALUES ("
                . "$this->qty,"
                . "".constants::$active.","
                . "$this->products_id,"
                . "$this->adjustment_id"
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
        $this->qty = getStringFormatted($this->qty);
        $this->status = getStringFormatted($this->status);
        $this->products_id = getStringFormatted($this->products_id);
        $this->adjustment_id = getStringFormatted($this->adjustment_id);
        
        if($this->qty != 'NULL') {
            array_push($update_array, "`qty`=$this->qty");
        }
        if($this->status != 'NULL') {
            array_push($update_array, "`status`=$this->status");
        }
        if($this->products_id != 'NULL') {
            array_push($update_array, "`products_id`=$this->products_id");
        }
        if($this->adjustment_id != 'NULL') {
            array_push($update_array, "`adjustment_id`=$this->adjustment_id");
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
        $string = "UPDATE `$this->table_name` SET `status`=".constants::$unactive." WHERE `id`=$this->id;";
        $result = dbQuery($string);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
    
}

?>