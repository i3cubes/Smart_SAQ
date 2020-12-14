<?php
/*
 * ============ LOGIC ==================
 */
include_once 'class/user.php';


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
$page_css[] = "your_style.css";
$no_main_header = true;
$page_html_prop = array("id" => "extr-page", "class" => "animated fadeInDown");
$index_page = 1;
include("inc/header.php");
?>
<style>
   
    
    .loginText {
        font-size: 10px;
    }
</style>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->
<!--<header id="header" style="height: 100px">
         <span id="logo"></span> 
    <div id="logo-group" style="height: inherit">
        <span id="" style="height: inherit; margin-left: 15px;"> <img src="<?php echo ASSETS_URL; ?>/img/logo-trans.png" alt="Alswh" class="img-responsive" style="height:inherit;"> </span>
    </div>

</header>-->
<div id="main" role="main" style="background-color: #92ddf8;">
    <!-- MAIN CONTENT -->
    <div style="
            height: 200px;
            ">&nbsp;</div>
    <div id="content" class="container" style="">
        <div class="col-3 col-s-3" id="form-width">
            <div class="no-padding">
                <form id="login_form" class="smart-form client-form" onsubmit="loginHandler(event)">

                    <fieldset style="background: #92ddf8;">

                        <section>
                            <label class="label" style="font-size: 12px;color: white;">User Name</label>
                            <label class="input"> <i class="icon-append fa fa-user"></i>
                                <input type="text" name="name" id="name">
                            </label>
                        </section>

                        <section>
                            <label class="label" id="errorMsg" style="color: red;display: none;">
                                <div class='alert alert-warning fade in'>
                                    <i class='fa-fw fa fa-warning'></i>&nbsp;You are not a valid user.
                                </div></label>
                        </section>

                        <section>
                            <label class="label" style="font-size: 12px;color: white;">Password</label>
                            <label class="input"> <i class="icon-append fa fa-lock"></i>
                                <input type="password" name="password" id="password">
                            </label>
                        </section> 
                        <section style="float:right;">
                            <input type="hidden" name="option" value="LOGIN" />
                        <button type="submit" class="btn btn-xs btn-primary" name="but" id="but" value="signin">
                            Sign in
                        </button>
                        </section>
                    </fieldset>
<!--                    <footer style="background: #92ddf8;">
                        
                    </footer>-->
                </form>
            </div>
        </div>
    </div>
<?php
//include("inc/footer.php");
?>
</div>
<!-- END MAIN PANEL -->
<!-- PAGE FOOTER -->

<!-- END PAGE FOOTER -->
<!-- ==========================CONTENT ENDS HERE ========================== -->

<?php
//include required scripts
include("inc/scripts.php");
?>

<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->

<script type="text/javascript">
  $(document).ready(function(){
      $("body").css('background','#91ddf8');
  });
  
  function loginHandler(e) {
      e.preventDefault();
      var form = $("#login_form").serialize();      
      $.ajax({
          url: 'ajax/ajx_user',
          type: 'POST',
          dataType: 'JSON',
          data: form,
          success: function(response){
              if(response['msg'] == 1) {
                  location.href = 'home';
              } else {
                  $("#errorMsg").css("display","block");
              }
          },
          error: function(xhr, status, error) {
              alert(status);
          }
      });
  }
  
  function signUp() {      
      var options = {
            url: 'SignUp',
            width: '600',
            height: '350',            
            center: true,
            skinClass: 'jg_popup_round'
        };
        $.jeegoopopup.open(options); 
        $("#errorMsg").css("display","none");
  }
</script>
