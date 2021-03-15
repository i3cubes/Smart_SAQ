<?php
session_start();

//error_reporting();
//ini_set("display_errors", 1);
//print_r($_SESSION);
//initilize the page
require_once("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)
//require_once("../inc/config.ui.php");



/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

/* ---------------- END PHP Custom Scripts ------------- */
include_once '../class/constants.php';
include_once '../class/cls_site.php';

if ($_REQUEST['id'] != 0) {
    $site_obj = new site($_REQUEST['id']);
    $site_obj->getData();
    $rm_id = $site_obj->regional_manager_id;
    $gn_division_id = $site_obj->gs_division;
    $saq_officer = $site_obj->saq_region_employee_id;
    $dns_officer = $site_obj->saq_dns_employee_id;
    $site_ownership = $site_obj->site_ownership;
    $operator_id = $site_obj->operator_name;
    $site_type = $site_obj->type;
    $category = $site_obj->category;
    $access_type = $site_obj->access_type;
    $access_permission_id = $site_obj->access_permision_type;
    $dns_deport = $site_obj->dns_deport;
//    print_r($site_obj);
} else {
    $site_obj = new site('');
}
$page_title = $site_obj->code;
//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
//$page_css[] = "your_style.css";
//include("../inc/header.php");
include("../inc/header_less.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["site_management"]["active"] = true;
//include("../inc/nav.php");
// ====================== LOGIC ================== --!>

include_once '../class/cls_saq_technical.php';
include_once '../class/cls_saq_other_operator.php';
include_once '../class/cls_saq_approvals.php';
include_once '../class/cls_saq_district.php';
include_once '../class/cls_saq_province.php';
include_once '../class/cls_divisional_secretariat.php';
include_once '../class/cls_saq_local_authority.php';
include_once '../class/cls_saq_local_authority.php';
include_once '../class/cls_police_station.php';
include_once '../class/cls_saq_region.php';
include_once '../class/cls_saq_employee.php';
include_once '../class/cls_saq_sites_status.php';
include_once '../class/ngs_date.php';
$ngs_date = new ngs_date();
?>
<style>
    .customFiled {
        margin-bottom: 10px;
    }

    /* Paste this css to your style sheet file or under head tag */
    /* This only works with JavaScript, 
    if it's not present, don't show loader */
    .no-js #loader { display: block;  }
    .js #loader { display: block; position: absolute; left: 100px; top: 0; }
    .se-pre-con {
        position: absolute;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url(../img/Preloader_11.gif) center no-repeat #fff;
    }
    #site_assessment_data {
        display: none;
    }
</style>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main" style="margin-left: 10px;"> 

    <!-- MAIN CONTENT -->
    <div id="content">


        <!-- widget grid -->
        <section id="widget-grid" class="">


            <!-- START ROW -->

            <div class="row">

                <!-- NEW COL START -->

                <!-- END COL -->

                <!-- NEW COL START -->
                <article class="col-sm-12 col-md-12 col-lg-12">

                    <!-- Widget ID (each widget will need unique ID)-->
                    <div class="jarviswidget" 
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">

                        <header style="margin:0px;">
                            <h2 style=""><b>Site Code: <?php print $site_obj->code ?> &nbsp;Site name: <?php print $site_obj->name ?></b></h2> 
                        </header>

                        <!-- widget div-->
                        <div>

                            <!-- widget content -->
                            <div class="widget-body">
                                <div id="main_tab">
                                    <div class="se-pre-con"></div>
                                    <ul id="" class="nav nav-tabs tabs-pull-left bordered">
                                        <li class="active">
                                            <a href="#general" data-toggle="tab" aria-expanded="true">General</a>
                                        </li>
                                        <li class="">
                                            <a href="#contact" data-toggle="tab" aria-expanded="true">Contact Data</a>
                                        </li>
                                        <li>
                                            <a href="#technical" data-toggle="tab" aria-expanded="false">Technical</a>
                                        </li>
                                        <li>
                                            <a href="#agreement" data-toggle="tab" aria-expanded="false">Agreements & Payments</a>
                                        </li>
                                        <li>
                                            <a href="#approvals" data-toggle="tab" aria-expanded="false">Approvals</a>
                                        </li>
                                        <!--                                        <li>
                                                                                    <a href="#tasks" data-toggle="tab" aria-expanded="false">Tasks</a>
                                                                                </li>-->
                                    </ul>
                                    <div id="" class="tab-content">
                                        <div class="tab-pane fade active in" id="general">
                                            <form class="smart-form" id="general_form" onsubmit="saveHandler(event, 'general_form')">
                                                <fieldset>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Site Code
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="site_code" id="site_code" value="<?php print $site_obj->code; ?>"/>
                                                        </label>
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Site Name
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="site_name" id="site_name" value="<?php print $site_obj->name; ?>"/>
                                                        </label>
                                                    </section> 

                                                    <div class="row">
                                                        <section class="col-sm-5">
                                                            <label class="ngs_form_label">
                                                                Site Address
                                                            </label>
                                                            <label class="input">
                                                                <input type="text" name="site_address" id="site_address" value="<?php print $site_obj->address; ?>"/>
                                                            </label>
                                                        </section>
                                                    </div>                                                                                                        

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            District
                                                        </label>
                                                        <label class="select"><i class="icon-append fa fa-user"></i>
                                                            <select name="district_id" id="district_id">
                                                                <?php
                                                                $saq_district_obj = new saq_district('');
                                                                $districts = $saq_district_obj->getAll();
//                                                                print_r($districts);
                                                                if (count($districts) > 0) {
                                                                    foreach ($districts as $district) {
                                                                        print "<option value='$district->id' " . (($site_obj->district_id == $district->id) ? "selected=''" : "") . ">$district->name</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            <!--<input type="text" name="district" id="district" value="<?php print $site_obj->district_name; ?>"/>-->
                                                        </label>
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Province
                                                        </label>
                                                        <label class="select"><i class="icon-append fa fa-user"></i>
                                                            <select name="province_id" id="province_id">
                                                                <?php
                                                                $saq_province_obj = new saq_province('');
                                                                $provinces = $saq_province_obj->getAll();
//                                                                print_r($districts);
                                                                if (count($provinces) > 0) {
                                                                    foreach ($provinces as $province) {
                                                                        print "<option value='$province->id' " . (($site_obj->province_id == $province->id) ? "selected=''" : "") . ">$province->name</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>                                                            
                                                        </label>
                                                        <!--                                                        <label class="input">
                                                                                                                    <input type="text" name="province" id="province" value=""/>
                                                                                                                </label>-->
                                                    </section>  

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Divisional Secretariat
                                                        </label>
                                                        <label class="select"><i class="icon-append fa fa-user"></i>
                                                            <select name="ds_id" id="ds_id">
                                                                <?php
                                                                $ds_obj = new saq_ds('');
                                                                $dss = $ds_obj->getAll();
//                                                                print_r($districts);
                                                                if (count($dss) > 0) {
                                                                    foreach ($dss as $ds) {
                                                                        print "<option value='$ds->id' " . (($site_obj->ds_id == $ds->id) ? "selected=''" : "") . ">$ds->name</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>                                                            
                                                        </label>
                                                        <!--                                                        <label class="input">
                                                                                                                    <input type="text" name="divisional_secretariat" id="divisional_secretariat"/>
                                                                                                                </label>-->
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Local Authority
                                                        </label>
                                                        <label class="select"><i class="icon-append fa fa-user"></i>
                                                            <select name="la_id" id="la_id">
                                                                <?php
                                                                $la_obj = new saq_la('');
                                                                $las = $la_obj->getAll();
//                                                                print_r($districts);
                                                                if (count($las) > 0) {
                                                                    foreach ($las as $la) {
                                                                        print "<option value='$la->id' " . (($site_obj->la_id == $la->id) ? "selected=''" : "") . ">$la->name</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>                                                            
                                                        </label>
                                                        <!--                                                        <label class="input">
                                                                                                                    <input type="text" name="local_authority" id="local_authority"/>
                                                                                                                </label>-->
                                                    </section> 
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            GS Division
                                                        </label>
                                                        <label class="select"><i class="icon-append fa fa-user"></i>
                                                            <select name="gs_division" id="gs_division">
                                                              
                                                               
                                                            </select>                                                            
                                                        </label>
                                                        <!--                                                        <label class="input">
                                                                                                                    <input type="text" name="local_authority" id="local_authority"/>
                                                                                                                </label>-->
                                                    </section> 

<!--                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            GS Division
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="gs_division" id="gs_division"/>
                                                        </label>
                                                    </section>-->
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Police Station
                                                        </label>
                                                        <label class="select"><i class="icon-append fa fa-user"></i>
                                                            <select name="police_station_id" id="police_station_id">
                                                                <?php
                                                                $ps_obj = new saq_police_station('');
                                                                $pss = $ps_obj->getAll();
//                                                                print_r($districts);
                                                                if (count($pss) > 0) {
                                                                    foreach ($pss as $ps) {
                                                                        print "<option value='$ps->id' " . (($site_obj->police_station_id == $ps->id) ? "selected=''" : "") . ">$ps->name</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>                                                            
                                                        </label>
                                                        <!--                                                        <label class="input">
                                                                                                                    <input type="text" name="police_station" id="police_station" value="<?php print $site_obj->police_station_name; ?>"/>
                                                                                                                </label>-->
                                                    </section> 

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            DNS Region
                                                        </label>
                                                        <label class="select"><i class="icon-append fa fa-user"></i>
                                                            <select name="region_id" id="region_id">
                                                                <?php
                                                                $region_obj = new saq_region('');
                                                                $regions = $region_obj->getAll();
//                                                                print_r($districts);
                                                                if (count($regions) > 0) {
                                                                    foreach ($regions as $region) {
                                                                        print "<option value='$region->id' " . (($site_obj->region_id == $region->id) ? "selected=''" : "") . ">$region->name</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>                                                            
                                                        </label>
                                                        <!--                                                        <label class="input">
                                                                                                                    <input type="text" name="dns_region" id="gs_division"/>
                                                                                                                </label>-->
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            DNS Deport
                                                        </label>
                                                        <label class="select"><i class="icon-append fa fa-user"></i>
                                                            <select name="dns_deport" id="dns_deport">
                                                              
                                                            </select>                                                            
                                                        </label>
<!--                                                        <label class="input">
                                                            <input type="text" name="dns_deport" id="dns_deport" value="<?php print $site_obj->dns_deport ?>"/>
                                                        </label>-->
                                                    </section> 

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            RM Name
                                                        </label>
                                                        <label class="select"><i class="icon-append fa fa-user"></i>
                                                            <select name="rm_id" id="rm_id">
                                                                
                                                                
                                                            </select>                                                            
                                                        </label>
                                                        <!--label class="input">
                                                            <?php
                                                            if ($site_obj->region_id != 0 && $site_obj->region_id != '') {
                                                                $region_obj = new saq_region($site_obj->region_id);
                                                                $region_obj->getData();
                                                                if ($region_obj->manager_id != '') {
                                                                    $emp_obj = new saq_employee($region_obj->manager_id);
                                                                    $emp_obj->getData();
                                                                }
                                                            }
                                                            ?>
                                                            <input type="text" name="rm_name" id="rm_name" value="<?php print $emp_obj->name ?>" disabled=""/>
                                                        </label-->
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            SAQ Officer Name
                                                        </label>
                                                        <?php //echo $site_obj->region_id ?>
                                                        <label class="select"><i class="icon-append fa fa-user"></i>
                                                            <select name="select_saq_officer_id" id="select_saq_officer_id">
                                                                
                                                                
                                                            </select>                                                            
                                                        </label>
<!--                                                        <label class="input">
                                                            <?php
                                                            if ($site_obj->region_id != 0 && $site_obj->region_id != '') {
                                                                $region_id = $site_obj->region_id;
                                                                $region_obj = new saq_region($site_obj->region_id);
                                                                $regionEmployee = $region_obj->getRegionEmployees();
                                                                foreach ($regionEmployee as $emp) {
                                                                    $stringRegionEmployee .= $emp->name . ' ';
                                                                }
                                                            }
                                                            ?>
                                                            <input type="text" name="saq_officer_name" id="saq_officer_name" disabled="" value="<?php print $stringRegionEmployee ?>"/>
                                                        </label>-->
                                                    </section>

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            DNS Officer Name
                                                        </label>
                                                        <label class="select"><i class="icon-append fa fa-user"></i>
                                                            <select name="dns_officer_id" id="dns_officer_id">
                                                                
                                                                ?>
                                                            </select>                                                            
                                                        </label>
                                                        <!--label class="input">                                                            
                                                            <input type="text" name="dns_officer_name" id="dns_officer_name" disabled="" value=""/>
                                                        </label-->
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Site Ownership
                                                        </label>
                                                        <label class="select"><i class="icon-append fa fa-user"></i>
                                                            <select name="site_ownership" id="site_ownership">
                                                             
                                                            </select>                                                            
                                                        </label>
<!--                                                        <label class="input">
                                                            <input type="text" name="site_ownership" id="site_ownership" value="<?php print $site_obj->site_ownership; ?>"/>
                                                        </label>-->
                                                    </section>

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Operator's Name
                                                        </label>
                                                        <label class="select"><i class="icon-append fa fa-user"></i>
                                                            <select name="operator_name" id="operator_name">
                                                             
                                                            </select>                                                            
                                                        </label>
<!--                                                        <label class="input">
                                                            <input type="text" name="operator_name" id="operator_name" value="<?php print $site_obj->operator_name; ?>"/>
                                                        </label>-->
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Other Operator ID
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="other_operator_id" id="other_operator_id" value="<?php print $site_obj->other_operator_id; ?>"/>
                                                        </label>
                                                    </section>

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Site Type
                                                        </label>
                                                        <label class="select"><i class="icon-append fa fa-user"></i>
                                                            <select name="site_type" id="site_type">
                                                             
                                                            </select>                                                            
                                                        </label>

                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Tower Height (m)
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="tower_height" id="tower_height" value="<?php print $site_obj->tower_height; ?>"/>
                                                        </label>
                                                    </section>

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Building Height (m)
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="building_height" id="building_height" value="<?php print $site_obj->building_height; ?>"/>
                                                        </label>
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Land Area (P)
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="land_area" id="land_area" value="<?php print $site_obj->land_area; ?>"/>
                                                        </label>
                                                    </section>

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Site Status
                                                        </label>                                                        
                                                        <label class="select"><i class="icon-append fa fa-user"></i>
                                                            <select name="site_status" id="site_status">
                                                        <?php
                                                        $saq_sites_status_obj = new saq_sites_status();
                                                        $site_statuses = $saq_sites_status_obj->getAll();
                                                        var_dump($site_obj->status);
                                                        foreach ($site_statuses as $status) {
                                                            print "<option value='$status->id' " . (($site_obj->status_id == $status->id) ? "selected=''" : "") . ">$status->name</option>";
                                                        }
                                                        ?>
                                                            </select>                                                            
                                                        </label>
<!--                                                        <label class="input">
                                                            <input type="text" name="site_status" id="site_status" value="<?php // print $site_obj->status; ?>"/>
                                                        </label>-->
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            On Air Date
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" placeholder="dd/mm/yyyy" name="on_air_date" id="on_air_date" value="<?php if($site_obj->on_air_date=="" || $site_obj->on_air_date ==null){} else {print $ngs_date->transform_date_back($site_obj->on_air_date);} ?>"/>
                                                        </label>
                                                    </section>

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Longitude
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="longitude" id="longitude" value="<?php print $site_obj->lon; ?>"/>
                                                        </label>
                                                    </section>                                                   
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Site Category
                                                        </label>
                                                        <label class="select"><i class="icon-append fa fa-user"></i>
                                                         <select name="site_category" id="site_category">
                                                             
                                                            </select> 
                                                        </label>
<!--                                                        <label class="input">
                                                            <input type="text" name="site_category" id="site_category" value="<?php print $site_obj->category; ?>"/>
                                                        </label>-->
                                                    </section>


                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Latitude
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="latitude" id="latitude" value="<?php print $site_obj->lat; ?>"/>
                                                        </label>
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Access Type
                                                        </label>
                                                        <label class="select"><i class="icon-append fa fa-user"></i>
                                                         <select name="access_type" id="access_type">
                                                             
                                                            </select> 
                                                        </label>
<!--                                                        <label class="input">
                                                            <input type="text" name="access_type" id="access_type" value="<?php print $site_obj->access_type; ?>"/>
                                                        </label>-->
                                                    </section>

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Manual Distance (KM)
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="manual_distance" id="manual_distance" value="<?php print $site_obj->manual_distance; ?>"/>
                                                        </label>
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Access Permission Type
                                                        </label>
                                                        <label class="select"><i class="icon-append fa fa-user"></i>
                                                         <select name="access_permission_type" id="access_permission_type">
                                                             
                                                            </select> 
                                                        </label>
<!--                                                        <label class="input">
                                                            <input type="text" name="access_permission_type" id="access_permission_type" value="<?php print $site_obj->access_permision_type; ?>"/>
                                                        </label>-->
                                                    </section>

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            PG Installation Possibility
                                                        </label>                                                        
                                                        <label class="select"><i class="icon-append fa fa-user"></i>
                                                            <select name="pg_installation_possibility" id="pg_installation_possibility">
                                                                <option value="yes" <?php print (($site_obj->pg_installation_possibility == 'yes') ? "selected=''" : "") ?>>Yes</option>
                                                                <option value="no" <?php print (($site_obj->pg_installation_possibility == 'no') ? "selected=''" : "") ?>>No</option>
                                                            </select>                                                            
                                                        </label>
                                                    </section>   
                                                    <section class="col-sm-12">                                                         
                                                        <input type="hidden" name="tab" value="G" />                                                        
                                                        <button class="btn btn-primary btn-xs" onclick="" style="float:right;">Save &nbsp;<i class="fa fa-save"></i></button>
                                                    </section>
                                                </fieldset>
                                            </form>
                                        </div>                                    
                                        <div class="tab-pane fade active in" id="contact">
                                            <form class="smart-form" id="contact_form" onsubmit="saveHandler(event, 'contact_form')">
                                                <fieldset>                                                
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Land Owner Name
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="land_owner_name" id="land_owner_name" value="<?php print $site_obj->lo_name; ?>"/>
                                                        </label>
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Land Owner address
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="land_owner_address" id="land_owner_address" value="<?php print $site_obj->lo_address; ?>"/>
                                                        </label>
                                                    </section>  

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Land Owner NIC/BRC
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="land_owner_nic" id="land_owner_nic" value="<?php print $site_obj->lo_nic_brc; ?>"/>
                                                        </label>
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Land Owner Mobile Number
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="land_owner_mobile_number" id="land_owner_mobile_number" value="<?php print $site_obj->lo_mobile; ?>"/>
                                                        </label>
                                                    </section> 

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Land Owner Land Number
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="land_owner_land_number" id="land_owner_nic" value="<?php print $site_obj->lo_land_number; ?>"/>
                                                        </label>
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Contact Person and Number
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="contact_person_and_number" id="contact_person_and_number" value="<?php print $site_obj->contact_person_number; ?>"/>
                                                        </label>
                                                    </section> 

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Fax
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="fax" id="fax" value="<?php print $site_obj->lo_fax; ?>"/>
                                                        </label>
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Email Address
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="email_address" id="email_address" value="<?php print $site_obj->lo_email; ?>"/>
                                                        </label>
                                                    </section> 
                                                    <section class="col-sm-12">                                                        
                                                        <input type="hidden" name="tab" value="C" />                                                        
                                                        <button class="btn btn-primary btn-xs" style="float:right;">Save &nbsp;<i class="fa fa-save"></i></button>
                                                    </section>
                                                </fieldset>
                                            </form>
                                        </div>                                    
                                        <div class="tab-pane fade active in" id="technical">
                                            <form class="smart-form" id="technical_form" onsubmit="saveHandler(event, 'technical_form')">
                                                <fieldset>
                                                    <!--button class="btn btn-primary" style="float:right;" type="button" onclick="addEditTechnology()">Add&nbsp;<i class="fa fa-plus-square"></i></button-->
                                                    <table class="table">
                                                        <thead>
                                                        <th>Technology</th>
                                                        <?php
                                                        $technology_obj = new saq_technical();
                                                        $technologies = $technology_obj->getAll();
//                                                            print_r($technologies);
                                                        foreach ($technologies as $tech) {
                                                            print "<th align='center'>$tech->technology"
                                                                    . "&nbsp;<!--button class='btn btn-success' type='button' onclick='addEditTechnology(".$tech->id.")'>Edit&nbsp;<i class='fa fa-edit'></i></button-->"
                                                                    . "</th>";
                                                        }
                                                        ?>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Dialog</td>
                                                                <?php
                                                                foreach ($technologies as $tech) {
//                                                                    var_dump($checkAvailable);
                                                                    if ($site_obj->id != '') {
                                                                        $checkAvailable = $site_obj->getTechnologyPresentSite($tech->id);
                                                                    }
                                                                    print "<td align='center'>
                                                                    <label class='checkbox'>
                                                                        <input type='checkbox' name='technologies' id='$tech->id' value='$tech->id' " . (($checkAvailable == true) ? "checked=''" : "") . ">
                                                                        <i></i>
                                                                    </label>
                                                                </td>";
                                                                }
                                                                ?>                                                               
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <br />
                                                    <h5>Other operators</h5>
                                                    <br />
                                                    <!--button class="btn btn-primary" style="float:right;" type="button" onclick="addEditOtherOperator()">Add&nbsp;<i class="fa fa-plus-square"></i></button-->
                                                    <table class="table">
                                                        <thead>
                                                        <th>Operator</th>
                                                        <th width="5%">Present</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $saq_other_operator_obj = new saq_other_operator();
                                                            $other_operators = $saq_other_operator_obj->getAll();

                                                            foreach ($other_operators as $operator) {
                                                                if ($site_obj->id != '') {
                                                                    $checkAvailable = $site_obj->getOtherOperatorPresentSite($operator->id);
                                                                }

                                                                print "<tr>"
                                                                        . "<td style='padding:10px;'>"
                                                                            . "$operator->name"
                                                                            . "&nbsp;<!--button class='btn btn-success' type='button' onclick='addEditOtherOperator(".$operator->id.")'>Edit&nbsp;<i class='fa fa-edit'></i></button-->"
                                                                        . "</td>"
                                                                        . "<td align='center'>
                                                                    <label class='checkbox'>
                                                                        <input type='checkbox' name='other_operators' id='$operator->id' value='$operator->id' " . (($checkAvailable) ? "checked=''" : "") . ">
                                                                        <i></i>
                                                                    </label>
                                                                </td></tr>";
                                                            }
                                                            ?>                                                            
                                                        </tbody>
                                                    </table>
                                                    <br />
                                                    <br />
                                                    <section class="col-12">                                                                                                                
                                                        <input type="hidden" name="tab" value="T" />                                                        
                                                        <button class="btn btn-primary btn-xs" onclick="" style="float:right;">Save &nbsp;<i class="fa fa-save"></i></button>
                                                    </section>
                                                </fieldset>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade active in" id="agreement">
                                            <form class="smart-form" id="agreement_form" onsubmit="saveHandler(event, 'agreement_form')">
                                                <?php
                                                if ($site_obj->id != '') {
                                                    $agreement_data_obj = $site_obj->getSiteAgreementData();
                                                }
//                                                var_dump($agreement_data_obj);
    //                                                    
                                                ?>
                                                <fieldset>
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <td>Site ID</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="site_id" id="site_id" value="<?php print $site_obj->code ?>"/>
                                                                </label>
                                                            </td>
                                                            <td>Site Name</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="site_name" id="site_name" value="<?php print $site_obj->name ?>"/>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Agreement Status</td>
                                                            <td>
                                                                <label class="select"><i class="icon-append fa fa-user"></i>
                                                                    <select name="agreement_status" id="agreement_status">
                                                                        <option value="active" <?php print (($agreement_data_obj->agreement_status == 'active') ? "selected=''" : '') ?>>ACTIVE</option>
                                                                        <option value="inactive" <?php print (($agreement_data_obj->agreement_status == 'inactive') ? "selected=''" : '') ?>>INACTIVE</option>
                                                                    </select>                                                                    
                                                                </label>
                                                            </td>
                                                            <td>Agreement Expire Date</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="agreement_expire_date" id="agreement_expire_date" value="<?php if($site_obj->on_air_date=="" || $site_obj->on_air_date ==null){} else {print $ngs_date->transform_date_back($agreement_data_obj->date_expire);}  ?>"/>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Agreement Start Date</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="agreement_start_date" id="agreement_start_date" value="<?php if($site_obj->on_air_date=="" || $site_obj->on_air_date ==null){} else {print $ngs_date->transform_date_back($agreement_data_obj->date_start);}  ?>"/>
                                                                </label>
                                                            </td>
                                                            <td>Payment Mode</td>
                                                            <td>
                                                                <label class="select"><i class="icon-append fa fa-user"></i>
                                                                    <select name="payment_mode" id="payment_mode">
                                                                        <option value="month" <?php print (($agreement_data_obj->payment_mode == 'month') ? "selected=''":'') ?>>Monthly</option>
                                                                        <option value="year" <?php print (($agreement_data_obj->payment_mode == 'year') ? "selected=''":'') ?>>Annually</option>
                                                                    </select>                                                                    
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Lease Period (Months)</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="number" name="leas_period" id="leas_period" value="<?php print $agreement_data_obj->lease_period ?>"/>
                                                                </label>
                                                            </td>
                                                            <td>Current Month Payment (LKR / RS)</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="number" name="current_month_payment" id="current_month_payment" value="<?php print $agreement_data_obj->current_month_payment ?>"/>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Start Monthly Rental (LKR / RS)</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="number" name="start_monthly_rental" id="start_monthly_rental" value="<?php print $agreement_data_obj->start_monthly_rental ?>"/>
                                                                </label>
                                                            </td>
                                                            <td>Monthly Deducting Amount for ADV Recovery</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="mdafar" id="mdafar" value="<?php print $agreement_data_obj->monthly_deduction_for_adv ?>"/>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>RATE Increment (%)</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="number" name="rate_increment" id="rate_increment" value="<?php print $agreement_data_obj->rate_increment ?>"/>
                                                                </label>
                                                            </td>
                                                            <td>Advance Recovery Period (Months)</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="adv_recovery_period" id="adv_recovery_period" value="<?php print $agreement_data_obj->adv_recovery_period ?>"/>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Advance Payment (LKR / RS)</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="number" name="advance_payment" id="advance_payment" value="<?php print $agreement_data_obj->advance_payment ?>"/>
                                                                </label>
                                                            </td>
                                                            <td>Account Holder Name</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="acc_holder_name" id="acc_holder_name" value="<?php print $agreement_data_obj->account_holder_name ?>"/>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Bank Account</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="bank_account" id="bank_account" value="<?php print $agreement_data_obj->bank_account ?>"/>
                                                                </label>
                                                            </td>
                                                            <td>Branch Name</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="branch_name" id="branch_name" value="<?php print $agreement_data_obj->branch_name ?>"/>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Bank Name</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="bank_name" id="bank_name" value="<?php print $agreement_data_obj->bank_name ?>"/>
                                                                </label>
                                                            </td>
                                                            <td>&nbsp;</td>
                                                            <td>
                                                                &nbsp;
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Account Type</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="acc_type" id="acc_type" value="<?php print $agreement_data_obj->account_type ?>"/>
                                                                </label>
                                                            </td>
                                                            <td>&nbsp;</td>
                                                            <td>
                                                                &nbsp;
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Account Holder NIC Number</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="acc_holder_nic_no" id="acc_holder_nic_no" value="<?php print $agreement_data_obj->account_holder_nic ?>"/>
                                                                </label>
                                                            </td>
                                                            <td>&nbsp;</td>
                                                            <td>
                                                                &nbsp;
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Property ID</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="property_id" id="property_id" value="<?php print $agreement_data_obj->property_id ?>"/>
                                                                </label>
                                                            </td>
                                                            <td>&nbsp;</td>
                                                            <td>
                                                                &nbsp;
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <br />
                                                    <button class="btn btn-primary btn-xs" type="button" id="toggleAssessmentData">Show Site Assessment Data</button>
                                                    <table class="table table-bordered" id="site_assessment_data">
                                                        <tr>
                                                            <td>
                                                                <b>Assessment NO</b>                                                                
                                                            </td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="assessment_no" id="assessment_no" value="<?php print $agreement_data_obj->assessment_no ?>"/>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Year</b></td>
                                                            <td align="center">2018</td>
                                                            <td align="center">2019</td>
                                                            <td align="center">2020</td>
                                                            <td align="center">2021</td>
                                                        </tr>
                                                        <?php
                                                        if ($site_obj->id != '') {
                                                            $assessment_info = $site_obj->getSiteAssesmentInfo();
                                                        }

//                                                            print_r($assessment_info);
                                                        ?>
                                                        <tr>
                                                            <td><b>Assessment Tax</b></td>
                                                            <td><label class="input">
                                                                    <input type="text" name="2018" id="2018" value="<?php print $assessment_info[0]->assessment_tax ?>"/>
                                                                </label></td>
                                                            <td><label class="input">
                                                                    <input type="text" name="2019" id="2019" value="<?php print $assessment_info[1]->assessment_tax ?>"/>
                                                                </label></td>
                                                            <td><label class="input">
                                                                    <input type="text" name="2020" id="2020" value="<?php print $assessment_info[2]->assessment_tax ?>"/>
                                                                </label></td>
                                                            <td><label class="input">
                                                                    <input type="text" name="2021" id="2021" value="<?php print $assessment_info[3]->assessment_tax ?>"/>
                                                                </label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Trade Tax</b></td>
                                                            <td><label class="input">
                                                                    <input type="text" name="2018" id="2018" value="<?php print $assessment_info[0]->trade_tax ?>"/>
                                                                    <input type="hidden" name="2018" id="2018" value="<?php print $assessment_info[0]->id ?>"/>
                                                                </label></td>
                                                            <td><label class="input">
                                                                    <input type="text" name="2019" id="2019" value="<?php print $assessment_info[1]->trade_tax ?>"/>
                                                                    <input type="hidden" name="2019" id="2019" value="<?php print $assessment_info[1]->id ?>"/>
                                                                </label></td>
                                                            <td><label class="input">
                                                                    <input type="text" name="2020" id="2020" value="<?php print $assessment_info[2]->trade_tax ?>"/>
                                                                    <input type="hidden" name="2020" id="2020" value="<?php print $assessment_info[2]->id ?>"/>
                                                                </label></td>
                                                            <td><label class="input">
                                                                    <input type="text" name="2021" id="2021" value="<?php print $assessment_info[3]->trade_tax ?>"/>
                                                                    <input type="hidden" name="2021" id="2021" value="<?php print $assessment_info[3]->id ?>"/>
                                                                </label></td>
                                                        </tr>
                                                    </table>
                                                    <br />
                                                    <br />
                                                    <section class="col-12">                                                                                                                
                                                        <input type="hidden" name="agreement_data_id" id="agreement_data_id" value="<?php print $agreement_data_obj->id ?>" />
                                                        <input type="hidden" name="tab" value="P" />                                                        
                                                        <button class="btn btn-primary btn-xs" onclick="" style="float:right;">Save &nbsp;<i class="fa fa-save"></i></button>
                                                    </section>
                                                </fieldset>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade active in" id="approvals">
                                            <form class="smart-form" id='approval_form' onsubmit="saveHandler(event, 'approval_form')">
                                                <fieldset>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <th width="5%"></th>
                                                        <th>Requirement</th>
                                                        <th>Approval Name</th>
                                                        <th>Short Name</th>
                                                        <th align='center'>Availability</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $saq_approvels_obj = new saq_approvals();
                                                            $approvals = $saq_approvels_obj->getAll();

                                                            foreach ($approvals as $approval) {
                                                                if ($site_obj->id != '') {
                                                                    $checkAvailable = $site_obj->getApprovalsPresentSite($approval->id);
                                                                }

                                                                print "<tr " . (($approval->requirement == 'Compulsory') ? "style='background: yellow;'" : "") . ">"
                                                                        . "<td>$approval->id</td>"
                                                                        . "<td>$approval->requirement</td>"
                                                                        . "<td>$approval->description"
                                                                        . "&nbsp;<!--button class='btn btn-success' type='button' onclick='addEditApprovals(".$approval->id.")'>Edit&nbsp;<i class='fa fa-edit'></i></button-->"
                                                                        . "</td>"
                                                                        . "<td>$approval->code</td>"
                                                                        . "<td align='center' width='5%' style='padding: 10px 30px'><label class='checkbox'>"
                                                                        . "<input type='checkbox' name='approvals' id='$approval->id' value='$approval->id' " . (($checkAvailable) ? "checked=''" : "") . "/><i></iS></label></td>"
                                                                        . "</tr>";
                                                            }
                                                            ?>                                                       
                                                        </tbody>
                                                    </table>
                                                    <br />
                                                    <br />
                                                    <section class="col-12">                                                        
                                                        <input type="hidden" name="tab" id='tab' value="A" />                                                        
                                                        <button class="btn btn-primary btn-xs" onclick="" style="float:right;">Save &nbsp;<i class="fa fa-save"></i></button>
                                                    </section>
                                                </fieldset>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade active in" id="tasks">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end widget content -->

                        </div>
                        <!-- end widget div -->

                    </div>
                    <!-- end widget -->

                    <!-- END COL -->		

            </div>

            <!-- END ROW -->          
        </section>
        <!-- end widget grid -->


    </div>
    <!-- END MAIN CONTENT -->


</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->



<?php
//include required scripts
include("../inc/scripts.php");
?>
<script type="text/javascript" src="../jeegoopopup/jquery.jeegoopopup.1.0.0.js"></script>
        <link href="../jeegoopopup/skins/blue/style.css" rel="Stylesheet" type="text/css" />
        <link href="../jeegoopopup/skins/round/style.css" rel="Stylesheet" type="text/css" />
<script type="text/javascript">
    var id = <?php print (($site_obj->id != 0) ? $site_obj->id : 0) ?>;
    var option = '<?php print (($site_obj->id != 0) ? 'EDIT' : 'ADD') ?>';
    console.log(option);
    $(document).ready(function () {
        $("#main_tab").tabs({
            active: 0
        });
        $(".se-pre-con").fadeOut("slow");
        if (id == 0) {
            $("#main_tab").tabs("option", "disabled", [1, 2, 3, 4]);
        }
        $('#on_air_date').datetimepicker({
            timepicker: false,
            format: 'd/m/Y',
            useCurrent: true,
            scrollMonth: false,
            scrollInput: false
        })
        $('#agreement_expire_date').datetimepicker({
            timepicker: false,
            format: 'd/m/Y',
            useCurrent: true,
            scrollMonth: false,
            scrollInput: false
        });
        $('#agreement_start_date').datetimepicker({
            timepicker: false,
            format: 'd/m/Y',
            useCurrent: true,
            scrollMonth: false,
            scrollInput: false
        });
        
        $('#toggleAssessmentData').click(function(){
            if($('#site_assessment_data').css('display') == 'table') {
                $('#site_assessment_data').css('display','none');
                $(this).text('Show Site Assessment Data');
            } else if($('#site_assessment_data').css('display') == 'none') {
                $('#site_assessment_data').css('display','table');
                $(this).text('Hide Site Assessment Data');
            }
        });

        $('#region_id').on('change', function () {
            $.ajax({
                url: '../json/get_region_employee',
                type: 'GET',
                dataType: 'JSON',
                data: {region_id: $(this).val()},
                success: function (response) {
                    if (response['saq_emp'].length > 0) {
                        var string = '';
                        $.each(response['saq_emp'], function (index, data) {
                            string += data['name'];
                        });
                        $('#saq_officer_name').val(string);
                    }
                    if (response['rm_name'] != null) {
                        $('$rm_name').val(response['rm_name']);
                    }
                },
                error: function (xhr, resp, text) {
                    alert("error :" + xhr.responseText);
                }
            });
        });
        
        getGSDivition('<?php echo $gn_division_id?>');
        getsite_type('<?php echo $site_type?>');
        getRm('<?php echo $rm_id?>');
        dnsofficer('<?php echo $dns_officer?>');
        getdepot('<?php echo $dns_deport?>');
        saqManager('<?php echo $site_obj->region_id?>');
        site_category('<?php echo $category?>');
        site_access_type('<?php echo $access_type?>');
        site_permission_type('<?php echo $access_permission_id?>');
        site_ownership('<?php echo $site_ownership?>');
        site_operator('<?php echo $operator_id?>');
        
        
        
        //$rm_id = $site_obj->regional_manager_id;
    //$gn_division_id = $site_obj->gs_division;
    //$saq_officer = $site_obj->saq_region_employee_id;
    //$dns_officer = $site_obj->saq_dns_employee_id;
    //$site_ownership = $site_obj->site_ownership;
   // $operator_id = $site_obj->operator_name;
    //$site_type = $site_obj->type;
    //$category = $site_obj->category;
    //$access_type = $site_obj->access_type;
    //$access_permission_id = $site_obj->access_permision_type;
    });
    
    function addEditTechnology(id = '') {        
        var options = {
            url: 'add_edit_technology?id=' + id,
            width: '600',
            height: '200',
            skinClass: 'jg_popup_round',
            resizable: false,
            scrolling: 'no'
        };
        $.jeegoopopup.open(options);
    }
    
    function addEditOtherOperator(id = '') {
        var options = {
            url: 'add_edit_other_operator?id=' + id,
            width: '600',
            height: '200',
            skinClass: 'jg_popup_round',
            resizable: false,
            scrolling: 'no'
        };
        $.jeegoopopup.open(options);
    }
    
    function addEditApprovals(id = '') {
        var options = {
            url: 'add_edit_approvals?id=' + id,
            width: '600',
            height: '350',
            skinClass: 'jg_popup_round',
            resizable: false,
            scrolling: 'no'
        };
        $.jeegoopopup.open(options);
    }

    function saveHandler(e, form) {
        e.preventDefault();
        var formData;
        if (form == 'technical_form') {
            formData = $(`input[type='checkbox']:checked`).serializeObject();
            formData.option = option;
            formData.id = id;
            formData.tab = 'T';
        } else if (form == 'approval_form') {
            formData = $(`input[type='checkbox']:checked`).serializeObject();
            formData.option = option;
            formData.id = id;
            formData.tab = 'A';
        } else {
            formData = $(`#${form}`).serializeObject();
            formData.id = id;
            formData.option = option;
        }
//        console.log(formData);
//        return false;
        $.ajax({
            url: '../ajax/ajx_saq_site',
            type: 'POST',
            dataType: 'JSON',
            data: formData,
            success: function (response) {
                if (response['msg'] == 1) {
                    $.notify('Successfully updated', 'success');
                    if (id == '') {
                        location.href = 'view';
                    } else {
                        id = response['site_id'];
                        option = ((response['site_id'] != '') ? 'EDIT' : 'ADD');
                        $('#agreement_data_id').val(response['agreement_data_id']);
                    }
                } else {
                    alert('Error occured');
                }
            },
            error: function (xhr, resp, text) {
                alert("error :" + xhr.responseText);
            }
        });
    }
  /*  function selectGNDivision(data) {
             $("#gs_division").select2({
                  //tags: true,
  data: data,
  allowClear: true,
  placeholder: "Product Name",
  query: function(q) {
      var pageSize,
        results,
        that = this;
      pageSize = 20; // or whatever pagesize
      results = [];
      if (q.term && q.term !== '') {
        // HEADS UP; for the _.filter function i use underscore (actually lo-dash) here
        results = _.filter(that.data, function(e) {
          return e.text.toUpperCase().indexOf(q.term.toUpperCase()) >= 0;
        });
      } else if (q.term === '') {
        results = that.data;
      }
      q.callback({
        results: results.slice((q.page - 1) * pageSize, q.page * pageSize),
        more: results.length >= q.page * pageSize,
      });
    },
})
 
}*/
function getGSDivition(id){
    var district_id = $('#district_id').val();
    $.ajax({
            url: '../ajax/ajx_saq_gndivision',
            type: 'POST',
            dataType: 'JSON',
            data: {SID:200,district_id:district_id},
            success: function (response) {
                if (response.result == 1) {
                    var cmb ="";
                    var data  = response.data;
                          

                if(data === undefined || data===null || data.lenght ===0){
                   cmb += "<opton>--NO DATA --</option>"
                }else {
                    cmb +="<option value=''>--SELECT--</option>"
                   $.each(data,function(index,data){
                        if( id === undefined  || id ==""){
                           var selected = ""
                       }else{
                           if(id == data.id){
                               var selected="selected";
                           }else {
                                var selected = ""
                           }
                           
                       }
                       
                       cmb +="<option value='"+data.id+"' "+selected+">"+data.gn_division+"</option>"
                   })
                   
               }
               $('#gs_division').html('').append(cmb);
                } else {
                    //alert('Error occured');
                }
            },
            error: function (xhr, resp, text) {
                alert("error :" + xhr.responseText);
            }
        });
}
function getsite_type(id){
    console.log(id);
    //var district_id = $('#district_id').val();
    $.ajax({
            url: '../ajax/ajx_saq_site_types',
            type: 'POST',
            dataType: 'JSON',
            data: {SID:200},
            success: function (response) {
                if (response.result == 1) {
                    var cmb2 ="";
                    var data  = response.data;
                         

                if(data === undefined || data===null || data.lenght ===0){
                   cmb2 += "<opton>--NO DATA --</option>"
                }else {
                    cmb2 +="<option value=''>--SELECT--</option>"
                   $.each(data,function(index,data){
                       if( id === undefined  || id ==""){
                           var selected = ""
                       }else{
                            if(id == data.id){
                               var selected="selected";
                           }else {
                                var selected = ""
                           }
                           
                       }
                       cmb2 +="<option value='"+data.id+"' "+selected+">"+data.type+"</option>"
                   })
                   
               }
              $('#site_type').html('').append(cmb2);
                } else {
                    
                   cmb2 +="<option value=''>--NO DATA--</option>"
                   $('#site_type').html(cmb2);
                }
                 
            },
            error: function (xhr, resp, text) {
                alert("error :" + xhr.responseText);
            }
        });
}
function getRm(id){
    //var district_id = $('#district_id').val();
    $.ajax({
            url: '../ajax/ajx_saq_employee',
            type: 'POST',
            dataType: 'JSON',
            data: {SID:200,designation_id:'1'},
            success: function (response) {
                if (response.result == 1) {
                    var cmb2 ="";
                    var data  = response.data;
                         

                if(data === undefined || data===null || data.lenght ===0){
                   cmb2 += "<opton>--NO DATA --</option>"
                }else {
                    cmb2 +="<option value=''>--SELECT--</option>"
                   $.each(data,function(index,data){
                       if( id === undefined  || id ==""){
                           var selected = ""
                       }else{
                           if(id == data.id){
                               var selected="selected";
                           }else {
                                var selected = ""
                           }
                       }
                       cmb2 +="<option value='"+data.id+"' "+selected+">"+data.name+"</option>"
                   })
                   
               }
              $('#rm_id').html('').append(cmb2);
                } else {
                    
                   cmb2 +="<option value=''>--NO DATA--</option>"
                   $('#rm_id').html(cmb2);
                }
                 
            },
            error: function (xhr, resp, text) {
                alert("error :" + xhr.responseText);
            }
        });
}
function dnsofficer(id){
    //var district_id = $('#district_id').val();
    $.ajax({
            url: '../ajax/ajx_saq_employee',
            type: 'POST',
            dataType: 'JSON',
            data: {SID:200,designation_id:'2'},
            success: function (response) {
                if (response.result == 1) {
                    var cmb2 ="";
                    var data  = response.data;
                         

                if(data === undefined || data===null || data.lenght ===0){
                   cmb2 += "<opton>--NO DATA --</option>"
                }else {
                    cmb2 +="<option value=''>--SELECT--</option>"
                   $.each(data,function(index,data){
                       if( id === undefined  || id ==""){
                           var selected = ""
                       }else{
                           if(id == data.id){
                               var selected="selected";
                           }else {
                                var selected = ""
                           }
                       }
                       cmb2 +="<option value='"+data.id+"' "+selected+">"+data.name+"</option>"
                   })
                   
               }
              $('#dns_officer_id').html('').append(cmb2);
                } else {
                    
                   cmb2 +="<option value=''>--NO DATA--</option>"
                   $('#dns_officer_id').html(cmb2);
                }
                 
            },
            error: function (xhr, resp, text) {
                alert("error :" + xhr.responseText);
            }
        });
}
function operator(id){
    //var district_id = $('#district_id').val();
    $.ajax({
            url: '../ajax/ajx_saq_employee',
            type: 'POST',
            dataType: 'JSON',
            data: {SID:200,designation_id:'2'},
            success: function (response) {
                if (response.result == 1) {
                    var cmb2 ="";
                    var data  = response.data;
                         

                if(data === undefined || data===null || data.lenght ===0){
                   cmb2 += "<opton>--NO DATA --</option>"
                }else {
                    cmb2 +="<option value=''>--SELECT--</option>"
                   $.each(data,function(index,data){
                       if( id === undefined  || id ==""){
                           var selected = ""
                       }else{
                            if(id == data.id){
                               var selected="selected";
                           }else {
                                var selected = ""
                           }
                       }
                       cmb2 +="<option value='"+data.id+"' "+selected+">"+data.name+"</option>"
                   })
                   
               }
              $('#dns_officer_id').html('').append(cmb2);
                } else {
                    
                   cmb2 +="<option value=''>--NO DATA--</option>"
                   $('#dns_officer_id').html(cmb2);
                }
                 
            },
            error: function (xhr, resp, text) {
                alert("error :" + xhr.responseText);
            }
        });
}
function getdepot(id){
    //var district_id = $('#district_id').val();
    $.ajax({
            url: '../ajax/ajx_site_customize',
            type: 'POST',
            dataType: 'JSON',
            data: {SID:200,designation_id:'2'},
            success: function (response) {
                if (response.result == 1) {
                    var cmb2 ="";
                    var data  = response.data;
                         

                if(data === undefined || data===null || data.lenght ===0){
                   cmb2 += "<opton>--NO DATA --</option>"
                }else {
                    cmb2 +="<option value=''>--SELECT--</option>"
                   $.each(data,function(index,data){
                       if( id === undefined  || id ==""){
                           var selected = ""
                       }else{
                           if(data.id == id){
                                var selected="selected";
                           }else {
                                 if(id == data.id){
                               var selected="selected";
                           }else {
                                var selected = ""
                           }
                           }
                          
                       }
                       cmb2 +="<option value='"+data.id+"' "+selected+">"+data.depot_name+"</option>"
                   })
                   
               }
              $('#dns_deport').html('').append(cmb2);
                } else {
                    
                   cmb2 +="<option value=''>--NO DATA--</option>"
                   $('#dns_deport').html(cmb2);
                }
                 
            },
            error: function (xhr, resp, text) {
                alert("error :" + xhr.responseText);
            }
        });
}
function saqManager(region_id){
    //var district_id = $('#district_id').val();
    console.log('<?php echo 'saqMananger'.$saq_officer; ?>');
    var cmb2 = "";
    if(region_id === undefined  || region_id =="" ){
         cmb2 +="<option value=''>--NO DATA2--</option>"
         $('#select_saq_officer_id').html(cmb2);
    }else {
    $.ajax({
            url: '../ajax/ajx_saq_employee',
            type: 'POST',
            dataType: 'JSON',
            data: {SID:203,region_id:region_id},
            success: function (response) {
                if (response.result == 1) {
                    var cmb2 ="";
                    var data  = response.data;
                         

                if(data === undefined || data===null || data.lenght ===0){
                   cmb2 += "<opton>--NO DATA1 --</option>"
                }else {
                    cmb2 +="<option value=''>--SELECT--</option>"
                    //should pass 
                   $.each(data,function(index,data){
                       if( region_id === undefined  || region_id ==""){
                           var selected = ""
                       }else{
                           if('<?php echo $saq_officer ?>' == data.id){
                               var selected="selected";
                           }else {
                                var selected = ""
                           }
                       }
                       cmb2 +="<option value='"+data.id+"' "+selected+">"+data.name+"</option>"
                   })
                   
               }
              $('#select_saq_officer_id').html('').append(cmb2);
                } else {
                    
                   cmb2 +="<option value=''>--NO DATA3--</option>"
                   $('#select_saq_officer_id').html(cmb2);
                }
                 
            },
            error: function (xhr, resp, text) {
                alert("error :" + xhr.responseText);
            }
        });
    }
}
function site_category(category_id){
    //var district_id = $('#district_id').val();
    /*if(region_id === undefined  || region_id =="" ){
         cmb2 +="<option value=''>--NO DATA2--</option>"
         $('#site_category').html(cmb2);
    }else {*/
    $.ajax({
            url: '../ajax/ajx_site_customize',
            type: 'POST',
            dataType: 'JSON',
            data: {SID:203,category_id:category_id},
            success: function (response) {
                if (response.result == 1) {
                    var cmb2 ="";
                    var data  = response.data;
                         

                if(data === undefined || data===null || data.lenght ===0){
                   cmb2 += "<opton>--NO DATA1 --</option>"
                }else {
                    cmb2 +="<option value=''>--SELECT--</option>"
                   $.each(data,function(index,data){
                       if( category_id === undefined  || category_id ==""){
                           var selected = ""
                       }else{
                            if(category_id == data.id){
                               var selected="selected";
                           }else {
                                var selected = ""
                           }
                       }
                       cmb2 +="<option value='"+data.id+"' "+selected+">"+data.category+"</option>"
                   })
                   
               }
              $('#site_category').html('').append(cmb2);
                } else {
                    
                   cmb2 +="<option value=''>--NO DATA3--</option>"
                   $('#site_category').html(cmb2);
                }
                 
            },
            error: function (xhr, resp, text) {
                alert("error :" + xhr.responseText);
            }
        });
    //}
}
function site_access_type(access_id){
    //var district_id = $('#district_id').val();
   /* if(category_id === undefined  || category_id =="" ){
         cmb2 +="<option value=''>--NO DATA2--</option>"
         $('#site_category').html(cmb2);
    }else {*/
    $.ajax({
            url: '../ajax/ajx_site_customize',
            type: 'POST',
            dataType: 'JSON',
            data: {SID:206,access_id:access_id},
            success: function (response) {
                if (response.result == 1) {
                    var cmb2 ="";
                    var data  = response.data;
                         

                if(data === undefined || data===null || data.lenght ===0){
                   cmb2 += "<opton>--NO DATA1 --</option>"
                }else {
                    cmb2 +="<option value=''>--SELECT--</option>"
                   $.each(data,function(index,data){
                       if( access_id === undefined  || access_id ==""){
                           var selected = ""
                       }else{
                            if(access_id == data.id){
                               var selected="selected";
                           }else {
                                var selected = ""
                           }
                       }
                       cmb2 +="<option value='"+data.id+"' "+selected+">"+data.access_type+"</option>"
                   })
                   
               }
              $('#access_type').html('').append(cmb2);
                } else {
                    
                   cmb2 +="<option value=''>--NO DATA3--</option>"
                   $('#access_type').html(cmb2);
                }
                 
            },
            error: function (xhr, resp, text) {
                alert("error :" + xhr.responseText);
            }
        });
   // }
}
function site_permission_type(permission_id){
    //var district_id = $('#district_id').val();
   /* if(category_id === undefined  || category_id =="" ){
         cmb2 +="<option value=''>--NO DATA2--</option>"
         $('#site_category').html(cmb2);
    }else {*/
    $.ajax({
            url: '../ajax/ajx_site_customize',
            type: 'POST',
            dataType: 'JSON',
            data: {SID:209,permission_id:permission_id},
            success: function (response) {
                if (response.result == 1) {
                    var cmb2 ="";
                    var data  = response.data;
                         

                if(data === undefined || data===null || data.lenght ===0){
                   cmb2 += "<opton>--NO DATA1 --</option>"
                }else {
                    cmb2 +="<option value=''>--SELECT--</option>"
                   $.each(data,function(index,data){
                       if( permission_id === undefined  || permission_id ==""){
                           var selected = ""
                       }else{
                           if(permission_id == data.id){
                               var selected="selected";
                           }else {
                                var selected = ""
                           }
                       }
                       cmb2 +="<option value='"+data.id+"' "+selected+">"+data.permission_type+"</option>"
                   })
                   
               }
              $('#access_permission_type').html('').append(cmb2);
                } else {
                    
                   cmb2 +="<option value=''>--NO DATA3--</option>"
                   $('#access_permission_type').html(cmb2);
                }
                 
            },
            error: function (xhr, resp, text) {
                alert("error :" + xhr.responseText);
            }
        });
   // }
}
function site_ownership(ownwership_id){
    //var district_id = $('#district_id').val();
   /* if(category_id === undefined  || category_id =="" ){
         cmb2 +="<option value=''>--NO DATA2--</option>"
         $('#site_category').html(cmb2);
    }else {*/
        console.log(ownwership_id);
    $.ajax({
            url: '../ajax/ajx_site_customize',
            type: 'POST',
            dataType: 'JSON',
            data: {SID:212,ownwership_id:ownwership_id},
            success: function (response) {
                if (response.result == 1) {
                    var cmb2 ="";
                    var data  = response.data;
                         

                if(data === undefined || data===null || data.lenght ===0){
                   cmb2 += "<opton>--NO DATA1 --</option>"
                }else {
                    cmb2 +="<option value=''>--SELECT--</option>"
                   $.each(data,function(index,data){
                       if( ownwership_id === undefined  || ownwership_id ==""){
                           var selected = ""
                       }else{
                           if(ownwership_id == data.id){
                               var selected="selected";
                           }else {
                                var selected = ""
                           }
                       }
                       cmb2 +="<option value='"+data.id+"' "+selected+">"+data.ownership+"</option>"
                   })
                   
               }
              $('#site_ownership').html('').append(cmb2);
                } else {
                    
                   cmb2 +="<option value=''>--NO DATA3--</option>"
                   $('#site_ownership').html(cmb2);
                }
                 
            },
            error: function (xhr, resp, text) {
                alert("error :" + xhr.responseText);
            }
        });
   // }
}
function site_operator(operator_id){
    //var district_id = $('#district_id').val();
   /* if(category_id === undefined  || category_id =="" ){
         cmb2 +="<option value=''>--NO DATA2--</option>"
         $('#site_category').html(cmb2);
    }else {*/
    $.ajax({
            url: '../ajax/ajx_site_customize',
            type: 'POST',
            dataType: 'JSON',
            data: {SID:215,operator_id:operator_id},
            success: function (response) {
                if (response.result == 1) {
                    var cmb2 ="";
                    var data  = response.data;
                         

                if(data === undefined || data===null || data.lenght ===0){
                   cmb2 += "<opton>--NO DATA1 --</option>"
                }else {
                    cmb2 +="<option value=''>--SELECT--</option>"
                   $.each(data,function(index,data){
                       if( operator_id === undefined  || operator_id ==""){
                           var selected = ""
                       }else{
                            if(operator_id == data.id){
                               var selected="selected";
                           }else {
                                var selected = ""
                           }
                       }
                       cmb2 +="<option value='"+data.id+"' "+selected+">"+data.name+"</option>"
                   })
                   
               }
              $('#operator_name').html('').append(cmb2);
                } else {
                    
                   cmb2 +="<option value=''>--NO DATA3--</option>"
                   $('#operator_name').html(cmb2);
                }
                 
            },
            error: function (xhr, resp, text) {
                alert("error :" + xhr.responseText);
            }
        });
   // }
}
</script>