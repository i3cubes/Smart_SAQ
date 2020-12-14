<?php
session_start();
include_once 'class/cls_employees.php';
include_once 'class/cls_business_customer.php';
//print_r($_SESSION);
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
//DeaderINFO
//$emp=new employees($_SESSION['EMPID']);
///$emp->getDetails();
//$cus=new business_customer($emp->business_customer_id);
//$cus->getDetails();
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

//include_once 'class/constants.php';
include_once 'class/cls_roster.php';
include_once 'class/cls_roster_manager.php';
include_once 'class/cls_business_customer.php';
include_once 'class/cls_date.php';
?>
<style>
    /* Style the Image Used to Trigger the Modal */
    .myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
        max-width: 100px;
        max-height: 100px;
    }

    #myImg:hover {opacity: 0.7;}

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

    .timeSize {
        font-size: 28px;
    }

    .timeSize1 {
        font-size: 25px;
    }

    .selectCustom {
        padding: 5px;
        width: 200px;
        border: 2px solid;
    }

    #message,
    #message-timeout,
    #message-lunchtime,
    #message-timeinout,
    #message-email{ 
        padding: 10px; 
        /*border: #999 1px dashed;*/ 

    }

    #message-timeout1 {
        font-size: 15px; 
        color: #000;
        font-weight: bold;
    }

    #message-timeinout{ 
        font-size: 15px; 
        color: #00F;
        font-weight: bold;
    }

    #message-email{ 
        font-size: 15px; 
        color: #F00;
        font-weight: bold;
    }
    
    .customFiled {
        width:200px;
        height:25px;
        margin-top:5px;
        border: solid 1px #dfb4c6;
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
        <section id="widget-grid" style="text-align: center;">
            <!-- row -->
            <?php
            if ($_SESSION['DESIGNATION'] == constants::$business_customer) {
                $start_date = $_REQUEST['start_date'];
                if($start_date == '') {
                    $start_date = date('Y-m-d');
                } 
                $fortnightWeek = array();
                $date_obj = new ngs_date();
                $start_date = $date_obj->x_week_start($start_date);
                for($i=1;$i<=14;$i++) {
                    array_push($fortnightWeek, $start_date);
                    $start_date = strtotime($start_date) + 86400;
                    $start_date = date('Y-m-d',$start_date);
                }
//                print_r($fortnightWeek);
                ?>
                <section class="col-sm-2"></section>
                <section class="col-sm-8"> 
                    <h3><u>Fortnight week allocated hours for centers</u></h3>
                                <label>
                                    Start Date
                                </label>
                    <input type="text" class="customFiled" id="startDate" placeholder="Start date" value="<?php print $fortnightWeek[0] ?>"/>                            
<!--                                <label>
                                    End Date
                                </label>
                                <input type="text" id="dateSelector" class="customFiled" id="endDate" placeholder="Start date"/>    -->
                                <hr />
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr class="info">
                                <th>
                                    Center Name
                                </th>
                                <th width="15%" style="text-align:center;">
                                    Used hours
                                </th>
                                <th width="15%" style="text-align:center;">
                                    Allocated hours
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $b_c_obj = new business_customer($_SESSION['BCID']);
                                $centers = $b_c_obj->get_centers();
                                foreach ($centers as $center) {
                                    $used_hours = 0;
                                    $roster_details_array = array();
                                    foreach ($fortnightWeek as $date) {
                                        $r_m_o = new roster_manager();                                        
                                        $roster_details = $r_m_o->viewByDateCenter($center->id, $date);    
                                        foreach ($roster_details as $details) { 
                                            if($details->time_in != '' && $details->time_out != '') {
                                                $used_hours += (int) $date_obj->getDuration(
                                                        ($date . ' ' . $details->time_out . ':00'),
                                                        ($date . ' ' . $details->time_in . ':00')
                                                        );
                                            }                                            
                                        }
                                    }
                                    print "<tr class='success'>"
                                            . "<td align='left'>$center->name</td>"
                                            . "<td>$used_hours</td>"
                                            . "<td>$center->weekly_hours</td>"
                                          . "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </section>

                <section class="col-sm-2"></section>

            <?php
            } else if ($_SESSION['DESIGNATION'] == constants::$employee) {
                $roster_obj = new roster('');
                $roster_obj->view($_SESSION['EMPID'], date('Y-m-d'));
                if ($roster_obj->time_in == '' || $roster_obj->time_out == '') {
                    echo("<script LANGUAGE='JavaScript'> 
                            window.alert('Your ROSTER for the day is not defined!! Please contact/email your practice manager asap.') 
                            </script>");
                }
                ?>
                <div id="clk" class="timeSize"></div>
                <br />
                <br />
                <table width='100%'>
                    <tr>
                        <td style="padding: 10px;">
                            <h1>
                                Roster Start Time: <span style="color:red;"><?php print (($roster_obj->time_in != 'NULL' && $roster_obj->time_out != '') ? $roster_obj->time_in : 'No Roster'); ?></span>
                            </h1>                                  
                        </td>
                        <td>
                            <h1>
                                Roster End Time: <span style="color:red;"><?php print (($roster_obj->time_out != 'NULL' && $roster_obj->time_out != '') ? $roster_obj->time_out : 'No Roster'); ?></span>
                            </h1>                            
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">
                            <button class="btn btn-success btn-lg" style="background-color:#518eb2;border-color:#6efff2;" onclick="timeIn()">&nbsp;Time In&nbsp;&nbsp;</button>
                        </td>
                        <td width='50%'>
                            <h3>Your Time in:</h3><h3 id='timeIn'></h3>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">
                            <button class="btn btn-success btn-lg" onclick="timeOut()">Time Out</button>
                        </td>
                        <td>
                            <label><h3>Lunch Time:</h3></label>                             
                            <select class="selectCustom" name='lunch_time' id='lunch_time'>
                                <option value="N/A" selected="">No Lunch Time</option>
                                <option value="15">15 MIN</option>
                                <option value="30" selected="">30 MIN</option>
                                <option value="45">45 MIN</option>
                                <option value="01">1 HOUR</option>
                            </select>                                                        
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="message-timeout"><h3 id="timeoutMessage" class='message-timeout1'>Your Timeout</h3></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding: 10px;">
                            <textarea rows="5" id="comment" style="width: 70%;" placeholder="Enter Your comment and press Timeout to save"></textarea>
                        </td>
                    </tr>
                    <tr><td colspan="2">

                            <div id="message-timeinout" >Summary total hours for the Week (Wed - Thurs)</div>

                            <div id="message-email" >If you are NOT AGREED with your TIME IN_OUT for the day, please send an email to practice manager - <a href="mailto:sharon@tmedicals.com.au?cc=contact@auswebsoo.com&subject=TIME SHEET | Manager's Approval Requested by <?php echo $user_name; ?> &body=Dear practice manager,">Send an email for approval</a></div>
                            <div id="message-email" >Your EXTRA_HRS will be paid in next pay cycle & any extra hours needs to be approved by the practice manager.</a></div>

                        </td></tr>
                </table>
<?php } ?>
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
                            var current_time;
                            var roster_id = '<?php print $roster_obj->id; ?>';

                            $(document).ready(function () {
<?php
if ($_SESSION['DESIGNATION'] == constants::$employee) {
    print "startTime();";
}
?>                                    
                                    $('#startDate').datetimepicker({
                                                timepicker: false,
                                                format: 'Y-m-d',
                                                useCurrent: true,
                                                onChangeDateTime: function (date, obj) {
                                                    if (date != '') {
                                                    date = new Date(date);
                                                    year = date.getFullYear();
                                                    month = ('0' + (date.getMonth() + 1)).slice(-2);
                                                    day = ('0' + (date.getDate())).slice(-2);
                                                    active_date = year + "-" + month + "-" + day;
                                                    }
                                                    window.location.href = 'home?start_date=' + active_date;
                                                }
                                            });
    
                                    $("#myImg_4").click(function () {
                                    var url = 'http://smsnow.com.au/';
                                    var NWin = window.open(url, '_blank');
                                    if (window.focus)
                                    {
                                        NWin.focus();
                                    }
                                });

                            });
                            function startTime() {
                                var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                                var dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]

                                var today = new Date();
                                // var date_formatted=today.getMonth() + "/" + today.getDate() + "/" + today.getFullYear(); 
                                var date_formatted = dayNames[today.getDay()] + " " + today.getDate() + " " + monthNames[today.getMonth()] + " " + today.getFullYear();
                                var h = today.getHours();
                                var m = today.getMinutes();
                                var s = today.getSeconds();
                                m = checkTime(m);
                                s = checkTime(s);
//        document.getElementById('clk').style.fontSize = '28px';
//        document.getElementById('clk').style.color='#FF0000';
//        document.getElementById('clk').style.color = '#006400';

                                //document.getElementById('clk').style.color='#FF0000';
                                document.getElementById('clk').innerHTML = date_formatted + " <br /> " + h + ":" + m + ":" + s;
                                var t = setTimeout(function () {
                                    startTime()
                                }, 1000);
                                current_time = h + ":" + m + ":" + s;
                            }

                            function checkTime(i) {
                                if (i < 10) {
                                    i = "0" + i
                                }
                                ;  // add zero in front of numbers < 10
                                return i;
                            }

                            function timeIn() {
                                var time_in = current_time;
                                $.ajax({
                                    url: "ajax/ajx_roster",
                                    type: "POST",
                                    dataType: "JSON",
                                    data: JSON.stringify({option: "ADDINOUTTIME", time_in: time_in, id: roster_id}),
                                    success: function (response) {
                                        $("#timeIn").text(response['timeinmsg']);
                                    },
                                    error: function (xhr, status, error) {
                                        alert("error :" + xhr.responseText, "error");
                                    }
                                });
                            }

                            function timeOut() {
//                                    var time_in = $("#timeIn").val();
                                var time_out = current_time;
                                var comment = $("#comment").val();
                                var lunchTime = $("#lunch_time").val();
                                $.ajax({
                                    url: "ajax/ajx_roster",
                                    type: "POST",
                                    dataType: "JSON",
                                    data: JSON.stringify({option: "ADDINOUTTIME",
                                        time_out: time_out, comment: comment,
                                        lunch: lunchTime, id: roster_id}),
                                    success: function (response) {
                                        $("#timeoutMessage").text(response['timeoutmsg']);
                                    },
                                    error: function (xhr, status, error) {
                                        alert("error :" + xhr.responseText, "error");
                                    }
                                });
                            }


</script>

