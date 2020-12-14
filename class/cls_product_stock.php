<?php

include_once 'database.php';
include_once 'constants.php';

class product_stock {

    public $id, $balance, $cost, $price, $status, $centers_id, $grn_id;
    private $table_name = 'product_stock';

    public function __construct($id) {
        $this->id = $id;
    }
    
    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->balance = $row['balance'];
        $this->cost = $row['cost'];
        $this->price = $row['price'];
        $this->status = $row['status'];
        $this->centers_id = $row['centers_id'];
        $this->grn_id = $row['grn_id'];
    }

    public function add() {
        $this->balance = getStringFormatted($this->balance);
        $this->cost = getStringFormatted($this->cost);
        $this->price = getStringFormatted($this->price);
        $this->centers_id = getStringFormatted($this->centers_id);
        $this->grn_id = getStringFormatted($this->grn_id);

        $string = "INSERT INTO `$this->table_name` (`balance`,`cost`,`price`,`status`,`centers_id`,`grn_id`) VALUES ("
                . "$this->balance,"
                . "$this->cost,"
                . "$this->price,"
                . "" . constants::$active . ","
                . "$this->centers_id,"
                . "$this->grn_id"
                . ");";
        $result = dbQuery($string);
        if ($result) {
            return dbInsertId();
        } else {
            return false;
        }
    }

    public function edit() {
        $update_array = array();
        $this->balance = getStringFormatted($this->balance);
        $this->cost = getStringFormatted($this->cost);
        $this->price = getStringFormatted($this->price);
        $this->status = getStringFormatted($this->status);
        $this->centers_id = getStringFormatted($this->centers_id);
        $this->grn_id = getStringFormatted($this->grn_id);
        
        if($this->balance != 'NULL') {
            array_push($update_array, "`balance`=$this->balance");
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
        if($this->centers_id != 'NULL') {
            array_push($update_array, "`centers_id`=$this->centers_id");
        }
        if($this->grn_id != 'NULL') {
            array_push($update_array, "`grn_id`=$this->grn_id");
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
        $string = "UPDATE `$this->table_name` SET `status` = " . constants::$unactive . " WHERE `id` = $this->id;";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}

?>