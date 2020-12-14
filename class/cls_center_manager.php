<?php

include_once 'database.php';
include_once 'constants.php';
include_once 'cls_employees.php';
include_once 'cls_centers.php';

class center_manager {

    public function getAll($emp_id,$flag='') {
        $return_array = array();
        $emp_data = new employees($emp_id);
        $emp_data->getDetails();
        $center = new \centers();
    if ($emp_data->designation_id == constants::$business_customer || $flag == 0) {
            $string = "SELECT * FROM `$center->table_name` WHERE `status` = '" . constants::$active . "' AND business_customer_id='" . $emp_data->business_customer_id . "';";
        }
//        print $string;
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $center = new centers($row['id']);
            $center->id = $row['id'];
            $center->name = $row['name'];
            $center->city = $row['city'];
            $center->code = $row['code'];
            $center->postcode = $row['postcode'];
            $center->rural_remote_area = $row['rural_remote_area'];
            $center->fax = $row['fax'];
            $center->email = $row['email'];
            $center->abn = $row['abn'];
            $center->lsp = $row['lsp'];
            $center->minor_id = $row['minor_id'];
            $center->site_id = $row['site_id'];
            $center->health_identifier = $row['health_identifier'];
            $center->address = $row['address'];
            $center->business_customer_id = $row['business_customer_id'];
            array_push($return_array, $center);
        }
        return $return_array;
    }

}

?>