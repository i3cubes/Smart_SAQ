<?php

include_once 'database.php';
include_once 'constants.php';

class saq_guideline_file {
    public $id,$name,$type,$location,$uploaded_date_time,$saq_guideline_id;
    private $table_name = 'saq_guideline_files';
    
    public function __construct($id = '') {
        $this->id = $id;
    }
    
    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->type=$row['type'];
        $this->location = $row['location'];
        $this->uploaded_date_time = $row['uploaded_date_time'];
        $this->saq_guideline_id = $row['saq_guideline_id'];
    }
    
    public function getAll($saq_id) {
        $array = array();
        $string = "SELECT * FROM `$this->table_name` WHERE `saq_guideline_id` = $saq_id;";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            array_push($array, array(
                'id' => $row['id'],
                'name' => $row['name'],
                'type' => $row['type'],
                'location' => $row['location'],                
                'uploaded_date_time' => $row['uploaded_date_time'],
                'saq_guideline_id' => $row['saq_guideline_id']
            ));
        }
        return $array;
    }
    
    public function add() {
        $string = "INSERT INTO `$this->table_name` (`name`,`type`,`location`,`uploaded_date_time`,`saq_guideline_id`) VALUES ("
                . "".getStringFormatted($this->name).","
                . "".getStringFormatted($this->type).","
                . "".getStringFormatted($this->location).","
                . "NOW(),"
                . "$this->saq_guideline_id"
                . ");";
//        print $string;
        $result = dbQuery($string);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function edit() {
        $string = "UPDATE `$this->table_name` SET `name` = ".getStringFormatted($this->name).","
                . "type=".getStringFormatted($this->type).","
                . "`location` = ".getStringFormatted($this->location)." WHERE `id` = $this->id;";
        $result = dbQuery($string);
        if($result) {
            return dbInsertId();
        } else {
            return false;
        }
    }
    
}
?>