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
include_once '../class/cls_saq_dns_depot.php';
$heading = "DNS Depot";
include_once '../class/functions.php';

$fn = new functions();
if ($_REQUEST['id'] != '') {
    $saq_depot_obj = new saq_dns_depot($_REQUEST['id']);
    $saq_depot_obj->getData();

    $heading = "DNS Depot";
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
                            <span class="widget-icon"><?php print (($saq_depot_obj->id != '') ? '<i class="fa fa-edit"></i>' : '<i class="fa fa-plus"></i>') ?>&nbsp;<?php echo $heading; ?></span>                            			                           
                        </header>

                        <!-- widget div-->
                        <div>

                            <!-- widget content -->
                            <div class="widget-body">
                                <form class="smart-form" onsubmit="saveHandler(event)">
                                    <fieldset>


                                        <div class="row">
                                            <section class="col col-3 ">
                                                <label class="input">
                                                    <input type="text" id="depot_name" name="depot_name" value="<?php print $saq_depot_obj->depot_name ?>"/>
                                                </label>

                                            </section>
                                        </div>


                                    </fieldset>
                                    <footer>
                                        <input type="hidden" name="id" id="id" value="<?php print $saq_depot_obj->id ?>"/>
                                        <input type="hidden" name="option" id="option" value="<?php print (($saq_depot_obj->id != '') ? '202' : '201') ?>"/>
                                        <button class="btn btn-primary">Save &nbsp;<i class="fa fa-save"></i></button>
                                        <?php if ($saq_depot_obj->id != '') { ?>
                                            <button type="button" class="btn btn-danger" onclick="deleteHandler(<?php print $saq_depot_obj->id ?>)">Delete &nbsp;<i class="fa fa-trash"></i></button> 
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
                data: {SID: $('#option').val(), id: $('#id').val(), name: $('#depot_name').val()},
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
                        data: {SID: '301', id: id},
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