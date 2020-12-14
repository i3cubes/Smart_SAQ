<?php

include_once 'database.php';
include_once 'constants.php';

class issue_items {
    public $id,$qty,$cost,$price,$status,$issue_note_id,$products_id;
    private $table_name = 'issue_items';
    
    public function __construct($id) {
        $this->id = $id;
    }
    
    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->qty = $row['qty'];
        $this->cost = $row['cost'];
        $this->price = $row['price'];
        $this->status = $row['status'];
        $this->issue_note_id = $row['issue_note_id'];
        $this->products_id = $row['products_id'];
    }
    
    public function add() {
        $this->qty = getStringFormatted($this->qty);
        $this->cost = getStringFormatted($this->cost);
        $this->price = getStringFormatted($this->price);
        
        $string = "INSERT INTO `$this->table_name` (`qty`,`cost`,`price`,`status`,`issue_note_id`,`products_id`) VALUES ("
                . "$this->qty,"
                . "$this->cost,"
                . "$this->price,"
                . "".constants::$active.","
                . "$this->issue_note_id,"
                . "$this->products_id"
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
        $this->cost = getStringFormatted($this->cost);
        $this->price = getStringFormatted($this->price);
        $this->status = getStringFormatted($this->status);
        $this->issue_note_id = getStringFormatted($this->issue_note_id);
        $this->products_id = getStringFormatted($this->products_id);
        
        if($this->qty != 'NULL') {
            array_push($update_array, "`qty`=$this->qty");
        }
        if($this->cost != 'NULL') {
            array_push($update_array, "`cost`=$this->cost");
        }
        if($this->price != 'NULL') {
            array_push($update_array, "`price`=$this->price");
        }
        if($this->status != 'NULL') {
            array_push($update_array, "`status`=$this->status");
        }
        if($this->issue_note_id != 'NULL') {
            array_push($update_array, "`issue_note_id`=$this->issue_note_id");
        }
        if($this->products_id != 'NULL') {
            array_push($update_array, "`products_id`=$this->products_id");
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