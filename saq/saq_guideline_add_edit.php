<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include_once '../class/cls_file.php';


$file_id = $_REQUEST['file_id'];
//print_r($_REQUEST);
if ($file_id != "") {  
    $file = new file($file_id);
    
    $row_file = $file->get_file_infomation("saq_guideline_files");   
    $file_path = $file->location;
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
include_once '../class/cls_saq_guideline.php';
include_once '../class/cls_saq_guideline_files.php';

if ($_REQUEST['id'] != 0) {
    $saq_obj = new saq_guideline($_REQUEST['id']);
    $saq_obj->getDetails();
}
?>
<style>
    .customFiled {
        margin-bottom: 10px;
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
                    <div class="jarviswidget" 
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">

                        <header style="margin:0px;">                            
                            <span><h2 style="margin-left: 10px;">ADD\EDIT SAQ GUIDELINE</h2></span>				                           
                        </header>

                        <!-- widget div-->
                        <div>

                            <!-- widget content -->
                            <div class="widget-body">
                                <form class="smart-form" id="saq_form" onsubmit="submitHandler(event)">  
                                    <fieldset>  
                                        <section class="col col-4">
                                            <label class="ngs_form_lable">
                                                Name
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="input">
                                                <input type="text" name="name" id="name" value="<?php print $saq_obj->name ?>"/> 
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="ngs_form_lable">
                                                Description
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="textarea">
                                                <textarea name="description" id="description"><?php print $saq_obj->description ?></textarea>
                                            </label>
                                        </section>
                                                                                                                    
                                        <section class="col col-4">
                                            <label class="ngs_form_lable">
                                                Upload File <span style="color:red;">(You can upload PDF files only)</span>
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="input">
                                                <input type="file" name="file" id="file" style="padding:5px;"/>
                                            </label>
                                        </section>                                       
                                        <footer>
                                            <input type="hidden" name="id" id="id" value="<?php print $saq_obj->id ?>" />
                                            <input type="hidden" name="option" value="<?php print (($saq_obj->id != '') ? 'EDIT' : 'ADD') ?>" />
                                            <button class="btn btn-primary">Save&nbsp;<i class="fa fa-save"></i></button>
                                            <?php if($saq_obj->id != '') {?>
                                            <button class="btn btn-danger" type="button" onclick="saq_guideline_delete(<?php print $saq_obj->id ?>)">Delete&nbsp;<i class="fa fa-trash"></i></button>
                                            <?php } ?>
                                        </footer>                                          
                                    </fieldset>                                             
                                </form>
                                <section class="col-12" style="margin:0px 15px;">
                                    <?php
                                    if($saq_obj->id != '') {
                                        $saq_g_file = new saq_guideline_file();
                                    $saq_files = $saq_g_file->getAll($saq_obj->id);

                                    if (count($saq_files) > 0) {
                                        print "<table class='table' id='saq_files'>"
                                        . "<thead>"
                                        . "<th>Name</th>"
                                                . "<th>Delete</th></thead><tbody>";
                                        foreach ($saq_files as $file) {                                            
                                                   print "<tr>"
                                                    . "<td><a href='?file_id=".$file['id']."'>" . $file['name'] . "</a></td>"
                                                    . "<td width='5%' align='center'><button class='btn btn-danger btn-xs' type='button' onclick='deleteFile(".$file['id'].")'><i class='fa fa-trash'></i></button></td>"
                                                    . "</tr>";
                                                    
                                        }
                                        print "</tbody></table>";
                                    }
                                    }                                    
                                    ?>
                                </section>
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
    $(document).ready(function () {
<?php if ($saq_obj->id == '') { ?>
            var validate = $("#saq_form").validate({
                ignore: "not:hidden",
                // Rules for form validation
                rules: {
                    name: {
                        required: true
                    },
                    description: {
                        required: true
                    }
                },

                // Messages for form validation
                messages: {
                    name: {
                        required: "Please enter name"
                    },
                    description: {
                        required: "Please enter description"
                    }
                },

                // Do not change code below
                errorPlacement: function (error, element) {
                    error.insertAfter(element.parent());
                }
            });
<?php } ?>
    
//        $('.download_file').click(function() {
//            location.reload();
//        });
    });

    function submitHandler(e) {
        e.preventDefault();
        var form = $('#saq_form').serializeObject();
        if ($("#saq_form").valid()) {
            if ($("#file").prop('files').length > 0) {
                var files = $("#file").prop('files')[0];
                form_data = new FormData();
                form_data.append("file", files);
                form_data.append("data", JSON.stringify(form));
            } else {
                form_data = new FormData();
                form_data.append("data", JSON.stringify(form));
            }
            console.log(form_data);
//            return false;
            $.ajax({
                url: '../ajax/ajx_saq_guideline',
                type: 'POST',
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response) {
                    if (response['msg'] == 1) {
                        if(response['error'] != null) {
                            alert(response['error']);
                        }
                        window.parent.location.reload();
                        window.parent.$.jeegoopopup.close();
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
    
    function deleteFile(id) {
         var newDiv = $(document.createElement('div'));
    $(newDiv).html('Are you sure ?');
    $(newDiv).attr("title", "DELETE");
    $(newDiv).dialog({
        resizable: false,
        height: 150,
        modal: true,
        buttons: {
            Yes: function () {
                $.ajax({
                    url: '../ajax/ajx_saq_guideline',
                    type: 'POST',
                    data: {option: 'DELETEFILE', id: id},
                    dataType: "json",
                    success: function (response) {
                        if (response['msg'] == 1) {
//                            getFiles();
                            window.parent.location.reload();
                        window.parent.$.jeegoopopup.close();
                        } else {
                            alert('Failure');
                        }
                        $(newDiv).dialog("close");
                        $(newDiv).remove();
                    },
                    error: function (xhr, status, error) {
                        alert(status);
                    }
                });
            },
            cancel: function () {
                $(this).dialog("close");
                $(newDiv).remove();
            }
        }
    });
    }
    
    function getFiles() {
        $.ajax({
            url: '../ajax/ajx_saq_guideline',
            type: 'POST',
            dataType: 'JSON',
            data: {option: 'GETFILES', id: $('#id').val()},
            success: function(response) {
                $('#saq_files > tbody').children().remove();
                if(response.length > 0) {
                    $.each(response, function(index, data){
                        $('#saq_files tbody').append(`
                                "<tr>"
                                                    . "<td><a href='?file_id=".${data.id}."'>${data.name}</a></td>"
                                                    . "<td width='5%' align='center'><button class='btn btn-danger btn-xs' type='button' onclick='deleteFile(${data.id})'><i class='fa fa-trash'></i></button></td>"
                                                    . "</tr>"
                        `);
                    });
                }
            },
            error: function (xhr, status, error) {
                        alert(status);
                    }
        });
    }
    
    function saq_guideline_delete(id) {
     var newDiv = $(document.createElement('div'));
    $(newDiv).html('Are you sure ?');
    $(newDiv).attr("title", "DELETE");
    $(newDiv).dialog({
        resizable: false,
        height: 150,
        modal: true,
        buttons: {
            Yes: function () {
                $.ajax({
                    url: '../ajax/ajx_saq_guideline',
                    type: 'POST',
                    data: {option: 'DELETE', id: id},
                    dataType: "json",
                    success: function (response) {
                        if (response['msg'] == 1) {
                            window.parent.location.reload();
                        window.parent.$.jeegoopopup.close();
                        } else {
                            alert('Failure');
                        }
                        $(newDiv).dialog("close");
                        $(newDiv).remove();
                    },
                    error: function (xhr, status, error) {
                        alert(status);
                    }
                });
            },
            cancel: function () {
                $(this).dialog("close");
                $(newDiv).remove();
            }
        }
    });
}
</script>