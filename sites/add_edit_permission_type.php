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
include_once '../class/cls_saq_permission_type.php';

if($_REQUEST['id'] != '') {
    $saq_permission_type_obj = new saq_permission_type($_REQUEST['id']);
    $saq_permission_type_obj->getData();
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
                    <div class="jarviswidget" id="wid-id-4" 
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">

                        <header style="margin:0px;">
                            <span class="widget-icon"><?php print (($saq_other_operator_obj->id != '') ? '<i class="fa fa-edit"></i>' : '<i class="fa fa-plus"></i>') ?></span>                            			                           
                        </header>

                        <!-- widget div-->
                        <div>

                            <!-- widget content -->
                            <div class="widget-body">
                                <form class="smart-form" onsubmit="saveHandler(event)">
                                    <fieldset>
                                        <label class="input">
                                            <input type="text" id="permission_type" name="permission_type" value="<?php print $saq_permission_type_obj->permission_type ?>"/>
                                        </label>
                                    </fieldset>
                                    <footer>
                                        <input type="hidden" name="id" id="id" value="<?php print $saq_permission_type_obj->id ?>"/>
                                        <input type="hidden" name="option" id="option" value="<?php print (($saq_permission_type_obj->id != '') ? '211' : '210') ?>"/>
                                        <button class="btn btn-primary">Save &nbsp;<i class="fa fa-save"></i></button>
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
        if($('#technology').val() != '') {
            $.ajax({
                url: '../ajax/ajx_site_customize',
                type: 'POST',
                dataType: 'JSON',
                data: {SID: $('#option').val(), id: $('#id').val(), type: $('#permission_type').val()},
                success: function(response) {
                    $.notify('Successfully saved', 'success');
                    window.parent.location.reload();
                },
                error: function (xhr, status, error) {
                    $.notify('Error occured', 'error');
                } 
            });
        } else {
            $.notify('please fill technology field');
        }
    }
                                                                         
</script>