<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
require_once("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)
require_once("../inc/config.ui.php");

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Site Data";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "ngs.css";
include("../inc/header.php");
$page_nav["site_data"]["sub"]["general"]["active"] = true;
//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["view"]["active"] = true;
include("../inc/nav.php");
//include_once 'class/reports.php';
include_once '../class/constants.php';
include_once '../class/cls_site_manager.php';
include_once '../class/cls_saq_technical.php';
include_once '../class/cls_saq_other_operator.php';
include_once '../class/cls_saq_gndivision.php';
include_once '../class/cls_site_type.php';
include_once '../class/cls_saq_dns_depot.php';
include_once '../class/cls_saq_ownership.php';
include_once '../class/cls_saq_site_category.php';
include_once '../class/cls_saq_access_type.php';
include_once '../class/cls_saq_permission_type.php';
include_once '../class/cls_saq_district.php';
include_once '../class/cls_divisional_secretariat.php';
include_once '../class/cls_saq_local_authority.php';
include_once '../class/cls_police_station.php';
include_once '../class/cls_saq_region.php';
include_once '../class/cls_saq_gs.php';

include_once '../class/cls_saq_employee.php';
//include_once '../class/cls_saq_ownership.php';
$gn_division = new saq_gn_division();
//
include_once '../class/functions.php';

$fn = new functions();
$gn_district = $_POST['gn_district'];
?>
<style>
    .jarviswidget .widget-body {
        height: 250px;
        scroll-behavior: smooth;
        overflow-x: auto;
    }
</style>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main" style="padding-bottom: 0px;">  
    <!-- MAIN CONTENT -->
    <div id="content">
        <div class="row" id="div_db">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            </div>
        </div>
        <!-- widget grid -->
        <section id="widget-grid">
            <!-- row -->
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="jarviswidget"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">


                        <header>
                            <!--<span class="widget-icon"> <i class="fa fa-edit"></i> </span>-->
                            <h2 style=""><b>District</b></h2> 
                            <button class="btn btn-default btn-xs" style="float:right;margin:5px;" type="button" onclick="addDistrictName()">Add&nbsp;<i class="fa fa-plus-square"></i></button>
                            <!--<button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="bulk_update(0)">Bulk Edit&nbsp;<i class="fa fa-cogs"></i></button>-->
                        </header> 
                        <div class="widget-body">

                            <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">       
                                <tbody>       

                                    <?php
                                    //$gn_division->saq_district_id = $gn_district;
                                    $cls_saq_district = new saq_district();
                                    $districts = $cls_saq_district->getAll();

                                    //print_r($gn_division);
                                    if (count($districts) > 0) {
                                        foreach ($districts as $d) {
                                            print "<tr class='ngs-popup-dis' id ='$d->id'>"
                                                    . "<td>" . $d->name . "</td>"
                                                    . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--</div>-->
                            <script>
                                $('.ngs-popup-dis').click(function () {


                                    var id = this.id;

                                    addDistrictName(id);

                                });


                            </script>
                        </div>

                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="jarviswidget"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">


                        <header>
                            <!--<span class="widget-icon"> <i class="fa fa-edit"></i> </span>-->
                            <h2 style=""><b>Divisional Secretariat</b></h2> 
                            <button class="btn btn-default btn-xs" style="float:right;margin:5px;" type="button" onclick="addDsName()">Add&nbsp;<i class="fa fa-plus-square"></i></button>
                            <!--<button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="bulk_update(0)">Bulk Edit&nbsp;<i class="fa fa-cogs"></i></button>-->
                        </header> 
                        <div class="widget-body">                    
                            <!--<div class="row">-->
                            <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">        
                                <tbody>       

                                    <?php
//$gn_division->saq_district_id = $gn_district;
                                    $saq_ds = new saq_ds();
                                    $saq_dss = $saq_ds->getAll();

//print_r($dns_depte_details);
                                    if (count($saq_dss) > 0) {
                                        foreach ($saq_dss as $ds) {
                                            print "<tr class='ngs-popup-ds' id ='$ds->id'>"
                                                    . "<td>" . $ds->name . "</td>"
                                                    . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--</div>-->
                            <script>
                                $('.ngs-popup-ds').click(function () {


                                    var id = this.id;

                                    addDsName(id);

                                });


                            </script>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="jarviswidget"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">


                        <header>
                            <!--<span class="widget-icon"> <i class="fa fa-edit"></i> </span>-->
                            <h2 style=""><b>Local Authority</b></h2> 
                            <button class="btn btn-default btn-xs" style="float:right;margin:5px;" type="button" onclick="addLaName()">Add&nbsp;<i class="fa fa-plus-square"></i></button>
                            <!--<button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="bulk_update(0)">Bulk Edit&nbsp;<i class="fa fa-cogs"></i></button>-->
                        </header> 
                        <div class="widget-body">

                            <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">       
                                <tbody>       

                                    <?php
                                    //$gn_division->saq_district_id = $gn_district;
                                    $saq_la = new saq_la();
                                    $las = $saq_la->getAll();

                                    //print_r($gn_division);
                                    if (count($las) > 0) {
                                        foreach ($las as $la) {
                                            print "<tr class='ngs-popup-la' id ='$la->id'>"
                                                    . "<td>" . $la->name . "</td>"
                                                    . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--</div>-->
                            <script>
                                $('.ngs-popup-la').click(function () {


                                    var id = this.id;

                                    addLaName(id);

                                });


                            </script>
                        </div>

                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="jarviswidget"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">


                        <header>
                            <!--<span class="widget-icon"> <i class="fa fa-edit"></i> </span>-->
                            <h2 style=""><b>GS Division</b></h2> 
                            <button class="btn btn-default btn-xs" style="float:right;margin:5px;" type="button" onclick="addGsDivision()">Add&nbsp;<i class="fa fa-plus-square"></i></button>
                            <!--<button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="bulk_update(0)">Bulk Edit&nbsp;<i class="fa fa-cogs"></i></button>-->
                        </header> 
                        <div class="widget-body">                    
                            <!--<div class="row">-->
                            <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">        
                                <tbody>       

                                    <?php
//$gn_division->saq_district_id = $gn_district;
                                    $saq_gs = new saq_gs();
                                    $saq_gss = $saq_gs->getAll();

//print_r($dns_depte_details);
                                    if (count($saq_gss) > 0) {
                                        foreach ($saq_gss as $gs) {
                                            print "<tr class='ngs-popup-gs' id ='$gs->id'>"
                                                    . "<td>" . $gs->gs_name . "</td>"
                                                    . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--</div>-->
                            <script>
                                $('.ngs-popup-gs').click(function () {


                                    var id = this.id;

                                    addGsDivision(id);

                                });


                            </script>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="jarviswidget"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">


                        <header>
                            <!--<span class="widget-icon"> <i class="fa fa-edit"></i> </span>-->
                            <h2 style=""><b>Police Station</b></h2> 
                            <button class="btn btn-default btn-xs" style="float:right;margin:5px;" type="button" onclick="addPsName()">Add&nbsp;<i class="fa fa-plus-square"></i></button>
                            <!--<button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="bulk_update(0)">Bulk Edit&nbsp;<i class="fa fa-cogs"></i></button>-->
                        </header> 
                        <div class="widget-body">

                            <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">       
                                <tbody>       

                                    <?php
                                    //$gn_division->saq_district_id = $gn_district;
                                    $saq_police_station = new saq_police_station();
                                    $pss = $saq_police_station->getAll();

                                    //print_r($gn_division);
                                    if (count($pss) > 0) {
                                        foreach ($pss as $ps) {
                                            print "<tr class='ngs-popup-ps' id ='$ps->id'>"
                                                    . "<td>" . $ps->name . "</td>"
                                                    . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--</div>-->
                            <script>
                                $('.ngs-popup-ps').click(function () {


                                    var id = this.id;

                                    addPsName(id);

                                });


                            </script>
                        </div>

                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="jarviswidget"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">


                        <header>
                            <!--<span class="widget-icon"> <i class="fa fa-edit"></i> </span>-->
                            <h2 style=""><b>DNS Region</b></h2> 
                            <button class="btn btn-default btn-xs" style="float:right;margin:5px;" type="button" onclick="addRegionName()">Add&nbsp;<i class="fa fa-plus-square"></i></button>
                            <!--<button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="bulk_update(0)">Bulk Edit&nbsp;<i class="fa fa-cogs"></i></button>-->
                        </header> 
                        <div class="widget-body">                    
                            <!--<div class="row">-->
                            <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">        
                                <tbody>       

                                    <?php
                                    $saq_region = new saq_region();
                                    $saq_regions = $saq_region->getAll();

//print_r($dns_depte_details);
                                    if (count($saq_regions) > 0) {
                                        foreach ($saq_regions as $region) {
                                            print "<tr class='ngs-popup-region' id ='$region->id'>"
                                                    . "<td>" . $region->name . "</td>"
                                                    . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--</div>-->
                            <script>
                                $('.ngs-popup-region').click(function () {


                                    var id = this.id;

                                    addRegionName(id);

                                });


                            </script>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="jarviswidget"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">


                        <header>
                            <!--<span class="widget-icon"> <i class="fa fa-edit"></i> </span>-->
                            <h2 style=""><b>RM Name</b></h2> 
                            <button class="btn btn-default btn-xs" style="float:right;margin:5px;" type="button" onclick="addRMOfficerName()">Add&nbsp;<i class="fa fa-plus-square"></i></button>
                            <!--<button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="bulk_update(0)">Bulk Edit&nbsp;<i class="fa fa-cogs"></i></button>-->
                        </header> 
                        <div class="widget-body">

                            <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">       
                                <tbody>       

                                    <?php
                                    $rm_employee_obj = new saq_employee();
                                    $rm_employee_obj->designtion_id = constants::$system_admin;
                                    $rms = $rm_employee_obj->getAll();

//print_r($dns_depte_details);
                                    if (count($rms) > 0) {
                                        foreach ($rms as $rm) {
                                            print "<tr class='ngs-popup-rm_officer' id ='$rm->id'>"
                                                    . "<td>" . $rm->name . "</td>"
                                                    . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--</div>-->
                            <script>
//                                $('.ngs-popup-rm').click(function () {
//
//
//                                    var id = this.id;
//
//                                    addRMName(id);
//
//                                });


                            </script>
                        </div>

                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="jarviswidget"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">


                        <header>
                            <!--<span class="widget-icon"> <i class="fa fa-edit"></i> </span>-->
                            <h2 style=""><b>SAQ Officer Name</b></h2> 
                            <button class="btn btn-default btn-xs" style="float:right;margin:5px;" type="button" onclick="addSaqOfficerName()">Add&nbsp;<i class="fa fa-plus-square"></i></button>
                            <!--<button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="bulk_update(0)">Bulk Edit&nbsp;<i class="fa fa-cogs"></i></button>-->
                        </header> 
                        <div class="widget-body">                    
                            <!--<div class="row">-->
                            <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">        
                                <tbody>       

                                    <?php
                                    $saq_employee_obj = new saq_employee();
                                    $saq_employee_obj->designtion_id = constants::$engineer;
                                    $saq_officers = $saq_employee_obj->getAll();

//print_r($dns_depte_details);
                                    if (count($saq_officers) > 0) {
                                        foreach ($saq_officers as $saq_officer) {
                                            print "<tr class='ngs-popup-saq_officer' id ='$saq_officer->id'>"
                                                    . "<td>" . $saq_officer->name . "</td>"
                                                    . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--</div>-->
                            <script>
//                                $('.ngs-popup-saq_officer').click(function () {
//
//
//                                    var id = this.id;
//
//                                    addSaqOfficerName(id);
//
//                                });


                            </script>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="jarviswidget"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">


                        <header>
                            <!--<span class="widget-icon"> <i class="fa fa-edit"></i> </span>-->
                            <h2 style=""><b>DNS Officer Name</b></h2> 
                            <button class="btn btn-default btn-xs" style="float:right;margin:5px;" type="button" onclick="addDNSOfficerName()">Add&nbsp;<i class="fa fa-plus-square"></i></button>
                            <!--<button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="bulk_update(0)">Bulk Edit&nbsp;<i class="fa fa-cogs"></i></button>-->
                        </header> 
                        <div class="widget-body">

                            <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">       
                                <tbody>       

                                    <?php
                                    $dns_employee_obj = new saq_employee();
                                    $dns_employee_obj->designtion_id = constants::$admin;
                                    $dns_officers = $dns_employee_obj->getAll();

//print_r($dns_depte_details);
                                    if (count($dns_officers) > 0) {
                                        foreach ($dns_officers as $dns_officer) {
                                            print "<tr class='ngs-popup-saq_officer' id ='$dns_officer->id'>"
                                                    . "<td>" . $dns_officer->name . "</td>"
                                                    . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--</div>-->
                            <script>
                                $('.ngs-popup-rm').click(function () {


                                    var id = this.id;

                                    addRMName(id);

                                });


                            </script>
                        </div>

                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="jarviswidget"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">


                        <header>
                            <!--<span class="widget-icon"> <i class="fa fa-edit"></i> </span>-->
                            <h2 style=""><b>Site Ownership</b></h2> 
                            <button class="btn btn-default btn-xs" style="float:right;margin:5px;" type="button" onclick="addOwnershipName()">Add&nbsp;<i class="fa fa-plus-square"></i></button>
                            <!--<button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="bulk_update(0)">Bulk Edit&nbsp;<i class="fa fa-cogs"></i></button>-->
                        </header> 
                        <div class="widget-body">                           
                            <!--<div class="row">-->
                            <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">                               
                                <tbody>       

                                    <?php
//$gn_division->saq_district_id = $gn_district;
                                    $ownership = new saq_site_ownership();
                                    $ownership_details = $ownership->getAll();

//print_r($ownership_details);
                                    if (count($ownership_details) > 0) {
                                        foreach ($ownership_details as $tech) {
                                            print "<tr class='ngs-popup-ownership' id ='$tech->id'>"
                                                    . "<td>" . $tech->ownership . "</td>"
                                                    . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--</div>-->
                            <script>
                                $('.ngs-popup-ownership').click(function () {


                                    var id = this.id;

                                    addOwnershipName(id);

                                });


                            </script>
                        </div>

                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="jarviswidget"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">


                        <header>
                            <!--<span class="widget-icon"> <i class="fa fa-edit"></i> </span>-->
                            <h2 style=""><b>Site Types</b></h2> 
                            <button class="btn btn-default btn-xs" style="float:right;margin:5px;" type="button" onclick="addRMName()">Add&nbsp;<i class="fa fa-plus-square"></i></button>
                            <!--<button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="bulk_update(0)">Bulk Edit&nbsp;<i class="fa fa-cogs"></i></button>-->
                        </header> 
                        <div class="widget-body">

                            <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">       
                                <tbody>       

                                    <?php
                                    //$gn_division->saq_district_id = $gn_district;
                                    $cls_site_type = new saq_site_type();
                                    $type_details = $cls_site_type->getAll();

                                    //print_r($gn_division);
                                    if (count($type_details) > 0) {
                                        foreach ($type_details as $tech) {
                                            print "<tr class='ngs-popup-rm' id ='$tech->id'>"
                                                    . "<td>" . $tech->type . "</td>"
                                                    . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--</div>-->
                            <script>
                                $('.ngs-popup-rm').click(function () {


                                    var id = this.id;

                                    addRMName(id);

                                });


                            </script>
                        </div>

                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="jarviswidget"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">


                        <header>
                            <!--<span class="widget-icon"> <i class="fa fa-edit"></i> </span>-->
                            <h2 style=""><b>DNS Deport</b></h2> 
                            <button class="btn btn-default btn-xs" style="float:right;margin:5px;" type="button" onclick="addDnsDepotName()">Add&nbsp;<i class="fa fa-plus-square"></i></button>
                            <!--<button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="bulk_update(0)">Bulk Edit&nbsp;<i class="fa fa-cogs"></i></button>-->
                        </header> 
                        <div class="widget-body">                    
                            <!--<div class="row">-->
                            <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">        
                                <tbody>       

                                    <?php
//$gn_division->saq_district_id = $gn_district;
                                    $dns_depot = new saq_dns_depot();
                                    $dns_depte_details = $dns_depot->getAll();

//print_r($dns_depte_details);
                                    if (count($dns_depte_details) > 0) {
                                        foreach ($dns_depte_details as $tech) {
                                            print "<tr class='ngs-popup-depot' id ='$tech->id'>"
                                                    . "<td>" . $tech->depot_name . "</td>"
                                                    . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--</div>-->
                            <script>
                                $('.ngs-popup-depot').click(function () {


                                    var id = this.id;

                                    addDnsDepotName(id);

                                });


                            </script>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="jarviswidget"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">


                        <header>
                            <!--<span class="widget-icon"> <i class="fa fa-edit"></i> </span>-->
                            <h2 style=""><b>Site Category</b></h2> 
                            <button class="btn btn-default btn-xs" style="float:right;margin:5px;" type="button" onclick="addsitecategory()">Add&nbsp;<i class="fa fa-plus-square"></i></button>
                            <!--<button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="bulk_update(0)">Bulk Edit&nbsp;<i class="fa fa-cogs"></i></button>-->
                        </header> 
                        <div class="widget-body">                           
                            <!--<div class="row">-->
                            <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">
                                <tbody>       

                                    <?php
//$gn_division->saq_district_id = $gn_district;
                                    $site_category = new saq_site_category();
                                    $site_category_deails = $site_category->getAll();

// print_r($ownership_details);
                                    if (count($site_category_deails) > 0) {
                                        foreach ($site_category_deails as $tech) {
                                            print "<tr class='ngs-popup-site_category' id ='$tech->id'>"
                                                    . "<td>" . $tech->category . "</td>"
                                                    . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--</div>-->
                            <script>
                                $('.ngs-popup-site_category').click(function () {


                                    var id = this.id;

                                    addsitecategory(id);

                                });


                            </script>
                        </div>

                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="jarviswidget"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">


                        <header>
                            <!--<span class="widget-icon"> <i class="fa fa-edit"></i> </span>-->
                            <h2 style=""><b>Access Type</b></h2> 
                            <button class="btn btn-default btn-xs" style="float:right;margin:5px;" type="button" onclick="addsiteacceype()">Add&nbsp;<i class="fa fa-plus-square"></i></button>
                            <!--<button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="bulk_update(0)">Bulk Edit&nbsp;<i class="fa fa-cogs"></i></button>-->
                        </header> 
                        <div class="widget-body">                           
                            <!--<div class="row">-->
                            <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">
<!--                                <thead>
                                    <tr style="height:40px;">
                                        <th>#ID</th>
                                        <td class="headerStyle" width="5%" style="">ACCESS TYPE</td>                               

                                    </tr>
                                </thead>-->
                                <tbody>       

                                    <?php
//$gn_division->saq_district_id = $gn_district;
                                    $access_type = new saq_access_type();
                                    $access_type_deails = $access_type->getAll();

//print_r($access_type_deails);
                                    if (count($access_type_deails) > 0) {
                                        foreach ($access_type_deails as $tech) {
                                            print "<tr class='ngs-popup-site_access_type' id ='$tech->id'>"
                                                    . "<td>" . $tech->access_type . "</td>"
                                                    . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--</div>-->
                            <script>
                                $('.ngs-popup-site_access_type').click(function () {


                                    var id = this.id;

                                    addsiteacceype(id);

                                });


                            </script>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="jarviswidget"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">


                        <header>
                            <!--<span class="widget-icon"> <i class="fa fa-edit"></i> </span>-->
                            <h2 style=""><b>Access Permission Type</b></h2> 
                            <button class="btn btn-default btn-xs" style="float:right;margin:5px;" type="button" onclick="addsitepermissiontype()">Add&nbsp;<i class="fa fa-plus-square"></i></button>
                            <!--<button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="bulk_update(0)">Bulk Edit&nbsp;<i class="fa fa-cogs"></i></button>-->
                        </header> 
                        <div class="widget-body">                           
                            <!--<div class="row">-->
                            <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">
<!--                                <thead>
                                    <tr style="height:40px;">
                                        <th>#ID</th>
                                        <td class="headerStyle" width="5%" style="">ACCESS PERMISSION TYPE</td>                               

                                    </tr>
                                </thead>-->
                                <tbody>       

                                    <?php
//$gn_division->saq_district_id = $gn_district;
                                    $permission_type = new saq_permission_type();
                                    $permission_type_deails = $permission_type->getAll();

// print_r($access_type_deails);
                                    if (count($permission_type_deails) > 0) {
                                        foreach ($permission_type_deails as $tech) {
                                            print "<tr class='ngs-popup-site_permission' id ='$tech->id'>"
                                                    . "<td>" . $tech->permission_type . "</td>"
                                                    . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--</div>-->
                            <script>
                                $('.ngs-popup-site_permission').click(function () {


                                    var id = this.id;

                                    addsitepermissiontype(id);

                                });


                            </script>
                        </div>

                    </div>
                </div>
            </div>





    </div>
</section>
</div>

<!-- end row -->


<!-- end widget grid -->



</div>
<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
//include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php
//include required scripts
include("../inc/scripts.php");
?>

<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->
<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.cust.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.tooltip.min.js"></script>

<!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- Full Calendar -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>

<script type="text/javascript" src="../jeegoopopup/jquery.jeegoopopup.1.0.0.js"></script>
<link href="../jeegoopopup/skins/blue/style.css" rel="Stylesheet" type="text/css" />
<link href="../jeegoopopup/skins/round/style.css" rel="Stylesheet" type="text/css" />

<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

<script>
                                $(document).ready(function () {
                                    $(".table").DataTable({
                                        "paging": true,
                                        "ordering": false,
                                        "info": true
                                    });
                                });

                                function addSaqOfficerName(id = '') {
                                    var options = {
                                        url: 'add_saq_officers?id=' + id,
                                        width: '600',
                                        height: '300',
                                        skinClass: 'jg_popup_round',
                                        resizable: false,
                                        scrolling: 'no'
                                    };
                                    $.jeegoopopup.open(options);
                                }
                                
                                function addRMOfficerName(id = '') {
                                    var options = {
                                        url: 'add_rm_officers?id=' + id,
                                        width: '600',
                                        height: '300',
                                        skinClass: 'jg_popup_round',
                                        resizable: false,
                                        scrolling: 'no'
                                    };
                                    $.jeegoopopup.open(options);
                                }
                                
                                function addDNSOfficerName(id = '') {
                                    var options = {
                                        url: 'add_dns_officers?id=' + id,
                                        width: '600',
                                        height: '300',
                                        skinClass: 'jg_popup_round',
                                        resizable: false,
                                        scrolling: 'no'
                                    };
                                    $.jeegoopopup.open(options);
                                }

                                function addDistrictName(id = '') {
                                    var options = {
                                        url: 'add_district?id=' + id,
                                        width: '600',
                                        height: '300',
                                        skinClass: 'jg_popup_round',
                                        resizable: false,
                                        scrolling: 'no'
                                    };
                                    $.jeegoopopup.open(options);
                                }

                                function addDsName(id = '') {
                                    var options = {
                                        url: 'add_ds?id=' + id,
                                        width: '600',
                                        height: '300',
                                        skinClass: 'jg_popup_round',
                                        resizable: false,
                                        scrolling: 'no'
                                    };
                                    $.jeegoopopup.open(options);
                                }

                                function addGsDivision(id = '') {
                                    var options = {
                                        url: 'add_gs?id=' + id,
                                        width: '600',
                                        height: '300',
                                        skinClass: 'jg_popup_round',
                                        resizable: false,
                                        scrolling: 'no'
                                    };
                                    $.jeegoopopup.open(options);
                                }

                                function addLaName(id = '') {
                                    var options = {
                                        url: 'add_la?id=' + id,
                                        width: '600',
                                        height: '300',
                                        skinClass: 'jg_popup_round',
                                        resizable: false,
                                        scrolling: 'no'
                                    };
                                    $.jeegoopopup.open(options);
                                }

                                function addPsName(id = '') {
                                    var options = {
                                        url: 'add_ps?id=' + id,
                                        width: '600',
                                        height: '300',
                                        skinClass: 'jg_popup_round',
                                        resizable: false,
                                        scrolling: 'no'
                                    };
                                    $.jeegoopopup.open(options);
                                }

                                function addRegionName(id = '') {
                                    var options = {
                                        url: 'add_region?id=' + id,
                                        width: '600',
                                        height: '300',
                                        skinClass: 'jg_popup_round',
                                        resizable: false,
                                        scrolling: 'no'
                                    };
                                    $.jeegoopopup.open(options);
                                }


                                function addgnName(id = '') {
                                    var options = {
                                        url: 'add_gn_division?id=' + id,
                                        width: '600',
                                        height: '300',
                                        skinClass: 'jg_popup_round',
                                        resizable: false,
                                        scrolling: 'no'
                                    };
                                    $.jeegoopopup.open(options);
                                }
                                function addRMName(id = '') {
                                    var options = {
                                        url: 'add_site_type?id=' + id,
                                        width: '600',
                                        height: '300',
                                        skinClass: 'jg_popup_round',
                                        resizable: false,
                                        scrolling: 'no'
                                    };
                                    $.jeegoopopup.open(options);
                                }
                                function addDnsDepotName(id = '') {
                                    var options = {
                                        url: 'add_dns_depot?id=' + id,
                                        width: '600',
                                        height: '300',
                                        skinClass: 'jg_popup_round',
                                        resizable: false,
                                        scrolling: 'no'
                                    };
                                    $.jeegoopopup.open(options);
                                }
                                function addOwnershipName(id = '') {
                                    var options = {
                                        url: 'add_edit_ownership?id=' + id,
                                        width: '600',
                                        height: '300',
                                        skinClass: 'jg_popup_round',
                                        resizable: false,
                                        scrolling: 'no'
                                    };
                                    $.jeegoopopup.open(options);
                                }
                                function addsitecategory(id = '') {
                                    var options = {
                                        url: 'add_edit_site_category?id=' + id,
                                        width: '600',
                                        height: '300',
                                        skinClass: 'jg_popup_round',
                                        resizable: false,
                                        scrolling: 'no'
                                    };
                                    $.jeegoopopup.open(options);
                                }
                                function addsiteacceype(id = '') {
                                    var options = {
                                        url: 'add_edit_access_type?id=' + id,
                                        width: '600',
                                        height: '300',
                                        skinClass: 'jg_popup_round',
                                        resizable: false,
                                        scrolling: 'no'
                                    };
                                    $.jeegoopopup.open(options);
                                }

                                function addsitepermissiontype(id = '') {
                                    var options = {
                                        url: 'add_edit_permission_type?id=' + id,
                                        width: '600',
                                        height: '300',
                                        skinClass: 'jg_popup_round',
                                        resizable: false,
                                        scrolling: 'no'
                                    };
                                    $.jeegoopopup.open(options);
                                }

</script>

