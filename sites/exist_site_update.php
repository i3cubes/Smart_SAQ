<?php

include_once '../class/cls_site.php';
include_once '../class/cls_saq_region.php';
include_once '../class/cls_saq_district.php';
include_once '../class/cls_divisional_secretariat.php';
include_once '../class/cls_saq_local_authority.php';
include_once '../class/cls_police_station.php';
include_once '../class/cls_saq_dns_office.php';
include_once '../class/cls_saq_site_category.php';
include_once '../class/cls_site_manager.php';

$saq_sites_obj = new site();
$sites = $saq_sites_obj->getAll();

$delimiter = ",";
$filename = "update_sites.csv";

//create a file pointer
$f = fopen('php://memory', 'w');

//set column headers
$fields = array(
    'Site Code',
    'Site Name',
    'Site Type',
    'Site Address',
    'Site Ownership',
    'Operators Name',
    'Tower Height',
    'Building Height',
    'Land Area',
    'On Air Date',
    'Category',
    'Longitude',
    'Latitude',
    'Access Type',
    'Manual Distance',
    'Access Permission Type',
    'PG Installation Possibility',
    'Region',
    'Region ID',
    'District',
    'District ID',
    'Div Sec ID',
    'Local Authority ID',
    'Police Station ID',
    'DNS Office ID',
    'Current Status',
    'SAQ Special Comment');
fputcsv($f, $fields, $delimiter);

//output each row of the data, format line as csv and write to file pointer
foreach ($sites as $s) {
    
    if ($s['saq_site_category_id'] != '' && $s['saq_site_category_id'] != 0) {
        $site_category_obj = new saq_site_category($s['saq_site_category_id']);
        $site_category_obj->getData();
    }
    if ($s['saq_region_id'] != '' && $s['saq_region_id'] != 0) {
        $region_obj = new saq_region($s['saq_region_id']);
        $region_obj->getData();
    }
    if ($s['saq_district_id'] != '' && $s['saq_district_id'] != 0) {
        $district_obj = new saq_district($s['saq_district_id']);
        $district_obj->getData();
    }
    if ($s['saq_ds_id'] != '' && $s['saq_ds_id'] != 0) {
        $ds_obj = new saq_ds($s['saq_ds_id']);
        $ds_obj->getData();
    }    
    if ($s['saq_la_id'] != '' && $s['saq_la_id'] != 0) {
        $la_obj = new saq_la($s['saq_la_id']);
        $la_obj->getData();
    }    
    if ($s['saq_police_station_id'] != '' && $s['saq_police_station_id'] != 0) {
        $ps_obj = new saq_police_station($s['saq_police_station_id']);
        $ps_obj->getData();
    }
    if ($s['saq_dns_office_id'] != '' && $s['saq_dns_office_id'] != 0) {
        $dns_office_obj = new saq_dns_office($s['saq_dns_office_id']);
        $dns_office_obj->getData();
    }   
    $lineData = array(
        $s['code'],
        $s['name'],
        $s['type'],
        $s['address'],
        $s['site_ownership'],
        $s['operators_name'],
        $s['tower_height'],
        $s['building_height'],
        $s['land_area'],
        $s['on_air_date'],
        $site_category_obj->id,
        $s['lon'],
        $s['lat'],
        $s['access_type'],
        $s['manual_distance'],
        $s['access_permission_type'],
        $s['PG_installation_possibility'],
        $region_obj->name,
        $region_obj->id,
        $district_obj->name,
        $district_obj->id,
        $ds_obj->id,
        $la_obj->id,
        $ps_obj->id,
        $dns_office_obj->id,
        $s['status'],
        ''
    );
    fputcsv($f, $lineData, $delimiter);
}

//move back to beginning of file
fseek($f, 0);

//set headers to download file rather than displayed
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";');
//output all remaining data on a file pointer
fpassthru($f);
?>