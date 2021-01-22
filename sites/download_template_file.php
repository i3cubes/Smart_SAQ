<?php

switch ($_REQUEST['file']){
    case 'G':
        $file_name="template_general.xlsx";
        break;
    case 'C':
        $file_name="template_contact.xlsx";
        break;
    case 'T':
        $file_name="template_technical.xlsx";
        break;
    case 'P':
        $file_name="template_agreement.xlsx";
        break;
    case 'A':
        $file_name="template_approvals.xlsx";
        break;
}

$filepath="../files/template/".$file_name;
print $filepath;

$exist=false;
if($filepath!=""){
    $exist=true;
}
else {}

if($exist){
    $file_name=urlencode($file_name);
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