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

include_once 'cls_saq_technical.php';
include_once 'cls_saq_site_agreement_data.php';

class site {
    //put your code here
    public $id;
    public $name,$code,$type,$address,$site_ownership,$operator_name,$tower_height,$building_height,$land_area;
    public $on_air_date,$category,$lat,$lon,$access_type,$manual_distance,$access_permision_type,$pg_installation_possibility;
    public $lo_name,$lo_address,$lo_nic_brc,$lo_mobile,$lo_land_number,$contact_person_number,$lo_fax,$lo_email;
    public $province_id,$peovince_name,$district_id,$district_name,$ds_id,$ds_name,$la_id,$la_name,$police_station_id,$police_station_name;
    public $region_id,$region_name,$dns_office_id,$dns_office_name;
    public $update_string;


    public function __construct($id = '') {
        $this->id = $id;
    }
    public function getData(){
        $str="SELECT t1.*,t2.name as district_name,t3.name as ds_name,t4.name as la_name,t5.name as police_station_name,"
                . "t6.name as region_name FROM saq_sites as t1 left join saq_district as t2 on t1.saq_district_id=t2.id "
                . "left join saq_ds as t3 on t1.saq_ds_id=t3.id left join saq_la as t4 on t1.saq_la_id=t4.name "
                . "left join saq_police_station as t5 on t1.saq_police_station_id=t5.id "
                . "left join saq_region as t6 on t1.saq_region_id=t6.id "
                . "WHERE t1.id='".$this->id."';";
        $res= dbQuery($str);
        $row= dbFetchAssoc($res);
        $this->id=$row['id'];
        $this->name=$row['name'];
        $this->code=$row['code'];
        $this->type=$row['type'];
        $this->address=$row['address'];
        $this->site_ownership=$row['site_ownership'];
        $this->operator_name=$row['operators_name'];
        $this->tower_height=$row['tower_height'];
        $this->building_height=$row['building_height'];
        $this->land_area=$row['land_area'];
        $this->on_air_date=$row['on_air_date'];
        $this->category=$row['category'];
        $this->lat=$row['lat'];
        $this->lon=$row['lon'];
        $this->access_type=$row['access_type'];
        $this->manual_distance=$row['manual_distance'];
        //
        $this->lo_name=$row['LO_name'];
        $this->lo_address=$row['LO_address'];
        $this->lo_nic_brc=$row['LO_nic_brc'];
        $this->lo_mobile=$row['LO_mobile'];
        $this->lo_land_number=$row['LO_land_number'];
        $this->contact_person_number=$row['contact_number'];
        $this->lo_fax=$row['LO_fax'];
        $this->lo_email=$row['LO_email'];
        $this->district_id=$row['saq_district_id'];
        $this->district_name=$row['district_name'];
        $this->ds_id=$row['saq_ds_id'];
        $this->ds_name=$row['ds_name'];
        $this->la_id=$row['saq_la_id'];
        $this->police_station_id=$row['saq_police_station_id'];
        $this->police_station_name=$row['police_station_name'];
        $this->region_id=$row['saq_region_id'];
        $this->region_name=$row['region_name'];
    }
    
    public function addSite(){
        if($this->addTemplate()){
            $this->update("");
            return true;
        }
        else{
            return false;
        }
    }

    public function addTemplate(){
        if($this->code!=""){
            $str="INSERT INTO saq_sites (code) VALUES('$this->code');";
            $res= dbQuery($str);
            if($res){
                $this->id= dbInsertId();
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    public function update($tab,$source='API'){
        if($this->id!=""){
            
            $sql=array();
            switch ($tab){
            case 'D':
                array_push($sql, $this->getCleanedData('name', $this->name,$source));
                array_push($sql, $this->getCleanedData('type', $this->type,$source));
                array_push($sql, $this->getCleanedData('address', $this->address,$source));
                array_push($sql, $this->getCleanedData('site_ownership', $this->site_ownership,$source));
                array_push($sql, $this->getCleanedData('operators_name', $this->operator_name,$source));
                array_push($sql, $this->getCleanedData('tower_height', $this->tower_height,$source));
                array_push($sql, $this->getCleanedData('building_height', $this->building_height,$source));
                array_push($sql, $this->getCleanedData('land_area', $this->land_area,$source));
                array_push($sql, $this->getCleanedData('on_air_date', $this->on_air_date,$source));
                array_push($sql, $this->getCleanedData('category', $this->category,$source));
                array_push($sql, $this->getCleanedData('lat', $this->lat,$source));
                array_push($sql, $this->getCleanedData('lon', $this->lon,$source));
                array_push($sql, $this->getCleanedData('access_type', $this->access_type,$source));
                array_push($sql, $this->getCleanedData('manual_distance', $this->manual_distance,$source));
                array_push($sql, $this->getCleanedData('access_permission_type', $this->access_permision_type,$source));
                array_push($sql, $this->getCleanedData('PG_installation_possibility', $this->pg_installation_possibility,$source));
                array_push($sql, $this->getCleanedData('saq_district_id', $this->district_id,$source));
                array_push($sql, $this->getCleanedData('saq_ds_id', $this->ds_id,$source));
                array_push($sql, $this->getCleanedData('saq_la_id', $this->la_id,$source));
                array_push($sql, $this->getCleanedData('saq_police_station_id', $this->police_station_id,$source));
                array_push($sql, $this->getCleanedData('saq_region_id', $this->region_id,$source));
                array_push($sql, $this->getCleanedData('saq_dns_office_id', $this->dns_office_id,$source));
                
                break;
            //print $str;
            case 'C':
            //Contact
                array_push($sql, $this->getCleanedData('LO_name', $this->lo_name,$source));
                array_push($sql, $this->getCleanedData('LO_address', $this->lo_address,$source));
                array_push($sql, $this->getCleanedData('LO_nic_brc', $this->lo_nic_brc,$source));
                array_push($sql, $this->getCleanedData('LO_mobile', $this->lo_mobile,$source));
                array_push($sql, $this->getCleanedData('LO_land_number', $this->lo_land_number,$source));
                array_push($sql, $this->getCleanedData('contact_person_number', $this->contact_person_number,$source));
                array_push($sql, $this->getCleanedData('LO_fax', $this->lo_fax,$source));
                array_push($sql, $this->getCleanedData('LO_email', $this->lo_email,$source));

                break;
            default :
                $sql=null;
            
            }
            if(!empty($sql)){
                $sql_str= implode(",", array_filter($sql));
                $this->update_string= implode("||", array_filter($sql));

                $str="UPDATE saq_sites SET ".$sql_str." WHERE id='$this->id';";
//                print $str;
                $result= dbQuery($str);
                return $result;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    
    private function getCleanedData($field,$data,$source='API'){
        if($source=='WEB' && $data==''){
            $data="NULL"; // -----enable set null by web interface when data fiels is empty
        }
        if($data=='NULL'){
            return "$field=NULL";
        }
        else{
            if($data==''){
                return false;
            }
            else{
                return $field."=".getStringFormatted($data);
            }
        }
    }


    public function getTechnologyPresent($technical_id){
        $tecnologies=array();
        $str="SELECT t1.* FROM saq_site_technical as t1 left join saq_technical as t2 on t1.saq_technical_id=t2.id "
                . "WHERE t1.saq_sites_id='$this->id' AND t1.saq_technical_id = $technical_id";
//        print $str;
        $res= dbQuery($str);
        if(dbNumRows($res)==1) {
            $row = dbFetchAssoc($res);   
            if($row['available'] == 'Y') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
             
//        return $tecnologies;
    }
    public function getOtherOperatorPresent($other_operator_id){
        $operators=array();
        $str="SELECT t1.* FROM saq_site_other_operator as t1 left join saq_other_operator as t2 on t1.saq_other_operator_id=t2.id "
                . "WHERE t1.saq_sites_id='$this->id' AND t1.saq_other_operator_id = $other_operator_id;";
        $res= dbQuery($str);
        if(dbNumRows($res)>0) {
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
        if(dbNumRows($result)==1) {
            $row = dbFetchAssoc($result);
//            print 'id'. $row['id'];
            $saq_s_a_d_obj = new saq_site_agreement_data($row['id']);
            $saq_s_a_d_obj->getData();
        } else {
            $saq_s_a_d_obj = new saq_site_agreement_data();
        }
        return $saq_s_a_d_obj;
    }
    public function getApprovalsPresent($approval_id){
        $approvals=array();
        $str="SELECT * FROM saq_site_approvals as t1 left join saq_approvals as t2 on t1.saq_approvals_id=t2.id "
                . "WHERE t1.saq_sites_id='$this->id' AND t1.saq_approvals_id = $approval_id;";
        $res= dbQuery($str);
        if(dbNumRows($res)>0) {
            return true;
        } else {
            return false;
        }
//        while ($row = dbFetchAssoc($res)) {
//            array_push($approvals, array('requirement'=>$row['requirement'],'description'=>$row['description'],'code'=>$row['code'],'available'=>$row['available']));
//        }
//        return $approvals;
    }

    public function getTabbedData(){
        $t_data=array();
        $t=[];
        $t['site_id']= $this->id;
        $t['code']= $this->code;
        $t['name']= $this->name;
        $t['province']= $this->district_name;
        $t['district']= $this->district_name;
        $t['DS']= $this->ds_name;
        $t['LA']= $this->la_name;
        $t['police_station']= $this->police_station_name;
        $t['dns_region']= $this->dns_office_name;
        $t['dns_office']= $this->dns_office_name;
        $t['rm_name']="";
        $t['saq_officer_name']="";
        $t['dns_officer_name']="";
        $t['site_ownership']= $this->site_ownership;
        $t['operator_name']= $this->operator_name;
        $t['other_operator_id']= "";
        $t['site_type']= $this->type;
        $t['tower_height']= $this->tower_height;
        $t['building_height']= $this->building_height;
        $t['land_area']= $this->land_area;
        $t['site_status']= "";
        $t['on_air_date']= $this->on_air_date;
        $t['category']= $this->category;
        $t['lat']= $this->lat;
        $t['lon']= $this->lon;
        $t['access_type']= $this->access_type;
        $t['manual_distance']= $this->manual_distance;
        $t['access_permission_type']= $this->access_permision_type;
        $t['PG_installation_possibility']= "";
        
        $t_data['general']=$t;
        
        $x=[];
        $x['LO_name']= $this->lo_name;
        $x['LO_address']= $this->lo_address;
        $x['LO_nic_brc']= $this->lo_nic_brc;
        $x['LO_mobile']= $this->lo_mobile;
        $x['LO_land_number']= $this->lo_land_number;
        $x['contact_person']="";
        $x['contact_person_number']= $this->contact_person_number;
        $x['LO_fax']= $this->lo_fax;
        $x['LO_email']= $this->lo_email;
        
        $t_data['contact']=$x;
        $ary_tech_data= $this->getTechnologyPresent();
        $ary_oth_opr= $this->getOtherOperatorPresent();
        
        $t_data['technical']['technology']=$ary_tech_data;
        $t_data['technical']['other_operator']=$ary_oth_opr;
        
        $t_data['payments']=array();
        
        $ary_apr= $this->getApprovalsPresent();
        $t_data['approvals']=$ary_apr;
        
        return $t_data;
        
    }
}
