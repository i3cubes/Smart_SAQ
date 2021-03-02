<?php

include_once 'database.php';
include_once 'constants.php';

class saq_approvals {
    public $id,$requirement,$description,$code;
    private $table_name = 'saq_approvals';
    
    public function __construct($id = '') {
        $this->id = $id;
    }
    
    public function getData() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->requirement = $row['requirement'];
        $this->description = $row['description'];
        $this->code = $row['code'];
    }
    
     public function add() {
        $string = "INSERT INTO `$this->table_name` (`requirement`,`description`,`code`) VALUES ("
                . "" . getStringFormatted($this->requirement) . ","
                . "" . getStringFormatted($this->description) . ","
                . "" . getStringFormatted($this->code) . ");";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function edit() {
        $string = "UPDATE `$this->table_name` SET "
                . "`requirement` = " . getStringFormatted($this->requirement) . ","
                . "`description` = " . getStringFormatted($this->description) . ","
                . "`code` = " . getStringFormatted($this->code) . " WHERE `id` = $this->id;";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getAll() {
        $array = array();
        $string = "SELECT * FROM `$this->table_name`;";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $saq_approvels_obj = new saq_approvals($row['id']);
            $saq_approvels_obj->getData();
            array_push($array, $saq_approvels_obj);
        }
        return $array;
    }
}
?>

