<?php
include_once 'class/database.php';
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
session_start();

//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
//require_once("inc/config.ui.php");

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Login";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
//$page_css[] = "your_style.css"; 
$no_main_header = true;
$page_body_prop = array("id" => "extr-page", "class" => "animated fadeInDown");
$index_page = 1;
include("inc/header.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->
<style>
    body {
        overflow: hidden !important;
    }

    #main_id {
        background-image: url("img/dialogkkk.jpg.png") !important;
        background-repeat: no-repeat;
        background-size:cover;
        height: 100vh;
        width: 100vw;
        overflow-x: hidden;
    }

    .smart-form .state-error+em {
        color: #c31616;
    }
</style>

<div id="main_id" role="main" style="margin-left:0px;">

    <!-- MAIN CONTENT -->
    <div id="content" class="container">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 hidden-xs hidden-sm" style="margin-top: 90px;">
                <div class="hero">

                    <div class="pull-left login-desc-box-l">
                        <!--<img alt="" src="img/tower_logo.png" height="200" width="200">-->
                        <!--<h3 style="text-align: center;">SAQ</h3>-->
                    </div>

                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
                <div class="" style="margin-top: 40%;">
                    <form id="login-form" class="smart-form client-form" method="post" onsubmit="loginHandler(event)">
                        <header style="background:rgb(255,255,255,0.1);border:none;">
                            <img src="img/LOGO with border1.png" height="150" width="150" style="display: block;margin-left: auto;margin-right: auto;"/>                                                    
                        </header>

                        <fieldset style="margin:10px;background:none;padding:0px 14px 5px;">
                            <?php // echo session_id(); ?>
                            <section>
                                <label class="label" style="font-weight:bolder;">User Name</label>
                                <label class="input"> <i class="icon-append fa fa-user"></i>
                                    <input type="text" name="username">
                                </label>
                            </section>

                            <section>
                                <label class="label" style="font-weight:bolder;">Password</label>
                                <label class="input"> <i class="icon-append fa fa-lock"></i>
                                    <input type="password" name="password" onchange="">
                                </label>
                            </section>       

                            <section>
                                <label class="label" id="errorMsg" style="color: red;display: none;">
                                    <div class='alert alert-warning fade in'>
                                        <i class='fa-fw fa fa-warning'></i>&nbsp;You are not a valid user.
                                    </div></label>
                            </section>
                        </fieldset>	
                        <footer style="border:none;">
                            <input type="hidden" name="option" value="LOGIN" />
                            <button type="submit" class="btn btn-primary" style="background:#c9005dd1;margin-right:10px;margin-bottom:18px;" name="but" id="but" value="signin">
                                Sign in
                            </button>
                        </footer>
                    </form>

                </div>													
            </div>
        </div>
    </div>

</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->
<!-- PAGE FOOTER -->
<?php
//	include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->
<?php
//include required scripts
include("inc/scripts.php");
?>

<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->

<script type="text/javascript">
    runAllForms();

    $('#main').height($(document).height());

    $.validator.addMethod("pwcheck", function (value) {
        return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
                && /[a-z]/.test(value) // has a lowercase letter
                && /\d/.test(value) // has a digit
    }, "Password must consist atleast one uppercase letter, one lowercase letter and one digit.");

    $(function () {
        // Validation
        $("#login-form").validate({
            // Rules for form validation
            rules: {
                username: {
                    required: true
                },
                password: {
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
                }
            },

            // Do not change code below
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            }
        });
    });

    function passwordCheck(value) {
        alert(value);
    }

    function loginHandler(e) {
        e.preventDefault();
        var form = $("#login-form").serialize();
//        console.log(form);
        if ($("#login-form").valid()) {
            $.ajax({
                url: 'ajax/ajx_user',
                type: 'POST',
                dataType: 'JSON',
                data: form,
                success: function (response) {
                    if (response['msg'] == 1) {
                        sessionStorage.setItem('JWT',response['token']);
                        location.href = 'home';
                    } else if (response['msg'] == 100) {
                        $.notify('Your account has been locked please contact admin', 'error');
                    } else {
                        $("#errorMsg").css("display", "block");
                    }
                },
                error: function (xhr, status, error) {
                    alert(status);
                }
            });
        }
    }
</script>