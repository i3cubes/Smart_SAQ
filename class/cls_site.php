<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cls_site
 *
 * @author kumar
 */
include_once 'database.php';
include_once 'shared.php';
include_once 'cls_saq_technical.php';
include_once 'cls_saq_site_agreement_data.php';
include_once 'cls_saq_site_assesment_info.php';

class site {

    //put your code here
    public $id;
    public $name, $code, $type, $address, $site_ownership, $operator_name, $tower_height, $building_height, $land_area;
    public $on_air_date, $category, $lat, $lon, $access_type, $manual_distance, $access_permision_type, $pg_installation_possibility;
    public $lo_name, $lo_address, $lo_nic_brc, $lo_mobile, $lo_land_number, $contact_person_number, $lo_fax, $lo_email;
    public $province_id, $peovince_name, $district_id, $district_name, $ds_id, $ds_name, $la_id, $la_name, $police_station_id, $police_station_name;
    public $region_id, $region_name, $dns_office_id, $dns_office_name, $technical, $other_operators, $agreement_data, $assessment_data, $agreement_data_id, $approvals;
    public $update_string;

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getData() {
        $str = "SELECT t1.*,t2.name as district_name,t3.name as ds_name,t4.name as la_name,t5.name as police_station_name,"
                . "t6.name as region_name FROM saq_sites as t1 left join saq_district as t2 on t1.saq_district_id=t2.id "
                . "left join saq_ds as t3 on t1.saq_ds_id=t3.id left join saq_la as t4 on t1.saq_la_id=t4.name "
                . "left join saq_police_station as t5 on t1.saq_police_station_id=t5.id "
                . "left join saq_region as t6 on t1.saq_region_id=t6.id "
                . "WHERE t1.id='" . $this->id . "';";
        //print $str."<br>";
        $res = dbQuery($str);
        $row = dbFetchAssoc($res);
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->code = $row['code'];
        $this->type = $row['type'];
        $this->address = $row['address'];
        $this->site_ownership = $row['site_ownership'];
        $this->operator_name = $row['operators_name'];
        $this->tower_height = $row['tower_height'];
        $this->building_height = $row['building_height'];
        $this->land_area = $row['land_area'];
        $this->on_air_date = $row['on_air_date'];
        $this->category = $row['category'];
        $this->lat = $row['lat'];
        $this->lon = $row['lon'];
        $this->access_type = $row['access_type'];
        $this->manual_distance = $row['manual_distance'];
        //
        $this->lo_name = $row['LO_name'];
        $this->lo_address = $row['LO_address'];
        $this->lo_nic_brc = $row['LO_nic_brc'];
        $this->lo_mobile = $row['LO_mobile'];
        $this->lo_land_number = $row['LO_land_number'];
        $this->contact_person_number = $row['contact_person_number'];
        $this->lo_fax = $row['LO_fax'];
        $this->lo_email = $row['LO_email'];
        $this->district_id = $row['saq_district_id'];
        $this->district_name = $row['district_name'];
        $this->ds_id = $row['saq_ds_id'];
        $this->ds_name = $row['ds_name'];
        $this->la_id = $row['saq_la_id'];
        $this->police_station_id = $row['saq_police_station_id'];
        $this->police_station_name = $row['police_station_name'];
        $this->region_id = $row['saq_region_id'];
        $this->region_name = $row['region_name'];
    }

    public function addSite() {
        if ($this->addTemplate()) {
            $this->update("");
            return true;
        } else {
            return false;
        }
    }

    public function addTemplate() {
        if ($this->code != "") {
            $str = "INSERT INTO saq_sites (code) VALUES('$this->code');";
            $res = dbQuery($str);
            if ($res) {
                $this->id = dbInsertId();
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function update($tab, $source = 'API') {
        if ($this->id != "") {

            $sql = array();
            switch ($tab) {
                case 'D':
                    array_push($sql, shared::getCleanedData('name', $this->name, $source));
                    array_push($sql, shared::getCleanedData('type', $this->type, $source));
                    array_push($sql, shared::getCleanedData('address', $this->address, $source));
                    array_push($sql, shared::getCleanedData('site_ownership', $this->site_ownership, $source));
                    array_push($sql, shared::getCleanedData('operators_name', $this->operator_name, $source));
                    array_push($sql, shared::getCleanedData('tower_height', $this->tower_height, $source));
                    array_push($sql, shared::getCleanedData('building_height', $this->building_height, $source));
                    array_push($sql, shared::getCleanedData('land_area', $this->land_area, $source));
                    array_push($sql, shared::getCleanedData('on_air_date', $this->on_air_date, $source));
                    array_push($sql, shared::getCleanedData('category', $this->category, $source));
                    array_push($sql, shared::getCleanedData('lat', $this->lat, $source));
                    array_push($sql, shared::getCleanedData('lon', $this->lon, $source));
                    array_push($sql, shared::getCleanedData('access_type', $this->access_type, $source));
                    array_push($sql, shared::getCleanedData('manual_distance', $this->manual_distance, $source));
                    array_push($sql, shared::getCleanedData('access_permission_type', $this->access_permision_type, $source));
                    array_push($sql, shared::getCleanedData('PG_installation_possibility', $this->pg_installation_possibility, $source));
                    array_push($sql, shared::getCleanedData('saq_district_id', $this->district_id, $source));
                    array_push($sql, shared::getCleanedData('saq_province_id', $this->province_id, $source));
                    array_push($sql, shared::getCleanedData('saq_ds_id', $this->ds_id, $source));
                    array_push($sql, shared::getCleanedData('saq_la_id', $this->la_id, $source));
                    array_push($sql, shared::getCleanedData('saq_police_station_id', $this->police_station_id, $source));
                    array_push($sql, shared::getCleanedData('saq_region_id', $this->region_id, $source));
                    array_push($sql, shared::getCleanedData('saq_dns_office_id', $this->dns_office_id, $source));

                    break;
                //print $str;
                case 'C':
                    //Contact
                    array_push($sql, shared::getCleanedData('LO_name', $this->lo_name, $source));
                    array_push($sql, shared::getCleanedData('LO_address', $this->lo_address, $source));
                    array_push($sql, shared::getCleanedData('LO_nic_brc', $this->lo_nic_brc, $source));
                    array_push($sql, shared::getCleanedData('LO_mobile', $this->lo_mobile, $source));
                    array_push($sql, shared::getCleanedData('LO_land_number', $this->lo_land_number, $source));
                    array_push($sql, shared::getCleanedData('contact_person_number', $this->contact_person_number, $source));
                    array_push($sql, shared::getCleanedData('LO_fax', $this->lo_fax, $source));
                    array_push($sql, shared::getCleanedData('LO_email', $this->lo_email, $source));

                    break;
                case 'T':
                    if (count($this->technical) > 0 || $this->technical != '') {
                        if (is_string($this->technical)) {
                            $this->technical = array($this->technical);
                        }
                        if ($this->deleteSiteTechnical($this->id)) {
                            foreach ($this->technical as $technical_id) {
                                $update_res = $this->updateSiteTechnical($this->id, $technical_id);
                                if (!$update_res) {
                                    continue;
                                }
                            }
                        }
                    } else {
                        $this->deleteSiteTechnical($this->id);
                    }

                    if (count($this->other_operators) > 0 || $this->other_operators != '') {
                        if (is_string($this->other_operators)) {
                            $this->other_operators = array($this->other_operators);
                        }
                        if ($this->deleteSiteOtherOperator($this->id)) {
                            foreach ($this->other_operators as $other_operator_id) {
                                $update_res = $this->updateSiteOtherOperator($this->id, $other_operator_id);
                                if (!$update_res) {
                                    continue;
                                }
                            }
                        }
                    } else {
                        $this->deleteSiteOtherOperator($this->id);
                    }
                    return true;
                    break;
                case 'P':
                    $agreement_data_obj = new saq_site_agreement_data($this->agreement_data['agreement_data_id']);
                    $agreement_data_obj->date_expire = $this->agreement_data['agreement_expire_date'];
                    $agreement_data_obj->date_start = $this->agreement_data['agreement_start_date'];
                    $agreement_data_obj->payment_mode = $this->agreement_data['payment_mode'];
                    $agreement_data_obj->lease_period = $this->agreement_data['leas_period'];
                    $agreement_data_obj->current_month_payment = $this->agreement_data['current_month_payment'];
                    $agreement_data_obj->start_monthly_rental = $this->agreement_data['start_monthly_rental'];
                    $agreement_data_obj->rate_increment = $this->agreement_data['rate_increment'];
                    $agreement_data_obj->advance_payment = $this->agreement_data['advance_payment'];
                    $agreement_data_obj->bank_account = $this->agreement_data['bank_account'];
                    $agreement_data_obj->bank_name = $this->agreement_data['bank_name'];
                    $agreement_data_obj->branch_name = $this->agreement_data['branch_name'];
                    $agreement_data_obj->account_type = $this->agreement_data['acc_type'];
                    $agreement_data_obj->account_holder_name = $this->agreement_data['acc_holder_name'];
                    $agreement_data_obj->account_holder_nic = $this->agreement_data['acc_holder_nic_no'];
                    $agreement_data_obj->monthly_deduction_for_adv = $this->agreement_data['mdafar'];
                    $agreement_data_obj->adv_recovery_period = $this->agreement_data['adv_recovery_period'];
                    $agreement_data_obj->saq_sites_id = $this->id;

                    $result = $agreement_data_obj->update('WEB');
                    if ($result) {                        
                        $this->agreement_data_id = $agreement_data_obj->id;
                        if (!empty($this->assessment_data)) {
                            if ($this->deleteSiteAssessmentInfo()) {
                                foreach ($this->assessment_data as $index => $tax_data) {
                                    $assessment_info_obj = new saq_site_assesment_info($tax_data[2]);
                                    if ($index == 0) {
                                        $assessment_info_obj->year = '2018';
                                    } else if ($index == 1) {
                                        $assessment_info_obj->year = '2019';
                                    } else if ($index == 2) {
                                        $assessment_info_obj->year = '2020';
                                    } else if ($index == 3) {
                                        $assessment_info_obj->year = '2021';
                                    }
                                    $assessment_info_obj->assessment_tax = $tax_data[0];
                                    $assessment_info_obj->trade_tax = $tax_data[1];
                                    $assessment_info_obj->saq_sites_id = $this->id;

                                    $ass_update_res = $assessment_info_obj->add();
                                    if (!$ass_update_res) {
                                        continue;
                                    }
                                }
                            }

                            return true;
                        } else {
                            return true;
                        }
                    } else {                       
                        return false;
                    }

                    break;
                case 'A':
                    if (count($this->approvals) > 0 || $this->approvals != '') {
                        if (is_string($this->approvals)) {
                            $this->approvals = array($this->approvals);
                        }
                        if ($this->deleteSiteApprovals($this->id)) {
                            foreach ($this->approvals as $approval_id) {
                                $update_res = $this->updateSiteApprovals($this->id, $approval_id);
                                if (!$update_res) {
                                    continue;
                                }
                            }
                        }
                    } else {
                        $this->deleteSiteApprovals($this->id);
                    }
                    return true;
                    break;
                default :
                    $sql = null;
            }
            if (!empty($sql)) {
                $sql_str = implode(",", array_filter($sql));
                $this->update_string = implode("||", array_filter($sql));

                $str = "UPDATE saq_sites SET " . $sql_str . " WHERE id='$this->id';";
//                print $str;
                $result = dbQuery($str);
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function add($tab, $source = 'API') {
        if ($this->id == 0) {

            $key = array();
            $value = array();
            switch ($tab) {
                case 'D':
                    array_push($key, 'name');
                    array_push($value, getStringFormatted($this->name));
                    array_push($key, 'type');
                    array_push($value, getStringFormatted($this->type));
                    array_push($key, 'address');
                    array_push($value, getStringFormatted($this->address));
                    array_push($key, 'site_ownership');
                    array_push($value, getStringFormatted($this->site_ownership));
                    array_push($key, 'operators_name');
                    array_push($value, getStringFormatted($this->operators_name));
                    array_push($key, 'tower_height');
                    array_push($value, getStringFormatted($this->tower_height));
                    array_push($key, 'building_height');
                    array_push($value, getStringFormatted($this->building_height));
                    array_push($key, 'land_area');
                    array_push($value, getStringFormatted($this->land_area));
                    array_push($key, 'on_air_date');
                    array_push($value, getStringFormatted($this->on_air_date));
                    array_push($key, 'category');
                    array_push($value, getStringFormatted($this->category));
                    array_push($key, 'lat');
                    array_push($value, getStringFormatted($this->lat));
                    array_push($key, 'lon');
                    array_push($value, getStringFormatted($this->lon));
                    array_push($key, 'access_type');
                    array_push($value, getStringFormatted($this->access_type));
                    array_push($key, 'manual_distance');
                    array_push($value, getStringFormatted($this->manual_distance));
                    array_push($key, 'access_permission_type');
                    array_push($value, getStringFormatted($this->access_permission_type));
                    array_push($key, 'PG_installation_possibility');
                    array_push($value, getStringFormatted($this->PG_installation_possibility));
                    array_push($key, 'saq_district_id');
                    array_push($value, getStringFormatted($this->saq_district_id));
                    array_push($key, 'saq_ds_id');
                    array_push($value, getStringFormatted($this->saq_ds_id));
                    array_push($key, 'saq_la_id');
                    array_push($value, getStringFormatted($this->saq_la_id));
                    array_push($key, 'saq_police_station_id');
                    array_push($value, getStringFormatted($this->saq_police_station_id));
                    array_push($key, 'saq_region_id');
                    array_push($value, getStringFormatted($this->saq_region_id));
                    array_push($key, 'saq_dns_office_id');
                    array_push($value, getStringFormatted($this->dns_office_id));

                    break;
                //print $str;
                case 'C':
                    //Contact
                    array_push($key, 'LO_name');
                    array_push($value, getStringFormatted($this->lo_name));
                    array_push($key, 'LO_address');
                    array_push($value, getStringFormatted($this->lo_address));
                    array_push($key, 'LO_nic_brc');
                    array_push($value, getStringFormatted($this->lo_nic_brc));
                    array_push($key, 'LO_mobile');
                    array_push($value, getStringFormatted($this->lo_mobile));
                    array_push($key, 'LO_land_number');
                    array_push($value, getStringFormatted($this->lo_land_number));
                    array_push($key, 'contact_person_number');
                    array_push($value, getStringFormatted($this->contact_person_number));
                    array_push($key, 'LO_fax');
                    array_push($value, getStringFormatted($this->lo_fax));
                    array_push($key, 'LO_email');
                    array_push($value, getStringFormatted($this->lo_email));

                    break;
                case 'T':
                    if (count($this->technical) > 0 || $this->technical != '') {
                        if (is_string($this->technical)) {
                            $this->technical = array($this->technical);
                        }
                        if ($this->deleteSiteTechnical($this->id)) {
                            foreach ($this->technical as $technical_id) {
                                $update_res = $this->updateSiteTechnical($this->id, $technical_id);
                                if (!$update_res) {
                                    continue;
                                }
                            }
                        }
                    } else {
                        $this->deleteSiteTechnical($this->id);
                    }

                    if (count($this->other_operators) > 0 || $this->other_operators != '') {
                        if (is_string($this->other_operators)) {
                            $this->other_operators = array($this->other_operators);
                        }
                        if ($this->deleteSiteOtherOperator($this->id)) {
                            foreach ($this->other_operators as $other_operator_id) {
                                $update_res = $this->updateSiteOtherOperator($this->id, $other_operator_id);
                                if (!$update_res) {
                                    continue;
                                }
                            }
                        }
                    } else {
                        $this->deleteSiteOtherOperator($this->id);
                    }
                    return true;
                    break;
                case 'P':
                    $agreement_data_obj = new saq_site_agreement_data($this->agreement_data['agreement_data_id']);
                    $agreement_data_obj->date_expire = $this->agreement_data['agreement_expire_date'];
                    $agreement_data_obj->date_start = $this->agreement_data['agreement_start_date'];
                    $agreement_data_obj->payment_mode = $this->agreement_data['payment_mode'];
                    $agreement_data_obj->lease_period = $this->agreement_data['leas_period'];
                    $agreement_data_obj->current_month_payment = $this->agreement_data['current_month_payment'];
                    $agreement_data_obj->start_monthly_rental = $this->agreement_data['start_monthly_rental'];
                    $agreement_data_obj->rate_increment = $this->agreement_data['rate_increment'];
                    $agreement_data_obj->advance_payment = $this->agreement_data['advance_payment'];
                    $agreement_data_obj->bank_account = $this->agreement_data['bank_account'];
                    $agreement_data_obj->bank_name = $this->agreement_data['bank_name'];
                    $agreement_data_obj->branch_name = $this->agreement_data['branch_name'];
                    $agreement_data_obj->account_type = $this->agreement_data['acc_type'];
                    $agreement_data_obj->account_holder_name = $this->agreement_data['acc_holder_name'];
                    $agreement_data_obj->account_holder_nic = $this->agreement_data['acc_holder_nic_no'];
                    $agreement_data_obj->monthly_deduction_for_adv = $this->agreement_data['mdafar'];
                    $agreement_data_obj->adv_recovery_period = $this->agreement_data['adv_recovery_period'];

                    $result = $agreement_data_obj->update('WEB');
                    if ($result) {
                        $this->agreement_data_id = $agreement_data_obj->id;
                        return true;
                    } else {
                        return false;
                    }
                    break;
                case 'A':
                    if (count($this->approvals) > 0 || $this->approvals != '') {
                        if (is_string($this->approvals)) {
                            $this->approvals = array($this->approvals);
                        }
                        if ($this->deleteSiteApprovals($this->id)) {
                            foreach ($this->approvals as $approval_id) {
                                $update_res = $this->updateSiteApprovals($this->id, $approval_id);
                                if (!$update_res) {
                                    continue;
                                }
                            }
                        }
                    } else {
                        $this->deleteSiteApprovals($this->id);
                    }
                    return true;
                    break;
                default :
                    $sql = null;
            }
            if (!empty($key)) {
                $sql_str_key = implode(",", array_filter($key));
                $sql_str_value = implode(",", array_filter($value));
                $this->update_string = implode("||", array_filter($key));
                $this->update_string .= implode("||", array_filter($value));

                $str = "INSERT INTO `saq_sites` ($sql_str_key) VALUES ($sql_str_value)";
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
        } else {
            return false;
        }
    }

    // delete site assessment info
    public function deleteSiteAssessmentInfo() {
        $string = "DELETE FROM `saq_site_assesment_info` WHERE `saq_sites_id` = $this->id;";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // delete site technical data
    public function deleteSiteTechnical($site_id) {
        $string = "DELETE FROM `saq_site_technical` WHERE `saq_sites_id` = $site_id;";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // delete site other operator data
    public function deleteSiteOtherOperator($site_id) {
        $string = "DELETE FROM `saq_site_other_operator` WHERE `saq_sites_id` = $site_id;";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // delete site approvels data
    public function deleteSiteApprovals($site_id) {
        $string = "DELETE FROM `saq_site_approvals` WHERE `saq_sites_id` = $site_id;";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // insert site technical data
    public function updateSiteTechnical($site_id, $technical_id) {
        $string = "INSERT INTO `saq_site_technical` (`available`,`saq_technical_id`,`saq_sites_id`) "
                . "VALUES ('Y',$technical_id,$site_id);";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // insert site other operator data
    public function updateSiteOtherOperator($site_id, $other_operator_id) {
        $string = "INSERT INTO `saq_site_other_operator` (`saq_other_operator_id`,`saq_sites_id`) "
                . "VALUES ($other_operator_id,$site_id);";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // insert site approvals 
    public function updateSiteApprovals($site_id, $approval_id) {
        $string = "INSERT INTO `saq_site_approvals` (`saq_approvals_id`,`saq_sites_id`,`available`) VALUES "
                . "($approval_id,$site_id,'Y');";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getTechnologyPresentSite($technical_id) {
        $tecnologies = array();
        $str = "SELECT t1.* FROM saq_site_technical as t1 left join saq_technical as t2 on t1.saq_technical_id=t2.id "
                . "WHERE t1.saq_sites_id='$this->id' AND t1.saq_technical_id = $technical_id";
//        print $str;
        $res = dbQuery($str);
        if (dbNumRows($res) == 1) {
            $row = dbFetchAssoc($res);
            if ($row['available'] == 'Y') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

//        return $tecnologies;
    }

    public function getOtherOperatorPresentSite($other_operator_id) {
        $operators = array();
        $str = "SELECT t1.* FROM saq_site_other_operator as t1 left join saq_other_operator as t2 on t1.saq_other_operator_id=t2.id "
                . "WHERE t1.saq_sites_id='$this->id' AND t1.saq_other_operator_id = $other_operator_id;";
        $res = dbQuery($str);
        if (dbNumRows($res) > 0) {
            return true;
        } else {
            return false;
        }
//        while ($row = dbFetchAssoc($res)) {
//            array_push($operators, $row['name']);
//        }
//        return $operators;
    }

    public function getSiteAgreementData() {
        $string = "SELECT t2.id FROM `saq_sites` AS `t1` INNER JOIN `saq_site_agreement_data` AS `t2` ON t2.saq_sites_id = t1.id WHERE t1.id = $this->id;";
//        print $string;
        $result = dbQuery($string);
        if (dbNumRows($result) == 1) {
            $row = dbFetchAssoc($result);
//            print 'id'. $row['id'];
            $saq_s_a_d_obj = new saq_site_agreement_data($row['id']);
            $saq_s_a_d_obj->getData();
        } else {
            $saq_s_a_d_obj = new saq_site_agreement_data();
        }
        return $saq_s_a_d_obj;
    }

    public function getSiteAssesmentInfo() {
        $array = array();
        $string = "SELECT t2.id FROM `saq_sites` AS `t1` INNER JOIN `saq_site_assesment_info` AS `t2` ON t1.id = t2.saq_sites_id WHERE t1.id = $this->id;";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            $assessment_info_obj = new saq_site_assesment_info($row['id']);
            $assessment_info_obj->getData();
            array_push($array, $assessment_info_obj);
        }
        return $array;
    }

    public function getApprovalsPresentSite($approval_id) {
        $approvals = array();
        $str = "SELECT * FROM saq_site_approvals as t1 left join saq_approvals as t2 on t1.saq_approvals_id=t2.id "
                . "WHERE t1.saq_sites_id='$this->id' AND t1.saq_approvals_id = $approval_id;";
        $res = dbQuery($str);
        if (dbNumRows($res) > 0) {
            return true;
        } else {
            return false;
        }
//        while ($row = dbFetchAssoc($res)) {
//            array_push($approvals, array('requirement'=>$row['requirement'],'description'=>$row['description'],'code'=>$row['code'],'available'=>$row['available']));
//        }
//        return $approvals;
    }

    public function getTechnologyPresent() {
        $tecnologies = array();
        $str = "SELECT * FROM saq_site_technical as t1 left join saq_technical as t2 on t1.saq_technical_id=t2.id "
                . "WHERE t1.saq_sites_id='$this->id'";
        $res = dbQuery($str);
        while ($row = dbFetchAssoc($res)) {
            array_push($tecnologies, array($row['technology'] => $row['availability']));
        }
        return $tecnologies;
    }

    public function getOtherOperatorPresent() {
        $operators = array();
        $str = "SELECT * FROM saq_site_other_operator as t1 left join saq_other_operator as t2 on t1.saq_other_operator_id=t2.id "
                . "WHERE t1.saq_sites_id='$this->id'";
        $res = dbQuery($str);
        while ($row = dbFetchAssoc($res)) {
            array_push($operators, $row['name']);
        }
        return $operators;
    }

    public function getApprovalsPresent() {
        $approvals = array();
        $str = "SELECT * FROM saq_site_approvals as t1 left join saq_approvals as t2 on t1.saq_approvals_id=t2.id "
                . "WHERE t1.saq_sites_id='$this->id'";
        $res = dbQuery($str);
        while ($row = dbFetchAssoc($res)) {
            array_push($approvals, array('requirement' => $row['requirement'], 'description' => $row['description'], 'code' => $row['code'], 'available' => $row['available']));
        }
        return $approvals;
    }

    public function getTabbedData() {
        $t_data = array();
        $t = [];
        $t['site_id'] = $this->id;
        $t['code'] = $this->code;
        $t['name'] = $this->name;
        $t['province'] = $this->district_name;
        $t['district'] = $this->district_name;
        $t['DS'] = $this->ds_name;
        $t['LA'] = $this->la_name;
        $t['police_station'] = $this->police_station_name;
        $t['dns_region'] = $this->dns_office_name;
        $t['dns_office'] = $this->dns_office_name;
        $t['rm_name'] = "";
        $t['saq_officer_name'] = "";
        $t['dns_officer_name'] = "";
        $t['site_ownership'] = $this->site_ownership;
        $t['operator_name'] = $this->operator_name;
        $t['other_operator_id'] = "";
        $t['site_type'] = $this->type;
        $t['tower_height'] = $this->tower_height;
        $t['building_height'] = $this->building_height;
        $t['land_area'] = $this->land_area;
        $t['site_status'] = "";
        $t['on_air_date'] = $this->on_air_date;
        $t['category'] = $this->category;
        $t['lat'] = $this->lat;
        $t['lon'] = $this->lon;
        $t['access_type'] = $this->access_type;
        $t['manual_distance'] = $this->manual_distance;
        $t['access_permission_type'] = $this->access_permision_type;
        $t['PG_installation_possibility'] = "";

        $t_data['general'] = $t;

        $x = [];
        $x['LO_name'] = $this->lo_name;
        $x['LO_address'] = $this->lo_address;
        $x['LO_nic_brc'] = $this->lo_nic_brc;
        $x['LO_mobile'] = $this->lo_mobile;
        $x['LO_land_number'] = $this->lo_land_number;
        $x['contact_person'] = "";
        $x['contact_person_number'] = $this->contact_person_number;
        $x['LO_fax'] = $this->lo_fax;
        $x['LO_email'] = $this->lo_email;

        $t_data['contact'] = $x;
        $ary_tech_data = $this->getTechnologyPresent();
        $ary_oth_opr = $this->getOtherOperatorPresent();

        $t_data['technical']['technology'] = $ary_tech_data;
        $t_data['technical']['other_operator'] = $ary_oth_opr;

        $t_data['payments'] = array();

        $ary_apr = $this->getApprovalsPresent();
        $t_data['approvals'] = $ary_apr;

        return $t_data;
    }

}
