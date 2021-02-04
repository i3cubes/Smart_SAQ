<?php

include_once 'database.php';
include_once 'constants.php';

include_once 'cls_employees.php';

class user {

    public $id, $name, $password, $date_created,$contact_no, $date_lastlogin, $type, $status, $address, $email, $employees_id;
    private $table_name = 'saq_us';

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getAllUsers() {
        $array = array();
        $string = "SELECT * FROM `$this->table_name`";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            array_push($array, array(
                'id' => $row['id'],
                'name' => $row['user_name'],
                'password' =>  $row['password'],
                'date_created' => $row['date_create'],
                'date_lastlogin' => $row['date_last_login'],
//                'email' => $row['email'],
//                'address' => $row['address'],
//                'contact_no' => $row['contact_no'],
                'status' => $row['status']
            ));            
        }      
        return $array;
    }
    
    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->name = $row['user_name'];
        $this->password = $row['password'];
        $this->date_created = $row['date_create'];
        $this->date_lastlogin = $row['date_last_login'];
//        $this->email = $row['email'];
//        $this->address = $row['address'];
//        $this->contact_no = $row['contact_no'];
        $this->status = $row['status'];
    } 

    public function add() {       
        $this->password = sha1($this->password);
        if (!$this->checkUser($this->name)) {
            $string = "INSERT INTO `$this->table_name` (`user_name`,`password`,`date_create`,`date_last_login`,"
                    . "`status`"                    
                    . ") VALUES ("
                    . "". getStringFormatted($this->name).","
                    . "'$this->password',"
                    . "NOW(),"
                    . "NOW(),"
                    . "" . constants::$active . ""                  
                    . ");";
//        print $string;
            $result = dbQuery($string);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return 100;
        }
    }

    public function edit() {
        $update_array = array();       
        if ($this->name != '') {
//            if (!$this->checkUser($this->name)) {
                array_push($update_array, "`user_name`=". getStringFormatted($this->name)."");
//            } else {
//                return 100;
//            }
        }
        if ($this->password != '') {
            array_push($update_array, "`password`='". sha1($this->password)."'");
        }
        if ($this->date_created != '') {
            array_push($update_array, "`date_create`=". getStringFormatted($this->date_created)."");
        }
        if ($this->date_lastlogin != '') {
            array_push($update_array, "`date_last_login`=NOW()");
        }
        if ($this->status != '') {
            array_push($update_array, "`status`='$this->status'");
        }
//        if ($this->email != '') {
//            array_push($update_array, "`email`=". getStringFormatted($this->email)."");
//        }
//        if ($this->address != '') {
//            array_push($update_array, "`address`=". getStringFormatted($this->address)."");
//        }
//        if ($this->contact_no != '') {
//            array_push($update_array, "`contact_no`=". getStringFormatted($this->contact_no)."");
//        }

        if (count($update_array) > 0) {
            $update_string = implode(',', $update_array);
            $string = "UPDATE `$this->table_name` SET $update_string WHERE `id` = $this->id;";
            $result = dbQuery($string);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function delete() {
        $string = "UPDATE `$this->table_name` SET `status`=" . constants::$unactive . " WHERE `id` = $this->id;";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function checkUser($username) {
        $string = "SELECT `id` FROM `$this->table_name` WHERE `user_name` = '$username';";
//        print $string;
        $result = dbQuery($string);
        if (dbNumRows($result) == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function loginUser() {
        $name = getStringFormatted($this->name);
        $password = getStringFormatted(sha1($this->password));

        $string = "SELECT * FROM `$this->table_name` WHERE user_name = $name AND "
                . "password = $password AND status = '" . constants::$active . "';";
        //print $string;
        $result = dbQuery($string);
        if (dbNumRows($result) == 1) {
            $row = dbFetchAssoc($result);
//            $emp_obj = new employees($row['employees_id']);
//            $emp_obj->getDetails();
            $_SESSION['UID'] = $row['id'];
//            $_SESSION['DESIGNATION'] = $emp_obj->designation_id;
//            $_SESSION['EMPID'] = $emp_obj->id;
//            $_SESSION['EMPNAME'] = $emp_obj->name;
//            $_SESSION['BCID'] = $emp_obj->business_customer_id;
            return true;
        } else {
            return false;
        }
    }

}

?>