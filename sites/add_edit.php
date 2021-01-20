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
                                                        <label class="input">
                                                            <input type="text" name="gs_division" id="gs_division"/>
                                                        </label>
                                                    </section>
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
                                                        <label class="input">
                                                            <input type="text" name="dns_deport" id="dns_deport"/>
                                                        </label>
                                                    </section> 

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            RM Name
                                                        </label>
                                                        <label class="input">
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
                                                        </label>
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            SAQ officer Name
                                                        </label>
                                                        <label class="input">
                                                            <?php
                                                            if ($site_obj->region_id != 0 && $site_obj->region_id != '') {
                                                                $region_obj = new saq_region($site_obj->region_id);
                                                                $regionEmployee = $region_obj->getRegionEmployees();
                                                                foreach ($regionEmployee as $emp) {
                                                                    $stringRegionEmployee .= $emp->name . ' ';
                                                                }
                                                            }
                                                            ?>
                                                            <input type="text" name="saq_officer_name" id="saq_officer_name" disabled="" value="<?php print $stringRegionEmployee ?>"/>
                                                        </label>
                                                    </section>

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            DNS Officer Name
                                                        </label>
                                                        <label class="input">                                                            
                                                            <input type="text" name="dns_officer_name" id="dns_officer_name" disabled="" value=""/>
                                                        </label>
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Site Owner ship
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="site_ownership" id="site_ownership" value="<?php print $site_obj->site_ownership; ?>"/>
                                                        </label>
                                                    </section>

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Operator's Name
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="operator_name" id="operator_name" value="<?php print $site_obj->operator_name; ?>"/>
                                                        </label>
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Other Operator ID
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="other_operator_id" id="other_operator_id"/>
                                                        </label>
                                                    </section>

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Site Type
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="site_type" id="site_type" value="<?php print $site_obj->type; ?>"/>
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
                                                            print "<option value='$status->id' " . (($site_obj->status == $status->id) ? "selected=''" : "") . ">$status->name</option>";
                                                        }
                                                        ?>
                                                            </select>                                                            
                                                        </label>
<!--                                                        <label class="input">
                                                            <input type="text" name="site_status" id="site_status" value="<?php print $site_obj->status; ?>"/>
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
                                                            <input type="text" name="on_air_date" id="on_air_date" value="<?php print $site_obj->on_air_date; ?>"/>
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
                                                        <label class="input">
                                                            <input type="text" name="site_category" id="site_category" value="<?php print $site_obj->category; ?>"/>
                                                        </label>
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
                                                        <label class="input">
                                                            <input type="text" name="access_type" id="access_type" value="<?php print $site_obj->access_type; ?>"/>
                                                        </label>
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
                                                        <label class="input">
                                                            <input type="text" name="access_permission_type" id="access_permission_type" value="<?php print $site_obj->access_permision_type; ?>"/>
                                                        </label>
                                                    </section>

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            PG installation Possibility
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
                                                            Land owner Name
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
                                                            Land owner address
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="land_owner_address" id="land_owner_address" value="<?php print $site_obj->lo_address; ?>"/>
                                                        </label>
                                                    </section>  

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Land owner NIC/BRC
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
                                                            Land owner Mobile number
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="land_owner_mobile_number" id="land_owner_mobile_number" value="<?php print $site_obj->lo_mobile; ?>"/>
                                                        </label>
                                                    </section> 

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Land owner Land number
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
                                                            Contact person and number
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
                                                    <table class="table">
                                                        <thead>
                                                        <th>Technology</th>
                                                        <?php
                                                        $technology_obj = new saq_technical();
                                                        $technologies = $technology_obj->getAll();
//                                                            print_r($technologies);
                                                        foreach ($technologies as $tech) {
                                                            print "<th align='center'>$tech->technology</th>";
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

                                                                print "<tr><td style='padding:10px;'>$operator->name</td>"
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

//                                                    var_dump($agreement_data_obj);
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
                                                                <label class="input">
                                                                    <input type="text" name="agreement_status" id="agreement_status" value="<?php print $agreement_data_obj->agreement_status ?>"/>
                                                                </label>
                                                            </td>
                                                            <td>Agreement Expire Date</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="agreement_expire_date" id="agreement_expire_date" value="<?php print $agreement_data_obj->date_expire ?>"/>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Agreement Start Date</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="agreement_start_date" id="agreement_start_date" value="<?php print $agreement_data_obj->date_start ?>"/>
                                                                </label>
                                                            </td>
                                                            <td>payment MODE</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="payment_mode" id="payment_mode" value="<?php print $agreement_data_obj->payment_mode ?>"/>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Lease Period</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="leas_period" id="leas_period" value="<?php print $agreement_data_obj->lease_period ?>"/>
                                                                </label>
                                                            </td>
                                                            <td>Current Month payment</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="current_month_payment" id="current_month_payment" value="<?php print $agreement_data_obj->current_month_payment ?>"/>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Start Monthly Rental</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="start_monthly_rental" id="start_monthly_rental" value="<?php print $agreement_data_obj->start_monthly_rental ?>"/>
                                                                </label>
                                                            </td>
                                                            <td>Monthly deducting amount for ADV recovery</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="mdafar" id="mdafar" value="<?php print $agreement_data_obj->monthly_deduction_for_adv ?>"/>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>RATE Increment</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="rate_increment" id="rate_increment" value="<?php print $agreement_data_obj->rate_increment ?>"/>
                                                                </label>
                                                            </td>
                                                            <td>ADV recovery period</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="adv_recovery_period" id="adv_recovery_period" value="<?php print $agreement_data_obj->adv_recovery_period ?>"/>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Advance payment</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="advance_payment" id="advance_payment" value="<?php print $agreement_data_obj->advance_payment ?>"/>
                                                                </label>
                                                            </td>
                                                            <td>Account holder name</td>
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
                                                            <td>Account type</td>
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
                                                            <td>Account holder NIC Number</td>
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
                                                    </table>
                                                    <br />
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <td colspan="5"><b>Assessment NO</b></td>
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
                                                                        . "<td>$approval->description</td>"
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

<script type="text/javascript">
    var id = <?php print (($site_obj->id != 0) ? $site_obj->id : 0) ?>;
    var option = '<?php print (($site_obj->id != 0) ? 'EDIT' : 'ADD') ?>';

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
            format: 'Y-m-d',
            useCurrent: true,
            scrollMonth: false,
            scrollInput: false
        })
        $('#agreement_expire_date').datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            useCurrent: true,
            scrollMonth: false,
            scrollInput: false
        });
        $('#agreement_start_date').datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            useCurrent: true,
            scrollMonth: false,
            scrollInput: false
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
    });

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
</script>