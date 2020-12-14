<?php

include_once 'database.php';

class designation {

    public $id, $designation, $status;
    private $table_name = 'designation';

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->designation = $row['designation'];
        $this->status = $row['status'];
    }

    public function getAll() {
        $return_array = array();
        $string = "SELECT * FROM `$this->table_name` WHERE `status` = " . constants::$active . "";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            array_push($return_array, array(
                'id' => $row['id'],
                'designation' => $row['designation'],
                'status' => $row['status']
            ));
        }
        return $return_array;
    }

}

?>
