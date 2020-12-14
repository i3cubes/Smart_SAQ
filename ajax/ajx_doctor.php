<?php

include_once '../class/cls_doctor.php';
include_once '../class/cls_employee_center.php';

$doc=new doctor($_POST['id']);
$doc->category_id=$_POST['category_id'];
$doc->title=$_POST['title'];
$doc->first_name = $_POST['first_name'];
$doc->last_name = $_POST['last_name'];
$doc->date_of_join = $_POST['date_of_join'];
$doc->home_address = $_POST['home_address'];
$doc->work_address = $_POST['work_address'];
$doc->work_function = $_POST['work_function'];
$doc->contract_id = $_POST['contract_id'];
$doc->company_name = $_POST['company_name'];
$doc->abn = $_POST['abn'];
$doc->contract_end_date = $_POST['contract_end_date'];
$doc->mobile_number = $_POST['mobile_number'];
$doc->office_number = $_POST['office_number'];
$doc->address = $_POST['address'];
$doc->contact_no = $_POST['contact_no'];
$doc->email = $_POST['email'];
$doc->status = $_POST['status'];
$doc->qualifications = $_POST['qualification'];
$doc->business_customer_id = $_POST['business_customer_id'];
$doc->health_identifier = $_POST['hi'];
$doc->default_center_id = $_POST['default_center_id'];
$doc->presctiber_no = $_POST['prescriber_no'];
$doc->registration_no = $_POST['registration_no'];
$doc->rate = $_POST['rate'];

//CENTERS
$ary_center_ids=$_POST['center_id'];
$ary_pn=$_POST['pn'];
if(is_array($ary_center_ids)){
    $doc->centers=array();
    $i=0;
    foreach ($ary_center_ids as $c_id){
        if($c_id!=""){
            $emp_center=new employee_center();
            $emp_center->cenetr_id=$c_id;
            $emp_center->provider_no=$ary_pn[$i];
            array_push($doc->centers, $emp_center);
        }
        $i++;
    }
}

$option = $_POST['option'];
//var_dump($doc);
//print($option);
switch ($option) {
    case 'ADD':
        $doc_id = $doc->addDoctor();
        if ($doc->id) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'EDIT':
        $result = $doc->editDoctor();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'DELETE':
        $result = $doc->delete();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'DEACTIVATE':
        $result = $doc->deActivate();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'ACTIVATE':
        $result = $doc->Activate();
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