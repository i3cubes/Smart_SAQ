<?php
include_once '../class/cls_site_manager.php';
include_once '../class/cls_site.php';


$system_url="http://203.94.66.253/dialogsaq/images/";
$key = $_REQUEST['KEY'];
$sid=$_REQUEST['SID'];
$device_id=$_REQUEST['device_id'];
$parent_id=(int)$_REQUEST['parent_id'];

$site_name=$_REQUEST['name'];
$site_code=$_REQUEST['code'];
$radius=$_REQUEST['radius'];

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
if ($key == "2ea3490b80dd2bd77d1a") {
    switch ($sid){
    case '110':
        $parent_id==""?$parent_id=0:$parent_id=$parent_id;
        $ary_nodes=$node[$parent_id];
        //DATA
        if($ary_nodes[0]=='node'){
            foreach ($ary_nodes as $k=>$val){
                if($k!=0){
                    $data[]=array("node_id"=>$k,"node_name"=>$val);
                }
            }
        }
        else{
            foreach ($ary_nodes as $k=>$val){
                if($k!=0){
                    $data[]=array("image_id"=>$k,"image_name"=>$val,"url"=>$system_url.$val);
                }
            }
        }
        $response[0]["result"] = '1';
        $response[0]["count"] = count($ary_nodes);
        $response[0]["type"] = $ary_nodes[0];
        $response[1]["data"] = $data;
        break;
    case '112':
        foreach ($node[5] as $k=>$val){
            if($k!=0){
                $data[]=array("image_id"=>$k,"image_name"=>$val,"url"=>$system_url.$val);
            }
        }
        foreach ($node[6] as $k=>$val){
            if($k!=0){
                $data[]=array("image_id"=>$k,"image_name"=>$val,"url"=>$system_url.$val);
            }
        }
        foreach ($node[7] as $k=>$val){
            if($k!=0){
                $data[]=array("image_id"=>$k,"image_name"=>$val,"url"=>$system_url.$val);
            }
        }
        $response[0]["result"] = '1';
        $response[0]["count"] = count($data);
        $response[1]["data"] = $data;
        break;
    case '101':
        $site_mgr=new site_manager();
        $site=new \site();
        $ary_sites=$site_mgr->serchSite($site_name, $region_id, $radius);
        
        $response[0]["result"] = '1';
        $response[0]["count"] = count($ary_sites);
        $data=array();
        $data['saq']=array();
        foreach ($ary_sites as $site){
            $ary_s=array("site_id"=>$site->id,"site_name"=>$site->name,"site_code"=>$site->code,"lat"=>$site->lat,"lon"=>$site->lon);
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
    $response[0]["error"] = 'you are not authorized user(Invalid Key)';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
