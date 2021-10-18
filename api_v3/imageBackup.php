
<?php

include_once '../class/cls_backup_image.php';

$log_file="/var/log/roads/api_calls_dialog_.txt";
$str=date("Y-m-d H:i:s")." || {".implode(",",array_keys($_REQUEST))."} -- {".implode(",",$_REQUEST)."}";
if ($file=fopen($log_file, "a+")) {
	fputs($file,"$str \n");
	fclose($file);
}

$uid = $_REQUEST["uid"];
$module=$_REQUEST['module'];
$tag=$_REQUEST['tag'];

$uploads_dir = "../files/backup/";
$path="files/backup/";

$bkp_img=new backup_image();

if($module!="" && $uid!=""){


    if (!file_exists($uploads_dir)) {
        $createFolder = mkdir($uploads_dir, 755, true);
        if (!$createFolder) {
            $json[] = array(
                'result' => "0",
                'meggage' => "Cannot create directory !"
                );
            exit;
        } else {
            //echo "file created ";
        }
    }

    //print_r($_FILES);

    if (is_uploaded_file($_FILES['image']['tmp_name'])) {
        $imagename = $stage_id . time();  //image name imei+stimestamp

        $tmp = $_FILES["image"]["tmp_name"];
        $type = $_FILES["image"]["type"];
        $extension = explode(".", $_FILES["image"]["name"]);
        $nameurl = $imagename . "." . $extension[1];
        $url = $uploads_dir . $nameurl;
        $path=$path.$nameurl;

        if (move_uploaded_file($tmp, $url)) {
           $bkp_img->module=$module;
           $bkp_img->tag=$tag;
           $bkp_img->user_id=$uid;
           $bkp_img->path=$path;
           $bkp_img->type=$type;
           $res=$bkp_img->save();
           if($res){
               $json[] = array(
                    'result' => "1",
                    'record_id' => $res
                );
           }
           else{
               $json[] = array(
                    'result' => "0",
                    'error_code'=>"3",
                    'error' => "Image saved, but db not updated"
                );
           }
        } else {
            $json[] = array(
                'result' => "0",
                'error_code'=>"4",
                'meggage' => "Image could not save to disk"
            );
        }
    } else {
        $json[] = array(
            'result' => "0",
            'error_code'=>"2",
            'error' => "Image upload Error !"
        );
    }
}
else{
    $json[] = array(
            'result' => "0",
            'error_code'=>"1",
            'error' => "parameter missing"
        );
}
print json_encode($json);
?>
