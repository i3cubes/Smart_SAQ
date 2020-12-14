<?php

include_once 'database.php';
include_once 'constants.php';

class product_ledger {
    public $id,$ref_type,$ref_id,$direction,$qty,$balanace_qty,$centers_id;
    private $table_name = 'product_ledger';


    public function __construct($id) {
        $this->id = $id;
    }
    
    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->ref_type = $row['ref_type'];
        $this->ref_id = $row['ref_id'];
        $this->direction = $row['direction'];
        $this->qty = $row['qty'];
        $this->balanace_qty = $row['balanace_qty'];
        $this->centers_id = $row['centers_id'];
    }
    
    public function add() {
        $this->ref_type = getStringFormatted($this->ref_type);
        $this->ref_id = getStringFormatted($this->ref_id);
        $this->direction = getStringFormatted($this->direction);
        $this->qty = getStringFormatted($this->qty);
        $this->balanace_qty = getStringFormatted($this->balanace_qty);
        $this->centers_id = getStringFormatted($this->centers_id);
        
        $string = "INSERT INTO `$this->table_name` (`ref_type`,`ref_id`,`direction`,`qty`,`balanace_qty`,`centers_id`) VALUES ("
                . "$this->ref_type,"
                . "$this->ref_id,"
                . "$this->direction,"
                . "$this->qty,"
                . "$this->balanace_qty,"
                . "$this->centers_id"
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
        $this->ref_type = getStringFormatted($this->ref_type);
        $this->ref_id = getStringFormatted($this->ref_id);
        $this->direction = getStringFormatted($this->direction);
        $this->qty = getStringFormatted($this->qty);
        $this->balanace_qty = getStringFormatted($this->balanace_qty);
        $this->centers_id = getStringFormatted($this->centers_id);
        
        if($this->ref_type != 'NULL') {
            array_push($update_array, "`ref_type`=$this->ref_type");
        }
        if($this->ref_id != 'NULL') {
            array_push($update_array, "`ref_id`=$this->ref_id");
        }
        if($this->direction != 'NULL') {
            array_push($update_array, "`direction`=$this->direction");
        }
        if($this->qty != 'NULL') {
            array_push($update_array, "`qty`=$this->qty");
        }
        if($this->balanace_qty != 'NULL') {
            array_push($update_array, "`balanace_qty`=$this->balanace_qty");
        }
        if($this->centers_id != 'NULL') {
            array_push($update_array, "`centers_id`=$this->centers_id");
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
//        $string = "UPDATE `$this->table_name` SET `s`"
    }
}

?>