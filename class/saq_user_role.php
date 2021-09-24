<?php 
    include_once 'database.php';
    include_once 'constants.php';

    class user_role {
        public $id,$role_name,$staus;

        public function getAll() {
            $array = array();
            $string = "SELECT * FROM `saq_us_role`;";
            $result = dbQuery($string);
            while($row = dbFetchAssoc($result)) {
                array_push($array, array(
                    'id' => $row['id'],
                    'role_name' => $row['role_name'],
                    'status' => $row['status']
                ));
            }
            return $array;
        }
    }
?>
