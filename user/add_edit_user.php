<?php
session_start();

// error_reporting(E_ALL);
// ini_set("display_errors", 1);
//print_r($_SESSION);
//initilize the page
require_once("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)
//require_once("../inc/config.ui.php");


/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
//$page_css[] = "your_style.css";
include("../inc/header_less.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
//$page_nav["employee"]["active"] = true;
//include("../inc/nav.php");
// ====================== LOGIC ================== --!>
include_once '../class/constants.php';
include_once '../class/cls_user.php';
include_once '../class/saq_user_role.php';
$id = $_REQUEST['id'];
if ($id != '') {
    $user_obj = new user($_REQUEST['id']);
    $user_obj->getDetails();

    // var_dump($user_obj);
}

$user_role_obj = new user_role();
$user_roles = $user_role_obj->getAll();
?>
<style>
    .customFiled {
        margin-bottom: 10px;
    }

    .smart-form .state-error+em {
        color: #c31616;
    }
</style>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main"> 

    <!-- MAIN CONTENT -->
    <div id="content">


        <!-- widget grid -->
        <section id="widget-grid" class="">


            <!-- START ROW -->

            <div class="row">

                <!-- NEW COL START -->

                <!-- END COL -->

                <!-- NEW COL START -->
                <article class="col-sm-12 col-md-12 col-lg-12">

                    <!-- Widget ID (each widget will need unique ID)-->
                    <div class="jarviswidget" id="wid-id-4" 
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">

                        <header style="margin:0px;">
                            <?php if (!isset($_REQUEST['f'])) { ?><span class="widget-icon"><i class="fa fa-edit"></i></span><?php } ?>
                            <span><h2 style="margin-left: 10px;"><?php print (($id != '') ? ((isset($_REQUEST['f'])) ? 'VIEW' : 'EDIT') : 'ADD') ?> USER</h2></span>				                           
                        </header>

                        <!-- widget div-->
                        <div>

                            <!-- widget content -->
                            <div class="widget-body">
                                <form class="smart-form" id="user_form">  
                                    <fieldset>                                         
                                        <section class="col col-4">
                                            <label class="ngs_form_lable">
                                                Username
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="input">
                                                <input type="text" name="username" id="username" value="<?php print $user_obj->name ?>"/> 
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="ngs_form_lable">
                                                password
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="input">
                                                <input type="password" name="password" id="password"/>
                                            </label>
                                        </section>
                                        <?php if ($id == '') { ?>
                                            <section class="col col-4">
                                                <label class="ngs_form_lable">
                                                    Re-enter password
                                                </label>
                                            </section>
                                            <section class="col col-4">
                                                <label class="input">
                                                    <input type="password" name="rePassword" id="rePassword"/>
                                                </label>
                                            </section>   
                                        <?php } ?>
                                        <section class="col col-4">
                                            <label class="ngs_form_lable">
                                                User Role
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="select">
                                                <select name='role'>
                                                    <?php
                                                    foreach ($user_roles as $role) {
                                                        print "<option value='" . $role['id'] . "' " . (($user_obj->saq_us_role_id == $role['id']) ? "selected=''" : "") . ">" . $role['role_name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </label>
                                        </section>

                                        <footer>
                                            <input type="hidden" name="option" value="<?php print (($id != '') ? 'EDITUSER' : 'ADDUSER') ?>" />
                                            <input type="hidden" name="id" value="<?php print $user_obj->id ?>" />
                                            <button type="button" class="btn btn-primary" onclick="submitHandler()">Save&nbsp;<i class="fa fa-save"></i></button>
                                        </footer>
                                    </fieldset>                                             
                                </form>

                            </div>
                            <!-- end widget content -->

                        </div>
                        <!-- end widget div -->

                    </div>
                    <!-- end widget -->

                    <!-- END COL -->		

            </div>

            <!-- END ROW -->
        </section>
        <!-- end widget grid -->


    </div>
    <!-- END MAIN CONTENT -->


</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->



<?php
//include required scripts
include("../inc/scripts.php");
?>

<script type="text/javascript">
    var passwordCheck = <?php print (($id != '') ? 'false' : 'true') ?>;
    $(document).ready(function () {        
        $.validator.addMethod("pwcheck", function (value) {
            return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
                    && /[a-z]/.test(value) // has a lowercase letter
                    && /\d/.test(value) // has a digit
        }, "Password must consist atleast one uppercase letter, one lowercase letter and one digit.");

        $(function () {
            // Validation
            $("#user_form").validate({
                // Rules for form validation
                rules: {
                    username: {
                        required: true
                    },
                    password: {
                        required: passwordCheck,
                        minlength: 8,
                        maxlength: 8,
                        pwcheck: passwordCheck
                    },
                    rePassword: {
                        required: true,
                        minlength: 8,
                        maxlength: 8,
                        pwcheck: true
                    }
                },

                // Messages for form validation
                messages: {
                    username: {
                        required: 'Please enter your user name'
                    },
                    password: {
                        required: 'Please enter your password'
                    },
                    rePassword: {
                        required: 'Please enter your password'
                    }
                },

                // Do not change code below
                errorPlacement: function (error, element) {
                    error.insertAfter(element.parent());
                }
            });
        });
    });

    function passwordCheck(value) {
        alert(value);
    }

    function submitHandler() {
        var form = $('#user_form').serialize();
        if ($("#user_form").valid()) {
            $.ajax({
                url: '../ajax/ajx_user',
                type: 'POST',
                dataType: 'JSON',
                data: form,
                success: function (response) {
                    if (response['msg'] == 1) {
                        window.parent.location.reload();
                        window.parent.$.jeegoopopup.close();
                    } else if (response['msg'] == 2) {
                        alert('Username already taken');
                    } else {
                        alert('Failure');
                    }
                },
                error: function (xhr, status, error) {
                    alert(status);
                }
            });
        }
    }
</script>