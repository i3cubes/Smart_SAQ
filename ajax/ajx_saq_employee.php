<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../class/cls_saq_employee.php';
include_once '../class/cls_saq_region.php';


$REQUEST_METHOD = $_SERVER["REQUEST_METHOD"];
$SID = $_REQUEST['SID'];

switch ($REQUEST_METHOD){
case "POST":
    switch ($SID){
        case 200://get emp
            $emp = new saq_employee();
            $designation_id = $_POST['designation_id'];
            $name = $_POST['name'];
            $department_id = $_POST['department_id'];
            $emp->designtion_id = $designation_id;
            $emp_all = $emp->getAll();
            
            if(count($emp_all)>0){
                echo json_encode(array('result'=>1,"data"=>$emp_all));
            } else {
                 echo json_encode(array('result'=>0,"data"=>$emp_all));
            }
           break; 
    case 201://add
        $name = $_POST['emp_name'];
        $designation = $_POST['emp_designation'];
        $reigion = $_POST['emp_designation'];
        
        $emp = new saq_employee();
        $emp->name = $name;
        $emp->designtion_id = $designation;
        if(isset($_POST['emp_region'])){
            $emp_region = $_POST['emp_region'];
            
        }
        $addNew = $emp->insert();
        if($addNew){
            echo json_encode(array('result'=>1,'msg'=>"Successfully Added"));
        }else {
            echo json_encode(array('result'=>0,'msg'=>"Save Failed"));
        }
        
        break;
    case 202:
        $id = $_REQUEST['id'];
        $name = $_POST['emp_name'];
        $designation = $_POST['emp_designation'];
        $reigion = $_POST['emp_designation'];
        
        $emp = new saq_employee();
        $emp->name = $name;
        $emp->designtion_id = $designation;
        if(isset($_POST['emp_region'])){
            $emp_region = $_POST['emp_region'];
            
        }
        $edit = $emp->updateEmp();
        if($edit){
            echo json_encode(array('result'=>1,'msg'=>"Successfully Edited"));
        }else {
            echo json_encode(array('result'=>0,'msg'=>"Update Failed"));
        }
        break;
    
    
    case 203://
        $region_id = $_POST['region_id'];
        $region_obj = new saq_region($region_id);
        $regionEmployee = $region_obj->getRegionEmployees();
        //echo json_encode($regionEmployee);
         if(count($regionEmployee)>0){
                echo json_encode(array('result'=>1,"data"=>$regionEmployee));
            } else {
                 echo json_encode(array('result'=>0,"data"=>$regionEmployee));
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

