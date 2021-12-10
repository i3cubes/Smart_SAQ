<?php
session_start();
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
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

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["view"]["active"] = true;
include("../inc/nav.php");
//include_once 'class/reports.php';
include_once '../class/constants.php';
include_once '../class/cls_site_manager.php';
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
                    <h2 style=""><b>SITES</b></h2> 
                    <?php
                    if ($_SESSION['UROLE'] == constants::$system_admin || $_SESSION['UROLE'] == constants::$admin) {
                        ?>
                        <button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="add_edit_site(0)">Add&nbsp;<i class="fa fa-plus"></i></button>
                        <button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="bulk_update(0)">Bulk Edit&nbsp;<i class="fa fa-cogs"></i></button>
                        <button class="btn btn-danger btn-xs" style="float: right;margin: 5px;" onclick="bulk_delete()">Bulk Delete&nbsp;<i class="fa fa-trash"></i></button>
                    <?php } ?>
                </header> 
                <div class="widget-body">
                    <!--<div class="row">-->
                    <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">
                        <thead>
                            <tr style="height:40px;">
                                <th class="headerStyle">...</th>
                                <td class="headerStyle" width="5%">CODE</td>                               
                                <td class="headerStyle">NAME</td>
                                <td class="headerStyle">ADDRESS</td>
                                <td class="headerStyle" width="10%">SITE OWNERSHIP</td>    
                                <?php
                                if ($_SESSION['UROLE'] == constants::$system_admin || $_SESSION['UROLE'] == constants::$admin) {
                                    ?>                            
                                    <td style="text-align:center;" class="headerStyle" width="7%">EDIT / VIEW</td>   
                                <?php } ?>                             
                            </tr>
                        </thead>
                        <tbody>                                    
                            <?php
                            $site_mgr_obj = new site_manager();
                            $sites = $site_mgr_obj->serchSite('', '', '', "");

                            if (count($sites) > 0) {
                                foreach ($sites as $site) {

                                    $site_ownership_name = $site->site_ownership_name == "" ? $site->site_ownership : $site->site_ownership_name;
                                    print "<tr>"
                                            . "<td><label class='input' style='margin:5px;'><input type='checkbox' class='getValueCheck' name='deleteCheck[]' value='$site->id' /></label></td>"
                                            . "<td>" . $site->code . "</td>"
                                            . "<td>" . $site->name . "</td>"
                                            . "<td>" . $site->address . "</td>"
                                            . "<td>" . $site_ownership_name . "</td>"
                                            . (($_SESSION['UROLE'] == constants::$system_admin || $_SESSION['UROLE'] == constants::$admin) ? "<td align='center'><button class='btn btn-primary btn-xs' onclick='add_edit_site(" . $site->id . ")'><i class='fa fa-edit'></i> / <i class='fa fa-eye'></i></button></td>" : "")
                                            . "</tr>";
                                }
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
                            var table = $("#table").DataTable({
                                "paging": true,
                                "ordering": false,
                                "info": true,
                                select: true

                            });



                            $(document).ready(function () {

                            });

                            function bulk_delete() {
                                var array = [];
                                var checkboxes = table.$(".getValueCheck:checked", {"page": "all"});
                                if (checkboxes.length > 0) {
                                    var newDiv = $(document.createElement('div'));
                                    $(newDiv).html('Are you sure?');
                                    $(newDiv).attr('title', 'Delete');
                                    $(newDiv).dialog({
                                        resizable: false,
                                        height: 200,
                                        modal: true,
                                        buttons: {
                                            "Delete": function () {
                                                checkboxes.each(function (index, value) {
                                                    array.push($(value).val());
                                                });
                                                $.ajax({
                                                    url: '../ajax/ajx_saq_site',
                                                    type: 'POST',
                                                    data: {option: 'BULKDELETE', values: array},
                                                    dataType: "json",
                                                    success: function (response) {
                                                        if (response.result == '1') {
                                                            $.notify(response.msg, 'success');
                                                            window.parent.location.reload();
                                                        } else {
                                                            $.notify(response.msg, 'error');
                                                        }
                                                    },
                                                    error: function (xhr, status, error) {
                                                        alert("error :" + xhr.responseText);
                                                    }
                                                });
                                                $(this).dialog("close");
                                                $(newDiv).remove();
                                            },
                                            cancel: function () {
                                                $(this).dialog("close");
                                                $(newDiv).remove();
                                            }
                                        }
                                    });

                                } else {
                                    $.notify('Please select rows to be delete', 'error');
                                }                                
                            }

                            function add_edit_site(id) {
                                //location.href = 'view?id=' + id;

                                var url = 'add_edit?<?php print SID . "&id=" ?>' + id;
                                var NWin = window.open(url, '_blank');
                                if (window.focus)
                                {
                                    NWin.focus();
                                }
                            }
                            function bulk_update() {
                                var url = 'bulk_update?<?php print SID ?>';
                                var NWin = window.open(url, '_blank');
                                if (window.focus)
                                {
                                    NWin.focus();
                                }
                            }
</script>

