<?php

include_once 'database.php';
include_once 'constants.php';
include_once 'shared.php';

class saq_site_agreement_data {
    public $id,
           $agreement_status,
            $date_expire,
            $date_start,
            $payment_mode,
            $lease_period,
            $current_month_payment,
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
    public $update_string;
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
        $this->current_month_payment = $row['current_month_payment'];
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
    
    public function update($source = 'API') {
        $sql = array();
        
        array_push($sql, shared::getCleanedData('date_expire', $this->date_expire, $source));
        array_push($sql, shared::getCleanedData('date_start', $this->date_start, $source));
        array_push($sql, shared::getCleanedData('payment_mode', $this->payment_mode, $source));
        array_push($sql, shared::getCleanedData('lease_period', $this->lease_period, $source));
        array_push($sql, shared::getCleanedData('current_month_payment', $this->current_month_payment, $source));
        array_push($sql, shared::getCleanedData('start_monthly_rental', $this->start_monthly_rental, $source));
        array_push($sql, shared::getCleanedData('rate_increment', $this->rate_increment, $source));
        array_push($sql, shared::getCleanedData('advance_payment', $this->advance_payment, $source));
        array_push($sql, shared::getCleanedData('bank_account', $this->bank_account, $source));
        array_push($sql, shared::getCleanedData('bank_name', $this->bank_name, $source));
        array_push($sql, shared::getCleanedData('branch_name', $this->branch_name, $source));
        array_push($sql, shared::getCleanedData('account_type', $this->account_type, $source));
        array_push($sql, shared::getCleanedData('account_holder_name', $this->account_holder_name, $source));
        array_push($sql, shared::getCleanedData('account_holder_nic', $this->account_holder_nic, $source));
        array_push($sql, shared::getCleanedData('monthly_deduction_for_adv', $this->monthly_deduction_for_adv, $source));
        array_push($sql, shared::getCleanedData('adv_recovery_period', $this->adv_recovery_period, $source));
        
        if (!empty($sql)) {
                $sql_str = implode(",", array_filter($sql));
                $this->update_string = implode("||", array_filter($sql));

                $str = "UPDATE `$this->table_name` SET " . $sql_str . " WHERE id='$this->id';";
//                print $str;
                $result = dbQuery($str);
                return $result;
            } else {
                return false;
            }
    }
}
?>
