<?php
session_start();

$ary_prev = $_SESSION['USER_PREV'];

//print_r($_SESSION);
//initilize the page
require_once("lib/config.php");

//require UI configuration (nav, ribbon, etc.)


/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "User-Add";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("ngs/header_ngspopup.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
//$page_nav["forms"]["sub"]["smart_layout"]["active"] = true;
//include("../inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main" style="min-height: 200px;"> 

    <!-- MAIN CONTENT -->
    <div id="content">


        <!-- widget grid -->
        <section id="widget-grid">


            <!-- START ROW -->

            <div class="row">

                <!-- NEW COL START -->

                <!-- END COL -->

                <!-- NEW COL START -->
                <article class="col-sm-12 col-md-12 col-lg-12">

                    <!-- Widget ID (each widget will need unique ID)-->
                    <div class="jarviswidget" id="wid-id-71" 
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">

                        <header style="background: #92ddf8;">
                            <span class="widget-icon"> <i class="fa fa-user"></i></span>
                            <span style="margin-left: 20px;"><h2>Sign Up</h2></span>				

                        </header>

                        <!-- widget div-->
                        <div>

                            <!-- widget content -->
                            <div class="widget-body no-padding">
                                <form id="user_register" class="smart-form">
                                    <fieldset>

                                        <div class="row">
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>
                                            <section class="col-xs-2 col-sm-2 col-md-2">
                                                <strong>Email Address</strong>
                                            </section>
                                            <section class="col-xs-8 col-sm-8 col-md-8">
                                                <label class="input"><i class="icon-append fa fa-envelope"></i>
                                                    <input type="email" name="email" id="email" placeholder="Email Adress" value="">
                                                </label>
                                            </section>
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>

                                        </div>                                        
                                        <div class="row">
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>
                                            <section class="col-xs-2 col-sm-2 col-md-2">
                                                <strong>Name</strong>
                                            </section>
                                            <section class="col-xs-8 col-sm-8 col-md-8">
                                                <label class="input"><i class="icon-append fa fa-user"></i>
                                                    <input type="text" name="name" id="name" placeholder="Name" value="">
                                                </label>
                                            </section>
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>

                                        </div>
                                        <div class="row">
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>
                                            <section class="col-xs-2 col-sm-2 col-md-2">
                                                <strong>Address</strong>
                                            </section>
                                            <section class="col-xs-8 col-sm-8 col-md-8">
                                                <label class="input"><i class="icon-append fa fa-user"></i>
                                                    <input type="text" name="address" id="address" placeholder="Address" value="">
                                                </label>
                                            </section>
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>

                                        </div>
                                        <div class="row">
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>
                                            <section class="col-xs-2 col-sm-2 col-md-2">
                                                <strong>Password</strong>
                                            </section>
                                            <section class="col-xs-8 col-sm-8 col-md-8">
                                                <label class="input">
                                                    <i class="icon-append fa fa-key"></i>
                                                    <input type="password" name="password" id="password" placeholder="Password" value="">
                                                </label>
                                            </section>
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>

                                        </div>                                      
                                        <section>
                                            <label class="label" id="errorCon" style="color: red;display: none;">
                                                <div class='alert alert-warning fade in'>
                                                    <i class='fa-fw fa fa-warning'></i>&nbsp;<font id="warnningMsg"></font>
                                                </div></label>
                                        </section>
                                    </fieldset>
                                    <footer>										
                                        <button type="submit" class="btn btn-primary" id="but" name="but" value="save">
                                            Sign Up
                                        </button>
                                    </footer>
                                </form>						
                            </div>
                            <!-- end widget content -->
                        </div>
                    </div>
                    <!-- end widget div -->
                </article>
            </div>
            <!-- end widget -->
        </section>
        <!-- END COL -->		

    </div>

    <!-- END ROW -->
</section>
<!-- end widget grid -->


</div>
<!-- END MAIN CONTENT -->
<!-- ==========================CONTENT ENDS HERE ========================== -->
<?php
//include required scripts
include("inc/scripts.php");
?>
<script>
    $(document).ready(function () {        
        $.jeegoopopup.center;

        var $registerForm = $("#user_register").validate({

            // Rules for form validation
            rules: {
                email: {
                    required: true
                },
                name: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },                
                address: {
                    required: true
                }
            },

            // Messages for form validation
            messages: {
                email: {
                    required: 'Please enter email'
                },
                name: {
                    required: 'Please enter name'
                },
                password: {
                    required: 'Please enter password'
                },
                address: {
                    required: 'Please enter address'
                }
            },

            // Do not change code below
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            }
        });


    });

    $('#user_register').submit(function (e) {        
        e.preventDefault();
        var email = $('#email').val();
        var password = $('#password').val();        
        var name = $('#name').val();
        var address = $('#address').val();        
        if ($("#user_register").valid()) {
            $.ajax({
                url: "ajax/ajx_user",
                type: "POST",
                data: {option: 'ADDUSER', email: email, name: name, address: address, password: password},
                dataType: "json",
                success: function (res) {
                    
                },
                error: function (xhr, status, error) {
                    alert("error :" + xhr.responseText);
                }
            });
        }
    });

    function clear() {
        $('#email').val("");
        $('#password').val("");
        $('#passwordConf').val("");
        $('#errorCon').css("display", "none");
    }
</script>
</body>
</html>