<?php
// session_start();
// error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)
require_once("../inc/config.ui.php");

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "SAQ-Guidelines";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "ngs.css";
include("../inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["saq_guidelines"]["active"] = true;
include("../inc/nav.php");
//include_once 'class/reports.php';
include_once '../class/constants.php';
include_once '../class/cls_saq_guideline.php';
include_once '../class/cls_saq_guideline_manager.php';
?>
<style>
.saq_edit {
    cursor:pointer;
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

            <div class="jarviswidget"
                 data-widget-deletebutton="false" 
                 data-widget-togglebutton="false"
                 data-widget-editbutton="false"
                 data-widget-fullscreenbutton="false"
                 data-widget-colorbutton="false">
                <header>
                    <!--<span class="widget-icon"> <i class="fa fa-edit"></i> </span>-->
                    <h2 style=""><b>SAQ GUIDELINES</b></h2> 
                    <?php
                        if($_SESSION['UROLE'] == constants::$system_admin || $_SESSION['UROLE'] == constants::$admin) { ?>
                            <button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="saq_guideline_add_edit(0,'a')">Add&nbsp;<i class="fa fa-plus"></i></button>
                    <?php    }
                    ?>
                    
                </header> 
                <div class="widget-body">
                    <!--<div class="row">-->
                    <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">
                        <thead>
                            <tr style="height:40px;">
                                <td class="headerStyle">NAME</td>
                                <td class="headerStyle">DESCRIPTION</td>
                                <td class="headerStyle" width="15%">ADDED DATE</td>
                                <?php
                        if($_SESSION['UROLE'] == constants::$system_admin || $_SESSION['UROLE'] == constants::$admin) { ?>
                             <td class="headerStyle" width="5%" align="center">..</td>
                    <?php    }
                    ?>
                               
                            </tr>
                        </thead>
                        <tbody>       
                            <?php
                                $saq_gl_mgr=new saq_guideline_manager();
                                $saq_gl = new \saq_guideline();
                                $saq_guidelines = $saq_gl_mgr->getGuidlines();
//                                print_r($saq_guidelines);
                                foreach ($saq_guidelines as $saq_gl) {
                                    print "<tr>"                                          
                                            . "<td>".$saq_gl->name."</td>"
                                            . "<td>".$saq_gl->description."</td>"
                                            . "<td>".date("d/m/Y", strtotime($saq_gl->date))."</td>"
                                            . (($_SESSION['UROLE'] == constants::$system_admin || $_SESSION['UROLE'] == constants::$admin) ? '<td align="center" width="5%"><i class="fa fa-cog fa-lg" style="cursor:pointer;" id="'.$saq_gl->id.'" onclick=saq_guideline_add_edit("'.$saq_gl->id.'","e") aria-hidden="true"></i></td>' : '')
                                        . "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                    <!--</div>-->

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
    $("#table").DataTable({
        "paging": true,
        "ordering": false,
        "info": true
    });      
});     
                            
                            
                            function saq_guideline_add_edit(id = 0, flag) {                                 
                                 var options = {
                                    url: 'saq_guideline_add_edit?id=' + id,
                                    width: '600',
                                    height: 450,
                                    skinClass: 'jg_popup_round',
                                    resizable: false,
                                    scrolling: 'yes'
                                };
                                $.jeegoopopup.open(options);
                            }
</script>

