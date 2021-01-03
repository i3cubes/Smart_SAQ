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

//include_once 'lib/i3c_config.php';

//print_r($_POST);
if($_POST['submitted']=='yes'){	

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
								<form id="from_inventory_add" class="smart-form" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
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
                                                                                    <td>Code</td>
                                                                                    <td>Result</td>
                                                                                    <td>Note</td>
                                                                                </tr>
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
    $('#tab').change(function(){
        $('#template_file_url').html("../file/template.php");
    });
});
</script>
