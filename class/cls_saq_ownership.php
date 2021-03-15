

<?php

include_once 'database.php';
include_once 'constants.php';

class saq_site_ownership {

    public $id, $ownership;
    private $table_name = 'saq_site_ownership';

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getData() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->ownership = $row['ownership'];
    }

    public function add() {
        $string = "INSERT INTO `$this->table_name` (`ownership`) VALUES (" . getStringFormatted($this->ownership) . ");";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function edit() {
        $string = "UPDATE `$this->table_name` SET `category` = " . getStringFormatted($this->ownership) . " WHERE `id` = $this->id;";
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
            $saq_ownership_obj = new saq_site_ownership($row['id']);
            $saq_ownership_obj->getData();
            array_push($array, $saq_ownership_obj);
        }
        return $array;
    }

}
