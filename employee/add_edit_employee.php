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
include_once '../class/cls_user.php';
include_once '../class/functions.php';
include_once '../class/cls_saq_employee.php';

$fn = new functions();
if($_REQUEST['id'] != '') {
    $emp_obj = new saq_employee($_REQUEST['id']);
    $emp_obj->getData();
    $region_id = $emp_obj->region_id;
    $DNS_region_id = $emp_obj->dns_region_id;
    $designation_id = $emp_obj->designtion_id;
    $district_id = $emp_obj->saq_district_id;
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
                            <?php if (!isset($_REQUEST['f'])) { ?><span class="widget-icon"><i class="fa fa-edit"></i></span><?php } ?>
                            <span><h2 style="margin-left: 10px;"><?php print (($_REQUEST['id'] != '') ? ((isset($_REQUEST['f'])) ? 'VIEW' : 'EDIT') : 'ADD') ?> USER</h2></span>				                           
                        </header>

                        <!-- widget div-->
                        <div>

                            <!-- widget content -->
                            <div class="widget-body">
                                <form class="smart-form" id="user_form">  
                                    <fieldset>  
                                        <section class="col col-4">
                                            <label class="ngs_form_lable">
                                               Employee Name
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="input">
                                                <input type="text" name="emp_name" id="emp_name" value="<?php print $emp_obj->name ?>"/> 
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="ngs_form_lable">
                                               Designation
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="select">
                                           <select name="emp_designation" id="emp_designation">
                                                        <option value="" selected="">SELECT DESIGNATION</option>
                                                        
                                                        <?php
                                                        
                                                        //$ary_status = $const->getFTStatus();
//                                                        if ($gn_district ==""){
//                                                            $gn_district = '';
//                                                        }else {
//                                                            $gn_district = $gn_district;
//                                                        }
                                                        print $fn->CreateMenu('saq_designation', 'designation', "", "$designation_id", "", "id", "", "");
                                                        ?>
                                                    </select> <i></i> 
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="ngs_form_lable">
                                               District
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="select">
                                           <select name="saq_district_id" id="saq_district_id">
                                                        <option value="" selected="">SELECT DISTRICT</option>
                                                        
                                                        <?php
                                                        
                                                        //$ary_status = $const->getFTStatus();
//                                                        if ($gn_district ==""){
//                                                            $gn_district = '';
//                                                        }else {
//                                                            $gn_district = $gn_district;
//                                                        }
                                                        print $fn->CreateMenu('saq_district', 'name', "", "$district_id", "", "id", "", "");
                                                        ?>
                                                    </select> <i></i> 
                                            </label>
                                        </section>
                                        <div class="hidden" id="select_region">
                                        <section class="col col-4 " id="">
                                            <label class="ngs_form_lable">
                                               Region
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="select">
                                           <select name="emp_region" id="emp_region">
                                                        <option value="" selected="">SELECT</option>
                                                        
                                                        <?php
                                                        
                                                        //$ary_status = $const->getFTStatus();
//                                                        if ($gn_district ==""){
//                                                            $gn_district = '';
//                                                        }else {
//                                                            $gn_district = $gn_district;
//                                                        }
                                                        print $fn->CreateMenu('saq_region', 'name', "", "", "", "id", "", "");
                                                        ?>
                                                    </select> <i></i> 
                                            </label>
                                        </section>
                                        </div>
                                        <div class="hidden" id="select_dns_region">
                                        <section class="col col-4 " id="">
                                            <label class="ngs_form_lable">
                                               DNS Region
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="select">
                                           <select name="emp_dns_region" id="emp_dns_region">
                                                        <option value="" selected="">SELECT</option>
                                                        
                                                        <?php
                                                        
                                                        //$ary_status = $const->getFTStatus();
//                                                        if ($gn_district ==""){
//                                                            $gn_district = '';
//                                                        }else {
//                                                            $gn_district = $gn_district;
//                                                        }
                                                        print $fn->CreateMenu('saq_dns_office', 'name', "", "", "", "id", "", "");
                                                        ?>
                                                    </select> <i></i> 
                                            </label>
                                        </section>
                                        </div>
                                        
<!--                                        <section class="col col-4">
                                            <label class="ngs_form_lable">
                                                Email
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="input">
                                                <input type="email" name="email" id="email"/>
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="ngs_form_lable">
                                                Contact no
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="input">
                                                <input type="text" name="contact_no" id="contact_no"/>
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="ngs_form_lable">
                                                Address
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="input">
                                                <input type="text" name="address" id="address"/>
                                            </label>
                                        </section>-->
                                        <footer>
                                            <input type="hidden" name="SID" value="<?php print (($_REQUEST['id'] != '') ? '202' : '201') ?>" />
                                            <input type="hidden" name="id" value="<?php print $emp_obj->id ?>" />
                                            <button type="button" class="btn btn-primary" onclick="submitHandler()">Save&nbsp;<i class="fa fa-save"></i></button>
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
<?php 

//if($designation_id =="1"){
//    print "$('#select_region').removeClass('hidden');";
//    print "$('#emp_designation').val('".$designation_id."');";
//    print "$('#emp_region').val('".$region_id."');";
//}if($designation_id =="2"){
//    print "$('#select_dns_region').removeClass('hidden');";
//    print "$('#emp_designation').val('".$designation_id."');";
//    print "$('#emp_dns_region').val('".$region_id."');";
//}else {
//    
//}

?>
    });    
//$('#emp_designation').change(function (){
//    var val = $(this).val();
//   if( val =='1'){
//       $('#select_region').removeClass('hidden');
//       $('#select_dns_region').addClass('hidden');
//   }else if(val =='2'){
//       $('#select_dns_region').removeClass('hidden');
//        $('#select_region').addClass('hidden');
//       
//   }else {
//       $('#select_dns_region').addClass('hidden');
//       $('#select_region').addClass('hidden');
//   }
//    
//    
//})
    function submitHandler() {
        var form = $('#user_form').serialize();
        $.ajax({
            url: '../ajax/ajx_saq_employee',
            type: 'POST',
            dataType: 'JSON',
            data: form,
            success: function (response) {
                if (response.result == 1) {
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
</script>