<?php
require_once("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)
require_once("../inc/config.ui.php");

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Agreements";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "ngs.css";
include("../inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["samples"]["sub"]["agreements"]["active"] = true;
include("../inc/nav.php");
//include_once 'class/reports.php';
include_once '../class/constants.php';
?>
<style>

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

            <div class="jarviswidget"
                 data-widget-deletebutton="false" 
                 data-widget-togglebutton="false"
                 data-widget-editbutton="false"
                 data-widget-fullscreenbutton="false"
                 data-widget-colorbutton="false">
                <header>
                    <!--<span class="widget-icon"> <i class="fa fa-edit"></i> </span>-->
                    <h2 style=""><b>AGREEMENTS</b></h2>                     
                </header> 
                <div class="widget-body">
                    <div class="tree">
                        <ul>
                            <li>
                                <span><i class="fa fa-lg fa-calendar"></i> 2013, Week 2</span>
                                <ul>
                                    <li>
                                        <span class="label label-success"><i class="fa fa-lg fa-plus-circle"></i> Monday, January 7: 8.00 hours</span>
                                        <ul>
                                            <li>
                                                <span><i class="fa fa-clock-o"></i> 8.00</span> &ndash; <a href="javascript:void(0);">Changed CSS to accomodate...</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <span class="label label-success"><i class="fa fa-lg fa-minus-circle"></i> Tuesday, January 8: 8.00 hours</span>
                                        <ul>
                                            <li>
                                                <span><i class="fa fa-clock-o"></i> 6.00</span> &ndash; <a href="javascript:void(0);">Altered code...</a>
                                            </li>
                                            <li>
                                                <span><i class="fa fa-clock-o"></i> 2.00</span> &ndash; <a href="javascript:void(0);">Simplified our approach to...</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <span class="label label-warning"><i class="fa fa-lg fa-minus-circle"></i> Wednesday, January 9: 6.00 hours</span>
                                        <ul>
                                            <li>
                                                <span><i class="fa fa-clock-o"></i> 3.00</span> &ndash; <a href="javascript:void(0);">Fixed bug caused by...</a>
                                            </li>
                                            <li>
                                                <span><i class="fa fa-clock-o"></i> 3.00</span> &ndash; <a href="javascript:void(0);">Comitting latest code to Git...</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <span class="label label-danger"><i class="fa fa-lg fa-minus-circle"></i> Wednesday, January 9: 4.00 hours</span>
                                        <ul>
                                            <li>
                                                <span><i class="fa fa-clock-o"></i> 2.00</span> &ndash; <a href="javascript:void(0);">Create component that...</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <span><i class="fa fa-lg fa-calendar"></i> 2013, Week 3</span>
                                <ul>
                                    <li>
                                        <span class="label label-success"><i class="fa fa-lg fa-minus-circle"></i> Monday, January 14: 8.00 hours</span>
                                        <ul>
                                            <li>
                                                <span><i class="fa fa-clock-o"></i> 7.75</span> &ndash; <a href="javascript:void(0);">Writing documentation...</a>
                                            </li>
                                            <li>
                                                <span><i class="fa fa-clock-o"></i> 0.25</span> &ndash; <a href="javascript:void(0);">Reverting code back to...</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

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
        loadScript("<?php echo ASSETS_URL; ?>/js/plugin/bootstraptree/bootstrap-tree.min.js");
    });
</script>

