		<!--================================================== -->

		<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
		<script data-pace-options='{ "restartOnRequestAfter": true }' src="<?php echo ASSETS_URL; ?>/js/plugin/pace/pace.min.js"></script>

		<!-- These scripts will be located in Header So we can add scripts inside body (used in class.datatables.php) -->
		 <!--Link to Google CDN's jQuery + jQueryUI; fall back to local--> 
		<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>-->
                <script src="<?php echo ASSETS_URL; ?>/js/libs/jquery-3.6.0.min.js"></script>
<!--		<script>
                        
			if (!window.jQuery) {
				document.write('<script src="<?php echo ASSETS_URL; ?>/js/libs/jquery-2.0.2.min.js"></script>');
			}
		</script>

		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
-->		<script>
//			if (!window.jQuery.ui) {
				document.write('<script src="<?php echo ASSETS_URL; ?>/js/libs/jquery-ui-1.10.3.min.js"><\/script>');
			//}
		</script> 
                <!--<script src="<?php echo ASSETS_URL; ?>/js/jquery.js"></script>-->	
		<!-- IMPORTANT: APP CONFIG -->
		<script src="<?php echo ASSETS_URL; ?>/js/app.config.js"></script>

		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
		<script src="<?php echo ASSETS_URL; ?>/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> 

		<!-- BOOTSTRAP JS -->
		<script src="<?php echo ASSETS_URL; ?>/js/bootstrap/bootstrap.min.js"></script>

		<!-- CUSTOM NOTIFICATION -->
		<script src="<?php echo ASSETS_URL; ?>/js/notify.min.js"></script>
                
                <!-- NOTIFICATION -->
                <script src="<?php echo ASSETS_URL; ?>/js/notification/SmartNotification.min.js"></script>
                
		<!-- JARVIS WIDGETS -->
		<script src="<?php echo ASSETS_URL; ?>/js/smartwidgets/jarvis.widget.min.js"></script>

		<!-- EASY PIE CHARTS -->
		<script src="<?php echo ASSETS_URL; ?>/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

		<!-- SPARKLINES -->
		<script src="<?php echo ASSETS_URL; ?>/js/plugin/sparkline/jquery.sparkline.min.js"></script>

		<!-- JQUERY VALIDATE -->
		<script src="<?php echo ASSETS_URL; ?>/js/plugin/jquery-validate/jquery.validate.min.js"></script>

		<!-- JQUERY MASKED INPUT -->
		<script src="<?php echo ASSETS_URL; ?>/js/plugin/masked-input/jquery.maskedinput.min.js"></script>

		<!-- JQUERY SELECT2 INPUT -->
		<script src="<?php echo ASSETS_URL; ?>/js/plugin/select2/select2.min.js"></script>

		<!-- JQUERY UI + Bootstrap Slider -->
		<script src="<?php echo ASSETS_URL; ?>/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

		<!-- browser msie issue fix -->
		<script src="<?php echo ASSETS_URL; ?>/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

		<!-- FastClick: For mobile devices -->
		<script src="<?php echo ASSETS_URL; ?>/js/plugin/fastclick/fastclick.min.js"></script>
                <script src="<?php echo ASSETS_URL; ?>/js/jquery.datetimepicker.js"></script>
                <script src="<?php echo ASSETS_URL; ?>/lib/time-picker/jquery.timeselector.js"></script>

		<!--[if IE 8]>
			<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
		<![endif]-->

		<!-- Demo purpose only -->
		<script src="<?php echo ASSETS_URL; ?>/js/demo.min.js"></script>

		<!-- MAIN APP JS FILE -->
		<script src="<?php echo ASSETS_URL; ?>/js/app.min.js"></script>		

		<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
		<!-- Voice command : plugin -->
		<script src="<?php echo ASSETS_URL; ?>/js/plugin/printThis/printThis.js"></script>	
                
                <!-- NGS Addings-->
                <script src="<?php echo ASSETS_URL; ?>/js/custome.js"></script>	
                <script type="text/javascript" src="<?php echo ASSETS_URL; ?>/jeegoopopup/jquery.jeegoopopup.1.0.0.js"></script>
                <script type="text/javascript" src="<?php echo ASSETS_URL; ?>/shared.js"></script>
                <!-- NGS -->
		<script type="text/javascript">
			// DO NOT REMOVE : GLOBAL FUNCTIONS!
			$(document).ready(function() {
				pageSetUp();
			})
		</script>