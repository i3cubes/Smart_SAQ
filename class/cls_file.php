<?php
include_once 'database.php';

class file {
    public $name, $type, $id, $base_path, $table_name;
    
    public function __construct($id) {
        $this->id = $id;
    }
    
    public function get_file_infomation($table_name) {
        $string = "SELECT * FROM `$table_name` WHERE `id` = $this->id;";
        print $string;
        $result = dbQuery($string);
        if($result) {
            $row = dbFetchAssoc($result);
            $this->name = $row['name'];
            $this->type = $row['type'];
            $this->base_path = $row['base_path'];
            $this->id = $row['id'];
        } else {
            return false;
        }
    }
}

?>