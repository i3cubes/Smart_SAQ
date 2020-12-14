<?php
session_start();

$ary_prev=$_SESSION['USER_PREV'];

//print_r($_SESSION);
//initilize the page
require_once("lib/config.php");

//require UI configuration (nav, ribbon, etc.)


/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "User - chnage password";

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

                                            <header>
                                                <span class="widget-icon"> <i class="fa fa-user"></i></span>
                                                <span style="margin-left: 20px;"><h2>Change password</h2></span>				

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
                                                                                <section class="col-xs-4 col-sm-4 col-md-4">
                                                                                        <strong>Password</strong>
                                                                                </section>
                                                                                <section class="col-xs-6 col-sm-6 col-md-6">
                                                                                    <label class="input"><i class="icon-append fa fa-lock"></i>
                                                                                        <input type="password" name="password" id="password" placeholder="Password" value="">
                                                                                    </label>
                                                                                </section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">

                                                                                </section>
                                                                        </div>
                                                                        <div class="row">
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                </section>
                                                                                <section class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                                                        <strong>Password Confirmation</strong>
                                                                                </section>
                                                                                <section class="col-xs-6 col-sm-6 col-md-6">
                                                                                    <label class="input"><i class="icon-append fa fa-lock"></i>
                                                                                        <input type="password" name="passwordConf" id="passwordConf" placeholder="Retype password" value="">
                                                                                    </label>
                                                                                </section>

                                                                        </div>
                                                                        </fieldset>
                                                                    <footer>	
                                                                            <input type="hidden" name="UID" value="<?php print $_GET['id'] ?>">
                                                                            <input type="hidden" name="option" value="PASSWORDRESET">
                                                                            <button type="submit" class="btn btn-primary" id="" name="but" value="save">
                                                                                    Save
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
    $(document).ready(function(){
        $.jeegoopopup.center;
        
        var $registerForm = $("#user_register").validate({

		// Rules for form validation
		rules : {
			email : {
				required : true
			},
			password : {
				minlength : 3,
				maxlength : 20
			},
			passwordConf : {
				minlength : 3,
				maxlength : 20,
				equalTo : '#password'
			}
		},

		// Messages for form validation
		messages : {
			email : {
				required : 'Please enter your email'
			},
			password : {
				required : 'Please enter your password'
			},
			passwordConf : {
				required : 'Please enter your password one more time',
				equalTo : 'Please enter the same password as above'
			}
		},

		// Do not change code below
		errorPlacement : function(error, element) {
			error.insertAfter(element.parent());
		}
	});
        
        $('#user_register').submit(function (e){
            e.preventDefault();            
             $.post("ajax/user", $('#user_register').serialize(), function (json) {
                 if(json){
                     alert("Successfully changed password"); 
                     window.parent.$.jeegoopopup.close();
                 } else {
                     alert("Failure in password changing");
                     window.parent.$.jeegoopopup.close();
                 }
             }, 'json');
        });
    });
</script>
</body>
</html>