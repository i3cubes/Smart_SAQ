<?php

include_once 'database.php';
include_once 'constants.php';
include_once 'cls_business_customer.php';

class business_customer_manager {

    private $table_name = 'business_customer';

    public function getAllBusinessCustomers() {
        $return_array = array();
        $cus = new \business_customer();

        $string = "SELECT * FROM `$this->table_name` ORDER BY id DESC;";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $cus = new business_customer($row[id]);
            $cus->id = $row['id'];
            $cus->name = $row['name'];
            $cus->status = $row['status'];
            $cus->city = $row['city'];
            $cus->postcode = $row['postcode'];
            $cus->rural_remote_area = $row['rural_remote_area'];
            $cus->fax = $row['fax'];
            $cus->email = $row['email'];
            $cus->abn = $row['abn'];
            $cus->lsp = $row['lsp'];
            $cus->minor_id = $row['minor_id'];
            $cus->site_id = $row['site_id'];
            $cus->health_identifier = $row['health_identifier'];
            $cus->br_number = $row['br_number'];
            $cus->address = $row['address'];

            array_push($return_array, $cus);
        }
        return $return_array;
    }

}
?>

