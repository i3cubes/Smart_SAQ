

<?php

include_once 'database.php';
include_once 'constants.php';

class saq_site_ownership {

    public $id, $ownership, $status;
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
            return dbInsertId();
        } else {
            return false;
        }
    }

    public function edit() {
        $string = "UPDATE `$this->table_name` SET `ownership` = " . getStringFormatted($this->ownership) . " WHERE `id` = $this->id;";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function delete() {
        $string = "UPDATE `$this->table_name` SET `status` = " . constants::$inactive . " WHERE `id` = $this->id;";
//        print $string;
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getAll() {
        $array = array();
        $string = "SELECT * FROM `$this->table_name` WHERE `status` = ".constants::$active.";";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $saq_ownership_obj = new saq_site_ownership($row['id']);
            $saq_ownership_obj->getData();
            array_push($array, $saq_ownership_obj);
        }
        return $array;
    }

    function search($ownership, $status, $limitcount, $orderby, $order, $likeType) {
        //liketype =,%A%, A%,%B
        $array_sql = array();
        if ($ownership != "") {
            if ($likeType == "=") {
                array_push($array_sql, "ownership = '$ownership'");
            } else if ($likeType == "%A%") {
                array_push($array_sql, "ownership LIKE '%$ownership%'");
            } else if ($likeType == "A%") {
                array_push($array_sql, "ownership LIKE '$ownership%'");
            } else if ($likeType == "%A") {
                array_push($array_sql, "ownership LIKE '%$ownership'");
            } else {
                array_push($array_sql, "ownership LIKE '$ownership'");
            }
        }
        if ($status != "") {
            
        }
        $LIMIT = "";
        if ($limitcount != "") {
            $LIMIT = "LIMIT " . $limitcount;
        }
        $ORDERBY = "";
        if ($orderby != "") {
            if ($order == "DESC") {
                $order = "DESC";
            } else {
                $order = "ASC";
            }
            $ORDERBY = " ORDER BY " . $orderby . " " . $order;
        }

        if (count($array_sql) > 0) {
            $WHERE = " WHERE " . implode(" AND ", $array_sql);
        }
        $str = "SELECT * FROM $this->table_name $WHERE $ORDERBY $LIMIT";
        //print $str;
        $result = dbQuery($str);
        $array = array();
        while ($row = dbFetchAssoc($result)) {
            $saq_ownership_obj = new saq_site_ownership($row['id']);
            $saq_ownership_obj->getData();
            array_push($array, $saq_ownership_obj);
        }
        return $array;
    }

}
