<?php

switch ($_REQUEST['file']){
    case 'G':
        $file_name="template_general.csv";
        break;
    case 'C':
        $file_name="template_contact.csv";
        break;
    case 'T':
        $file_name="template_technical.csv";
        break;
    case 'P':
        $file_name="template_agreement.csv";
        break;
    case 'A':
        $file_name="template_approvals.csv";
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