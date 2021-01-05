<?php

include_once 'database.php';
include_once 'constants.php';

class saq_site_agreement_data {
    public $id,
           $agreement_status,
            $date_expire,
            $date_start,
            $payment_mode,
            $lease_period,
            $start_monthly_rental,
            $rate_increment,
            $advance_payment,
            $bank_account,
            $bank_name,
            $branch_name,
            $account_type,
            $account_holder_name,
            $account_holder_nic,
            $monthly_deduction_for_adv,
            $adv_recovery_period,
            $saq_sites_id;
    private $table_name = 'saq_site_agreement_data';


    public function __construct($id = '') {
        $this->id = $id;
    }
    
    public function getData() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
//        print $string;
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->agreement_status = $row['agreement_status'];
        $this->date_expire = $row['date_expire'];
        $this->date_start = $row['date_start'];
        $this->payment_mode = $row['payment_mode'];
        $this->lease_period = $row['lease_period'];
        $this->start_monthly_rental = $row['start_monthly_rental'];
        $this->rate_increment = $row['rate_increment'];
        $this->advance_payment = $row['advance_payment'];
        $this->bank_account = $row['bank_account'];
        $this->bank_name = $row['bank_name'];
        $this->branch_name = $row['branch_name'];
        $this->account_type = $row['account_type'];
        $this->account_holder_name = $row['account_holder_name'];
        $this->account_holder_nic = $row['account_holder_nic'];
        $this->monthly_deduction_for_adv = $row['monthly_deduction_for_adv'];
        $this->adv_recovery_period = $row['adv_recovery_period'];
        $this->saq_sites_id = $row['saq_sites_id'];
    }
}
?>
