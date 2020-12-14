<?php

include_once 'database.php';
include_once 'constants.php';

class modules {
    public $id,$name,$path,$url,$status;
    private $table_name = 'modules';
    
    public function __construct($id = 0) {
        $this->id = $id;
    }
    
    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->path = $row['path'];
        $this->url = $row['url'];
        $this->status = $row['status'];
    }
    
    public function getAll() {
        $array = array();
        $string = "SELECT * FROM `$this->table_name` WHERE `status` = ".constants::$ACTIVE.";";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            array_push($array, array(
                'id' => $row['id'],
                'name' => $row['name'],
                'path' => $row['path'],
                'url' => $row['url'],
                'status' => $row['status']
            ));
        }
        return $array;
    }


    public function add() {
        $string = "INSERT INTO `$this->table_name` (`name`,`path`,`url`,`status`) VALUES ("
                . "". getStringFormatted($this->name).","
                . "". getStringFormatted($this->path).","
                . "". getStringFormatted($this->url).","
                . "".constants::$ACTIVE.""
                . ");";
        $result = dbQuery($string);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function edit() {
        $query_array = array();
        
        if($this->name != '') {
            array_push($query_array, "`name`=". getStringFormatted($this->name)."");
        }
        
        if($this->path != '') {
            array_push($query_array, "`path`=". getStringFormatted($this->path)."");
        }
        
        if($this->url != '') {
            array_push($query_array, "`url`=". getStringFormatted($this->url)."");
        }
        
        if(count($query_array)>0) {
            $query_string = implode(',', $query_array);
            $string = "UPDATE `$this->table_name` SET $query_string WHERE `id` = $this->id;";
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
        $string = "UPDATE `$this->table_name` SET `status` = ".constants::$inactive." WHERE `id` = $this->id;";
        $result = dbQuery($string);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
}
?>