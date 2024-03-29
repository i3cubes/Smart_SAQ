<?php
include_once '../class/cls_file.php';

$file_id = $_REQUEST['file_id'];
//print 'a';
if ($file_id != "") {
    $file = new file($file_id);

    $row_file = $file->get_file_infomation("saq_site_model_images");
    $file_path = '../' . $file->base_path;
    $file_name = $file->name;

    if ($file_path != "") {
        $exist = true;
    } else {
        $exist = false;
    }

    if ($exist) {
        $file_name = urlencode($file_name);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $file_name);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        ob_clean();
        flush();
        readfile($file_path);
    } else {
        print "File Not Found";
    }
}
?>
<?php
require_once("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)
//require_once("../inc/config.ui.php");

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Site";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
//$page_css[] = "ngs.css";
include("../inc/header_less.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
//$page_nav["samples"]["sub"]["site"]["active"] = true;
//include("../inc/nav.php");
//include_once 'class/reports.php';
include_once '../class/constants.php';
include_once '../class/cls_site_model.php';
$id = htmlspecialchars($_REQUEST['id']);
$site_model_obj = new site_model($id);
$site_model_obj->getData();
?>
<style>

</style>
<link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/dropzone.css">
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="" role="main" style="padding-bottom: 0px;">  
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
                    <h2 style=""><b>SITE IMAGES - <?php print $site_model_obj->name ?></b></h2>                     
                </header> 
                <div class="widget-body">                    

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div id="drop" class="dropzone">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-align-right">
                        <div class="page-title">
                            <a class="btn btn-default" onclick="upload_image()">Upload</a>                            
                        </div>
                        <p style="color:red;">Supported file type(s) .jpeg,.jpg,.png,.gif</p>

                    </div>

                    <div class="row">
                        <div class="superbox col-xs-12 col-sm-12 col-md-12 col-lg-12" >

                            <!--<div class="superbox-float" style="margin:15px;">-->
                            <table width="100%" class="table">
                                    <thead>
                                        <tr>
                                            <th>File</th>
                                            <th width="5%">...</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $site_model_obj->getImages();

                                    if (count($site_model_obj->files) > 0) {
                                        foreach ($site_model_obj->files as $file) {
                                            print "<tr>"
                                                    . "<td><a href='?file_id=" . $file['id'] . "'>" . $file['name'] . "</a></td>"
                                                    . "<td><button class='btn btn-danger btn-xs' onclick='deleteFile(" . $file['id'] . ")'><i class='fa fa-trash'></i></button></td>"
                                                    . "</tr>";
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>

                            <!--</div>-->

                        </div>
                        <!--<div class="superbox-show" style="height:300px; display: none"></div>-->  
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
<script src="<?php echo ASSETS_URL; ?>/js/dropzone.js"></script>

<script>
                                $(document).ready(function () {

//                                    getImages(<?php print $id ?>);

                                    $("#drop").dropzone({
                                        url: "../ajax/ajx_saq_site_images",
                                        autoProcessQueue: false,
                                        addRemoveLinks: true,
                                        acceptedFiles: ".jpeg,.jpg,.png,.gif",
                                        headers: {
                                            "Authorization": `Bearer ${sessionStorage.getItem('JWT')}`
                                        },
                                        init: function () {
                                            this.on("sending", function (file, xhr, formData) {
                                                formData.append("option", "ADD");
                                                formData.append("id", <?php print $id ?>);
//                                                JSON.stringify(formData);
                                            });
                                            this.on("error", function (file, message, xhr) {
                                                if (xhr == null) {
                                                    this.removeFile(file); // perhaps not remove on xhr errors
                                                    alert(message);
                                                    location.reload();
                                                }
                                            });
                                            this.on("complete", function () {
                                                if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                                                    var _this = this;
                                                    _this.removeAllFiles();
//                                                    $.notify("Successfully uploaded", "success");
                                                    window.parent.$.jeegoopopup.close();
//                                                    getImages(<?php print $id ?>);
                                                }
                                            });
                                            this.on("success", function (file, response) {
                                                if (response['msg'] == -1) {
                                                    alert("File type not supported!");
                                                }
                                            });
                                        }
                                    });
                                });

                                function getImages(id) {
                                    $.ajax({
                                        url: '../ajax/ajx_saq_site_images',
                                        type: 'GET',
                                        dataType: 'json',
                                        data: {'option': 'VIEW', 'id': id},
                                        headers: {
                                            "Authorization": `Bearer ${sessionStorage.getItem('JWT')}`
                                        },
                                        success: function (response) {
                                            if (response.length > 0) {
                                                $('.superbox .superbox-list').remove();
                                                $.each(response, function (index, data) {
                                                    $('.superbox').append(`
                                                        <div class="superbox-list">
                                                            <img src="../${data.base_path}" data-img="../${data.base_path}" alt="" title="" class="superbox-img">
                                                        </div>`)
                                                });
                                            }
                                        },
                                        error: function (xhr, resp, text) {
                                            alert("error :" + xhr.responseText);
                                            location.reload();
                                        }
                                    });
                                }

                                function upload_image() {
                                    var myDropzone = Dropzone.forElement(".dropzone");
                                    if (myDropzone.files.length != 0) {
                                        myDropzone.processQueue();
                                    } else {
                                        $.notify("add files", "error");
                                    }
                                }

                                function deleteFile(id) {
                                    var newDiv = $(document.createElement('div'));
                                    $(newDiv).html('Are you sure?');
                                    $(newDiv).attr('title', 'Delete');
                                    //$(newDiv).css('font-size','62.5%');
                                    $(newDiv).dialog({
                                        resizable: false,
                                        height: 200,
                                        modal: true,
                                        buttons: {
                                            "Delete": function () {
                                                $.ajax({
                                                    url: '../ajax/ajx_saq_site_images',
                                                    type: 'POST',
                                                    data: {option: 'DELETE', id: id},
                                                    dataType: "json",
                                                    headers: {
                                                        "Authorization": `Bearer ${sessionStorage.getItem('JWT')}`
                                                    },
                                                    success: function (res) {
                                                        if (res['msg'] == 1) {
                                                            window.parent.$.jeegoopopup.close();
                                                        } else {
                                                            alert('Error');
                                                        }
                                                    },
                                                    error: function (xhr, status, error) {
                                                        alert("error :" + xhr.responseText);
                                                        location.reload();
                                                    }
                                                });
                                                $(this).dialog("close");
                                                $(newDiv).remove();
                                            },
                                            cancel: function () {
                                                $(this).dialog("close");
                                                $(newDiv).remove();
                                            }
                                        }
                                    });
                                }

                                // PAGE RELATED SCRIPTS

                                // pagefunction

                                var pagefunction = function () {

                                    $('.superbox').SuperBox({
                                        background: '#FF0000', // Full image background color. Default: #333
                                        border: 'white', // Full image border color. Default: #222
                                        height: 600, // Maximum full image height. Default: 400
                                        view: 'landscape|square|portrait', // Sets ratio on smaller viewports. Default: landscape
                                        xColor: '#CCC', // Close icon color. Default: #FFF
                                        xShadow: 'embed' // Close icon shadow. Default: none
                                    });

                                };

                                // end pagefunction

                                // run pagefunction on load

                                // load bootstrap-progress bar script
                                loadScript("<?php echo ASSETS_URL; ?>/js/plugin/superbox/superbox.min.js", pagefunction);

</script>

