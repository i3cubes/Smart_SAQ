<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../class/cls_saq_dns_depot.php';
include_once '../class/cls_saq_site_category.php';
include_once '../class/cls_saq_access_type.php';
include_once '../class/cls_saq_permission_type.php';
include_once '../class/cls_saq_ownership.php';
include_once '../class/cls_saq_other_operator.php';

$REQUEST_METHOD = $_SERVER["REQUEST_METHOD"];
$SID = $_REQUEST['SID'];

switch ($REQUEST_METHOD) {
    case "POST":
        switch ($SID) {
            case 200://get depot
                $name = $_POST['name'];
                $depot = new saq_dns_depot();
                $depot->depot_name = $name;
                $depot_details = $depot->getAll();
                if (count($depot_details) > 0) {
                    echo json_encode(array('result' => 1, "data" => $depot_details));
                } else {
                    echo json_encode(array('result' => 0, "data" => $depot_details));
                }
                break;
            case 201://add depot
                $name = $_POST['name'];
                $depot = new saq_dns_depot();
                $depot->depot_name = $name;
                $addNew = $depot->addNew();
                if ($addNew) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Added"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Save Failed"));
                }

                break;

            case 202://edit depot
                $name = $_POST['name'];
                $id = $_POST['id'];
                $depot = new saq_dns_depot();

                $depot->id = $id;
                $depot->depot_name = $name;
                $edit = $depot->edit();
                //print $edit;
                if ($edit) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Updated"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Update Failed"));
                }
                break;
            case 203://get category
                $name = $_POST['category'];
                $category = new saq_site_category();
                $category->category = $name;
                $category_details = $category->getAll();
                if (count($category_details) > 0) {
                    echo json_encode(array('result' => 1, "data" => $category_details));
                } else {
                    echo json_encode(array('result' => 0, "data" => $category_details));
                }
                break;

            case 204://add cat
                $name = $_POST['category'];
                $category = new saq_site_category();
                $category->category = $name;
                $addNew = $category->add();
                if ($addNew) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Added"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Save Failed"));
                }

                break;

            case 205://edit cat
                $name = $_POST['category'];
                $id = $_POST['id'];
                $category = new saq_site_category();
                $category->id = $id;
                $category->category = $name;
                $category = $category->edit();
                //print $edit;
                if ($edit) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Updated"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Update Failed"));
                }
                break;
            case 206://get access type
                $name = $_POST['type'];
                $access_type = new saq_access_type();
                $access_type->access_type = $name;
                $access_type_details = $access_type->getAll();
                if (count($access_type_details) > 0) {
                    echo json_encode(array('result' => 1, "data" => $access_type_details));
                } else {
                    echo json_encode(array('result' => 0, "data" => $access_type_details));
                }
                break;

            case 207://add  access type
                $name = $_POST['type'];
                $access_type = new saq_access_type();
                $access_type->access_type = $name;
                $addNew = $access_type->add();
                if ($addNew) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Added"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Save Failed"));
                }

                break;

            case 208://edit access_type
                $name = $_POST['type'];
                $id = $_POST['id'];
                $access_type = new saq_access_type();
                $access_type->id = $id;
                $access_type->access_type = $name;
                $edit= $access_type->edit();
                //print $edit;
                if ($edit) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Updated"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Update Failed"));
                }
                break;
                
                
                
                
            case 209://get permission type
                $name = $_POST['type'];
                $permission_type = new saq_permission_type();
                $permission_type->permission_type = $name;
                $permission_type_details = $permission_type->getAll();
                if (count($permission_type_details) > 0) {
                    echo json_encode(array('result' => 1, "data" => $permission_type_details));
                } else {
                    echo json_encode(array('result' => 0, "data" => $permission_type_details));
                }
                break;

            case 210://add  permission type
                $name = $_POST['type'];
                $permission_type = new saq_permission_type();
                $permission_type->permission_type = $name;
                $addNew = $permission_type->add();
                if ($addNew) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Added"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Save Failed"));
                }

                break;

            case 211://edit permission_type
                $name = $_POST['type'];
                $id = $_POST['id'];
                $permission_type = new saq_permission_type();
                $permission_type->id = $id;
                $permission_type->permission_type = $name;
                $edit= $permission_type->edit();
                //print $edit;
                if ($edit) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Updated"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Update Failed"));
                }
                break;
                
                
                
            case 212://get ownership type
                $name = $_POST['type'];
                $ownership = new saq_site_ownership();
                $ownership->ownership = $name;
                $ownership_details = $ownership->getAll();
                if (count($ownership_details) > 0) {
                    echo json_encode(array('result' => 1, "data" => $ownership_details));
                } else {
                    echo json_encode(array('result' => 0, "data" => $ownership_details));
                }
                break;

            case 213://add  ownership type
                $name = $_POST['ownership'];
                $ownership = new saq_site_ownership();
                $ownership->ownership = $name;
                $addNew = $ownership->add();
                if ($addNew) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Added"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Save Failed"));
                }

                break;

            case 214://edit ownership
                $name = $_POST['type'];
                $id = $_POST['id'];
                $ownership = new saq_site_ownership();
                $permission_type->id = $id;
                $ownership->ownership = $name;
                $edit= $ownership->edit();
                //print $edit;
                if ($edit) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Updated"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Update Failed"));
                }
                break;
 case 215://get operator type
                $name = $_POST['type'];
                $other_operators = new saq_other_operator();
                $other_operators->ownership = $name;
                $other_operators_details = $other_operators->getAll();
                if (count($other_operators_details) > 0) {
                    echo json_encode(array('result' => 1, "data" => $other_operators_details));
                } else {
                    echo json_encode(array('result' => 0, "data" => $other_operators_details));
                }
                break;

            default :
                break;
        }
        break;


    default :
        break;
}