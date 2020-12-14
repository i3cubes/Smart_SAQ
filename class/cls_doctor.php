<?php

session_start();
include_once 'database.php';
include_once 'constants.php';
include_once 'cls_employees.php';

class doctor extends employees {

    public  $contract_id,
            $company_name,
            $contract_end_date,
            $qualifications,
            $category_id,
            $presctiber_no,
            $registration_no,
            $rate,
            $abn;

    public function __construct($id = '') {
        parent::__construct($id);
    }

    public function getDetails() {
        parent::getDetails();
        $this->getDoctorData();
    }
    public function getDoctorData(){
        $string = "SELECT * FROM `doctor_data` WHERE `employees_id` = '$this->id';";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->contract_id=$row['contract_id'];
        $this->contract_end_date=$row['contract_end_date'];
        $this->company_name=$row['company_name'];
        $this->qualifications=$row['qualifications'];
        $this->category_id=$row['doctor_category_id'];
        $this->presctiber_no=$row['prescriber_no'];
        $this->registration_no=$row['registration_no'];
        $this->abn=$row['abn'];
        $this->rate=$row['rate'];
    }
    public function addDoctor() {
        $this->designation_id= constants::$doctor;
        parent::add();
        if($this->id!=""){
            $str="INSERT INTO doctor_data VALUES(NULL,"
            .getStringFormatted($this->contract_id).","
            .getStringFormatted($this->contract_end_date).","
            .getStringFormatted($this->company_name).","
            .getStringFormatted($this->qualifications).","
            .getStringFormatted($this->abn).",'"
            .$this->id."',"            
            .getStringFormatted($this->category_id).","
            .getStringFormatted($this->rate).","
            . getStringFormatted($this->presctiber_no).","
            . getStringFormatted($this->registration_no).");";
            //print $str;
            $result = dbQuery($str);
        }
    }

    public function editDoctor() {
        $this->designation_id= constants::$doctor;
        parent::edit();
        if($this->id!=""){
            $str="UPDATE doctor_data SET contract_id="
            .getStringFormatted($this->contract_id).",contract_end_date="
            .getStringFormatted($this->contract_end_date).",company_name="
            .getStringFormatted($this->company_name).",qualifications="
            .getStringFormatted($this->qualifications).",doctor_category_id="
            .getStringFormatted($this->category_id).",rate="
            .getStringFormatted($this->rate).",prescriber_no="
            .getStringFormatted($this->presctiber_no).",registration_no="
            .getStringFormatted($this->registration_no).",abn="
            .getStringFormatted($this->abn)." WHERE employees_id='"
            .$this->id."';";
            $result = dbQuery($str);
            if($result){
                parent::deleteCenters();
                parent::addCenters();
            }
            return $result;
        }
        
    }

    public function delete() {
        if($this->id!=""){
            $str="DELETE FROM doctor_data WHERE employees_id='$this->id';";
            $result = dbQuery($str);
            if($result){
                return parent::delete();
            }
            else{
                return false;;
            }
        }
    }

}

?>