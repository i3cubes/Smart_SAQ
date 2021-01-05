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


<div id="main" role="main" style="margin-left:0px;background: url(img/bg.jpg) #fff;">

	<!-- MAIN CONTENT -->
	<div id="content" class="container">

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 hidden-xs hidden-sm" style="margin-top: 90px;">
				<div class="hero">

					<div class="pull-left login-desc-box-l">
                                            <img alt="" src="img/tower_logo.png" height="200" width="200">
                                            <!--<h3 style="text-align: center;">SAQ</h3>-->
					</div>

				</div>

			</div>
			<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
				<div class="well no-padding" style="margin-top: 32%;">
                                    <form id="login-form" class="smart-form client-form" onsubmit="loginHandler(event)">
						<header style="background-color: #008FC9 !important;">
							Sign In
						</header>

						<fieldset>
							
							<section>
								<label class="label">User Name</label>
								<label class="input"> <i class="icon-append fa fa-user"></i>
									<input type="text" name="username">
								</label>
							</section>

							<section>
								<label class="label">Password</label>
								<label class="input"> <i class="icon-append fa fa-lock"></i>
									<input type="password" name="password">
								</label>
							</section>

							<section>								
							</section>
						</fieldset>
						<footer style="background-color: #A4A4A4;">
                                                         <input type="hidden" name="option" value="LOGIN" />
							<button type="submit" class="btn btn-primary" name="but" id="but" value="signin">
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
	include("inc/footer.php");
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
	$(function() {
		// Validation
		$("#login-form").validate({
			// Rules for form validation
			rules : {
				username : {
					required : true
				},
				password : {
					required : true,
					minlength : 3,
					maxlength : 20
				}
			},

			// Messages for form validation
			messages : {
				username : {
					required : 'Please enter your user name'
				},
				password : {
					required : 'Please enter your password'
				}
			},

			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
        
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
                            location.href = 'home';                        
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