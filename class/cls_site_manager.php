<?php

session_start();
include_once 'cls_site.php';
include_once 'database.php';

include_once 'constants.php';
include_once 'cls_saq_employee.php';
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

    public function serchSite($name, $region_id, $radius, $code) {
        $result = array();
        $ary_sql = array();
        if ($name != "") {
            array_push($ary_sql, "t1.name LIKE '%$name%'");
        }
        if ($code != "") {
            array_push($ary_sql, "t1.code LIKE '%$code%'");
        }
        if ($region_id != "") {
            array_push($ary_sql, "t1.saq_region_id='$region_id'");
        }
        if (!empty($ary_sql)) {
            $where = implode(" AND ", $ary_sql);
        } else {
            if ($_SESSION['UROLE'] == constants::$system_admin || $_SESSION['UROLE'] == constants::$admin) {
                $where = "t1.status_delete = " . constants::$active . " AND t1.id>0 ORDER BY t1.id DESC";
            } else {
                $emp_id = $_SESSION['EID'];
                $employee_obj = new saq_employee($emp_id);
                $employee_obj->getData();
                $employee_districts = $employee_obj->districts;
                if(count($employee_districts)>0) {
                    $district_where_value = implode(',', $employee_districts);
                    $where = "t1.status_delete = " . constants::$active . " AND t1.id>0 AND t1.saq_district_id IN ($district_where_value) ORDER BY t1.id DESC";
                } else {
                    return $result;

                }
                
            }
        }
        $str = "SELECT DISTINCT t1.id,t1.*,t2.name as district_name,t3.name as ds_name,t4.name as la_name,t5.name as police_station_name,"
                . "t6.name as region_name,t7.name as status_name,t8.ownership FROM saq_sites as t1 left join saq_district as t2 on t1.saq_district_id=t2.id "
                . "left join saq_ds as t3 on t1.saq_ds_id=t3.id left join saq_la as t4 on t1.saq_la_id=t4.name "
                . "left join saq_police_station as t5 on t1.saq_police_station_id=t5.id "
                . "left join saq_region as t6 on t1.saq_region_id=t6.id left join saq_sites_status as t7 on t1.saq_sites_status_id=t7.id "
                . "LEFT JOIN saq_site_ownership AS t8 ON t1.saq_site_ownership_id = t8.id left join saq_employee_has_saq_district AS t9 ON t2.id = t9.saq_district_id"
                . " WHERE " . $where;
//        print $str;
        $res = dbQuery($str);
        while ($row = dbFetchAssoc($res)) {
            //print_r($row);
            $site = new site($row['id']);
            $site->id = $row['id'];
            $site->status = $row['status_name'];
            $site->status_id = $row['saq_sites_status_id'];
            $site->name = $row['name'];
            $site->code = $row['code'];
            $site->type = $row['type'];
            $site->address = $row['address'];
            $site->site_ownership = $row['site_ownership'];
            $site->operator_name = $row['operators_name'];
            $site->tower_height = $row['tower_height'];
            $site->building_height = $row['building_height'];
            $site->land_area = $row['land_area'];
            $site->on_air_date = $row['on_air_date'];
            $site->category = $row['category'];
            $site->lat = $row['lat'];
            $site->lon = $row['lon'];
            $site->access_type = $row['access_type'];
            $site->manual_distance = $row['manual_distance'];
            $site->site_ownership_name = $row['ownership'];
            //
            $site->lo_name = $row['LO_name'];
            $site->lo_address = $row['LO_address'];
            $site->lo_nic_brc = $row['LO_nic_brc'];
            $site->lo_mobile = $row['LO_mobile'];
            $site->lo_land_number = $row['LO_land_number'];
            $site->contact_person_number = $row['contact_number'];
            $site->lo_fax = $row['LO_fax'];
            $site->lo_email = $row['LO_email'];
            $site->district_id = $row['saq_district_id'];
            $site->district_name = $row['district_name'];
            $site->ds_id = $row['saq_ds_id'];
            $site->ds_name = $row['ds_name'];
            $site->la_id = $row['saq_la_id'];
            $site->police_station_id = $row['saq_police_station_id'];
            $site->police_station_name = $row['police_station_name'];
            $site->region_id = $row['saq_region_id'];
            $site->region_name = $row['region_name'];
            array_push($result, $site);
        }
        return $result;
    }

    public function serchNearbySite($radius = 10, $lat, $lon) {
        $result = array();
        if ($lat != "" && $lon != "") {
            $R = 6371;
            // first-cut bounding box (in degrees)
            $maxLat = $lat + rad2deg($radius / $R);
            $minLat = $lat - rad2deg($radius / $R);
            // compensate for degrees longitude getting smaller with increasing latitude
            $maxLon = $lon + rad2deg($radius / $R / cos(deg2rad($lat)));
            $minLon = $lon - rad2deg($radius / $R / cos(deg2rad($lat)));

            $lat = deg2rad($lat);
            $lon = deg2rad($lon);

            $str = "Select id,lat,lon,acos(sin($lat)*sin(radians(lat)) + cos($lat)*cos(radians(lat))*cos(radians(lon)-$lon))*$R As D
	    		From (Select id,lat,lon
	      		From saq_sites
	      		Where lat>$minLat And lat<$maxLat
	        	And lon>$minLon And lon<$maxLon
	      		) As FirstCut 
	    		Where id>'1' AND acos(sin($lat)*sin(radians(lat)) + cos($lat)*cos(radians(lat))*cos(radians(lon)-$lon))*$R < $radius
	    		Order by D";
            //print $str;
            $res = dbQuery($str);
            $ary_ids = array();
            while ($row = dbFetchAssoc($res)) {
                array_push($ary_ids, $row['id']);
            }
            if (!empty($ary_ids)) {
                $str = "SELECT t1.*,t2.name as district_name,t3.name as ds_name,t4.name as la_name,t5.name as police_station_name,"
                        . "t6.name as region_name,t7.name as status_name FROM saq_sites as t1 left join saq_district as t2 on t1.saq_district_id=t2.id "
                        . "left join saq_ds as t3 on t1.saq_ds_id=t3.id left join saq_la as t4 on t1.saq_la_id=t4.name "
                        . "left join saq_police_station as t5 on t1.saq_police_station_id=t5.id "
                        . "left join saq_region as t6 on t1.saq_region_id=t6.id left join saq_sites_status as t7 on t1.saq_sites_status_id=t7.id"
                        . " WHERE t1.id IN(" . implode(",", $ary_ids) . ");";

                //print $str;
                $res = dbQuery($str);
                while ($row = dbFetchAssoc($res)) {
                    //print_r($row);
                    $site = new site($row['id']);
                    $site->id = $row['id'];
                    $site->status = $row['status_name'];
                    $site->status_id = $row['saq_sites_status_id'];
                    $site->name = $row['name'];
                    $site->code = $row['code'];
                    $site->type = $row['type'];
                    $site->address = $row['address'];
                    $site->site_ownership = $row['site_ownership'];
                    $site->operator_name = $row['operators_name'];
                    $site->tower_height = $row['tower_height'];
                    $site->building_height = $row['building_height'];
                    $site->land_area = $row['land_area'];
                    $site->on_air_date = $row['on_air_date'];
                    $site->category = $row['category'];
                    $site->lat = $row['lat'];
                    $site->lon = $row['lon'];
                    $site->access_type = $row['access_type'];
                    $site->manual_distance = $row['manual_distance'];
                    //
                    $site->lo_name = $row['LO_name'];
                    $site->lo_address = $row['LO_address'];
                    $site->lo_nic_brc = $row['LO_nic_brc'];
                    $site->lo_mobile = $row['LO_mobile'];
                    $site->lo_land_number = $row['LO_land_number'];
                    $site->contact_person_number = $row['contact_number'];
                    $site->lo_fax = $row['LO_fax'];
                    $site->lo_email = $row['LO_email'];
                    $site->district_id = $row['saq_district_id'];
                    $site->district_name = $row['district_name'];
                    $site->ds_id = $row['saq_ds_id'];
                    $site->ds_name = $row['ds_name'];
                    $site->la_id = $row['saq_la_id'];
                    $site->police_station_id = $row['saq_police_station_id'];
                    $site->police_station_name = $row['police_station_name'];
                    $site->region_id = $row['saq_region_id'];
                    $site->region_name = $row['region_name'];
                    array_push($result, $site);
                }
            }
        } else {
            
        }
        return $result;
    }

    public function getSiteIDFromCode($code) {
        $str = "SELECT id from saq_sites WHERE code='$code';";
//        print $str;
        $result = dbQuery($str);
        if (dbNumRows($result) > 0) {
            $row = dbFetchArray($result);
            return $row[0];
        } else {
            return false;
        }
    }

    // check site have sample agreements
}

?>
