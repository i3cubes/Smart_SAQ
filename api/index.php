<?php
$system_url="http://220.247.201.200/SmartField/images/";
$key = $_REQUEST['KEY'];
$sid=$_REQUEST['SID'];
$device_id=$_REQUEST['device_id'];
$parent_id=(int)$_REQUEST['parent_id'];

//Define tree
$node[0]= array(0=>"node",1=>"Site",2=>"Agreements");
$node[1]=array(0=>"node",3=>"Roof Top",4=>"Green Field");
$node[3]=array(0=>"node",5=>"10M",6=>"Pole",7=>"15M");
$node[4]=array(0=>"node",8=>"80M",9=>"50M",10=>"30M");
$node[5]=array(0=>"image",1=>"imag1.jpg",1=>"imag2.jpg",1=>"imag3.jpg");
$node[6]=array(0=>"image",1=>"imag4.jpg",1=>"imag5.jpg",1=>"imag6.jpg");
$node[7]=array(0=>"image",1=>"imag7.jpg",1=>"imag8.jpg",1=>"imag9.jpg");
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
