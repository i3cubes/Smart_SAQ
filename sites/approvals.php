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
$page_nav["site_data"]["sub"]["approvals"]["active"] = true;
//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["view"]["active"] = true;
include("../inc/nav.php");
//include_once 'class/reports.php';
include_once '../class/constants.php';
include_once '../class/cls_site_manager.php';
include_once '../class/cls_saq_technical.php';
include_once '../class/cls_saq_other_operator.php';
include_once '../class/cls_saq_approvals.php';
//
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
                    <h2 style=""><b>Approvals</b></h2> 
                    <button class="btn btn-default btn-xs" style="float:right;margin:5px;" type="button" onclick="addEditApprovals()">Add&nbsp;<i class="fa fa-plus-square"></i></button>
                    <!--<button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="bulk_update(0)">Bulk Edit&nbsp;<i class="fa fa-cogs"></i></button>-->
                </header> 
                <div class="widget-body">
                    <!--<div class="row">-->
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <th width="5%"></th>
                                                        <th>Requirement</th>
                                                        <th>Approval Name</th>
                                                        <th>Short Name</th>
                                                        
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $saq_approvels_obj = new saq_approvals();
                                                            $approvals = $saq_approvels_obj->getAll();

                                                            foreach ($approvals as $approval) {
                                                                if ($site_obj->id != '') {
                                                                    $checkAvailable = $site_obj->getApprovalsPresentSite($approval->id);
                                                                }

                                                                print "<tr " . (($approval->requirement == 'Compulsory') ? "style='background: yellow;'" : "") . " class='ngs-popup' id ='$approval->id'>"
                                                                        . "<td>$approval->id</td>"
                                                                        . "<td>$approval->requirement</td>"
                                                                        . "<td>$approval->description"
                                                                        . "&nbsp;<!--button class='btn btn-success' type='button' onclick='addEditApprovals(".$approval->id.")'>Edit&nbsp;<i class='fa fa-edit'></i></button-->"
                                                                        . "</td>"
                                                                        . "<td>$approval->code</td>"
                                                                        . "</tr>";
                                                            }
                                                            ?>                                                       
                                                        </tbody>
                                                    </table>
                    <!--</div>-->
                    <script> 
                     $('.ngs-popup').click(function () {
                                        
                                       /* var url = 'product_add?id=' + this.id+"&v=<?php echo strtotime(date('Y-m-d H:i:s'))?>";
                                        var NWin = window.open(url, '_blank');
                                        if (window.focus)
                                        {
                                            NWin.focus();
                                        }*/
                                        var id = this.id;
                                        /*var section = $(this).attr('data-section');

                                        var options = {
                                        url: 'Edit?<?php //print SID."&"?>id='+id,
                                        width: '600',
                                        height: '450',
                                        skinClass: 'jg_popup_round'
                                        };		
                                        $.jeegoopopup.open(options);*/
                                        addEditApprovals(id);
    
                                    });
                    
                    
                    </script>
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

   
        function addEditOtherOperator(id = '') {
        var options = {
            url: 'add_edit_other_operator?id=' + id,
            width: '600',
            height: '200',
            skinClass: 'jg_popup_round',
            resizable: false,
            scrolling: 'no'
        };
        $.jeegoopopup.open(options);
    }
        function addEditApprovals(id = '') {
        var options = {
            url: 'add_edit_approvals?id=' + id,
            width: '600',
            height: '350',
            skinClass: 'jg_popup_round',
            resizable: false,
            scrolling: 'no'
        };
        $.jeegoopopup.open(options);
    }
    
</script>

