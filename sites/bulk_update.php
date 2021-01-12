<?php
session_start();
//initilize the page

//print_r($_SESSION);
require_once("../lib/config.php");

//print_r($ary_prev[3]);
//require UI configuration (nav, ribbon, etc.)


/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Sites-Bulk Update";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("../ngs/header_ngspopup.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["forms"]["sub"]["smart_layout"]["active"] = true;
//include("..inc/nav.php");

// ====================== LOGIC ================== --!>

include_once '../class/cls_site.php';
include_once '../class/cls_site_manager.php';

$site_mgr=new site_manager();

print_r($_POST);
//print $_FILES['file']['tmp_name'];
if($_POST['but']=='update'){	
    if(isset($_FILES)){
        $f_name=$_FILES['file']['name']; 
        $source = $_FILES['file']['tmp_name'];
        $save_to="../files/sitedata/".time()."_".$f_name;
        //print $save_to;
        if(move_uploaded_file($source, $save_to)) { 
            chmod($saveloc,644);
            //Update Data
            $row = 1;
            $col_count=0;
            if (($handle = fopen($save_to, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    //print $data;
                    $msg="";
                    if($row==1){
                        $col_count=count($data);
                    }
                    else{
                        $num = count($data);
                        //print "N=".$num;
                        if($col_count==$num){
                            //Update
                            $site_id=$site_mgr->getSiteIDFromCode(trim($data[0]));
                            if($site_id!=''){
                                $site=new site($site_id);
                            }
                            else{
                                $site=new site();
                                $site->code=trim($data[0]);
                                if($site->addTemplate()){
                                    $msg.="new site added.";
                                }
                                else{
                                    $msg.="<font color='red'>Could not add new site.</font>";
                                }
                            }
                            $site->name=$data[1];
                            $site->type=$data[2];
                            $site->address=$data[3];
                            $site->site_ownership=$data[4];
                            $site->operator_name=$data[5];
                            $site->tower_height=$data[6];
                            $site->building_height=$data[7];
                            $site->land_area=$data[8];
                            $site->on_air_date=$data[9];
                            $site->category=$data[10];
                            $site->lat=$data[11];
                            $site->lon=$data[12];
                            $site->access_type=$data[13];
                            $site->manual_distance=$data[14];
                            $site->access_permision_type=$data[15];
                            $site->pg_installation_possibility=$data[16];
                            $site->region_id=cleanCSVData($data[18]);
                            //$site->province_id=cleanData($data[21]);
                            $site->district_id=cleanCSVData($data[20]);
                            $site->ds_id=cleanCSVData($data[21]);
                            $site->la_id=cleanCSVData($data[22]);
                            $site->police_station_id=cleanCSVData($data[23]);
                            $site->dns_office_id=cleanCSVData($data[24]);
                            
                            //var_dump($site);
                            if($site->update("G","API")){
                                $msg.="site data updated";
                            }
                            else{
                                $msg.="<font color='red'>site data update failed.</font>";
                            }
                            $log.="<tr>
                                        <td>".$data[0]."</td>
                                        <td>". $msg."</td>
                                        <td>".$site->update_string."</td>
                                    </tr>";
                        }
                        else{
                            //Error
                            $msg.='data column count mismatched.please check the address and other fields whether additional "," is there.';
                        }
                        
                    }
                    $row++;
                    //print $msg."<br>";
                }
                fclose($handle);
            }
        }
        else{
            $err_msg="Could not upload the file.";
        }
    }
}

function cleanCSVData($d){
    if($d=='#N/A'){
        return "";
    }
    else{
        return $d;
    }
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
                                                                                <?php print $log?>
                                                                            </table>
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
//checkUserPopUpBlank('<?php //print $_SESSION['UID']?>');

// DO NOT REMOVE : GLOBAL FUNCTIONS!


$(document).ready(function() {
    $('#template_file_url').html("<a href='<?php echo ASSETS_URL?>/sites/download_template_file?file=G' target='_blank'>template-general</a>");
    $('#tab').change(function(){
        switch($(this).children("option:selected").val()){
            case 'G':
                $('#template_file_url').html("<a href='<?php echo ASSETS_URL?>/sites/download_template_file?file=G' target='_blank'>template-general</a>");
                break;
            case 'C':
                $('#template_file_url').html("<a href='<?php echo ASSETS_URL?>/sites/download_template_file?file=C' target='_blank'>template-contact</a>");
                break;
            case 'T':
                $('#template_file_url').html("<a href='<?php echo ASSETS_URL?>/sites/download_template_file?file=T' target='_blank'>template-technical</a>");
                break;
            case 'P':
                $('#template_file_url').html("<a href='<?php echo ASSETS_URL?>/sites/download_template_file?file=P' target='_blank'>template-agreement_payments</a>");
                break;
            case 'A':
                $('#template_file_url').html("<a href='<?php echo ASSETS_URL?>/sites/download_template_file?file=A' target='_blank'>template-approvals</a>");
                break;
        }
        
    });
});
</script>
