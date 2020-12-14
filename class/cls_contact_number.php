<?php

include_once 'database.php';
include_once 'constants.php';

class contact_number {

    public $id, $number, $status, $customer_id;
    private $table_name = 'contact_number';

    public function __construct($id) {
        $this->id = $id;
    }
    
    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->number = $row['number'];
        $this->status = $row['status'];
        $this->customer_id = $row['customer_id'];
    }

    public function add() {
        $this->number = getStringFormatted($this->number);
        $this->customer_id = getStringFormatted($this->customer_id);

        $string = "INSERT INTO `$this->table_name` (`number`,`status`,`customer_id`) VALUES ("
                . "$this->number,"
                . "" . constants::$active . ","
                . "$this->customer_id"
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
        $this->number = getStringFormatted($this->number);
        $this->customer_id = getStringFormatted($this->customer_id);
        $this->status = getStringFormatted($this->status);

        if ($this->number != 'NULL') {
            array_push($update_array, "`number`=$this->number");
        }
        if ($this->customer_id != 'NULL') {
            array_push($update_array, "`customer_id`=$this->customer_id");
        }
        if ($this->status != 'NULL') {
            array_push($update_array, "`status`=$this->status");
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
