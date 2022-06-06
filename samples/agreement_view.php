<?php
include_once '../class/cls_file.php';

$file_id = $_REQUEST['file_id'];
//print 'a';
if ($file_id != "") {
    $file = new file($file_id);

    $row_file = $file->get_file_infomation("saq_sample_agreement_files");
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
session_start();

//error_reporting();
//ini_set("display_errors", 1);
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
include_once '../class/cls_agreement_model.php';
$id = htmlspecialchars($_REQUEST['id']);
$agreement_model_obj = new agreement_model($id);
$agreement_model_obj->getData();
?>
<style>
    .customFiled {
        margin-bottom: 10px;
    }
</style>
<link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/dropzone.css">
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
                            <span class="widget-icon"><i class="fa fa-plus"></i></span>
                            <span><h2 style="margin-left: 10px;">AGREEMENT FILE - <?php print $agreement_model_obj->name ?></h2></span>				                           
                        </header>

                        <!-- widget div-->
                        <div>

                            <!-- widget content -->
                            <div class="widget-body">

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div id="drop" class="dropzone">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-align-right">
                                    <div class="page-title">
                                        <a class="btn btn-default" onclick="upload_image()">Upload</a>                            
                                    </div>
                                    <p style="color:red;">Supported file type(s) .jpeg,.jpg,.png,.gif,.pdf</p>

                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="">
                                    <table id="agreement_files" class="table">
                                        <thead>
                                        <th>Name</th>
                                        <th width='5%'>Delete</th>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end widget content -->

                        </div>
                        <!-- end widget div -->

                    </div>
                    <!-- end widget -->

                    <!-- END COL -->		

            </div>

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
<script src="<?php echo ASSETS_URL; ?>/js/dropzone.js"></script>
<script type="text/javascript">
                                            $(document).ready(function () {

                                                getFiles(<?php print $id ?>);

                                                $("#drop").dropzone({
                                                    url: "../ajax/ajx_saq_agreement_files",
                                                    autoProcessQueue: false,
                                                    addRemoveLinks: true,
                                                    acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",
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
//                                                        $.notify("Successfully uploaded", "success"); 
                                                                getFiles(<?php print $id ?>);
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

                                            function upload_image() {
                                                var myDropzone = Dropzone.forElement(".dropzone");
                                                if (myDropzone.files.length != 0) {
                                                    myDropzone.processQueue();
                                                } else {
                                                    $.notify("add files", "error");
                                                }
                                            }

                                            function getFiles(id) {
                                                $.ajax({
                                                    url: '../ajax/ajx_saq_agreement_files',
                                                    type: 'GET',
                                                    dataType: 'json',
                                                    data: {'option': 'VIEW', 'id': id},
                                                    headers: {
                                                        "Authorization": `Bearer ${sessionStorage.getItem('JWT')}`
                                                    },
                                                    success: function (response) {
                                                        $('#agreement_files > tbody').children().remove();
                                                        if (response.length > 0) {
                                                            $.each(response, function (index, data) {
                                                                $('#agreement_files tbody').append(
                                                                        `<tr>
                                                            <td><a href='?file_id=${data.id}'>${data.name}</a></td>
                                                            <td><button class='btn btn-danger btn-xs' onclick='deleteFile(${data.id})'><i class='fa fa-trash'></i></button></td>
                                                        </tr>`);
                                                            });
                                                        }
                                                    },
                                                    error: function (xhr, resp, text) {
                                                        alert("error :" + xhr.responseText);
                                                        location.reload();
                                                    }
                                                });
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
                                                                url: '../ajax/ajx_saq_agreement_files',
                                                                type: 'POST',
                                                                data: {option: 'DELETE', id: id},
                                                                dataType: "json",
                                                                headers: {
                                                                    "Authorization": `Bearer ${sessionStorage.getItem('JWT')}`
                                                                },
                                                                success: function (res) {
                                                                    if (res['msg'] == 1) {
                                                                        getFiles(<?php print $id ?>);
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
</script>