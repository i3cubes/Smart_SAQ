<?php
require_once("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)
require_once("../inc/config.ui.php");

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "User Management";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "ngs.css";
include("../inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["user_management"]["active"] = true;
include("../inc/nav.php");
//include_once 'class/reports.php';
include_once '../class/constants.php';
include_once '../class/cls_user.php';

$user_obj = new user();
$users = $user_obj->getAllUsers();
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
                    <h2 style=""><b>USER MANAGEMENT</b></h2> 
                    <button class="btn btn-default btn-xs" style="float: right;margin: 5px;" onclick="add_edit_user('')">Add&nbsp;<i class="fa fa-plus"></i></button>
                </header> 
                <div class="widget-body">
                    <!--<div class="row">-->
                    <table id="table" class="table table-bordered table_style table-striped table-hover" style="width:100% !important;">
                        <thead>
                            <tr style="height:40px;">
                                <!--<th>#ID</th>-->
                                <td class="headerStyle">NAME</td>                               
                                <td class="headerStyle">ADDRESS</td>
                                <td class="headerStyle">EMAIL</td>
                                <td class="headerStyle">CONTACT NO</td>                                
                                <td style="text-align:center;" class="headerStyle" width="5%">EDIT</td>
                                <td style="text-align:center;" class="headerStyle" width="5%">STATUS</td>
                            </tr>
                        </thead>
                        <tbody>                                    
                            <?php
                            if (count($users) > 0) {
                                foreach ($users as $user) {
                                    print "<tr>"
                                            . "<td>" . $user['name'] . "</td>"
                                            . "<td>" . $user['address'] . "</td>"
                                            . "<td>" . $user['email'] . "</td>"
                                            . "<td>" . $user['contact_no'] . "</td>"
                                            . "<td align='center' width='5%'><button class='btn btn-primary btn-xs' onclick='add_edit_user(" . $user['id'] . ")'>Edit</button></td>"
                                            . "<td align='center' width='5%'>" . (($user['status'] == constants::$active) ? "<button onclick=changeStatus(" . $user['id'] . ",'D') title='LOCK'><i class='fa fa-check-circle' style='color:green;font-size:21px;'></i></button>" : "<button onclick=changeStatus(" . $user['id'] . ",'E') title='UNLOCK'><i class='fa fa-times-circle'  style='color:red;font-size:21px;'></i></button>") . "</td>"
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
                        $(document).ready(function () {
                            $("#table").DataTable({
                                "paging": true,
                                "ordering": false,
                                "info": true
                            });
                        });

                        function changeStatus(user_id, status) {
                            var newDiv = $(document.createElement('div'));
                            $(newDiv).html(`Are you sure?`);
                            $(newDiv).attr('title', `${((status == 'E') ? 'UNLOCK' : 'LOCK')} USER`);                           
                            $(newDiv).dialog({
                                resizable: false,
                                height: 200,
                                modal: true,
                                buttons: {
                                    "YES": function () {
                                        $.ajax({
                                            url: '../ajax/ajx_user',
                                            type: 'POST',
                                            data: {option: 'CHANGESTATUS', id: user_id, status: status},
                                            dataType: "json",
                                            success: function (res) {
                                               if(res['msg'] == 1) {
                                                   location.reload();
                                               } else {
                                                   $.notify('Error occured','error');
                                               }
                                            },
                                            error: function (xhr, status, error) {
                                                alert("error :" + xhr.responseText);
                                            }
                                        });
                                        $(this).dialog("close");
                                        $(newDiv).remove();
                                    },
                                    NO: function () {
                                        $(this).dialog("close");
                                        $(newDiv).remove();
                                    }
                                }
                            });                          
                        }

                        function add_edit_user(id) {
                            var options = {
                                url: 'add_edit_user?id=' + id,
                                width: '500',
                                height: '470',
                                skinClass: 'jg_popup_round',
                                resizable: false,
                                scrolling: 'no'
                            };
                            $.jeegoopopup.open(options);
                        }
</script>

