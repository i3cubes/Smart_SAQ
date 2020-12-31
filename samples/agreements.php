<?php
//error_reporting();
//ini_set("display_errors", 1);
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
include_once '../class/cls_agreement_model.php';
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
                        <?php
                        $agreement_obj = new agreement_model();
                        $parent_nodes = $agreement_obj->getParentNodes();

                        if (count($parent_nodes) > 0) {
                            foreach ($parent_nodes as $parent_node) {
                                $agreement_obj = new agreement_model($parent_node['id']);
                                $agreement_file_count = $agreement_obj->getFiles();
                                if (count($agreement_file_count) > 0) {
                                    $icon = "&nbsp;&nbsp;&nbsp;<i class='fa fa-file' style='font-size:15px;color:blue;' onclick='addHandler(".$parent_node['id'].")'></i>";
                                } else {
                                    $icon = "&nbsp;&nbsp;&nbsp;<i class='fa fa-file' style='font-size:15px;color:green;' onclick='addHandler(".$parent_node['id'].")'></i>";
                                }

                                $sub_child_html_main = process_sub_nav_node($parent_node['id']);

                                print "<ul>"
                                        . "<li>"
                                        . "<span class=''>" . $parent_node['name'] . " &nbsp;<i class='fa fa-plus' style='font-size:15px;color:green;' onclick='addHandlerNode(".$parent_node['id'].")'></i>$icon</span>"                                        
                                        . "$sub_child_html_main"                                     
                                        . "</li>"
                                        . "</ul>";
                        }}
                        
                        function process_sub_nav_node($parent_model_id) {
//                            $tree_node_obj = new tree_node($parent_model_id);
                            $agreement_obj = new agreement_model($parent_model_id);

                            $child_nodes = $agreement_obj->getChild();
//                            print_r($child_nodes);
                            if (count($child_nodes) > 0) {
                                $html = "<ul>";
                                foreach ($child_nodes as $node) {  
                                    $agreement_obj = new agreement_model($node->id);
                                    $child_files = $agreement_obj->getFiles();

                                    if (count($child_files) > 0) {
                                        $icon = "&nbsp;&nbsp;&nbsp;<i class='fa fa-file' style='font-size:15px;cursor:pointer;color:blue;' onclick='addHandler($node->id)'></i>";
                                    } else {
                                        $icon = "&nbsp;&nbsp;&nbsp;<i class='fa fa-file' style='font-size:15px;cursor:pointer;color:green;' onclick='addHandler($node->id)'></i>";
                                    }
                                    
                                    $sub_child_html = process_sub_nav_node($node->id);

                                    $html .= "<li>"
                                            . "<span class=''>$node->name&nbsp;<i class='fa fa-cog' style='font-size:15px;cursor:pointer;' onclick='editHandler($node->id)'></i>$icon</span>"
                                            . $sub_child_html              
                                            . "</li>";
                                }
                                $html .= "</ul>";
                            }
                            return $html;
                        }
                                ?>                               
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
    
        function editHandler(id) {
            var options = {
                                    url: 'agreement_edit?id=' + id,
                                    width: '425',
                                    height: '200',
                                    skinClass: 'jg_popup_round',
                                    resizable: false,
                                    scrolling: 'no'
                                };
                                $.jeegoopopup.open(options);
        }

      function addHandler(id) {
      var options = {
                                    url: 'agreement_view?id=' + id,
                                    width: '600',
                                    height: '500',
                                    skinClass: 'jg_popup_round',
                                    resizable: false,
                                    scrolling: 'yes'
                                };
                                $.jeegoopopup.open(options);
    }
    
    function addHandlerNode(id) {
        var options = {
                                    url: 'agreement_add?id=' + id,
                                    width: '400',
                                    height: '250',
                                    skinClass: 'jg_popup_round',
                                    resizable: false,
                                    scrolling: 'no'
                                };
                                $.jeegoopopup.open(options);
    }
</script>

