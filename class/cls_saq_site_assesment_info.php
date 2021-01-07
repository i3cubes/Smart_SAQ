<?php

include_once 'database.php';
include_once 'constants.php';

include_once 'shared.php';

class saq_site_assesment_info {

    public $id, $year, $assessment_tax, $trade_tax, $saq_sites_id;
    private $table_name = 'saq_site_assesment_info';

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getData() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->year = $row['year'];
        $this->assessment_tax = $row['assessment_tax'];
        $this->trade_tax = $row['trade_tax'];
        $this->saq_sites_id = $row['saq_sites_id'];
    }

    public function add() {
        $key = array();
        $value = array();

        array_push($key, 'year');
        array_push($value, getStringFormatted($this->year));
        array_push($key, 'assessment_tax');
        array_push($value, getStringFormatted($this->assessment_tax));
        array_push($key, 'trade_tax');
        array_push($value, getStringFormatted($this->trade_tax));
        array_push($key, 'saq_sites_id');
        array_push($value, getStringFormatted($this->saq_sites_id));

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

            array_push($sql, shared::getCleanedData('year', $this->year, $source));
            array_push($sql, shared::getCleanedData('assessment_tax', $this->assessment_tax, $source));
            array_push($sql, shared::getCleanedData('trade_tax', $this->trade_tax, $source));

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
        } else {
            $this->add();
        }
    }

}

?>
