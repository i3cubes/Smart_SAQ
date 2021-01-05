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
?>
<style>
    .customFiled {
        margin-bottom: 10px;
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

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            District
                                                        </label>
                                                        <label class="input">
    <!--                                                        <select name="district" id="district">
                                                            <?php
                                                            ?>
                                                            </select>-->
                                                            <input type="text" name="district" id="district" value="<?php print $site_obj->district_name; ?>"/>
                                                        </label>
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Province
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="province" id="province" value=""/>
                                                        </label>
                                                    </section>  

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Divisional Secretariat
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="divisional_secretariat" id="divisional_secretariat"/>
                                                        </label>
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Local Authority
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="local_authority" id="local_authority"/>
                                                        </label>
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
                                                        <label class="input">
                                                            <input type="text" name="police_station" id="police_station" value="<?php print $site_obj->police_station_name; ?>"/>
                                                        </label>
                                                    </section> 

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            DNS Region
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="dns_region" id="gs_division"/>
                                                        </label>
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
                                                            <input type="text" name="rm_name" id="rm_name"/>
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
                                                            <input type="text" name="saq_officer_name" id="saq_officer_name"/>
                                                        </label>
                                                    </section>

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            DNS Officer Name
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="dns_officer_name" id="dns_officer_name"/>
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
                                                        <label class="input">
                                                            <input type="text" name="site_status" id="site_status"/>
                                                        </label>
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
                                                            Site Category
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="site_category" id="site_status" value="<?php print $site_obj->category; ?>"/>
                                                        </label>
                                                    </section>
                                                    <section class="col-sm-2">
                                                        &nbsp;
                                                    </section>
                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            Longitude
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="longitude" id="longitude" value="<?php print $site_obj->lon; ?>"/>
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
                                                            Manual Distance
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
                                                            <input type="text" name="access_permission_type" id="access_permission_type"/>
                                                        </label>
                                                    </section>

                                                    <section class="col-sm-5">
                                                        <label class="ngs_form_label">
                                                            PG installation Possibility
                                                        </label>
                                                        <label class="input">
                                                            <input type="text" name="pg_installation_possibility" id="pg_installation_possibility"/>
                                                        </label>
                                                    </section>   
                                                    <section class="col-sm-12"> 
                                                        <input type="hidden" name="id" value="<?php print $site_obj->id ?>" />
                                                        <input type="hidden" name="tab" value="D" />
                                                        <input type="hidden" name="option" value="<?php print (($site_obj->id != '') ? 'EDIT' : 'ADD') ?>"/>
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
                                                        <input type="hidden" name="id" value="<?php print $site_obj->id ?>" />
                                                        <input type="hidden" name="tab" value="C" />
                                                        <input type="hidden" name="option" value="<?php print (($site_obj->id != '') ? 'EDIT' : 'ADD') ?>"/>
                                                        <button class="btn btn-primary btn-xs" onclick="" style="float:right;">Save &nbsp;<i class="fa fa-save"></i></button>
                                                    </section>
                                                </fieldset>
                                            </form>
                                        </div>                                    
                                        <div class="tab-pane fade active in" id="technical">
                                            <form class="smart-form">
                                                <fieldset>
                                                    <table class="table">
                                                        <thead>
                                                        <th>Technology</th>
                                                        <th align="center">GSM</th>
                                                        <th align="center">2G</th>
                                                        <th align="center">3G</th>
                                                        <th align="center">4G</th>
                                                        <th align="center">TDD</th>
                                                        <th align="center">FDD</th>
                                                        <th align="center">Fiber</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Dialog</td>
                                                                <td align="center">
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="gsm" id="gsm">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                                <td align="center">
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="2g" id="2g">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                                <td align="center">
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="3g" id="3g">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                                <td align="center">
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="4g" id="4g">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                                <td align="center"> 
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="tdd" id="tdd">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                                <td align="center">
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="fdd" id="fdd">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                                <td align="center">
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="fiber" id="fiber">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <br />
                                                    <h5>Other operators</h5>
                                                    <br />
                                                    <table class="table">
                                                        <thead>
                                                        <th>Operator</th>
                                                        <th>Present</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="padding:10px;">Mobitel</td>
                                                                <td>
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="mobitel" id="mobitel">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding:10px;">Hutch</td>
                                                                <td>
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="hutch" id="hutch">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding:10px;">Airtel</td>
                                                                <td>
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="airtel" id="airtel">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding:10px;">LB</td>
                                                                <td>
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="lb" id="lb">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding:10px;">SLA</td>
                                                                <td>
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="sla" id="sla">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding:10px;">STF</td>
                                                                <td>
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="stf" id="stf">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding:10px;">SAF</td>
                                                                <td>
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="saf" id="saf">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding:10px;">Police</td>
                                                                <td>
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="police" id="police">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding:10px;">Sirasa</td>
                                                                <td>
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="sirasa" id="sirasa">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding:10px;">TNL</td>
                                                                <td>
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="tnl" id="tnl">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding:10px;">Suwarnawahini</td>
                                                                <td>
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="suwarnwahini" id="suwarnwahini">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding:10px;">Derana</td>
                                                                <td>
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="derana" id="derana">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding:10px;">Other</td>
                                                                <td>
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="other" id="other">
                                                                        <i></i>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </fieldset>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade active in" id="agreement">
                                            <form class="smart-form">
                                                <fieldset>
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <td>Site ID</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="site_id" id="site_id" />
                                                                </label>
                                                            </td>
                                                            <td>Site Name</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="site_id" id="site_id" />
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Agreement Status</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="site_id" id="site_id" />
                                                                </label>
                                                            </td>
                                                            <td>Agreement Expire Date</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="site_id" id="site_id" />
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Agreement Start Date</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="agreement_start_date" id="agreement_start_date" />
                                                                </label>
                                                            </td>
                                                            <td>payment MODE</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="payment_mode" id="payment_mode" />
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Leas Period</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="leas_period" id="leas_period" />
                                                                </label>
                                                            </td>
                                                            <td>Current Month payment</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="current_month_payment" id="current_month_payment" />
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Start Monthly Rental</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="start_monthly_rental" id="start_monthly_rental" />
                                                                </label>
                                                            </td>
                                                            <td>Monthly deducting amount for ADV recovery</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="mdafar" id="mdafar" />
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>RATE Increment</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="rate_increment" id="rate_increment" />
                                                                </label>
                                                            </td>
                                                            <td>ADV recovery period</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="adv_recovery_period" id="adv_recovery_period" />
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Advance payment</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="advance_payment" id="advance_payment" />
                                                                </label>
                                                            </td>
                                                            <td>Account holder name</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="acc_holder_name" id="acc_holder_name" />
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Bank Account</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="bank_account" id="bank_account" />
                                                                </label>
                                                            </td>
                                                            <td>Branch Name</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="branch_name" id="branch_name" />
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Bank Name</td>
                                                            <td>
                                                                <label class="input">
                                                                    <input type="text" name="bank_name" id="bank_name" />
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
                                                                    <input type="text" name="acc_type" id="acc_type" />
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
                                                                    <input type="text" name="acc_holder_nic_no" id="acc_holder_nic_no" />
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
                                                        <tr>
                                                            <td><b>Assessment Tax</b></td>
                                                            <td><label class="input">
                                                                    <input type="text" name="at18" id="at18" />
                                                                </label></td>
                                                            <td><label class="input">
                                                                    <input type="text" name="at19" id="at19" />
                                                                </label></td>
                                                            <td><label class="input">
                                                                    <input type="text" name="at20" id="at20" />
                                                                </label></td>
                                                            <td><label class="input">
                                                                    <input type="text" name="at21" id="at21" />
                                                                </label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Trade Tax</b></td>
                                                            <td><label class="input">
                                                                    <input type="text" name="tt18" id="tt18" />
                                                                </label></td>
                                                            <td><label class="input">
                                                                    <input type="text" name="tt19" id="tt19" />
                                                                </label></td>
                                                            <td><label class="input">
                                                                    <input type="text" name="tt20" id="tt20" />
                                                                </label></td>
                                                            <td><label class="input">
                                                                    <input type="text" name="tt21" id="tt21" />
                                                                </label></td>
                                                        </tr>
                                                    </table>
                                                </fieldset>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade active in" id="approvals">
                                            <form class="smart-form">
                                                <fieldset>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <th width="5%"></th>
                                                        <th>Requirement</th>
                                                        <th>Approvel Name</th>
                                                        <th>Short Name</th>
                                                        <th>Availability</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr style="background:yellow;">
                                                                <td>1</td>
                                                                <td>Compulsory</td>
                                                                <td>Telecommunications Regulatory Commission Of Sri Lanka</td>
                                                                <td>TRC</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr style="background:yellow;">
                                                                <td>2</td>
                                                                <td>Compulsory</td>
                                                                <td>Ministry Of Defense</td>
                                                                <td>MOD</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr style="background:yellow;">
                                                                <td>3</td>
                                                                <td>Compulsory</td>
                                                                <td>Civil Aviation Authority Of Sri Lanka</td>
                                                                <td>CAA</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr style="background:yellow;">
                                                                <td>4</td>
                                                                <td>Compulsory</td>
                                                                <td>Central Environmental Authority</td>
                                                                <td>CEA</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr style="background:yellow;">
                                                                <td>5</td>
                                                                <td>Compulsory</td>
                                                                <td>Board Of Investment Of Sri Lanka</td>
                                                                <td>BOI</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr style="background:yellow;">
                                                                <td>6</td>
                                                                <td>Compulsory</td>
                                                                <td>Urban Development Authority</td>
                                                                <td>UDA</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr style="background:yellow;">
                                                                <td>7</td>
                                                                <td>Compulsory</td>
                                                                <td>Local Authority</td>
                                                                <td>LA</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>8</td>
                                                                <td>Optional</td>
                                                                <td>National Building Research Organization</td>
                                                                <td>NBRO</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>9</td>
                                                                <td>Optional</td>
                                                                <td>Divisional Secretariat No Objection Letter</td>
                                                                <td>DVS</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>10</td>
                                                                <td>Optional</td>
                                                                <td>Land Commissioner General’s Department</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>11</td>
                                                                <td>Optional</td>
                                                                <td>Department Of Archaeology</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>12</td>
                                                                <td>Optional</td>
                                                                <td>Ministry Of Buddha asana</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>13</td>
                                                                <td>Optional</td>
                                                                <td>Land Reform Commission</td>
                                                                <td>LRC</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>14</td>
                                                                <td>Optional</td>
                                                                <td>Department Of Forest Conservation</td>
                                                                <td>LRC</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>15</td>
                                                                <td>Optional</td>
                                                                <td>Department Of Wildlife Conservation</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>16</td>
                                                                <td>Optional</td>
                                                                <td>Department Of Wildlife Conservation</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>17</td>
                                                                <td>Optional</td>
                                                                <td>Ministry Of Plantation Industries</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>18</td>
                                                                <td>Optional</td>
                                                                <td>Department Of Coast Conservation and Coastal Resource Management</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>19</td>
                                                                <td>Optional</td>
                                                                <td>Road Development Authority</td>
                                                                <td>RDA</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>20</td>
                                                                <td>Optional</td>
                                                                <td>Department Of Railways</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>21</td>
                                                                <td>Optional</td>
                                                                <td>Sri Lanka Land Reclamation & Development Corporation</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>22</td>
                                                                <td>Optional</td>
                                                                <td>Department of Agrarian Development</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>23</td>
                                                                <td>Optional</td>
                                                                <td>Irrigation Department</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>24</td>
                                                                <td>Optional</td>
                                                                <td>Condominium Management Authority</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>25</td>
                                                                <td>Optional</td>
                                                                <td>Management Approval</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr style="background:yellow;">
                                                                <td>26</td>
                                                                <td>Compulsory</td>
                                                                <td>Environmental Protection Licen</td>
                                                                <td>EPL</td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
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
    $(document).ready(function () {
        $("#main_tab").tabs({
            active: 0
        });
    });

    function saveHandler(e, form) {
        e.preventDefault();
        var formData = $(`#${form}`).serializeObject();
        $.ajax({
            url: '../ajax/ajx_saq_site',
            type: 'POST',
            dataType: 'JSON',
            data: formData,
            success: function (response) {
                if(response['msg'] == 1) {
                    alert('Successfully updated');
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