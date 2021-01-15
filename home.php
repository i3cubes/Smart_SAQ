<?php
session_start();
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
require_once("inc/init.php");

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
//include_once 'class/reports.php';

//print_r($modules_array);
?>
<style>
    /* Style the Image Used to Trigger the Modal */
     body {
        overflow: hidden !important;
    }
    .myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
        max-width: 150px;
        max-height: 150px;
    }

    .myImg:hover {opacity: 0.7;}

    .section_display {
        padding: 30px;
        display: inline-block;
    }
    
    .text_style {
        text-align: center;
        margin: 0px;
        font-size: 15px;
        color: #4858ae;
    }
      
    
     #main_id {
        background-image: url("img/dialogkkk.jpg.png") !important;
        background-repeat: no-repeat;
        background-size:cover;
        height: 97vh;
        width: 100vw;
        overflow-x: hidden;
    }


</style>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main_id" role="main" style="padding-bottom: 0px;">  
    <!-- MAIN CONTENT -->
    <div id="content">
        <div class="row" id="div_db">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            </div>
        </div>
        <!-- widget grid -->
        <section id="widget-grid" class="">
          
        </section>
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
 
</script>

