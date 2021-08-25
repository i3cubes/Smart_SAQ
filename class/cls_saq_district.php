<?php

include_once 'database.php';
include_once 'constants.php';

class saq_district {
    
    public $id,$name,$saq_province_id;
    private $table_name = 'saq_district';

    public function __construct($id = '') {
        $this->id = $id;
    }
    
    public function getData() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->saq_province_id = $row['saq_province_id'];
    }
    
    public function getAll() {
        $array = array();
        $string = "SELECT * FROM `$this->table_name`;";
//        print $string;
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $saq_district_obj = new saq_district($row['id']);
            $saq_district_obj->getData();
            array_push($array, $saq_district_obj);
        }
        return $array;
    }
}

?>

