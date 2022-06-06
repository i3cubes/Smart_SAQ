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
$parent_model_id = htmlspecialchars($_REQUEST['id']);
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
                            <span class="widget-icon"><i class="fa fa-plus"></i></span>
                            <span><h2 style="margin-left: 10px;">ADD NODE</h2></span>				                           
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
                                                <input type="text" name="name" id="name" value=""/> 
                                            </label>
                                        </section>                                                                                                                  
                                        <footer>
                                            <input type="hidden" name="parent_model_id" id="parent_model_id" value="<?php print $parent_model_id ?>" />
                                            <input type="hidden" name="option" id="option" value="ADD" />
                                            <button class="btn btn-primary">Save&nbsp;<i class="fa fa-save"></i></button>
                                        </footer>                                        
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

    });

    function submitHandler(e) {
        e.preventDefault();
        $.ajax({
            url: '../ajax/ajx_saq_site_model',
            type: 'POST',
            dataType: 'JSON',
            headers: {
                "Authorization": `Bearer ${sessionStorage.getItem('JWT')}`
            },
            data: {option: $('#option').val(), name: $('#name').val(), parent_model_id: $('#parent_model_id').val()},
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