<?php

session_start();
include_once '../class/constants.php';
include_once '../class/cls_employees.php';
include_once '../class/cls_user.php';

if (array_key_exists('data', $_REQUEST)) {
    $data = json_decode($_REQUEST['data'], true);
    $e_obj = new employees($data['id']);
    $e_obj->id = $data['id'];
    $e_obj->title = $data['title'];
    $e_obj->first_name = $data['first_name'];
    $e_obj->last_name = $data['last_name'];
    $e_obj->date_of_join = $data['date_of_join'];
    $e_obj->home_address = $data['home_address'];
    $e_obj->work_address = $data['work_address'];
    $e_obj->contract_id = $date['contract_id'];
    $e_obj->default_center_id = $data['default_center_id'];
    $e_obj->company_name = $data['company_name'];
    $e_obj->contract_end_date = $data['contract_end_date'];
    $e_obj->work_function = $data['work_function'];
    $e_obj->rate_per_hour = $data['rate_per_hour'];
    $e_obj->mobile_number = $data['mobile_number'];
    $e_obj->office_number = $data['office_number'];
    $e_obj->name = $data['name'];
    $e_obj->address = $data['address'];
    $e_obj->contact_no = $data['contact_no'];
    $e_obj->email = $data['email'];  
    $e_obj->path = $data['path'];
    $e_obj->country = $data['country'];
    $e_obj->area_of_interest = $data['area_of_interest'];
    $e_obj->status = $data['status'];
    $e_obj->designation_id = $data['designation_id'];
    $e_obj->business_customer_id = $data['business_customer_id'];
    if (is_string($data['center_id'])) {
        $data['center_id'] = array($data['center_id']);
    }
    $e_obj->center_id = $data['center_id'];

    // user obj
//    if ($_SESSION['DESIGNATION'] == constants::$admin) {
        $u_obj = new user($data['user_id']);        
//    } else {
//        $u_obj = new user();
//    }
    $user_id = $data['user_id'];
    $u_obj->name = $data['user'];
    $u_obj->password = $data['pwd'];
    $option = $data['option'];
} else {
    $e_obj = new employees($_POST['id']);
    $e_obj->id = $_POST['id'];
    $e_obj->title = $_POST['title'];
    $e_obj->first_name = $_POST['first_name'];
    $e_obj->last_name = $_POST['last_name'];
    $e_obj->date_of_join = $_POST['date_of_join'];
    $e_obj->home_address = $_POST['home_address'];
    $e_obj->work_address = $_POST['work_address'];
    $e_obj->work_function = $_POST['work_function'];
    $e_obj->contract_id = $_POST['contract_id'];
    $e_obj->default_center_id = $_POST['default_center_id'];
    $e_obj->company_name = $_POST['company_name'];
    $e_obj->contract_end_date = $_POST['contract_end_date'];
    $e_obj->rate_per_hour = $_POST['rate_per_hour'];
    $e_obj->mobile_number = $_POST['mobile_number'];
    $e_obj->office_number = $_POST['office_number'];
    $e_obj->name = $_POST['name'];
    $e_obj->address = $_POST['address'];
    $e_obj->contact_no = $_POST['contact_no'];
    $e_obj->email = $_POST['email'];
    $e_obj->path = $_POST['path'];
    $e_obj->country = $_POST['country'];
    $e_obj->area_of_interest = $_POST['area_of_interest'];
    $e_obj->status = $_POST['status'];
    $e_obj->designation_id = $_POST['designation_id'];
    $e_obj->business_customer_id = $_POST['business_customer_id'];
    if (is_string($_POST['center_id'])) {
        $_POST['center_id'] = array($data['center_id']);
    }
    $e_obj->center_id = $_POST['center_id'];
    // user obj
//    if ($_SESSION['DESIGNATION'] == constants::$admin) {
        $u_obj = new user($_POST['user_id']);
//    } else {
//        $u_obj = new user();
//    }
    $user_id = $_POST['user_id'];   
    $u_obj->name = $_POST['user'];
    $u_obj->password = $_POST['pwd'];    
    $option = $_POST['option'];
}
//$e_obj->centers_id = $_POST['centers_id'];
// upload file if uploded
if (!empty($_FILES)) {
    $test = explode(".", $_FILES['file']['name']);
    $extension = end($test);
    $newName = time() . rand(100, 999) . "." . $extension;
    $location = "../employee_profile_picture/" . $newName;
    $file_name = $_FILES['file']['name'];
    if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
        $e_obj->path = $location;
    }
}
//print ($e_obj->path);

//print($option);
switch ($option) {
    case 'ADD':
        $e_id = $e_obj->add();
        $u_obj->employees_id = $e_id;
        $result = $u_obj->add();
        if ($result) {
            echo json_encode(array('msg' => $result));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'EDIT':
        $result = $e_obj->edit();
        if ($result) {            
                if($user_id != '') {
                    $result = $u_obj->edit();
                } else {
                    $u_obj->employees_id = $e_obj->id;
                    $result = $u_obj->add();
                }            
            echo json_encode(array('msg' => $result));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'DELETE':
        $result = $e_obj->delete();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'CHANGESTATUS':
        if ($e_obj->status == constants::$ACTIVE) {
            $result = $e_obj->Activate();
        } else if ($e_obj->status == constants::$DISABALED) {
            $result = $e_obj->deActivate();
        }
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    default :
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}
?>