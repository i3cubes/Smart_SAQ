<?php

include_once 'database.php';
include_once 'constants.php';

class saq_guideline {
    public $id,$name,$description,$date;
    private $table_name = 'saq_guideline';
    
    public function __construct($id = '') {
        $this->id = $id;
    }
    
    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->description = $row['description'];
        $this->date = $row['uploaded_date_time'];
    }
    
    
    public function add() {
        $string = "INSERT INTO `$this->table_name` (`name`,`description`,`uploaded_date_time`) VALUES ("
                . "".getStringFormatted($this->name).","
                . "".getStringFormatted($this->description).","
                . "NOW()"
                . ");";
        $result = dbQuery($string);
        if($result) {             
            return dbInsertId();
        } else {
            return false;
        }
    }
    
    public function edit() {
        $string = "UPDATE `$this->table_name` SET `name` = ".getStringFormatted($this->name).","
                . "`description` = ".getStringFormatted($this->description)." WHERE `id` = $this->id;";
//        print $string;
        $result = dbQuery($string);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function delete() {
        $string = "UPDATE `$this->table_name` SET `status` = ".constants::$inactive." WHERE `id` = $this->id;";
        $result = dbQuery($string);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getFiles() {
        $array = array();
        $string = "SELECT * FROM `saq_guideline_files` WHERE `saq_guideline_id` = '$this->id';";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            array_push($array, array(
                'id' => $row['id'],
                'name' => $row['name'],
                'type' => $row['type'],
//                'location' => $row['location'],
                'uploaded_date_time' => $row['uploaded_date_time'],
                'saq_guideline_id' => $row['saq_guideline_id']
            ));
        }
        return $array;
    }


    public function deleteFile($id) {
        $string = "DELETE FROM `saq_guideline_files` WHERE `id` = $id;";       
        $result = dbQuery($string);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
    
}
?>