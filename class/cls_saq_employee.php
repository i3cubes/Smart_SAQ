<?php

include_once 'database.php';
include_once 'constants.php';

class saq_employee {

    public $id, $name, $address, $mobile, $email, $status, $saq_department_id, $designtion_id, $dns_region_id, $region_id, $saq_district_id;
    public $designation, $department, $districts, $username;
    private $table_name = 'saq_employee';

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getData() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
//        print $string;
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->address = $row['address'];
        $this->mobile = $row['$mobile'];
        $this->email = $row['email'];
        $this->status = $row['status'];
        $this->saq_department_id = $row['saq_department_id'];
        $this->designtion_id = $row['saq_designation_id'];
        $this->dns_region_id = $row['saq_dns_office_id'];
        $this->saq_district_id = $row['saq_district_id'];
        $this->districts = $this->getEmployeeDistricts($this->id);
    }

    public function getAll() {
        $ary_sql = array();
        if ($this->name != "") {
            array_push($ary_sql, "t1.`name` LIKE '%$this->name%'");
        }
        if ($this->saq_department_id != "") {
            array_push($ary_sql, "t1.`saq_department_id` = '$this->saq_department_id'");
        }
        if ($this->designtion_id != "") {
            array_push($ary_sql, "t1.`saq_designation_id` IN ('$this->designtion_id')");
        }
        if (count($ary_sql) > 0) {
            $WHERE = " WHERE " . implode(" AND ", $ary_sql);
        }
        $str = "SELECT t1.*, t2.dept, t3.designation, t4.user_name FROM $this->table_name AS t1 LEFT JOIN saq_department AS t2 ON t1.saq_department_id = t2.id"
                . " LEFT JOIN saq_designation AS t3 ON t1.saq_designation_id = t3.id LEFT JOIN `saq_us` AS `t4` ON t1.id = t4.saq_employee_id $WHERE ";
        $res = dbQuery($str);
        $results = array();
        while ($row = dbFetchAssoc($res)) {

            $saq_employee_obj = new saq_employee();
            $saq_employee_obj->id = $row['id'];
            $saq_employee_obj->name = $row['name'];
            $saq_employee_obj->address = $row['address'];
            $saq_employee_obj->mobile = $row['$mobile'];
            $saq_employee_obj->email = $row['email'];
            $saq_employee_obj->status = $row['status'];
            $saq_employee_obj->saq_department_id = $row['saq_department_id'];
            $saq_employee_obj->designtion_id = $row['saq_designation_id'];
            $saq_employee_obj->designtion = $row['designation'];
            $saq_employee_obj->department = $row['dept'];
            $saq_employee_obj->status = $row['status'];
//            $saq_employee_obj->saq_district_id = $row['saq_district_id'];
            $saq_employee_obj->username = $row['user_name'];

            array_push($results, $saq_employee_obj);
        }
        return $results;
    }

    public function insert() {
        $name = getStringFormatted($this->name);
        $address = getStringFormatted($this->address);
        $mobile = getStringFormatted($this->mobile);
        $email = getStringFormatted($this->email);
        $dept = getStringFormatted($this->saq_department_id);
        $des = getStringFormatted($this->designtion_id);
        $saq_region_id = getStringFormatted($this->region_id);
        $DNS_region_id = getStringFormatted($this->dns_region_id);        
        //id, name, address, mobile, email, status, saq_department_id, saq_designation_id, DNS_region_id, saq_region_id
        $str = "INSERT INTO $this->table_name (name, address, mobile, email, status, saq_department_id, saq_designation_id,saq_dns_office_id,saq_region_id,saq_district_id) "
                . "VALUES ($name, $address, $mobile, $email, '1', $dept, $des,$DNS_region_id,$saq_region_id)";

        $res = dbQuery($str);
        if ($res) {
            $employee_id = dbInsertId();
            $this->employeeHasDistricts($employee_id,$this->districts);
            return true;
        } else {
            return false;
        }
    }
    
    public function getEmployeeDistricts($employee_id) {
        $array = array();
        $string = "SELECT * FROM `saq_employee_has_saq_district` WHERE `saq_employee_id` = '$employee_id';";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            array_push($array, $row['saq_district_id']);
        }
        return $array;
    }

    public function employeeHasDistricts($employee_id, $district_ids) {
        if (!is_array($district_ids) && $district_ids != '') {
            $district_ids = [$district_ids];
        }

        if (count($district_ids) > 0) {
            if ($this->deleteEmployeeDistricts($employee_id)) {
                foreach ($district_ids as $district_id) {
                    $string = "INSERT INTO `saq_employee_has_saq_district` (`saq_employee_id`,`saq_district_id`) VALUES ("
                            . "'$employee_id','$district_id');";
                    $result = dbQuery($string);
                    if (!$result) {
                        continue;
                    }
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function deleteEmployeeDistricts($employee_id) {
        $string = "DELETE FROM `saq_employee_has_saq_district` WHERE `saq_employee_id` = '$employee_id';";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function updateEmp() {
        $ary_sql = array();
        $name = ($this->name);
        $address = ($this->address);
        $mobile = ($this->mobile);
        $email = ($this->email);
        $dept = ($this->saq_department_id);
        $des = ($this->designtion_id);
        $saq_region_id = ($this->region_id);
        $DNS_region_id = ($this->dns_region_id);
        $status = ($this->status);
        $saq_district_id = ($this->saq_district_id);

        if ($name != "") {
            array_push($ary_sql, "name =" . getStringFormatted($name));
        }
        if ($address != "") {
            array_push($ary_sql, "address =" . getStringFormatted($address));
        }
        if ($mobile != "") {
            array_push($ary_sql, "mobile =" . getStringFormatted($mobile));
        }
        if ($email != "") {
            array_push($ary_sql, "email =" . getStringFormatted($email));
        }
        if ($dept != "") {
            array_push($ary_sql, "saq_department_id =" . getStringFormatted($dept));
        }
        if ($saq_region_id != "") {
            array_push($ary_sql, "saq_region_id =" . getStringFormatted($saq_region_id));
        }
        if ($DNS_region_id != "") {
            array_push($ary_sql, "saq_dns_office_id =" . getStringFormatted($DNS_region_id));
        }
        if ($des != "") {
            array_push($ary_sql, "saq_designation_id =" . getStringFormatted($des));
        }
        if ($status != "") {
            array_push($ary_sql, "status =" . getStringFormatted($status));
        }
        if ($saq_district_id != "") {
            array_push($ary_sql, "saq_district_id =" . getStringFormatted($saq_district_id));
        }

        if (count($ary_sql) > 0) {
            $updStr = implode(", ", $ary_sql);
            $str = "UPDATE $this->table_name SET $updStr WHERE id='$this->id'";
//            print $str;
            $res = dbQuery($str);
            if ($res) {
                $this->employeeHasDistricts($this->id,$this->districts);
                return true;
            } else {
                return false;
            }
        }
    }

}
?>

