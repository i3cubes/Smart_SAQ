<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../class/cls_saq_gndivision.php';

$REQUEST_METHOD = $_SERVER["REQUEST_METHOD"];
$SID = $_REQUEST['SID'];

switch ($REQUEST_METHOD){
case "POST":
    switch ($SID){
        case 200://get gn
            $gn_division = new saq_gn_division();
            $district_id = $_REQUEST['district_id'];
            $gn_division->saq_district_id = $district_id;
            $gn_division_all = $gn_division->getAll();
            $getAll = $gn_division->getAll();
            if(count($getAll)>0){
                echo json_encode(array('result'=>1,"data"=>$getAll));
            } else {
                 echo json_encode(array('result'=>0,"data"=>$getAll));
            }
           break; 
    case 201:
        $district_id = $_POST['district_id'];
        $gn_name = $_POST['gn_name'];
        $gn_division = new saq_gn_division();
        $gn_division->gn_division = $gn_name;
        $gn_division->saq_district_id = $district_id;
        $addNew = $gn_division->addNew();
        if($addNew){
            echo json_encode(array('result'=>1,'msg'=>"Successfully Added"));
        }else {
            echo json_encode(array('result'=>0,'msg'=>"Save Failed"));
        }
        
        break;
    case 202:
        $id = $_REQUEST['id'];
        $gn_name = $_REQUEST['gn_name'];
        $district_id = $_REQUEST['district_id'];
         $gn_division = new saq_gn_division();
        $gn_division->gn_division = $gn_name;
        $gn_division->saq_district_id = $district_id;
        $gn_division->id = $id;
        $edit = $gn_division->edit();
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

