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
include_once '../class/cls_saq_guideline.php';
include_once '../class/cls_saq_guideline_files.php';

if ($_REQUEST['id'] != 0) {
    $saq_obj = new saq_guideline($_REQUEST['id']);
    $saq_obj->getDetails();
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
                            <span class="widget-icon"><?php if ($_REQUEST['id'] != '') { ?><i class="fa fa-edit"></i><?php } else { ?><i class="fa fa-plus"></i> <?php } ?></span>
                            <span><h2 style="margin-left: 10px;"><?php print (($_REQUEST['id'] != '') ? ((isset($_REQUEST['f'])) ? 'VIEW' : 'EDIT') : 'ADD') ?> SAQ GUIDELINE</h2></span>				                           
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
                                                <input type="text" name="name" id="name" value="<?php print $saq_obj->name ?>"/> 
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="ngs_form_lable">
                                                Description
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="textarea">
                                                <textarea name="description" id="description" ><?php print $saq_obj->description ?></textarea>
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="ngs_form_lable">
                                                Upload File 
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="input">
                                                <input type="file" name="file" id="file" style="padding:5px;"/>
                                            </label>
                                        </section>
                                        <footer>
                                            <input type="hidden" name="id" value="<?php print $saq_obj->id ?>" />
                                            <input type="hidden" name="option" value="<?php print (($saq_obj->id != '') ? 'EDIT' : 'ADD') ?>" />
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

            <!-- END ROW -->
            <?php if ($saq_obj->id != '') { ?>
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
                                <span><h2 style="margin-left: 10px;"> SAQ GUIDELINE FILES</h2></span>				                           
                            </header>

                            <!-- widget div-->
                            <div>

                                <!-- widget content -->
                                <div class="widget-body">
                                    <?php
                                    $saq_g_file = new saq_guideline_file();
                                    $saq_files = $saq_g_file->getAll($saq_obj->id);

                                    if (count($saq_files) > 0) {
                                        foreach ($saq_files as $file) {
                                            print "<table>"
                                                    . "<tr>"
                                                    . "<td>" . $file['name'] . "</td>"
                                                    . "</tr>"
                                                    . "</table>";
                                        }
                                    }
                                    ?>

                                </div>
                                <!-- end widget content -->

                            </div>
                            <!-- end widget div -->

                        </div>
                        <!-- end widget -->

                        <!-- END COL -->		

                </div>
            <?php } ?>
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
<?php if ($saq_obj->id == '') { ?>
            var validate = $("#saq_form").validate({
                ignore: "not:hidden",
                // Rules for form validation
                rules: {
                    name: {
                        required: true
                    },
                    description: {
                        required: true
                    }
                },

                // Messages for form validation
                messages: {
                    name: {
                        required: "Please enter name"
                    },
                    description: {
                        required: "Please enter description"
                    }
                },

                // Do not change code below
                errorPlacement: function (error, element) {
                    error.insertAfter(element.parent());
                }
            });
<?php } ?>
    });

    function submitHandler(e) {
        e.preventDefault();
        var form = $('#saq_form').serializeObject();
        if ($("#saq_form").valid()) {
            if ($("#file").prop('files').length > 0) {
                var files = $("#file").prop('files')[0];
                form_data = new FormData();
                form_data.append("file", files);
                form_data.append("data", JSON.stringify(form));
            } else {
                form_data = new FormData();
                form_data.append("data", JSON.stringify(form));
            }
            console.log(form_data);
//            return false;
            $.ajax({
                url: '../ajax/ajx_saq_guideline',
                type: 'POST',
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response) {
                    if (response['msg'] == 1) {
                        window.parent.location.reload();
                        window.parent.$.jeegoopopup.close();
                    } else {
                        alert('Failure');
                    }
                },
                error: function (xhr, status, error) {
                    alert(status);
                }
            });
        }
    }
</script>