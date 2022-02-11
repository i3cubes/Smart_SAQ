<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
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
include_once '../class/cls_saq_district.php';
include_once '../class/cls_divisional_secretariat.php';
include_once '../class/cls_saq_local_authority.php';
include_once '../class/cls_police_station.php';
include_once '../class/cls_saq_region.php';
include_once '../class/cls_saq_payment_mode.php';
include_once '../class/cls_site_type.php';

include_once '../class/constants.php';

$REQUEST_METHOD = $_SERVER["REQUEST_METHOD"];
$SID = $_REQUEST['SID'];

switch ($REQUEST_METHOD) {
    case "POST":
        switch ($SID) {
            case 220://get district
                $name = $_POST['name'];
                $district = new saq_district();
                $district->name = $name;
                $district_details = $district->getAll();
                if (count($district_details) > 0) {
                    echo json_encode(array('result' => 1, "data" => $district_details));
                } else {
                    echo json_encode(array('result' => 0, "data" => $district_details));
                }
                break;
            case 221://add district
                $name = $_POST['name'];
                $province_id = $_POST['province_id'];
                $saq_district = new saq_district();
                $addNew = $saq_district->add($name, $province_id);
                if ($addNew) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Added"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Save Failed"));
                }

                break;

            case 222://edit district
                $name = $_POST['name'];
                $province_id = $_POST['province_id'];
                $id = $_POST['id'];
                $saq_district = new saq_district();

                $saq_district->id = $id;
                $saq_district->name = $name;
                $saq_district->saq_province_id = $province_id;

                $edit = $saq_district->edit();
                //print $edit;
                if ($edit) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Updated"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Update Failed"));
                }
                break;
            case 310://delete district                
                $id = $_POST['id'];
                $saq_district = new saq_district($id);

                $saq_district->status = constants::$inactive;
                $delete = $saq_district->delete();
                //print $edit;
                if ($delete) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Deleted"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Deletion Failed"));
                }
                break;
            case 230://get ds
                $name = $_POST['name'];
                $ds = new saq_ds();
                $ds->name = $name;
                $ds_details = $ds->getAll();
                if (count($ds_details) > 0) {
                    echo json_encode(array('result' => 1, "data" => $ds_details));
                } else {
                    echo json_encode(array('result' => 0, "data" => $ds_details));
                }
                break;
            case 231://add ds                
                $name = $_POST['name'];
                $ds = new saq_ds();
                $ds->name = $name;
                $addNew = $ds->add();
                if ($addNew) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Added"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Save Failed"));
                }
                break;
            case 232://edit ds
                $name = $_POST['name'];
                $id = $_POST['id'];
                $ds = new saq_ds();

                $ds->id = $id;
                $ds->name = $name;
                $edit = $ds->edit();
                //print $edit;
                if ($edit) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Updated"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Update Failed"));
                }
                break;
            case 311://delete ds                
                $id = $_POST['id'];
                $ds = new saq_ds($id);

                $ds->status = constants::$inactive;
                $delete = $ds->delete();
                //print $edit;
                if ($delete) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Deleted"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Deletion Failed"));
                }
                break;
            case 240://get la
                $name = $_POST['name'];
                $la = new saq_la();
                $la->name = $name;
                $la_details = $la->getAll();
                if (count($la_details) > 0) {
                    echo json_encode(array('result' => 1, "data" => $ds_details));
                } else {
                    echo json_encode(array('result' => 0, "data" => $ds_details));
                }
                break;
            case 241://add la                
                $name = $_POST['name'];
                $la = new saq_la();
                $la->name = $name;
                $addNew = $la->add();
                if ($addNew) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Added"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Save Failed"));
                }
                break;
            case 242://edit la
                $name = $_POST['name'];
                $id = $_POST['id'];
                $la = new saq_la();

                $la->id = $id;
                $la->name = $name;
                $edit = $la->edit();
                //print $edit;
                if ($edit) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Updated"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Update Failed"));
                }
                break;
            case 321://delete la                
                $id = $_POST['id'];
                $la = new saq_la($id);

                $la->status = constants::$inactive;
                $delete = $la->delete();
                //print $edit;
                if ($delete) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Deleted"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Deletion Failed"));
                }
                break;
            case 250://get ps
                $name = $_POST['name'];
                $ps = new saq_police_station();
                $ps->name = $name;
                $ps_details = $ps->getAll();
                if (count($ps_details) > 0) {
                    echo json_encode(array('result' => 1, "data" => $ps_details));
                } else {
                    echo json_encode(array('result' => 0, "data" => $ps_details));
                }
                break;
            case 251://add ps                
                $name = $_POST['name'];
                $ps = new saq_police_station();
                $ps->name = $name;
                $addNew = $ps->add();
                if ($addNew) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Added"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Save Failed"));
                }
                break;
            case 252://edit ps
                $name = $_POST['name'];
                $id = $_POST['id'];
                $ps = new saq_police_station();

                $ps->id = $id;
                $ps->name = $name;
                $edit = $ps->edit();
                //print $edit;
                if ($edit) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Updated"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Update Failed"));
                }
                break;
            case 331://delete ps                
                $id = $_POST['id'];
                $ps = new saq_police_station($id);

                $ps->status = constants::$inactive;
                $delete = $ps->delete();
                //print $edit;
                if ($delete) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Deleted"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Deletion Failed"));
                }
                break;
             case 260://get region
                $name = $_POST['name'];
                $region = new saq_region();
                $region->name = $name;
                $region_details = $region->getAll();
                if (count($region_details) > 0) {
                    echo json_encode(array('result' => 1, "data" => $region_details));
                } else {
                    echo json_encode(array('result' => 0, "data" => $region_details));
                }
                break;
            case 261://add region                
                $name = $_POST['name'];
                $manager_id = $_POST['manager_id'];
                $region = new saq_region();
                $region->name = $name;
                $region->manager_id = $manager_id;
                $addNew = $region->add($name);
                if ($addNew) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Added"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Save Failed"));
                }
                break;
            case 262://edit ps
                $name = $_POST['name'];
                $manager_id = $_POST['manager_id'];
                $id = $_POST['id'];
                $region = new saq_region();

                $region->id = $id;
                $region->name = $name;
                $region->manager_id = $manager_id;
                $edit = $region->edit();
                //print $edit;
                if ($edit) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Updated"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Update Failed"));
                }
                break;
            case 341://delete ps                
                $id = $_POST['id'];
                $region = new saq_region($id);

                $region->status = constants::$inactive;
                $delete = $region->delete();
                //print $edit;
                if ($delete) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Deleted"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Deletion Failed"));
                }
                break;
            case 270://get payment mode
                $name = $_POST['name'];
                $payment_mode = new saq_payment_mode();
                $payment_mode->name = $name;
                $payment_mode_details = $payment_mode->getAll();
                if (count($payment_mode_details) > 0) {
                    echo json_encode(array('result' => 1, "data" => $payment_mode_details));
                } else {
                    echo json_encode(array('result' => 0, "data" => $payment_mode_details));
                }
                break;
            case 271://add payment mode             
                $name = $_POST['name'];                
                $payment_mode = new saq_payment_mode();
                $payment_mode->name = $name;
                
                $addNew = $payment_mode->add();
                if ($addNew) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Added"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Save Failed"));
                }
                break;
            case 272://edit payment mode
                $name = $_POST['name'];                
                $id = $_POST['id'];
                $payment_mode = new saq_payment_mode($id);

//                $payment_mode->id = $id;
                $payment_mode->name = $name;                
                $edit = $payment_mode->edit();
                //print $edit;
                if ($edit) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Updated"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Update Failed"));
                }
                break;
            case 351://delete payment mode               
                $id = $_POST['id'];
                $payment_mode = new saq_payment_mode($id);

                $payment_mode->status = constants::$inactive;
                $delete = $payment_mode->delete();
                //print $edit;
                if ($delete) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Deleted"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Deletion Failed"));
                }
                break;
            case 280://get site type
                $name = $_POST['name'];
                $site_type = new saq_site_type();
                $site_type->type = $name;
                $site_type_details = $site_type->getAll();
                if (count($site_type_details) > 0) {
                    echo json_encode(array('result' => 1, "data" => $site_type_details));
                } else {
                    echo json_encode(array('result' => 0, "data" => $site_type_details));
                }
                break;
            case 281://add site type           
                $name = $_POST['site_type'];                
                $site_type = new saq_site_type();
                $site_type->type = $name;
                
                $addNew = $site_type->addNew();
                if ($addNew) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Added"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Save Failed"));
                }
                break;
            case 282://edit site type                  
                $name = $_POST['site_type'];                
                $id = $_POST['id'];
                $site_type = new saq_site_type($id);

//                $payment_mode->id = $id;
                $site_type->type = $name;                
                $edit = $site_type->edit();
                //print $edit;
                if ($edit) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Updated"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Update Failed"));
                }
                break;
            case 361://delete site type               
                $id = $_POST['id'];
                $site_type = new saq_site_type($id);

                $site_type->status = constants::$inactive;
                $delete = $site_type->delete();
                //print $edit;
                if ($delete) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Deleted"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Deletion Failed"));
                }
                break;
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
            case 301://delete depot                
                $id = $_POST['id'];
                $depot = new saq_dns_depot($id);

                $depot->status = constants::$inactive;
                $edit = $depot->delete();
                //print $edit;
                if ($edit) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Deleted"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Deletion Failed"));
                }
                break;
            case 220://get district
                $name = $_POST['name'];
                $district = new saq_district();
                $district->name = $name;
                $district_details = $district->getAll();
                if (count($district_details) > 0) {
                    echo json_encode(array('result' => 1, "data" => $district_details));
                } else {
                    echo json_encode(array('result' => 0, "data" => $district_details));
                }
                break;
            case 221://add district
                $name = $_POST['name'];
                $province_id = $_POST['province_id'];
                $saq_district = new saq_district();
                $addNew = $saq_district->add($name, $province_id);
                if ($addNew) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Added"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Save Failed"));
                }

                break;

            case 222://edit district
                $name = $_POST['name'];
                $province_id = $_POST['province_id'];
                $id = $_POST['id'];
                $saq_district = new saq_district();

                $saq_district->id = $id;
                $saq_district->name = $name;
                $saq_district->saq_province_id = $province_id;

                $edit = $saq_district->edit();
                //print $edit;
                if ($edit) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Updated"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Update Failed"));
                }
                break;
            case 310://delete district                
                $id = $_POST['id'];
                $saq_district = new saq_district($id);

                $saq_district->status = constants::$inactive;
                $delete = $saq_district->delete();
                //print $edit;
                if ($delete) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Deleted"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Deletion Failed"));
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
            case 303://delete category                
                $id = $_POST['id'];
                $site_category = new saq_site_category($id);

                $delete = $site_category->delete();
                //print $edit;
                if ($delete) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Deleted"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Deletion Failed"));
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
                $edit = $access_type->edit();
                //print $edit;
                if ($edit) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Updated"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Update Failed"));
                }
                break;
            case 304://delete access type                
                $id = $_POST['id'];
                $access_type = new saq_access_type($id);

                $delete = $access_type->delete();
                //print $edit;
                if ($delete) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Deleted"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Deletion Failed"));
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
                $edit = $permission_type->edit();
                //print $edit;
                if ($edit) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Updated"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Update Failed"));
                }
                break;
            case 305://delete permission type                
                $id = $_POST['id'];
                $permission_type = new saq_permission_type($id);

                $delete = $permission_type->delete();
                //print $edit;
                if ($delete) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Deleted"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Deletion Failed"));
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
                $name = $_POST['ownership'];
                $id = $_POST['id'];
                $ownership = new saq_site_ownership($id);
//                $permission_type->id = $id;
                $ownership->ownership = $name;
                $edit = $ownership->edit();
                //print $edit;
                if ($edit) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Updated"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Update Failed"));
                }
                break;
            case 302://delete ownership                
                $id = $_POST['id'];
                $ownership = new saq_site_ownership($id);
                $delete = $ownership->delete();
                //print $edit;
                if ($delete) {
                    echo json_encode(array('result' => 1, 'msg' => "Successfully Deleted"));
                } else {
                    echo json_encode(array('result' => 0, 'msg' => "Deletion Failed"));
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