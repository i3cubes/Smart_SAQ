<?php

include_once 'database.php';
include_once 'constants.php';

class grn_products {
    public $id,$qty,$price,$cost,$grn_id,$products_id;
    private $table_name = 'grn_products';


    public function __construct($id) {
        $this->id = $id;
    }
    
    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->qty = $row['qty'];
        $this->price = $row['price'];
        $this->cost = $row['cost'];
        $this->grn_id = $row['grn_id'];
        $this->products_id = $row['products_id'];
    }
    
    public function add() {
        $this->qty = getStringFormatted($this->qty);
        $this->price = getStringFormatted($this->price);
        $this->cost = getStringFormatted($this->cost);
//        $this->grn_id = getStringFormatted($this->grn_id);
//        $this->products_id = getStringFormatted($this->products_id);
        
        $string = "INSERT INTO `$this->table_name` (`qty`,`price`,`cost`,`grn_id`,`products_id`) VALUES ("
                . "$this->qty,"
                . "$this->price,"
                . "$this->cost,"
                . "$this->grn_id,"
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
        $this->price = getStringFormatted($this->price);
        $this->cost = getStringFormatted($this->cost);
        $this->grn_id = getStringFormatted($this->grn_id);
        $this->products_id = getStringFormatted($this->products_id);
        
        if($this->qty != 'NULL') {
            array_push($update_array, "`qty`=$this->qty");
        }
        if($this->price != 'NULL') {
            array_push($update_array, "`price`=$this->price");
        }
        if($this->cost != 'NULL') {
            array_push($update_array, "`cost`=$this->cost");
        }
        if($this->grn_id != 'NULL') {
            array_push($update_array, "`grn_id`=$this->grn_id");
        }
        if($this->products_id != 'NULL') {
            array_push($update_array, "`products_id`=$this->products_id");
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
//        $string = "UPDATE `$this->table_name` SET ``"
    }
}

?>