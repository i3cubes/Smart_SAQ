<?php
session_start();
//initilize the page
//print_r($_SESSION);
require_once("../lib/config.php");

//print_r($ary_prev[3]);
//require UI configuration (nav, ribbon, etc.)


/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Sites-Bulk Update";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("../ngs/header_ngspopup.php");
include_once '../class/ngs_date.php';
$date = new ngs_date();
//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["forms"]["sub"]["smart_layout"]["active"] = true;
//include("..inc/nav.php");
// ====================== LOGIC ================== --!>

include_once '../class/cls_site.php';
include_once '../class/cls_site_manager.php';
include_once '../class/cls_saq_technical.php';
include_once '../class/cls_saq_site_agreement_data.php';
include_once '../class/cls_saq_ownership.php';
include_once '../class/cls_site_type.php';
$site_mgr = new site_manager();
$saq_technical = new saq_technical();
$saq_site_agreement_data = new saq_site_agreement_data();
$site_ownership = new saq_site_ownership();
$site_type = new saq_site_type();
//print_r($_POST);
//$site_mgr=new site_manager();

//print_r($_POST);
//print $_FILES['file']['tmp_name'];
if ($_POST['but'] == 'update') {
    if (isset($_FILES)) {
        
        $test = explode(".", $_FILES['file']['name']);
        $extension = end($test);         
        if($extension == 'csv') {                     
        $tab = $_REQUEST['tab'];

        $f_name = (string) $_FILES['file']['name'];
        $source = (string) $_FILES['file']['tmp_name'];
        $save_to = (string) "../files/sitedata/" . time() . "_" . $f_name;
        //print $save_to;
        if (move_uploaded_file($source, $save_to)) {
            chmod($saveloc, 644);
            //Update Data
            $row = 1;
            $col_count = 0;
            if (($handle = fopen($save_to, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
//                    var_dump($data);
//                    return false;
                    $msg = "";
                    if ($row == 1) {
                        $col_count = count($data);
                    } else {
                        $num = count($data);
                        //print "N=".$num;
                        if ($col_count == $num) {
                            //Update
//                            var_dump($data[0]);
                            
                            $site_id = $site_mgr->getSiteIDFromCode(trim($data[0]));
                            if ($site_id != '') {
                                $site = new site($site_id);
                            } else {
                                $site = new site();
                                $site->code = trim($data[0]);
                                if ($site->addTemplate()) {
                                    $msg .= "new site added.";
                                } else {
                                    $msg .= "<font color='red'>Could not add new site.</font>";
                                }
                            }
                            //gctpa
                            if ($tab == "G") {                                
                                $site->name = $data[1];
                                //$site->type = $data[2];
                                $type = $data[2];
                                //$site_type->like_format= "=";
                                $site_type->type= $type;
                                $hastype = $site_type->getAll();
                                if(count($hastype)>0){
                                    $site->type =$hastype[0]->id;
                                } else {
                                    $site_type->type = $type;
                                    $addnew = $site_type->addNew();
                                    $site->type =$addnew;
                                }
//                                return false;
                                $site->address = $data[3];
                                //$site->site_ownership = $data[4];
                                $ownership = $data[4];
                                $hasOwner = $site_ownership->search($ownership, "", "1", "", "", "");
                                if(count($hasOwner)>0){
                                    $site->site_ownership =$hasOwner[0]->id;
                                } else {
                                    $site_ownership->ownership = $ownership;
                                    $addnew = $site_ownership->add();
                                    $site->site_ownership =$addnew;
                                }
                                 
                                $site->operator_name = $data[5];
                                $site->tower_height = $data[6];
                                $site->building_height = $data[7];
                                $site->land_area = $data[8];
                                if($data[9]!=""){
                                    $site->on_air_date = $data[9] =="NULL" ? "NULL" : $date->transform_date($data[9]);
                                            
                                }
                                //$site->on_air_date = $data[9] =="" ? "NULL" : $date->transform_date($data[9]) /**/;
                                $site->category = $data[10];
                                $site->lat = $data[11];
                                $site->lon = $data[12];
                                $site->access_type = cleanCSVData($data[13]);
                                $site->manual_distance = cleanCSVData($data[14]);
                                $site->access_permision_type = cleanCSVData($data[15]);
                                $site->pg_installation_possibility = cleanCSVData($data[16]);
                                $site->region_id = cleanCSVData($data[18]);
                                //$site->province_id=cleanData($data[21]);
                                $site->district_id = cleanCSVData($data[20]);
                                $site->ds_id = cleanCSVData($data[21]);
                                $site->la_id = cleanCSVData($data[22]);
                                $site->police_station_id = cleanCSVData($data[23]);
                                $site->dns_office_id = cleanCSVData($data[24]);

                                if ($site->update($tab,"API")) {
                                    $msg .= "site data updated";
                                } else {
                                    $msg .= "<font color='red'>site data update failed.</font>";
                                }
                            } else if ($tab == "C") {
                                $site->lo_name = cleanCSVData($data[1]);
                                $site->lo_address = cleanCSVData($data[2]);
                                $site->lo_nic_brc = cleanCSVData($data[3]);
                                $site->lo_mobile = cleanCSVData($data[4]);
                                $site->lo_land_number = cleanCSVData($data[5]);
                                $site->contact_person_number = cleanCSVData($data[6]);
                                $site->lo_fax = cleanCSVData($data[7]);
                                $site->lo_email = cleanCSVData($data[8]);

                                if ($site->update($tab,"API")) {
                                    $msg .= "Contact data updated";
                                } else {
                                    $msg .= "<font color='red'>site data update failed.</font>";
                                }
                            } else if ($tab == "T") {
                                $ary_technical = array();
                                //$site_id
                                //print "<br>aaaa <br>";
                                //print_r($data);

                                $gms = $data['1'];
                                $twog = $data['2'];
                                $threeg = $data['3'];
                                $fourg = $data['4'];
                                $TDD = $data['5'];
                                $FDD = $data['6'];
                                $Fiber = $data['7'];
                                if (strtolower($gms) == "y") {
                                    //$gsmid = $saq_technical->getId("GSM");
                                    array_push($ary_technical, "1");
                                }
                                if (strtolower($twog) == "y") {
                                    //$twogid = $saq_technical->getId("2G");
                                    array_push($ary_technical, "2");
                                }
                                if (strtolower($threeg) == "y") {
                                    //$threegid = $saq_technical->getId("3G");
                                    array_push($ary_technical, "3");
                                }
                                if (strtolower($fourg) == "y") {
                                    //$fourgid = $saq_technical->getId("4G");
                                    array_push($ary_technical, "4");
                                }
                                if (strtolower($TDD) == "y") {
                                    //$TDDid = $saq_technical->getId("TDD");
                                    array_push($ary_technical, "5");
                                }
                                if (strtolower($FDD) == "y") {
                                    //$FDDid = $saq_technical->getId("FDD");
                                    array_push($ary_technical, "6");
                                }
                                if (strtolower($Fiber) == "y") {
                                    //$Fibid = $saq_technical->getId("Fibre");
                                    array_push($ary_technical, "7");
                                }
                                $site->technical = $ary_technical;
                                if ($site->update($tab,"API")) {
                                    $msg .= "Technical data updated";
                                } else {
                                    $msg .= "<font color='red'>site data update failed.</font>";
                                }
                            } else if ($tab == "P") {
                                
                                $agreement_status =$data['1']; 
                                $date_expire=$data['2']; 
                                $date_start=$data['3']; 
                                $payment_mode=$data['4']; 
                                $lease_period=$data['5']; 
                                $current_month_payment=$data['6']; 
                                $start_monthly_rental=$data['7']; 
                                $rate_increment=$data['8']; 
                                $advance_payment=$data['9']; 
                                $bank_account=$data['10']; 
                                $bank_name=$data['11']; 
                                $branch_name=$data['12']; 
                                $account_type=$data['13']; 
                                $account_holder_name=$data['14']; 
                                $account_holder_nic=$data['15']; 
                                $monthly_deduction_for_adv=$data['16']; 
                                $adv_recovery_period=$data['17']; 
                                $site_aggreement_obj = $site->getSiteAgreementData();
                                
                                
                                //print "SITE AGGREEMENT  DATA ID ".$site_aggreement_obj->id."<br>";
                                $agreement_id =$site_aggreement_obj->id;
                                if($agreement_id !=""){
                                   /// $saq_site_agreement_data = new saq_site_agreement_data($agreement_id);
                                   $agreement_id = $agreement_id;
                                }else {
                                    //insert new aggreement 
                                    $saq_site_agreement_data->saq_sites_id = $site_id;
                                    $saq_site_agreement_data->add();
                                    $agreement_id= $saq_site_agreement_data->id;
                                }
                               // print $date_expire."<br>";
                                //$date_expire = $date_expire=="" ? "" : $date->transform_date($date_expire);
                                //$date_start = $date_start =="" ? "" : $date->transform_date($date_start);
                                //print $date_expire."<br>";
                                
                                /*if($date_expire ==""){
                                    $date_expire = "NULL";
                                }else {
                                    $date_expire =  $date->transform_date($date_expire);
                                }
                                if($date_start ==""){
                                    $date_start = "NULL";
                                }else {
                                    $date_start =  $date->transform_date($date_start);
                                }*/
                                $agreement_data_array = array(
                                    "agreement_data_id"=>$agreement_id,
                                    "agreement_status"=>$agreement_status,
                                    "agreement_expire_date" => $date_expire,
                                    "agreement_start_date" => $date_start,
                                    "payment_mode"=>$payment_mode,
                                    "leas_period"=>$lease_period,
                                    "current_month_payment"=>$current_month_payment,
                                    "start_monthly_rental"=>$start_monthly_rental,
                                    "rate_increment"=>$rate_increment,
                                    "advance_payment"=>$advance_payment,
                                    "bank_account"=>$bank_account,
                                    "bank_name"=>$bank_name,
                                    "branch_name"=>$branch_name,
                                    "acc_type"=>$account_type,
                                    "acc_holder_name"=>$account_holder_name,
                                    "acc_holder_nic_no"=>$account_holder_nic,
                                    "mdafar"=>$monthly_deduction_for_adv,
                                    "adv_recovery_period"=>$adv_recovery_period
                                    
                                    
                                    
                                );
                                
                                $site->agreement_data = $agreement_data_array;
                                /*$saq_site_agreement_data->agreement_status = $agreement_status;
                                $saq_site_agreement_data->date_expire = $date_expire;
                                $saq_site_agreement_data->date_start = $date_start;
                                $saq_site_agreement_data->payment_mode = $payment_mode;
                                $saq_site_agreement_data->lease_period = $lease_period;
                                $saq_site_agreement_data->current_month_payment = $current_month_payment;
                                $saq_site_agreement_data->start_monthly_rental = $start_monthly_rental;
                                $saq_site_agreement_data->rate_increment = $rate_increment;
                                $saq_site_agreement_data->advance_payment = $advance_payment;
                                $saq_site_agreement_data->bank_account = $bank_account;
                                $saq_site_agreement_data->bank_name = $bank_name;
                                $saq_site_agreement_data->branch_name = $branch_name;
                                $saq_site_agreement_data->account_type = $account_type;
                                $saq_site_agreement_data->account_holder_name = $account_holder_name;
                                $saq_site_agreement_data->account_holder_nic = $account_holder_nic;
                                $saq_site_agreement_data->monthly_deduction_for_adv = $monthly_deduction_for_adv;
                                $saq_site_agreement_data->adv_recovery_period = $adv_recovery_period;
                                $saq_site_agreement_data->saq_sites_id = $site_id;*/
                               // echo $date_expire."<br>";
                                if ($site->update($tab,"API")) {
                                    $msg .= "Payment data updated";
                                } else {
                                    $msg .= "<font color='red'>Payment data update failed.</font>";
                                }
                                
                                
                                
                                
                                
                                
                            } else if ($tab == "A") {
                                $ary_approval = array();
                                $f_1 = $data['1'];
                                $f_2 = $data['2'];
                                $f_3 = $data['3'];
                                $f_4 = $data['4'];
                                $f_5 = $data['5'];
                                $f_6 = $data['6'];
                                $f_7 = $data['7'];
                                $f_8 = $data['8'];
                                $f_9 = $data['9'];
                                $f_10 = $data['10'];
                                $f_11 = $data['11'];
                                $f_12 = $data['12'];
                                $f_13 = $data['13'];
                                $f_14 = $data['14'];
                                $f_15 = $data['15'];
                                $f_16 = $data['16'];
                                $f_17 = $data['17'];
                                $f_18 = $data['18'];
                                $f_19 = $data['19'];
                                $f_20 = $data['20'];
                                $f_21 = $data['21'];
                                $f_22 = $data['22'];
                                $f_23 = $data['23'];
                                $f_24 = $data['24'];
                                $f_25 = $data['25'];
                                $f_26 = $data['26'];
                                if (strtolower($f_1) == "y") {
                                    array_push($ary_approval, "1");
                                }
                                if (strtolower($f_2) == "y") {
                                    array_push($ary_approval, "2");
                                }
                                if (strtolower($f_3) == "y") {
                                    array_push($ary_approval, "3");
                                }
                                if (strtolower($f_4) == "y") {
                                    array_push($ary_approval, "4");
                                }
                                if (strtolower($f_5) == "y") {
                                    array_push($ary_approval, "5");
                                }
                                if (strtolower($f_6) == "y") {
                                    array_push($ary_approval, "6");
                                }
                                if (strtolower($f_7) == "y") {
                                    array_push($ary_approval, "7");
                                }
                                if (strtolower($f_8) == "y") {
                                    array_push($ary_approval, "8");
                                }
                                if (strtolower($f_9) == "y") {
                                    array_push($ary_approval, "9");
                                }
                                if (strtolower($f_10) == "y") {
                                    array_push($ary_approval, "10");
                                }
                                if (strtolower($f_11) == "y") {
                                    array_push($ary_approval, "11");
                                }
                                if (strtolower($f_12) == "y") {
                                    array_push($ary_approval, "12");
                                }
                                if (strtolower($f_13) == "y") {
                                    array_push($ary_approval, "13");
                                }
                                if (strtolower($f_14) == "y") {
                                    array_push($ary_approval, "14");
                                }
                                if (strtolower($f_15) == "y") {
                                    array_push($ary_approval, "15");
                                }
                                if (strtolower($f_16) == "y") {
                                    array_push($ary_approval, "16");
                                }
                                if (strtolower($f_17) == "y") {
                                    array_push($ary_approval, "17");
                                }
                                if (strtolower($f_18) == "y") {
                                    array_push($ary_approval, "18");
                                }
                                if (strtolower($f_19) == "y") {
                                    array_push($ary_approval, "19");
                                }
                                if (strtolower($f_20) == "y") {
                                    array_push($ary_approval, "20");
                                }
                                if (strtolower($f_21) == "y") {
                                    array_push($ary_approval, "21");
                                }
                                if (strtolower($f_22) == "y") {
                                    array_push($ary_approval, "22");
                                }
                                if (strtolower($f_23) == "y") {
                                    array_push($ary_approval, "23");
                                }
                                if (strtolower($f_24) == "y") {
                                    array_push($ary_approval, "24");
                                }
                                if (strtolower($f_25) == "y") {
                                    array_push($ary_approval, "25");
                                }
                                if (strtolower($f_26) == "y") {
                                    array_push($ary_approval, "26");
                                }
                                $site->approvals = $ary_approval;
                                if ($site->update($tab,"API")) {
                                    $msg .= "Approval data updated";
                                } else {
                                    $msg .= "<font color='red'>approval data update failed.</font>";
                                }
                            } else {
                                
                            }

                            //var_dump($site);

                            /*if($site->update("G","API")){
                                $msg.="site data updated";
                            }
                            else{
                                $msg.="<font color='red'>site data update failed.</font>";
                            }*/
                            $log.="<tr>
                                        <td>".$data[0]."</td>
                                        <td>". $msg."</td>
                                        <td>".$site->update_string."</td>
                                    </tr>";
                        } else {
                            //Error
                            $msg .= 'data column count mismatched.please check the address and other fields whether additional "," is there.';
                        }
                    }
                    $row++;
                    //print $msg."<br>";
                }
                fclose($handle);
            }
        } else {
            $err_msg = "Could not upload the file.";
        }
    } else {
        $errorMsg = "Please upload CSV file format";
    }
}
}

function cleanCSVData($d) {
    if ($d == '#N/A') {
        return "";
    } else {
        return $d;
    }
}

function uploadContact() {
    $site->name = $data[1];
    $site->type = $data[2];
    $site->address = $data[3];
    $site->site_ownership = $data[4];
    $site->operator_name = $data[5];
    $site->tower_height = $data[6];
    $site->building_height = $data[7];
    $site->land_area = $data[8];
    $site->on_air_date = $data[9];
    $site->category = $data[10];
    $site->lat = $data[11];
    $site->lon = $data[12];
    $site->access_type = $data[13];
    $site->manual_distance = $data[14];
    $site->access_permision_type = $data[15];
    $site->pg_installation_possibility = $data[16];
    $site->region_id = cleanCSVData($data[18]);
    //$site->province_id=cleanData($data[21]);
    $site->district_id = cleanCSVData($data[20]);
    $site->ds_id = cleanCSVData($data[21]);
    $site->la_id = cleanCSVData($data[22]);
    $site->police_station_id = cleanCSVData($data[23]);
    $site->dns_office_id = cleanCSVData($data[24]);
    var_dump($site);
    if ($site->update("")) {
        $msg .= "site data updated";
    } else {
        $msg .= "<font color='red'>site data update failed.</font>";
    }
    $log .= "<tr>
                                        <td>" . $data[0] . "</td>
                                        <td>" . $msg . "</td>
                                        <td>" . $site->update_string . "</td>
                                    </tr>";
}
?>
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
                    <div class="jarviswidget" id="w_inv_e1"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">
                        <header>
                            <span class="widget-icon"> <i class="fa fa-edit"></i></span>
                            <h2>Update site data through a file</h2>				

                        </header>

                        <!-- widget div-->
                        <div>

                            <!-- widget edit box -->
                            <div class="jarviswidget-editbox">
                                <!-- This area used as dropdown edit box -->

                            </div>
                            <!-- end widget edit box -->

                            <!-- widget content -->
                            <div class="widget-body">
                                <form id="from_inventory_add" class="smart-form" method="post" action="" enctype="multipart/form-data">
                                    <table class="table table-striped" width="100%">
                                        <tbody>
                                            <tr>
                                                <td align="right"><strong>EDIT TAB:</strong></td>
                                                <td width="150">
                                                    <label class="select">													
                                                        <select name="tab" id="tab">
                                                            <option value="G" selected="">General</option>
                                                            <option value="C">Contact</option>
                                                            <option value="T">Technical</option>
                                                            <option value="P">Agreement&Payment</option>
                                                            <option value="A">Approvals</option>
                                                        </select> <i></i> 
                                                    </label>
                                                </td>
                                                <td><strong>Template File:</strong></td>
                                                <td>
                                                    <span id="template_file_url"></span>
                                                </td>
                                                <td>
                                                    <label class="input"> <i class="icon-append fa fa-file"></i>
                                                        <input type="file" name="file" id="file" placeholder="">
                                                    </label>                                                    
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-primary" id="but" name="but" value="update" style="padding: 6px 12px;">Update</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <div style="border-top: 1px solid gray; width: 80%; margin-left: auto;margin-right: auto;">
                                        <label style="width: 100%; text-align: center;"><h3>Update Logs</h3></label>

                                    </div>

                                    <div class="row do-not-print" id="row_1">
                                        <table class="table table-striped" width="100%">
                                            <tr>
                                                <td width="150px">Code</td>
                                                <td width="300px">Result</td>
                                                <td>Note</td>
                                            </tr>
                                            <?php print $log ?>
                                            
                                        </table>
                                        <p style="color:red;font-size:15px;text-align:center;"><?php print $errorMsg; ?></p>
                                    </div>


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

<!-- PAGE FOOTER -->
<?php
// include page footer
//include("../inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php
//include required scripts
include("../inc/scripts.php");
?>
<!-- PAGE RELATED PLUGIN(S) -->


<script type="text/javascript">
//checkUserPopUpBlank('<?php //print $_SESSION['UID']  ?>');

// DO NOT REMOVE : GLOBAL FUNCTIONS!


    $(document).ready(function () { 
        $('#template_file_url').html("<a href='<?php echo ASSETS_URL ?>/sites/download_template_file?file=G' target='_blank'>template-general</a>");
        $('#tab').change(function () {
            switch ($(this).children("option:selected").val()) {
                case 'G':
                    $('#template_file_url').html("<a href='<?php echo ASSETS_URL ?>/sites/download_template_file?file=G' target='_blank'>template-general</a>");
                    break;
                case 'C':
                    $('#template_file_url').html("<a href='<?php echo ASSETS_URL ?>/sites/download_template_file?file=C' target='_blank'>template-contact</a>");
                    break;
                case 'T':
                    $('#template_file_url').html("<a href='<?php echo ASSETS_URL ?>/sites/download_template_file?file=T' target='_blank'>template-technical</a>");
                    break;
                case 'P':
                    $('#template_file_url').html("<a href='<?php echo ASSETS_URL ?>/sites/download_template_file?file=P' target='_blank'>template-agreement_payments</a>");
                    break;
                case 'A':
                    $('#template_file_url').html("<a href='<?php echo ASSETS_URL ?>/sites/download_template_file?file=A' target='_blank'>template-approvals</a>");
                    break;
            }

        });
    });
</script>
