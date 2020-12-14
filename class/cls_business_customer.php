<?php
session_start();
include_once 'database.php';
include_once 'constants.php';
include_once 'cls_employees.php';
include_once 'cls_centers.php';

class business_customer {

    public $id, $name, $br_number, $address, $status, $logo;
    public $contact_number, $web, $email, $fax,$contact_person_name,$contact_person_email_address,$contact_person_mobile,$no_of_employees;
    private $table_name = 'business_customer';

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
//        print $string;
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->br_number = $row['br_number'];
        $this->address = $row['address'];
        $this->status = $row['status'];
        $this->logo = $row['logo_path'];
        $this->contact_number = $row['contact_number'];
        $this->web = $row['web'];
        $this->email = $row['email'];
        $this->fax = $row['fax'];
        $this->contact_person_name = $row['contact_person_name'];
        $this->contact_person_email_address = $row['contact_person_email_address'];
        $this->contact_person_mobile = $row['contact_person_mobile'];
        $this->no_of_employees = $row['no_of_employees'];
    }

    public function add() {        
        $string = "INSERT INTO `$this->table_name` ("
                . "`name`,"
                . "`br_number`,"
                . "`address`,"
                . "`logo_path`,"
                . "`contact_number`,"
                . "`web`,"
                . "`email`,"
                . "`fax`,"
                . "`contact_person_name`,"
                . "`contact_person_email_address`,"
                . "`contact_person_mobile`,"
                . "`no_of_employees`,"
                . "`status`) VALUES "
                . "("
                . "". getStringFormatted($this->name).","
                . "". getStringFormatted($this->br_number).","
                . "". getStringFormatted($this->address).","
                . "". getStringFormatted($this->logo).","
                . "". getStringFormatted($this->contact_number).","
                . "". getStringFormatted($this->web).","
                . "". getStringFormatted($this->email).","
                . "". getStringFormatted($this->fax).","
                . "". getStringFormatted($this->contact_person_name).","
                . "". getStringFormatted($this->contact_person_email_address).","
                . "". getStringFormatted($this->contact_person_mobile).","
                . "". getStringFormatted($this->no_of_employees).","
                . "" . constants::$active . ");";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function edit() {
        $update_string = array();        

        if ($this->name != '') {
            array_push($update_string, "`name`=". getStringFormatted($this->name)."");
        }
        if ($this->br_number != '') {
            array_push($update_string, "`br_number`=". getStringFormatted($this->br_number)."");
        }
        if ($this->address != '') {
            array_push($update_string, "`address`=". getStringFormatted($this->address)."");
        }
        if ($this->logo != '') {
            array_push($update_string, "`logo_path`=". getStringFormatted($this->logo)."");
        }
        if ($this->contact_number != '') {
            array_push($update_string, "`contact_number`=". getStringFormatted($this->contact_number)."");
        }
        if ($this->web != '') {
            array_push($update_string, "`web`=". getStringFormatted($this->web)."");
        }
        if ($this->email != '') {
            array_push($update_string, "`email`=". getStringFormatted($this->email)."");
        }
        if ($this->fax != '') {
            array_push($update_string, "`fax`=". getStringFormatted($this->fax)."");
        }
        if ($this->contact_person_name != '') {
            array_push($update_string, "`contact_person_name`=". getStringFormatted($this->contact_person_name)."");
        }
        if ($this->contact_person_email_address != '') {
            array_push($update_string, "`contact_person_email_address`=". getStringFormatted($this->contact_person_email_address)."");
        }
        if ($this->contact_person_mobile != '') {
            array_push($update_string, "`contact_person_mobile`=". getStringFormatted($this->contact_person_mobile)."");
        }
        if ($this->no_of_employees != '') {
            array_push($update_string, "`no_of_employees`=". getStringFormatted($this->no_of_employees)."");
        }
        if ($this->status != '') {
            array_push($update_string, "`status`=". getStringFormatted($this->status)."");
        }

        if (count($update_string) > 0) {
            $update_string = implode(',', $update_string);
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

    public function delete($status) {
        $string = "UPDATE `$this->table_name` SET `status` = $status WHERE `id` = $this->id;";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // get centers 
    public function get_centers($active = true) {
        $centers = array();
        if (!$active) {
            $active = '';
        } else {
            $active = "AND status = " . constants::$active . "";
        }
        $center = new \centers();
        $string = "SELECT * FROM `centers` WHERE business_customer_id = $this->id $active ORDER BY id DESC;";
//        print $string;
        $result = dbQuery($string);
        if (dbNumRows($result) > 0) {
            while ($row = dbFetchAssoc($result)) {
                $center = new centers($row['id']);
                $center->id = $row['id'];
                $center->code = $row['code'];
                $center->name = $row['name'];
                $center->status = $row['status'];
                $center->address = $row['address'];
                $center->contact_no = $row['contact_no'];
                $center->city = $row['city'];
                $center->postcode = $row['postcode'];
                $center->rural_remote_area = $row['rural_remote_area'];
                $center->fax = $row['fax'];
                $center->email = $row['email'];
                $center->abn = $row['abn'];
                $center->lsp = $row['lsp'];
                $center->minor_id = $row['minor_id'];
                $center->site_id = $row['site_id'];
                $center->health_identifier = $row['health_identifier'];
                $center->business_customer_id = $row['business_customer_id'];
                $center->weekly_hours = $row['weekly_hours'];
                $center->available_weekly_hours = $row['available_weekly_hours'];
                array_push($centers, $center);
            }
        }
        return $centers;
    }

    // get employees 
    public function get_employees($active = true) {
        $employees = array();
        if (!$active) {
            $active = '';
        } else {
            $active = "AND t1.status = " . constants::$active . "";
        }
        if($_SESSION['DESIGNATION'] == constants::$business_customer) {
            $designations = " AND t1.designation_id <> ".constants::$doctor." ";
        } else {
            $designations = "";
        }
        $string = "SELECT t1.*,t2.designation FROM `employees` as t1 left join designation as t2 on t1.designation_id=t2.id WHERE "
                . "t1.business_customer_id = $this->id AND t1.designation_id <> " . constants::$admin . " $designations $active ORDER BY t1.id DESC;";
        $result = dbQuery($string);
        if (dbNumRows($result) > 0) {
            while ($row = dbFetchAssoc($result)) {
                $emp_obj = new employees($row['id']);
                $emp_obj->id = $row['id'];
                $emp_obj->name = $row['name'];
                $emp_obj->address = $row['address'];
                $emp_obj->contact_no = $row['contact_no'];
                $emp_obj->first_name = $row['first_name'];
                $emp_obj->last_name = $row['last_name'];
                $emp_obj->date_of_join = $row['date_of_join'];
                $emp_obj->rate_per_hour = $row['rate_per_hour'];
                $emp_obj->office_number = $row['office_number'];
                $emp_obj->mobile_number = $row['mobile_number'];
                $emp_obj->home_address = $row['home_address'];
                $emp_obj->work_address = $row['work_address'];
                $emp_obj->work_function = $row['work_function'];
                $emp_obj->path = $row['path'];
                $emp_obj->status = $row['status'];
                $emp_obj->designation_id = $row['designation_id'];
                $emp_obj->email = $row['email'];
                $emp_obj->designation = $row['designation'];
                array_push($employees, $emp_obj);
            }
        }
        return $employees;
    }

}

?>