<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
require_once("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)
require_once("../inc/config.ui.php");

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Saq-guidelines";

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
                    <h2 style=""><b>SAQ GUIDELINES</b></h2> 
                    <button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="saq_guideline_add_edit()">Add&nbsp;<i class="fa fa-plus"></i></button>
                </header> 
                <div class="widget-body">
                    <!--<div class="row">-->
                    <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">
                        <thead>
                            <tr style="height:40px;">
                                <td class="headerStyle">NAME</td>
                                <td class="headerStyle">DESCRIPTION</td>
                                <td class="headerStyle" width="10%">UPLOADED DATE TIME</td>
                                <td class="headerStyle" width="5%" align="center">VIEW</td>
                                <td class="headerStyle" width="5%" align="center">EDIT</td>
                                <td class="headerStyle" width="5%" align="center">DELETE</td>
                            </tr>
                        </thead>
                        <tbody>       
                            <?php
                                $saq_obj = new saq_guideline();
                                $saq_guidelines = $saq_obj->getAll();
                                
                                foreach ($saq_guidelines as $guideline) {
                                    print "<tr>"
                                            . "<td>".$guideline['name']."</td>"
                                            . "<td>".$guideline['description']."</td>"
                                            . "<td>".$guideline['uploaded_date_time']."</td>"
                                            . "<td align='center' width='5%'><button class='btn btn-primary btn-xs' onclick=saq_guideline_add_edit(".$guideline['id'].",'v')>VIEW&nbsp;<i class='fa fa-eye'></i></button></td>"
                                            . "<td align='center' width='5%'><button class='btn btn-primary btn-xs' onclick='saq_guideline_add_edit(".$guideline['id'].")'>Edit&nbsp;<i class='fa fa-edit'></i></button></td>"
                                            . "<td align='center' width='5%'><button class='btn btn-danger btn-xs' onclick='saq_guideline_delete(".$guideline['id'].")'>DELETE&nbsp;<i class='fa fa-trash'></i></button></td>"
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
                            
                            function saq_guideline_delete(id) {
                                 var newDiv = $(document.createElement('div'));
                                $(newDiv).html('Are you sure ?');
                                $(newDiv).attr("title", "DELETE");
                                $(newDiv).dialog({
                                    resizable: false,
                                    height: 150,
                                    modal: true,
                                    buttons: {
                                        Yes: function () {
                                            $.ajax({
                                                url: '../ajax/ajx_saq_guideline',
                                                type: 'POST',
                                                data: {option: 'DELETE', id: id},
                                                dataType: "json",
                                                success: function (response) {
                                                    if (response['msg'] == 1) {
                                                        location.reload();
                                                    } else {
                                                        alert('Failure');
                                                    }
                                                    $(newDiv).dialog("close");
                                                    $(newDiv).remove();
                                                },
                                                error: function (xhr, status, error) {
                                                    alert(status);
                                                }
                                            });
                                        },
                                        cancel: function () {
                                            $(this).dialog("close");
                                            $(newDiv).remove();
                                        }
                                    }
                                });
                            }
                            
                            function saq_guideline_add_edit(id = 0, flag = '') {
                                var f = '';
                                if(flag != '') {
                                    f = '&f=' + flag;
                                }
                                 var options = {
                                    url: 'saq_guideline_add_edit?id=' + id + f,
                                    width: '600',
                                    height: '600',
                                    skinClass: 'jg_popup_round',
                                    resizable: false,
                                    scrolling: 'yes'
                                };
                                $.jeegoopopup.open(options);
                            }
</script>

