<?php
session_start();
include_once '../class/cls_site.php';

$site_obj = new site($_REQUEST['id']);
// tab general
$site_obj->code = $_REQUEST['site_code'];
$site_obj->name = $_REQUEST['site_name'];
$site_obj->district_id = $_REQUEST[''];
$site_obj->province_id = $_REQUEST[''];
$site_obj->divisional_secretariat = $_REQUEST['divisional_secretariat'];
$site_obj->local_authority = $_REQUEST['local_authority'];
$site_obj->gs_division = $_REQUEST['gs_division'];
$site_obj->police_station_id = $_REQUEST['police_station'];
$site_obj->dns_office_id = $_REQUEST['dns_region'];
//$site_obj->
$site_obj->site_ownership = $_REQUEST['site_ownership'];
$site_obj->operator_name = $_REQUEST['operator_name'];
$site_obj->other_operator_id = $_REQUEST[''];
$site_obj->type = $_REQUEST['site_type'];
$site_obj->tower_height = $_REQUEST['tower_height'];
$site_obj->building_height = $_REQUEST['building_height'];
$site_obj->land_area = $_REQUEST['land_area'];
$site_obj->status = $_REQUEST['site_status'];
$site_obj->on_air_date = $_REQUEST['on_air_date'];
$site_obj->category = $_REQUEST['site_category'];
$site_obj->lon = $_REQUEST['longitude'];
$site_obj->lat = $_REQUEST['latitude'];
$site_obj->access_type = $_REQUEST['access_type'];
$site_obj->manual_distance = $_REQUEST['manual_distance'];
$site_obj->access_permision_type = $_REQUEST['access_permission_type'];
$site_obj->pg_installation_possibility = $_REQUEST['pg_installation_possibility'];

// tab contact
$site_obj->lo_name = $_REQUEST['land_owner_name'];
$site_obj->lo_email = $_REQUEST['email_address'];
$site_obj->lo_address = $_REQUEST['land_owner_address'];
$site_obj->lo_nic_brc = $_REQUEST['land_owner_nic'];
$site_obj->lo_mobile = $_REQUEST['land_owner_mobile_number'];
$site_obj->contact_person_number = $_REQUEST['contact_person_and_number'];
$site_obj->lo_fax = $_REQUEST['fax'];

switch ($_REQUEST['option']) {
    case 'ADD': 
       
        break;   
    case 'EDIT':        
        $result = $site_obj->update($_REQUEST['tab'], 'WEB');
        if($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;   
    default :
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}
?>