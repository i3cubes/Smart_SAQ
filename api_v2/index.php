<?php

include_once '../class/cls_site_manager.php';
include_once '../class/cls_site.php';
include_once '../class/cls_saq_guideline_manager.php';
include_once '../class/cls_saq_guideline.php';

include_once '../class/cls_site_model.php';
include_once '../class/cls_site_model_manager.php';

include_once '../class/cls_agreement_model.php';
include_once '../class/cls_agreement_model_manager.php';
include_once '../class/cls_user.php';

//session_id($_REQUEST['pid']);

if($_REQUEST['pid']!=""){
    print "SID-bbbb=".session_id();
    session_id($_REQUEST['pid']);
    session_start();
    print "SID-afff=".session_id();
}
else{
    session_start();
}
print "SID=".session_id();
print_r($_SESSION);
$system_url="http://203.94.66.253/dialogsaq/";
$key = $_REQUEST['KEY'];
$sid=$_REQUEST['SID'];
$device_id=$_REQUEST['device_id'];
$uid=$_REQUEST['uid'];
$parent_id=(int)$_REQUEST['parent_id'];

$site_name=$_REQUEST['name'];
$code=$_REQUEST['code'];

$radius=$_REQUEST['radius'];
$lat=$_REQUEST['lat'];
$lon=$_REQUEST['lon'];

$site_id=$_REQUEST['site_id'];
$tab_id=$_REQUEST['tab_id'];

//Define tree
$node[0]= array(0=>"node",1=>"Site",2=>"Agreements");
$node[1]=array(0=>"node",3=>"Roof Top",4=>"Green Field");
$node[3]=array(0=>"node",5=>"10M",6=>"Pole",7=>"15M");
$node[4]=array(0=>"node",8=>"80M",9=>"50M",10=>"30M");
$node[5]=array(0=>"image",1=>"image1.jpeg",2=>"image2.jpg",3=>"image3.jpg");
$node[6]=array(0=>"image",4=>"image4.jpg",5=>"image5.jpg",6=>"image6.jpg");
$node[7]=array(0=>"image",7=>"image7.jpg",8=>"image8.jpg",9=>"image9.jpg");
//print $ip;
$log_file = "api_calls.txt";
$str = date("Y-m-d H:i:s") . " || {" . implode(",", array_keys($_REQUEST)) . "} -- {" . implode(",", $_REQUEST) . "}";
if ($file = fopen($log_file, "a+")) {
    fputs($file, "$str \n");
    fclose($file);
}


$response = array();
//LOGIN
if($sid=='100'){
    if($_REQUEST['user_name']=="" || $_REQUEST['password']==""){
        $response[0]["result"] = '0';
        $response[0]["pid"] = null;
        $response[0]["error_code"] = "1002";
        $response[0]["error"] = "User Name or Password is empty";
    }
    else{
        $us=new user();
        $us->name=$_REQUEST['user_name'];
        $us->password=$_REQUEST['password'];
        if($us->loginUser()){
            $response[0]["result"] = '1';
            $response[0]["user_id"] = $_SESSION['UID'];
            $response[0]["pid"] = session_id();
        }
        else{
            $response[0]["result"] = '0';
            $response[0]["pid"] = "";
            $response[0]["error_code"] = "1001";
            $response[0]["error"] = "User Name or Password is wrong";
        }
    }
}
else{
    if ($_SESSION['UID']==$uid) {
        switch ($sid){
        case '110':
            $site_model=new \site_model();
            if($parent_id==''){
                $site_model_mgr=new site_model_manager();
                $ary_nodes=$site_model_mgr->getParentNodes();
            }
            else{
                $site_model=new site_model($parent_id);
                $ary_nodes=$site_model->getChild();
            }
            //$parent_id==""?$parent_id=0:$parent_id=$parent_id;
            //$ary_nodes=$node[$parent_id];
            //DATA
            $count=0;
            if(count($ary_nodes)>0){
                $type='node';
                foreach ($ary_nodes as $site_model){
                    $data[]=array("node_id"=>$site_model->id,"node_name"=>$site_model->name);
                    $count++;
                }
            }
            else{
                $type='image';
                $site_model->getImages();
                foreach ($site_model->files as $file){
                    $data[]=array("image_id"=>$file['id'],"image_name"=>$file['name'],"url"=>$system_url."".$file['base_path']);
                    $count++;
                }
            }
            $response[0]["result"] = '1';
            $response[0]["count"] = $count;
            $response[0]["type"] = $type;
            $response[1]["data"] = $data;
            break;
        case '111':
            if($parent_id==""){
                $agreement_model_mgr=new agreement_model_manager();
                $ary_nodes=$agreement_model_mgr->getParentNodes();
            }
            else{
                $agreement_model=new agreement_model($parent_id);
                $ary_nodes=$agreement_model->getChild();
            }
            //DATA
            $count=0;
            if(count($ary_nodes)>0){
                $type='node';
                foreach ($ary_nodes as $agreement_model){
                    $data[]=array("node_id"=>$agreement_model->id,"node_name"=>$agreement_model->name);
                    $count++;
                }
            }
            else{
                $type='file';
                $agreement_model->getFiles();
                foreach ($agreement_model->files as $file){
                    $data[]=array("file_id"=>$file['id'],"file_name"=>$file['name'],"url"=>$system_url."".$file['base_path']);
                    $count++;
                }
            }
            $response[0]["result"] = '1';
            $response[0]["count"] = $count;
            $response[0]["type"] = $type;
            $response[1]["data"] = $data;
            break;
        case '112':
            foreach ($node[5] as $k=>$val){
                if($k!=0){
                    $data[]=array("image_id"=>$k,"image_name"=>$val,"url"=>$system_url."images/".$val);
                }
            }
            foreach ($node[6] as $k=>$val){
                if($k!=0){
                    $data[]=array("image_id"=>$k,"image_name"=>$val,"url"=>$system_url."images/".$val);
                }
            }
            foreach ($node[7] as $k=>$val){
                if($k!=0){
                    $data[]=array("image_id"=>$k,"image_name"=>$val,"url"=>$system_url."images/".$val);
                }
            }
            $response[0]["result"] = '1';
            $response[0]["count"] = count($data);
            $response[1]["data"] = $data;
            break;
        case '101':
            $site_mgr=new site_manager();
            $site=new \site();
            $ary_sites=$site_mgr->serchSite($site_name, $region_id, $radius,$code);

            $response[0]["result"] = '1';
            $response[0]["count"] = count($ary_sites);
            $data=array();
            $data['saq']=array();
            foreach ($ary_sites as $site){
                $ary_s=array("site_id"=>$site->id,"site_name"=>$site->name,"site_code"=>$site->code,"lat"=>$site->lat,"lon"=>$site->lon,"status"=>$site->status,"status_id"=>$site->status_id);
                array_push($data['saq'], $ary_s);
            }
            $response[1] = $data;
            break;
        case '102':
            $site=new site($site_id);
            $site->getData();
            $t_data=$site->getTabbedData();

            $response[0]["result"] = '1';

            switch ($tab_id){
                case '1':
                    break;
                case '2':
                    break;
                case '3':
                    break;
                case '4':
                    break;
                default :
                    $response[0]["count"] = count($t_data);
                    $response[1] = $t_data;
                    break;
            }
            break;
        case '103':
            if($lat!="" && $lon!=""){
                $site_mgr=new site_manager();
                $site=new \site();
                $ary_sites=$site_mgr->serchNearbySite($radius, $lat, $lon);

                $response[0]["result"] = '1';
                $response[0]["count"] = count($ary_sites);
                $data=array();
                $data['saq']=array();
                foreach ($ary_sites as $site){
                    $ary_s=array("site_id"=>$site->id,"site_name"=>$site->name,"site_code"=>$site->code,"lat"=>$site->lat,"lon"=>$site->lon,"status"=>$site->status,"status_id"=>$site->status_id);
                    array_push($data['saq'], $ary_s);
                }
                $response[1] = $data;
            }
            else{
                $response[0]["result"] = '0';
                $response[0]["error_code"] = '1031';
                $response[0]["error"] = 'lat or lon is empty';
            }
            break;
        case '130':
            $saq_gl_mgr=new saq_guideline_manager();
            $saq_gl=new \saq_guideline();
            $ary_gl=$saq_gl_mgr->getGuidlines();
            $response[0]["result"] = '1';
            $response[0]["count"] = count($ary_gl);
            $data=array();
            foreach ($ary_gl as $saq_gl){
                $files=array();
                $saq_files=$saq_gl->getFiles();
                foreach ($saq_files as $f){
                    array_push($files, array('name'=>$f['name'],'type'=>$f['type'],"url"=>$system_url."".$f['location']));
                }
                array_push($data, array("name"=>$saq_gl->name,"description"=>$saq_gl->description,"files"=>$files));
            }
            $response[1]['data']=$data;
            break;
        default :
            $response[0]["result"] = '0';
            $response[0]["error_code"] = '102';
            $response[0]["error"] = 'SID is empty';
            break;
        }
    }  
    else {
        $response[0]["result"] = '0';
        $response[0]["error_code"] = '101';
        $response[0]["error"] = 'session expired';
    }
}
header('Content-Type: application/json');
echo json_encode($response);
?>
