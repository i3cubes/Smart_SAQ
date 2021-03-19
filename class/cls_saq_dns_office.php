

<?php

include_once 'database.php';
include_once 'constants.php';

class saq_site_ownership {

    public $id, $name;
    private $table_name = 'saq_dns_office';

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getData() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->name = $row['ownership'];
    }

    public function add() {
        $string = "INSERT INTO `$this->table_name` (`ownership`) VALUES (" . getStringFormatted($this->name) . ");";
        $result = dbQuery($string);
        if ($result) {
            return dbInsertId();
        } else {
            return false;
        }
    }

    public function edit() {
        $string = "UPDATE `$this->table_name` SET `category` = " . getStringFormatted($this->name) . " WHERE `id` = $this->id;";
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
    function search($ownership,$status,$limitcount,$orderby,$order,$likeType){
        //liketype =,%A%, A%,%B
        $array_sql = array();
        if($ownership !=""){
            if($likeType=="="){
                array_push($array_sql, "name = '$ownership'");
            }else if($likeType =="%A%"){
                array_push($array_sql, "name LIKE '%$ownership%'");
            }else if($likeType =="A%"){
                array_push($array_sql, "name LIKE '$ownership%'");
            }else if($likeType=="%A"){
                array_push($array_sql, "name LIKE '%$ownership'");
            }else {
                array_push($array_sql, "name LIKE '$ownership'");
            }
            
        }
        if($status !=""){
            
        }
        $LIMIT = "";
        if($limitcount !=""){
            $LIMIT = "LIMIT ".$limitcount;
        }
        $ORDERBY="";
        if($orderby !=""){
            if($order =="DESC"){
                $order = "DESC";
            }else {
                $order = "ASC";
            }
            $ORDERBY = " ORDER BY ".$orderby." ".$order;
            
        }
        
        if(count($array_sql)>0){
            $WHERE = " WHERE ". implode(" AND ", $array_sql);
        }
        $str = "SELECT * FROM $this->table_name $WHERE $ORDERBY $LIMIT";
        //print $str;
        $result = dbQuery($str);
        $array= array();
        while ($row = dbFetchAssoc($result)) {
            $saq_ownership_obj = new saq_site_ownership($row['id']);
            $saq_ownership_obj->getData();
            array_push($array, $saq_ownership_obj);
        }
        return $array;
        
    }

}
