<?php
session_start();

//error_reporting(E_ALL);
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

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
//$page_css[] = "your_style.css";
include("../inc/header_less.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
//$page_nav["employee"]["active"] = true;
//include("../inc/nav.php");
// ====================== LOGIC ================== --!>
include_once '../class/constants.php';
include_once '../class/cls_saq_gs.php';
include_once '../class/cls_saq_district.php';
$heading = "GS Division";
include_once '../class/functions.php';

$fn = new functions();
$id = $_REQUEST['id'];
if ($id != '') {
    $saq_gs_obj = new saq_gs($id);
    $saq_gs_obj->getData();

    $heading = "GS Division - $saq_gs_obj->gs_name";
}
?>
<style>
    .customFiled {
        margin-bottom: 10px;
    }
</style>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main"> 

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
                    <div class="jarviswidget" id="" 
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">

                        <header style="margin:0px;">
                            <span class="widget-icon"><?php print (($saq_gs_obj->id != '') ? '<i class="fa fa-edit"></i>' : '<i class="fa fa-plus"></i>') ?>&nbsp;<?php echo $heading; ?></span>                            			                           
                        </header>

                        <!-- widget div-->
                        <div>

                            <!-- widget content -->
                            <div class="widget-body">
                                <form class="smart-form" onsubmit="saveHandler(event)">
                                    <fieldset>

                                        <div class="row">
                                            <section class="col col-3 ">
                                                <label>GS Division Name</label>
                                                <label class="input">
                                                    <input type="text" id="gs_name" name="gs_name" value="<?php print $saq_gs_obj->gs_name ?>" placeholder="Please enter gs division name..."/>
                                                </label>

                                            </section>
                                        </div>
                                        <div class="row">
                                            <section class="col col-3 ">
                                                <label>District</label>
                                                <label class="select">
                                                    <select name="saq_district_id" id="saq_district_id">
                                                        <option value="" selected="" disabled="">Please Select District...</option>
                                                        <?php
                                                        $district_obj = new saq_district();
                                                        $districts = $district_obj->getAll();

                                                        foreach ($districts as $district) {
                                                            print "<option value='" . $district->id . "' " . (($saq_gs_obj->saq_district_id == $district->id) ? "selected=''" : "") . ">" . $district->name . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </label>

                                            </section>
                                        </div>                                      


                                    </fieldset>
                                    <footer>
                                        <input type="hidden" name="id" id="id" value="<?php print $saq_gs_obj->id ?>"/>
                                        <input type="hidden" name="option" id="option" value="<?php print (($saq_gs_obj->id != '') ? '292' : '291') ?>"/>
                                        <button class="btn btn-primary">Save &nbsp;<i class="fa fa-save"></i></button>
                                        <?php if ($saq_gs_obj->id != '') { ?>
                                            <button type="button" class="btn btn-danger" onclick="deleteHandler(<?php print $saq_gs_obj->id ?>)">Delete &nbsp;<i class="fa fa-trash"></i></button> 
                                            <?php } ?>
                                    </footer>
                                </form>

                            </div>
                            <!-- end widget content -->

                        </div>
                        <!-- end widget div -->

                    </div>
                    <!-- end widget -->

                    <!-- END COL -->		

            </div>

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


    });

    function saveHandler(e) {
        e.preventDefault();
        if ($('#depot_name').val() != '') {
            $.ajax({
                url: '../ajax/ajx_site_customize',
                type: 'POST',
                dataType: 'JSON',
                headers: {
                    "Authorization": `Bearer ${sessionStorage.getItem('JWT')}`
                },
                data: {SID: $('#option').val(), id: $('#id').val(), gs_name: $('#gs_name').val(), saq_district_id: $('#saq_district_id').val()},
                success: function (response) {
                    if (response.result == '1') {
                        $.notify(response.msg, 'success');
                        window.parent.location.reload();
                    } else {
                        $.notify(response.msg, 'error');
                    }


                },
                error: function (xhr, status, error) {
                    $.notify(xhr.responseText, 'error');
                }
            });
        } else {
            $.notify('All Fields are required');
        }
    }

    function deleteHandler(id) {
        var newDiv = $(document.createElement('div'));
        $(newDiv).html('Are you sure?');
        $(newDiv).attr('title', 'Delete');
        $(newDiv).dialog({
            resizable: false,
            height: 200,
            modal: true,
            buttons: {
                "Delete": function () {
                    $.ajax({
                        url: '../ajax/ajx_site_customize',
                        type: 'POST',
                        data: {SID: '371', id: id},
                        dataType: "json",
                        headers: {
                            "Authorization": `Bearer ${sessionStorage.getItem('JWT')}`
                        },
                        success: function (response) {
                            if (response.result == '1') {
                                $.notify(response.msg, 'success');
                                window.parent.location.reload();
                            } else {
                                $.notify(response.msg, 'error');
                            }
                        },
                        error: function (xhr, status, error) {
                            alert("error :" + xhr.responseText);
                        }
                    });
                    $(this).dialog("close");
                    $(newDiv).remove();
                },
                cancel: function () {
                    $(this).dialog("close");
                    $(newDiv).remove();
                }
            }
        });
    }

</script>