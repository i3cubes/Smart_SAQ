<?php

include_once 'database.php';
include_once 'constants.php';

class customer {

    public $id, $name, $address, $location, $email, $business_customer_id;
    private $table_name = 'customer';

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getAll() {
        $return_array = array();
        $string = "SELECT * FROM `$this->table_name`";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            array_push($return_array, array(
                'id' => $row['id'],
                'name' => $row['name'],
                'address' => $row['address'],
                'location' => $row['location'],
                'email' => $row['email'],
//                'status' => $row['status'],
                'business_customer_id' => $row['business_customer_id']
            ));
        }
        return $return_array;
    }

    public function getDetails() {
        if ($this->id != "") {
            $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";           
            $result = dbQuery($string);
            $row = dbFetchAssoc($result);
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->address = $row['address'];
            $this->location = $row['location'];
            $this->email = $row['email'];
            $this->business_customer_id = $row['business_customer_id'];
        }
    }

    public function add() {
        $this->name = getStringFormatted($this->name);
        $this->address = getStringFormatted($this->address);
        $this->location = getStringFormatted($this->location);
        $this->email = getStringFormatted($this->email);

        $string = "INSERT INTO `$this->table_name` (`name`,`address`,`location`,`email`,`business_customer_id`) VALUES ("
                . "$this->name,"
                . "$this->address,"
                . "$this->location,"
                . "$this->email,"
                . "$this->business_customer_id"
                . ");";

        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function edit() {
        $update_array = array();
        $this->name = getStringFormatted($this->name);
        $this->address = getStringFormatted($this->address);
        $this->location = getStringFormatted($this->location);
        $this->email = getStringFormatted($this->email);
        $this->business_customer_id = getStringFormatted($this->business_customer_id);

        if ($this->name != 'NULL') {
            array_push($update_array, "`name`=$this->name");
        }
        if ($this->address != 'NULL') {
            array_push($update_array, "`address`=$this->address");
        }
        if ($this->location != 'NULL') {
            array_push($update_array, "`location`=$this->location");
        }
        if ($this->email != 'NULL') {
            array_push($update_array, "`email`=$this->email");
        }
        if ($this->business_customer_id != 'NULL') {
            array_push($update_array, "`business_customer_id`=$this->business_customer_id");
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