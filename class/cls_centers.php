<?php

session_start();
include_once 'database.php';
include_once 'constants.php';

class centers {

    public $id,
            $code,
            $name,
            $address,
            $city,
            $postcode,
            $rural_remote_area,
            $fax,
            $email,
            $web,
            $abn,
            $lsp,
            $minor_id,
            $site_id,
            $health_identifier,           
            $status,
            $business_customer_id,
            $available_weekly_hours,
            $weekly_hours,$contact_no;
    public $table_name = 'centers';

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getAll() {
        $return_array = array();
        $string = "SELECT * FROM `$this->table_name` WHERE `status` = " . constants::$active . "";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            array_push($return_array, array(
                'id' => $row['id'],
                'code' => $row['code'],
                'name' => $row['name'],
                'address' => $row['address'],
                'contact_no' => $row['contact_no'],
                'status' => $row['status'],
                'business_customer_id' => $row['business_customer_id']
            ));
        }
        return $return_array;
    }

    public function getDetails() {
        if ($this->id != '') {
            $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";            
            $result = dbQuery($string);
            $row = dbFetchAssoc($result);
            $this->id = $row['id'];
            $this->code = $row['code'];
            $this->name = $row['name'];
            $this->contact_no = $row['contact_no'];
            $this->city = $row['city'];
            $this->postcode = $row['postcode'];
            $this->rural_remote_area = $row['rural_remote_area'];
            $this->fax = $row['fax'];
            $this->email = $row['email'];
            $this->abn = $row['abn'];
            $this->web = $row['web'];
            $this->lsp = $row['lsp'];
            $this->minor_id = $row['minor_id'];
            $this->site_id = $row['site_id'];
            $this->health_identifier = $row['health_identifier'];
            $this->address = $row['address'];
            $this->status = $row['status'];
            $this->business_customer_id = $row['business_customer_id'];
        }
    }

    public function add() {                       
        $string = "INSERT INTO `$this->table_name` ("
                . "`name`,"
                . "`address`,"
                . "`contact_no`,"
                . "`city`,"
                . "`postcode`,"
                . "`rural_remote_area`,"
                . "`fax`,"
                . "`email`,"
                . "`web`,"
                . "`abn`,"
                . "`lsp`,"
                . "`minor_id`,"
                . "`site_id`,"
                . "`health_identifier`,"
                . "`status`,"
                . "`business_customer_id`,"
                . "`code`) VALUES ("
                . "". getStringFormatted($this->name).","
                . "". getStringFormatted($this->address).","
                . "". getStringFormatted($this->contact_no).","
                . "". getStringFormatted($this->city).","
                . "". getStringFormatted($this->postcode).","
                . "". getStringFormatted($this->rural_remote_area).","
                . "". getStringFormatted($this->fax).","
                . "". getStringFormatted($this->email).","
                . "". getStringFormatted($this->web).","
                . "". getStringFormatted($this->abn).","
                . "". getStringFormatted($this->lsp).","
                . "". getStringFormatted($this->minor_id).","
                . "". getStringFormatted($this->site_id).","
                . "". getStringFormatted($this->health_identifier).","                
                . "" . constants::$active . ","
                . "". getStringFormatted($this->business_customer_id).","
                . "". getStringFormatted($this->code).""
                . ");";
        $result = dbQuery($string);
        if ($result) {
            return dbInsertId();
        } else {
            return false;
        }
    }

    public function edit() {
        $update_array = array();        

        if ($this->name != '') {
            array_push($update_array, "`name`=". getStringFormatted($this->name)."");
        }
        if ($this->address != '') {
            array_push($update_array, "`address`=". getStringFormatted($this->address)."");
        }
        if ($this->contact_no != '') {
            array_push($update_array, "`contact_no`=". getStringFormatted($this->contact_no)."");
        }
        if ($this->code != '') {
            array_push($update_array, "`code`=". getStringFormatted($this->code)."");
        }
        if ($this->city != '') {
            array_push($update_array, "`city`=". getStringFormatted($this->city)."");
        }
        if ($this->postcode != '') {
            array_push($update_array, "`postcode`=". getStringFormatted($this->postcode)."");
        }
        if ($this->rural_remote_area != '') {
            array_push($update_array, "`rural_remote_area`=". getStringFormatted($this->rural_remote_area)."");
        }
        if ($this->fax != '') {
            array_push($update_array, "`fax`=". getStringFormatted($this->fax)."");
        }
        if ($this->email != '') {
            array_push($update_array, "`email`=". getStringFormatted($this->email)."");
        }
        if ($this->web != '') {
            array_push($update_array, "`web`=". getStringFormatted($this->web)."");
        }
        if ($this->abn != '') {
            array_push($update_array, "`abn`=". getStringFormatted($this->abn)."");
        }
        if ($this->lsp != '') {
            array_push($update_array, "`lsp`=". getStringFormatted($this->lsp)."");
        }
        if ($this->minor_id != '') {
            array_push($update_array, "`minor_id`=". getStringFormatted($this->minor_id)."");
        }
        if ($this->site_id != '') {
            array_push($update_array, "`site_id`=". getStringFormatted($this->site_id)."");
        }
        if ($this->health_identifier != '') {
            array_push($update_array, "`health_identifier`=". getStringFormatted($this->health_identifier)."");
        }
        if ($this->status != '') {
            array_push($update_array, "`status`=". getStringFormatted($this->status)."");
        }
        if ($this->weekly_hours != '') {
            array_push($update_array, "`weekly_hours`=". getStringFormatted($this->weekly_hours)."");
        }
        if ($this->available_weekly_hours != '') {
            array_push($update_array, "`available_weekly_hours`=". getStringFormatted($this->available_weekly_hours)."");
        }
//        if($this->business_customer_id != 'NULL') {
//            array_push($update_array, "`business_customer_id`=$this->business_customer_id");
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

    public function delete($status) {
        $string = "UPDATE `$this->table_name` SET `status` = $status WHERE `id` = $this->id;";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function centerCodeGen() {
        $string = "SELECT MAX(id) + 1 AS `MAXID` FROM `$this->table_name`;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $maxid = $row['MAXID'];        
        $code = substr(str_repeat(0, 4).$maxid, - 4);
        return $code;
    }

}

?>