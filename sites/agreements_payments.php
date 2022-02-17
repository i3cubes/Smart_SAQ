<?php
require_once("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)
require_once("../inc/config.ui.php");

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Site Data";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "ngs.css";
include("../inc/header.php");
$page_nav["site_data"]["sub"]["agreement_payments"]["active"] = true;
//include left panel (navigation)
//follow the tree in inc/config.ui.php
//$page_nav["view"]["active"] = true;
include("../inc/nav.php");
//include_once 'class/reports.php';
include_once '../class/constants.php';

include_once '../class/cls_saq_payment_mode.php';
include_once '../class/cls_saq_rate_increment.php';
//
include_once '../class/functions.php';

include_once '../class/shared.php';


$fn = new functions();


$value = $_POST['increment_rate'];
if(isset($_POST['submit'])) {
    $shared = new shared();
    $result = $shared->updateVariable($value);
    if($result) {
        
    }
}
?>
<style>
    .jarviswidget .widget-body {
        height: 250px;
        scroll-behavior: smooth;
        overflow-x: auto;
    }
</style>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main" style="padding-bottom: 0px;">  
    <!-- MAIN CONTENT -->
    <div id="content">
        <div class="row" id="div_db">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            </div>
        </div>
        <!-- widget grid -->
        <section id="widget-grid">
            <!-- row -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="jarviswidget"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">


                        <header>
                            <!--<span class="widget-icon"> <i class="fa fa-edit"></i> </span>-->
                            <h2 style=""><b>Rate Increment</b></h2> 
                            <button class="btn btn-default btn-xs" style="float:right;margin:5px;" type="button" onclick="addRateIncrement()">Add&nbsp;<i class="fa fa-plus-square"></i></button>
                            <!--<button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="bulk_update(0)">Bulk Edit&nbsp;<i class="fa fa-cogs"></i></button>-->
                        </header> 
                        <div class="widget-body">
                            
                            <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">       
                                <tbody>       

                                    <?php
                                    //$gn_division->saq_district_id = $gn_district;
                                    $saq_rate_increment_obj = new saq_rate_increment();
                                    $rate_increments = $saq_rate_increment_obj->getAll();

                                    //print_r($gn_division);
                                    if (count($rate_increments) > 0) {
                                        foreach ($rate_increments as $rate_increment) {
                                            print "<tr class='ngs-popup-rate-increment' id ='$rate_increment->id'>"
                                                    . "<td>" . $rate_increment->name . "</td>"
                                                    . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <script>
                                $('.ngs-popup-rate-increment').click(function () {


                                    var id = this.id;

                                    addRateIncrement(id);

                                });


                            </script>
                        </div>

                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="jarviswidget"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">


                        <header>
                            <!--<span class="widget-icon"> <i class="fa fa-edit"></i> </span>-->
                            <h2 style=""><b>Payment Mode</b></h2> 
                            <button class="btn btn-default btn-xs" style="float:right;margin:5px;" type="button" onclick="addPaymentMode()">Add&nbsp;<i class="fa fa-plus-square"></i></button>
                            <!--<button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="bulk_update(0)">Bulk Edit&nbsp;<i class="fa fa-cogs"></i></button>-->
                        </header> 
                        <div class="widget-body">

                            <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">       
                                <tbody>       

                                    <?php
                                    //$gn_division->saq_district_id = $gn_district;
                                    $saq_payment_mode = new saq_payment_mode();
                                    $payment_modes = $saq_payment_mode->getAll();

                                    //print_r($gn_division);
                                    if (count($payment_modes) > 0) {
                                        foreach ($payment_modes as $payment_mode) {
                                            print "<tr class='ngs-popup-pay-mode' id ='$payment_mode->id'>"
                                                    . "<td>" . $payment_mode->name . "</td>"
                                                    . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--</div>-->
                            <script>
                                $('.ngs-popup-pay-mode').click(function () {


                                    var id = this.id;

                                    addPaymentMode(id);

                                });


                            </script>
                        </div>

                    </div>
                </div>              
            </div>             
    </div>
</section>
</div>

<!-- end row -->


<!-- end widget grid -->



</div>
<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
//include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php
//include required scripts
include("../inc/scripts.php");
?>

<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->
<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.cust.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.tooltip.min.js"></script>

<!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- Full Calendar -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>

<script type="text/javascript" src="../jeegoopopup/jquery.jeegoopopup.1.0.0.js"></script>
<link href="../jeegoopopup/skins/blue/style.css" rel="Stylesheet" type="text/css" />
<link href="../jeegoopopup/skins/round/style.css" rel="Stylesheet" type="text/css" />

<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

<script>
                                $(document).ready(function () {

                                });

                                function addPaymentMode(id = '') {
                                    var options = {
                                        url: 'add_payment_mode?id=' + id,
                                        width: '600',
                                        height: '300',
                                        skinClass: 'jg_popup_round',
                                        resizable: false,
                                        scrolling: 'no'
                                    };
                                    $.jeegoopopup.open(options);
                                }
                                
                                function addRateIncrement(id = '') {
                                    var options = {
                                        url: 'add_rate_increment?id=' + id,
                                        width: '600',
                                        height: '300',
                                        skinClass: 'jg_popup_round',
                                        resizable: false,
                                        scrolling: 'no'
                                    };
                                    $.jeegoopopup.open(options);
                                }

</script>

