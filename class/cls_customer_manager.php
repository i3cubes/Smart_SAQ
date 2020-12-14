<?php

include_once 'database.php';

class customer_manager {    
    
    public function customer_has_module($customer_id, $module_id) {
        if($customer_id != "" && $module_id != "") {
            $string = "INSERT INTO `customer_has_module` (`customer_id`,`module_id`) VALUES ($customer_id,$module_id);";
            $result = dbQuery($string);
            if($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
        
}
?>