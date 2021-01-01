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

                                                                        </td>
                                                                        <td><strong></strong></td>
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
	include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php 
	//include required scripts
	include("inc/scripts.php"); 

?>
<!-- PAGE RELATED PLUGIN(S) -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

<script type="text/javascript" src="jeegoopopup/jquery.jeegoopopup.1.0.0.js"></script>
<link href="jeegoopopup/skins/blue/style.css" rel="Stylesheet" type="text/css" />
<link href="jeegoopopup/skins/round/style.css" rel="Stylesheet" type="text/css" />

<script type="text/javascript">
checkUserPopUpBlank('<?php print $_SESSION['UID']?>');
<?php 
if($close){
	//print "window.parent.location.reload(false);";
	//print "window.close();";
}

?>
// DO NOT REMOVE : GLOBAL FUNCTIONS!

var del=0;

$(document).ready(function() {
	$('#but_save').click(function(){
		$('#submitted').val("yes");
		$('#from_inventory_add').submit();
	});
	$('#inv_part_no').autocomplete({
		source: 'json/get_product_code.php',
		minLength:1,
		select: function(event,ui){			
			var id = ui.item.id;
			var prd = ui.item.partname;
			if(id != '') {
				$('#inv_prd_id').val(id);
				$('#inv_part_name').val(prd);
				showPartData(id);
			}
		}
    });	
	$('#inv_part_name').autocomplete({
		source: 'json/get_product.php',
		minLength:1,
		select: function(event,ui){			
			var id = ui.item.id;
			var prt_no = ui.item.partnumber;
			if(id != '') {
				$('#inv_prd_id').val(id);
				$('#inv_part_no').val(prt_no);
				showPartData(id);
			}
		}
    });
	$( "#inv_location" ).change(function() {
	  	showPartData($('#inv_prd_id').val());
	});
	
	$('#inv_qty').keyup(function(e){
		e.stopPropagation();
	    if(e.keyCode == 13)
	    {
		    e.preventDefault();
			var ex_rate=$('#inv_ex_rate').val();
			var prd_id=$('#inv_prd_id').val();
			var batch=$('#inv_batchno').val();
			var supplier=$('#inv_supplier').val();
			var bin=$('#inv_bin').val();
			var qty=$('#inv_qty').val();
			var loc=$('#inv_location').val();
			var loc_txt=$('#inv_location option:selected').text();
			var price=$('#inv_price').val();
			var part_no=$('#inv_part_no').val();
			var part_name=$('#inv_part_name').val();
			var inv_id='';
			var grn_id=$('#inv_grn_id').val();
                        if($('#inv_ex_rate').val()!=''){
                            var c=Math.round($('#inv_ex_rate').val()*$('#inv_cost').val()*100)/100;
                        }
                        else{
                            var c=$('#inv_cost').val();
                        }
                        if(grn_id!=''){
                                addProduct(grn_id,prd_id,batch,qty,loc,bin,price,part_no,part_name,loc_txt,c);
                        }
                        else{
                             $.ajax({
                                url: 'ajax/ajx_pre_grn_add.php', //this is the submit URL
                                type: 'POST', //or POST
                                data: {uid:<?php print $_SESSION['UID']?>, shipment_id: batch, supplier: supplier},
                                success: function(data){
                                        //alert(data);
                                    if(data!='0'){
                                            grn_id=data;	
                                            $('#inv_grn_id').val(grn_id);    
                                            addProduct(grn_id,prd_id,batch,qty,loc,bin,price,part_no,part_name,loc_txt,c);
                                    }
                                    else{
                                        alert('could not add GRN [0]');
                                    }
                                },
                                error: function(){
                                     alert("could not add GRN [1]");
                                }
                            });
                        }		
	    }
	});
	$('#inv_cost').keyup(function(e){
            if($('#inv_ex_rate').val()!=''){
                var c="<strong>Total:</strong>"+Math.round($('#inv_ex_rate').val()*$('#inv_cost').val()*100)/100;
                $('#txt_cost').html(c);
            }
	});
        $('#inv_qty').keyup(function(e){
            if($('#inv_ex_rate').val()!=''){
                var c="<strong>Total:</strong>"+(Math.round($('#inv_ex_rate').val()*$('#inv_cost').val()*100)/100)*$('#inv_qty').val();
                $('#txt_total_cost').html(c);
            }
            else{
                var c="<strong>Total:</strong>"+$('#inv_cost').val()*$('#inv_qty').val();
                $('#txt_total_cost').html(c);
            }
	});
    
});

function showPartData(prd_id){
	var loc=$("#inv_location").val();
	$.getJSON( "json/get_product_data.php", { prdid: prd_id, location: loc } )
	  .done(function( json ) {
	    if(json[0]['bin']=='' || json[0]['bin']==null){
	    	$("#txt_bin").html('not defined');
	    }
	    else{
	    	$("#txt_bin").html(json[0]['bin']);
	    }
	    if(json[0]['price']=='' || json[0]['price']==null){
	    	$("#txt_price").html('not defined');
	    }
	    else{
	    	$("#txt_price").html(json[0]['price']);
		}
	  })
	  .fail(function( jqxhr, textStatus, error ) {
	    var err = textStatus + ", " + error;
	    console.log( "Request Failed: " + err );
	});
}
function addProduct(grn_id,prd_id,batch,qty,loc,bin,price,part_no,part_name,loc_txt,cost){
	if(prd_id==''){
		$.ajax({
            url: 'ajax/ajx_product_add.php', //this is the submit URL
            type: 'POST', //or POST
            data: {uid:<?php print $_SESSION['UID']?>,prd_code: part_no, prd_name: part_name, price: price, cost: cost},
            success: function(data){
                if(data!='0'){
                	prd_id=data;	
            		$('#inv_grn_id').val(grn_id);    
            		addItem(grn_id,prd_id,batch,qty,loc,bin,price,part_no,part_name,loc_txt);
                }
                else{
                    alert('could not add GRN [0]');
                }
            },
            error: function(){
            	 alert("could not add GRN [1]");
            }
        });
	}
	else{
		addItem(grn_id,prd_id,batch,qty,loc,bin,price,part_no,part_name,loc_txt,cost);
	}
	
}
function addItem(grn_id,prd_id,batch,qty,loc,bin,price,part_no,part_name,loc_txt,cost){
    if(!add){
        alert("you do not have previledge");
        return;
    }
	$.ajax({
        url: 'ajax/ajx_pre_grn_item_add.php', //this is the submit URL
        type: 'POST', //or POST
        data: {uid:<?php print $_SESSION['UID']?>,grn_id: grn_id, inv_prd_id: prd_id,inv_batchno: batch, inv_qty:qty,inv_location:loc, inv_price:price, bin:bin, cost: cost},
        success: function(data){
            //alert(data);
            dd=data.split(";");
            inv_id=dd[0];
            pgrn_value=dd[1];
            if(isNaN(inv_id)==false){
                
                var html='<div class="row" id="'+inv_id+'"><section class="col col-2">'+
						part_no+'</section><section class="col col-4">'+
						part_name+'</section><section class="col col-1">'+loc_txt+
						'</section><section class="col col-1">'+bin+
                                                '</section><section class="col col-1">'+cost+
						'</section><section class="col col-1">'+price+
						'</section><section class="col col-1">'+qty+" ("+(cost*qty)+")"+
						'</section><section class="col col-1"><a href="javascript:delete_item('+"'"+inv_id+"'"+')"><img alt="" src="img/cross.png" width="16px" height="16px"></a></section></div>';
						
        		$('#inv_prd_id').val('');    
        		$('#inv_qty').val('');   
        		$('#inv_part_no').val('');
        		$('#inv_part_name').val('');  
                        $('#inv_cost').val('');
        		$('#inv_price').val('');   
        		$('#inv_bin').val('');
        		$('#row_1').after(html);
                        $("#grn_total").html(pgrn_value);
            }
            else{
                alert('faile-[NAN]');
            }
        },
        error: function(){
        	 alert("failure");
        }
    });
}
function delete_item(inv_id){
	var newDiv = $(document.createElement('div')); 
	  $(newDiv).html('Item will be deleted.Are you sure?');
	  $(newDiv).attr('title','Delete Inventry Item');
	  //$(newDiv).css('font-size','62.5%');
	  $(newDiv).dialog({
	      resizable: false,
	      height:160,
	      modal: true,
	      buttons: {
	        "Yes": function() { 
			  $.ajax({
		            url: 'ajax/ajx_pre_grn_item_delete.php', //this is the submit URL
		            type: 'POST', //or POST
		            data: {INVID: inv_id ,uid:<?php print $_SESSION['UID']?>, pgrn_id: $('#inv_grn_id').val()},
		            success: function(data){
		                if(data!='0'){
			                var id_of_div='#'+inv_id;			                	                  
		                	$(id_of_div).remove();	
                                        $("#grn_total").html(data);
		                }
		                else{
		                	alert("failure");
		                }
		            },
		            error: function(){
		            	 alert("failure");
		            }
		        });
			  $( this ).dialog( "close" );
	        },
	        Cancel: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });
}



function print_this(){
	window.print();
}
</script>
