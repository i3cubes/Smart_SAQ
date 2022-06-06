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
include_once '../class/cls_site_model.php';

$id = htmlspecialchars($_REQUEST['id']);
$site_model_obj = new site_model($id);
$site_model_obj->getData();
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
                    <div class="jarviswidget"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">

                        <header style="margin:0px;">
                            <span class="widget-icon"><i class="fa fa-edit"></i></span>
                            <span><h2 style="margin-left: 10px;">EDIT NODE</h2></span>				                           
                        </header>

                        <!-- widget div-->
                        <div>

                            <!-- widget content -->
                            <div class="widget-body">
                                <form class="smart-form" id="saq_form" onsubmit="submitHandler(event)">  
                                    <fieldset>  
                                        <section class="col col-4">
                                            <label class="ngs_form_lable">
                                                Name
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="input">
                                                <input type="text" name="name" id="name" value="<?php print $site_model_obj->name ?>"/> 
                                            </label>
                                        </section>                                                                                                                  
                                        <!--<footer>-->
                                        <section class="col col-12">
                                            <div style="float: right;">
                                                <input type="hidden" name="id" id="id" value="<?php print $id ?>" />                                                                                       

                                                <button class="btn btn-primary btn-sm" id="add">Add Node&nbsp;<i class="fa fa-plus"></i></button>
                                                <button class="btn btn-danger btn-sm" id="delete" type="button">Delete&nbsp;<i class="fa fa-trash"></i></button>                                            
                                                <button class="btn btn-primary btn-sm">Save&nbsp;<i class="fa fa-save"></i></button>
                                            </div>
                                        </section>

                                        <!--</footer>-->                                        
                                    </fieldset>                                             
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
        $('#add').click(function () {
            window.parent.$.jeegoopopup.close();
            window.parent.addHandlerNode($('#id').val());
        });

        $('#delete').click(function () {
            var newDiv = $(document.createElement('div'));
            $(newDiv).html('Are you sure?, All child nodes and related images will be deleted.');
            $(newDiv).attr('title', 'Delete');
            //$(newDiv).css('font-size','62.5%');
            $(newDiv).dialog({
                resizable: false,
                height: 180,
                modal: true,
                buttons: {
                    "Ok": function () {
                        $.ajax({
                            url: '../ajax/ajx_saq_site_model',
                            type: 'POST',
                            data: {option: 'DELETE', id: $('#id').val()},
                            dataType: "json",
                            headers: {
                                "Authorization": `Bearer ${sessionStorage.getItem('JWT')}`
                            },
                            success: function (res) {
                                if (res['msg'] == 1) {
                                    window.parent.loadTree();
                                    window.parent.$.jeegoopopup.close();
                                } else {
                                    alert('Error');
                                }
                            },
                            error: function (xhr, status, error) {
                                alert("error :" + xhr.responseText);
                                location.reload();
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
        });
    });

    function submitHandler(e) {
        e.preventDefault();
        $.ajax({
            url: '../ajax/ajx_saq_site_model',
            type: 'POST',
            dataType: 'JSON',
            data: {option: 'EDIT', name: $('#name').val(), id: $('#id').val()},
            headers: {
                "Authorization": `Bearer ${sessionStorage.getItem('JWT')}`
            },
            success: function (response) {
                if (response['msg'] == 1) {
                    window.parent.loadTree();
                    window.parent.$.jeegoopopup.close();
                } else {
                    alert('Failure');
                }
            },
            error: function (xhr, status, error) {
                alert("error :" + xhr.responseText);
                location.reload();
            }
        });
    }
</script>