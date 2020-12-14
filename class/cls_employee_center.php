<?php

session_start();
include_once 'database.php';
include_once 'constants.php';
include_once 'cls_centers.php';

class employee_center{

    public $id,$cenetr_id,$provider_no,$cenetr_name;

    public function __construct($id = '') {
        $this->id = $id;
    }
    function getDetails() {
        $str="SELECT * FROM employee_center WHERE WHERE id='$this->id';";
        $result = dbQuery($str);
        $row = dbFetchAssoc($result);
        $this->cenetr_id=$row['centers_id'];
        $this->provider_no=$row['provider_no'];
    }
}

?>