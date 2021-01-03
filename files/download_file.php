<?php
include_once '../class/cls_job_order.php';
$file_no=$_REQUEST['fid'];

//get already uploaded files
$jo=new job_order();
$row_file=$jo->getFileData($file_no);


$filepath=$row_file['Path'];
$type=$row_file['Type'];
print $filepath."/".$type;


if($filepath!=""){
	$exist=true;
}
else {
	$exist=false;
}
if($type==''){
	$type="";
}
if($exist){
	$file_name=urlencode($row_file['Name']);
	//print $file_name;
	//$header1="Content-disposition: attachment; filename=$file_name";
	//$header2="Content-type: $type";
	//header($header1);
	//header($header2);
	//readfile($filepath);
	
	header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.$file_name);
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filepath));
    ob_clean();
    flush();
    readfile($filepath);
}
else {
	print "File Not Found";
}

?>