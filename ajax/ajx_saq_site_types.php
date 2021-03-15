<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../class/cls_site_type.php';

$REQUEST_METHOD = $_SERVER["REQUEST_METHOD"];
$SID = $_REQUEST['SID'];

switch ($REQUEST_METHOD){
case "POST":
    switch ($SID){
        case 200://get gn
            $site_type = new saq_site_type();
            $type = $_REQUEST['name'];
            $site_type->type = $type;
            $site_type_all = $site_type->getAll();
            
            if(count($site_type_all)>0){
                echo json_encode(array('result'=>1,"data"=>$site_type_all));
            } else {
                 echo json_encode(array('result'=>0,"data"=>$site_type_all));
            }
           break; 
    case 201://add
        $type = $_POST['site_type'];
        $site_type = new saq_site_type();
        $site_type->type = $type;
        $addNew  = $site_type->addNew();
        if($addNew){
            echo json_encode(array('result'=>1,'msg'=>"Successfully Added"));
        }else {
            echo json_encode(array('result'=>0,'msg'=>"Save Failed"));
        }
        
        break;
    case 202:
        $type = $_POST['site_type'];
        $id = $_POST['id'];
        $site_type = new saq_site_type();
        $site_type->id = $id;
        $site_type->type = $type;
        $edit  = $site_type->edit();
        if($edit){
            echo json_encode(array('result'=>1,'msg'=>"Successfully Edited"));
        }else {
            echo json_encode(array('result'=>0,'msg'=>"Update Failed"));
        }
        break;
    
    
    
    
    
    default :// default SID
        return false;
        break;
    }
    break;

default :
    return false;
    break;
    
    
}

