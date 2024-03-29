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
            $property_id,
            $assessment_no,
            $ward_no,
            $road,
            $acc_no_property_id,
            $assessment_owner_name,
            $saq_sites_id,
            $saq_payment_mode_id,
            $saq_rate_increment_id;
    public $update_string;
    private $table_name = 'saq_site_agreement_data';

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getData() {
        if ($this->id != '') {
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
            $this->property_id = $row['property_id'];
            $this->assessment_no = $row['assessment_no'];
            $this->ward_no = $row['ward_no'];
            $this->road = $row['road'];
            $this->acc_no_property_id = $row['acc_no_property_id'];
            $this->assessment_owner_name = $row['assessment_owner_name'];
            $this->saq_sites_id = $row['saq_sites_id'];
            $this->saq_payment_mode_id = $row['saq_payment_mode_id'];
            $this->saq_rate_increment_id = $row['saq_rate_increment_id'];
        }
    }

    public function getDataFromSiteID($s_id) {
        $str = "SELECT id from `$this->table_name` WHERE saq_sites_id='$s_id';";
//        print $str;
        $result = dbQuery($str);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->getData();
    }

    public function add() {
        $key = array();
        $value = array();

        array_push($key, 'date_expire');
        array_push($value, getStringFormatted($this->date_expire));
        array_push($key, 'date_start');
        array_push($value, getStringFormatted($this->date_start));
        array_push($key, 'payment_mode');
        array_push($value, getStringFormatted($this->payment_mode));
        array_push($key, 'lease_period');
        array_push($value, getStringFormatted($this->lease_period));
        array_push($key, 'current_month_payment');
        array_push($value, getStringFormatted($this->current_month_payment));
        array_push($key, 'start_monthly_rental');
        array_push($value, getStringFormatted($this->start_monthly_rental));
        array_push($key, 'rate_increment');
        array_push($value, getStringFormatted($this->rate_increment));
        array_push($key, 'advance_payment');
        array_push($value, getStringFormatted($this->advance_payment));
        array_push($key, 'bank_account');
        array_push($value, getStringFormatted($this->bank_account));
        array_push($key, 'bank_name');
        array_push($value, getStringFormatted($this->bank_name));
        array_push($key, 'branch_name');
        array_push($value, getStringFormatted($this->branch_name));
        array_push($key, 'account_type');
        array_push($value, getStringFormatted($this->account_type));
        array_push($key, 'account_holder_name');
        array_push($value, getStringFormatted($this->account_holder_name));
        array_push($key, 'account_holder_nic');
        array_push($value, getStringFormatted($this->account_holder_nic));
        array_push($key, 'monthly_deduction_for_adv');
        array_push($value, getStringFormatted($this->monthly_deduction_for_adv));
        array_push($key, 'adv_recovery_period');
        array_push($value, getStringFormatted($this->adv_recovery_period));
        array_push($key, 'property_id');
        array_push($value, getStringFormatted($this->property_id));
        array_push($key, 'assessment_no');
        array_push($value, getStringFormatted($this->assessment_no));
        array_push($key, 'ward_no');
        array_push($value, getStringFormatted($this->ward_no));
        array_push($key, 'road');
        array_push($value, getStringFormatted($this->road));
        array_push($key, 'acc_no_property_id');
        array_push($value, getStringFormatted($this->acc_no_property_id));
        array_push($key, 'assessment_owner_name');
        array_push($value, getStringFormatted($this->assessment_owner_name));
        array_push($key, 'saq_sites_id');
        array_push($value, getStringFormatted($this->saq_sites_id));
        array_push($key, 'saq_payment_mode_id');
        array_push($value, getStringFormatted($this->saq_payment_mode_id));
        array_push($key, 'saq_rate_increment_id');
        array_push($value, getStringFormatted($this->saq_rate_increment_id));

        if (!empty($key)) {
            $sql_str_key = implode(",", array_filter($key));
            $sql_str_value = implode(",", array_filter($value));
            $this->update_string = implode("||", array_filter($key));
            $this->update_string .= implode("||", array_filter($value));

            $str = "INSERT INTO `$this->table_name` ($sql_str_key) VALUES ($sql_str_value)";
//                print $str;
            $result = dbQuery($str);
            if ($result) {
                $this->id = dbInsertId();
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function update($source = 'API') {
        if ($this->id != '') {
            $sql = array();
            array_push($sql, shared::getCleanedData('agreement_status', $this->agreement_status, $source));
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
            array_push($sql, shared::getCleanedData('property_id', $this->property_id, $source));
            array_push($sql, shared::getCleanedData('assessment_no', $this->assessment_no, $source));
            array_push($sql, shared::getCleanedData('ward_no', $this->ward_no, $source));
            array_push($sql, shared::getCleanedData('road', $this->road, $source));
            array_push($sql, shared::getCleanedData('acc_no_property_id', $this->acc_no_property_id, $source));
            array_push($sql, shared::getCleanedData('assessment_owner_name', $this->assessment_owner_name, $source));
            array_push($sql, shared::getCleanedData('saq_payment_mode_id', $this->saq_payment_mode_id, $source));
            array_push($sql, shared::getCleanedData('saq_rate_increment_id', $this->saq_rate_increment_id, $source));

            if (!empty($sql)) {
                $sql_str = implode(",", array_filter($sql));
                $this->update_string = implode("||", array_filter($sql));

                $str = "UPDATE `$this->table_name` SET " . $sql_str . " WHERE id='$this->id';";
                //print $str;
                $result = dbQuery($str);
                return $result;
            } else {
                return false;
            }
        } else {
            $result = $this->add();
            return $result;
        }
    }

}

?>
