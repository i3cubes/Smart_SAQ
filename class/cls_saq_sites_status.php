<?php

include_once 'database.php';
include_once 'constants.php';

class saq_sites_status {
    
    public $id,$name;
    private $table_name = 'saq_sites_status';

    public function __construct($id = '') {
        $this->id = $id;
    }
    
    public function getData() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->name = $row['name'];        
    }
    
    public function add($name) {
        if ($name != '') {
            $string = "INSERT INTO `$this->table_name` (`name`) VALUES (" . getStringFormatted($name) . ");";
            $result = dbQuery($string);
            if ($result) {
                return dbInsertId();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getIdByName($name) {
        $id = 0;
        if ($name != '') {
            $string = "SELECT `id` FROM `$this->table_name` WHERE `name` = " . getStringFormatted($name) . ";";
            $result = dbQuery($string);
            if (dbNumRows($result) > 0) {
                $row = dbFetchAssoc($result);
                $id = $row['id'];
            } else {
                $id = $this->add($name);
            }
        }

        return $id;
    }
    
    public function getAll() {
        $array = array();
        $string = "SELECT * FROM `$this->table_name`;";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $saq_status_obj = new saq_sites_status($row['id']);
            $saq_status_obj->getData();
            array_push($array, $saq_status_obj);
        }
        return $array;
    }
}

?>

