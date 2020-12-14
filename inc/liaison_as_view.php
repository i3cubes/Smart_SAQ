<?php
error_reporting(0);
session_start();
include_once 'class/fault_ticket_manager.php';
include_once 'class/seviceJobManager.php';
include_once 'class/repair_order_manager.php';
include_once 'class/employee.php';
//
//print_r($_SESSION);
$ary_prev = $_SESSION['ROLE_PREV'];
//print_r($ary_prev);
//initilize the page
require_once("lib/config.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Home";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "ngs.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["dashboard"]["active"] = true;
include("inc/nav.php");

include_once 'class/reports.php';
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main" style="padding-bottom: 0px;">
    <?php
//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
//$breadcrumbs["New Crumb"] => "http://url.com"
//include("inc/ribbon.php");
    ?>

    <!-- MAIN CONTENT -->
    <div id="content">
        <div class="row" id="div_db">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div id="div_db_jo" style="float: right;display: table-cell;">
                    <ul id="sparks" >

                        <?php
                        $datemonth_fst = date("Y-m") . "-01 00:00:00";
                        $datetoday1st = date("Y-m-d") . " 00:00:00";
                        $datenow = date("Y-m-d") . " 23:59:59";

                        $ft_rep_month = new reports();
                        $ft_rep_month->summery_counts($datemonth_fst, $datenow, "fault_ticket");
                        ?>
                        <li class="sparks-info" style="height: 80px;max-height: 80px;text-align: center;">
                            <h5 style="text-align: center;">FT this month
                                <span style="text-align: center;">
                                    <table style="margin-left: auto; margin-right: auto;">
                                        <tr>
                                            <td style="font-size: 10px; padding-right: 8px;" align="right">Open</td>
                                            <td style="font-size: 10px; border-left: 1px solid black; padding-left: 8px;" align="left">Closed</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px; padding-right: 8px;" align="right"><?= $ft_rep_month->tot_open ?></td>
                                            <td style="font-size: 12px; border-left: 1px solid black; padding-left: 8px;" align="left"><?= $ft_rep_month->tot_closed ?></td>
                                        </tr>
                                    </table>
                                </span></h5>
                        </li>
                        <li class="sparks-info" style="height: 80px;max-height: 80px;text-align: center;">
                            <h5>FT Status 
                                <span style="text-align: center;">
                                    <?php
                                    $ft_rep_today = new reports();
                                    $ft_rep_today->summery_counts($datetoday1st, $datenow, "fault_ticket");
                                    ?> 
                                    <table style="margin-left: auto; margin-right: auto;">
                                        <tr>
                                            <td style="font-size: 10px; padding-right: 8px;" align="right">Open</td>
                                            <td style="font-size: 10px; border-left: 1px solid black; padding-left: 8px;" align="left">Pending</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px;padding-right: 8px;" align="right"><?= $ft_rep_today->tot_open ?></td>
                                            <td style="font-size: 12px; border-left: 1px solid black; padding-left: 8px;" align="left"><?= $ft_rep_today->tot_pending ?></td>
                                        </tr>
                                    </table>
                                </span></h5>
                        </li>
                        <li class="sparks-info" style="height: 80px;max-height: 80px;text-align: center;">
                            <h5>AMC Expiring
                                <span style="text-align: center;">
                                    <table style="margin-left: auto; margin-right: auto;">
                                        <tr>
                                            <td style="font-size: 10px; padding-right: 8px;" align="right">this month</td>
                                            <td style="font-size: 10px; border-left: 1px solid black; padding-left: 8px;" align="left">next month</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px;padding-right: 8px;" align="right">20</td>
                                            <td style="font-size: 12px; border-left: 1px solid black;padding-left: 8px;" align="left">18</td>
                                        </tr>
                                    </table>
                                </span></h5>
                        </li>
                        <li class="sparks-info" style="height: 80px;max-height: 80px;text-align: center;">
                            <h5>AMC Service - this month
                                <span style="text-align: center;">
                                    <table style="margin-left: auto; margin-right: auto;">
                                        <tr>
                                            <td style="font-size: 10px; padding-right: 8px;" align="right">Schedule</td>
                                            <td style="font-size: 10px; border-left: 1px solid black; padding-left: 8px;" align="left">Completed</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px;padding-right: 8px;" align="right">89</td>
                                            <td style="font-size: 12px; border-left: 1px solid black; padding-left: 8px;" align="left">63</td>
                                        </tr>
                                    </table>
                                </span></h5>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- widget grid -->
        <section id="widget-grid" class="">
            <!-- row -->

            <div class="row">

                <article class="col-sm-12 col-md-12 col-lg-6">



                </article>

                <!-- ============================= -->

                <article class="col-sm-12 col-md-12 col-lg-6">
                    <div class="row">

                    </div>
                </article>
            </div>

            <!-- end row -->

        </section>
        <!-- end widget grid -->


    </div>
    <!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php
//include required scripts
include("inc/scripts.php");
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

<script type="text/javascript" src="jeegoopopup/jquery.jeegoopopup.1.0.0.js"></script>
<link href="jeegoopopup/skins/blue/style.css" rel="Stylesheet" type="text/css" />
<link href="jeegoopopup/skins/round/style.css" rel="Stylesheet" type="text/css" />

<script>
    checkUser('<?php print $_SESSION['UID'] ?>');

    $(document).ready(function () {
        var h = $(document).height();
        var cont_h = h - $('#header').height() - $('.page-footer').height();
        $('#content').height(cont_h);
        /*
         * PAGE RELATED SCRIPTS
         */

        $(window).resize(function () {
            var h = $(document).height();
            var cont_h = h - $('#header').height() - $('.page-footer').height();
            $('#content').height(cont_h);
        });

    });

</script>

<?php
//include footer
?>