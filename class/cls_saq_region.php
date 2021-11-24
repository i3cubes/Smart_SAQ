<?php

include_once 'database.php';
include_once 'constants.php';

include_once 'cls_saq_employee.php';

class saq_region {

    public $id, $name, $status, $manager_id;
    private $table_name = 'saq_region';

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getData() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->status = $row['status'];
        $this->manager_id = $row['manager_id'];
    }

    public function add($name) {
        if ($name != '') {
            $string = "INSERT INTO `$this->table_name` (`name`,`status`) VALUES (" . getStringFormatted($name) . "," . constants::$active . ");";
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
            $string = "SELECT `id` FROM `$this->table_name` WHERE `name` = " . getStringFormatted($name) . " AND `status` = " . constants::$active . ";";
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
        $string = "SELECT * FROM `$this->table_name` WHERE `status` = " . constants::$ACTIVE . ";";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $saq_region_obj = new saq_region($row['id']);
            $saq_region_obj->getData();
            array_push($array, $saq_region_obj);
        }
        return $array;
    }

    public function getRegionEmployees() {
        $array = array();
        $string = "SELECT t2.saq_employee_id FROM `saq_region` AS `t1` INNER JOIN "
                . "`saq_region_employee` AS `t2` ON t1.id = t2.saq_region_id WHERE t1.id = $this->id;";
//        print $string;
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $saq_emp_obj = new saq_employee($row['saq_employee_id']);
            $saq_emp_obj->getData();
            array_push($array, $saq_emp_obj);
        }
        return $array;
    }

}
?>

