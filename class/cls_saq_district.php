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
    
    public function add($name) {
        if ($name != '') {
            $count_string = "SELECT COUNT(id) AS `id` FROM `$this->table_name`;";
            $result_count = dbQuery($count_string);
            $row = dbFetchAssoc($result_count);
            $id = ((int) $row['id']) + 1;
            $string = "INSERT INTO `$this->table_name` (`id`,`name`) VALUES ($id," . getStringFormatted($name) . ");";
//            print $string;
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

