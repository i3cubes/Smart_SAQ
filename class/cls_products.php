<?php

include_once 'database.php';
include_once 'constants.php';

class products {

    public $id, $name, $code, $bar_code, $cost, $price, $status, $unit_id;
    private $table_name = 'products';

    public function __construct($id) {
        $this->id = $id;
    }
    
    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->code = $row['code'];
        $this->bar_code = $row['bar_code'];
        $this->cost = $row['cost'];
        $this->price = $row['price'];
        $this->status = $row['status'];
        $this->unit_id = $row['unit_id'];
    }

    public function add() {
        $this->name = getStringFormatted($this->name);
        $this->code = getStringFormatted($this->code);
        $this->bar_code = getStringFormatted($this->bar_code);
        $this->cost = getStringFormatted($this->cost);
        $this->price = getStringFormatted($this->price);
        $this->unit_id = getStringFormatted($this->unit_id);

        $string = "INSERT INTO `$this->table_name` (`name`,`code`,`bar_code`,`cost`,`price`,`status`,`unit_id`) VALUES ("
                . "$this->name,"
                . "$this->code,"
                . "$this->bar_code,"
                . "$this->cost,"
                . "$this->price,"
                . "" . constants::$active . ","
                . "$this->unit_id"
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
        $this->name = getStringFormatted($this->name);
        $this->code = getStringFormatted($this->code);
        $this->bar_code = getStringFormatted($this->bar_code);
        $this->cost = getStringFormatted($this->cost);
        $this->price = getStringFormatted($this->price);
        $this->status = getStringFormatted($this->status);
        $this->unit_id = getStringFormatted($this->unit_id);

        if ($this->name != 'NULL') {
            array_push($update_array, "`name`=$this->name");
        }
        if ($this->code != 'NULL') {
            array_push($update_array, "`code`=$this->code");
        }
        if ($this->bar_code != 'NULL') {
            array_push($update_array, "`bar_code`=$this->bar_code");
        }
        if ($this->cost != 'NULL') {
            array_push($update_array, "`cost`=$this->cost");
        }
        if ($this->price != 'NULL') {
            array_push($update_array, "`price`=$this->price");
        }
        if ($this->status != 'NULL') {
            array_push($update_array, "`status`=$this->status");
        }
        if ($this->unit_id != 'NULL') {
            array_push($update_array, "`unit_id`=$this->unit_id");
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