<?php
include_once 'cls_site.php';
include_once 'database.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cls_site_manager
 *
 * @author kumar
 */
class site_manager {
    //put your code here
    
    public function serchSite($name,$region_id,$radius){
        $result=array();
        $ary_sql=array();
        if($name!=""){
            array_push($ary_sql, "t1.name LIKE '%$name%'");
        }
        if($region_id!=""){
            array_push($ary_sql, "t1.saq_region_id='$region_id'");
        }
        if(!empty($ary_sql)){
            $where= implode(" AND ", $ary_sql);
        }
        else{
            $where="t1.id>0";
        }
        $str="SELECT t1.*,t2.name as district_name,t3.name as ds_name,t4.name as la_name,t5.name as police_station_name,"
                . "t6.name as region_name FROM saq_sites as t1 left join saq_district as t2 on t1.saq_district_id=t2.id "
                . "left join saq_ds as t3 on t1.saq_ds_id=t3.id left join saq_la as t4 on t1.saq_la_id=t4.name "
                . "left join saq_police_station as t5 on t1.saq_police_station_id=t5.id "
                . "left join saq_region as t6 on t1.saq_region_id=t6.id "
                . "WHERE ".$where;
        //print $str;
        $res= dbQuery($str);
        while ($row = dbFetchAssoc($res)) {
            //print_r($row);
            $site=new site($row['id']);
            $site->id=$row['id'];
            $site->name=$row['name'];
            $site->code=$row['code'];
            $site->type=$row['type'];
            $site->address=$row['address'];
            $site->site_ownership=$row['site_ownership'];
            $site->operator_name=$row['operators_name'];
            $site->tower_height=$row['tower_height'];
            $site->building_height=$row['building_height'];
            $site->land_area=$row['land_area'];
            $site->on_air_date=$row['on_air_date'];
            $site->category=$row['category'];
            $site->lat=$row['lat'];
            $site->lon=$row['lon'];
            $site->access_type=$row['access_type'];
            $site->manual_distance=$row['manual_distance'];
            //
            $site->lo_name=$row['LO_name'];
            $site->lo_address=$row['LO_address'];
            $site->lo_nic_brc=$row['LO_nic_brc'];
            $site->lo_mobile=$row['LO_mobile'];
            $site->lo_land_number=$row['LO_land_number'];
            $site->contact_person_number=$row['contact_number'];
            $site->lo_fax=$row['LO_fax'];
            $site->lo_email=$row['LO_email'];
            $site->district_id=$row['saq_district_id'];
            $site->district_name=$row['district_name'];
            $site->ds_id=$row['saq_ds_id'];
            $site->ds_name=$row['ds_name'];
            $site->la_id=$row['saq_la_id'];
            $site->police_station_id=$row['saq_police_station_id'];
            $site->police_station_name=$row['police_station_name'];
            $site->region_id=$row['saq_region_id'];
            $site->region_name=$row['region_name'];
            array_push($result, $site);
        }
        return $result;
    }
    
    // check site have sample images
    public function getSiteImage($saq_site_id) {
        $string = "SELECT * FROM `saq_site_images` WHERE `saq_sites_id` = $saq_site_id;";
        $result = dbQuery($string);
        if(dbNumRows($result)>0) {
            return true;
        } else {
            return false;
        }
    }
    
    // check site have sample agreements
}
?>
