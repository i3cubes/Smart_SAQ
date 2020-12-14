<?php
error_reporting(E_ALL);
error_reporting(1);

include_once '../class/cls_payment.php';
include_once '../class/cls_user.php';
//include '../mpdf/mpdf.php';
include_once '../class/cls_mail.php';

$emp_id=$_REQUEST['EMPID'];

switch ($_POST['option']) {
    case 'ADD': 
        $pay=new payment();
        $pay->date_start=$_POST['start_date'];
        $pay->date_end=$_POST['end_date'];
        $pay->total_billing=$_POST['total_bill'];
        $pay->adjustment=$_POST['adjustment'];
        $pay->rate=$_POST['rate'];
        //CALC
        $TE=$_POST['total_bill']+$_POST['adjustment'];
        $FF=round($TE*$_POST['rate'],2);
        $GST=round($FF*0.1,2);
        $TSF=$FF+$GST;
        $Payable=$TE-$TSF;
        $pay->facility_fee=$FF;
        
        $pay->payable=$Payable;
        $pay->gst= $GST;
        $pay->employee_id=$_POST['doctor_id'];
        $pay->center_id=$_POST['center_id'];
        $pay->note=$_POST['note'];
        
        $pay_id = $pay->save();
        if($pay_id) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'EDIT':
        $pay=new payment($_POST['pid']);
        $pay->date_start=$_POST['start_date'];
        $pay->date_end=$_POST['end_date'];
        $pay->total_billing=$_POST['total_bill'];
        $pay->adjustment=$_POST['adjustment'];
        $pay->rate=$_POST['rate'];
        $pay->facility_fee=$_POST['facility_fee'];
        
        $pay->payable=round(($pay->total_billing-$pay->adjustment-$pay->facility_fee)*($pay->rate),2);
        $pay->gst= round((($pay->payable)*0.01),2);
        $pay->center_id=$_POST['center_id'];
        $pay->note=$_POST['note'];
        $pay->paid_date=$_POST['paid_date'];
        
        $pay_id = $pay->edit();
        if($pay_id) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'DELETE':
        $pay=new payment($_POST['pid']);
        $result = $pay->delete();
        if($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'PAID':
        $pay=new payment($_POST['pid']);
        if($_POST['paid_date']!=""){
            $pay->paid_date=$_POST['paid_date'];
        }
        else{
            $pay->paid_date=date("d/m/Y");
        }
        $result = $pay->setPaid();
        if($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'CANCEL':
        $pay=new payment($_POST['pid']);
        $result = $pay->cancel();
        if($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'MAIL_SLIP':
        $pay=new payment($_POST['pid']);
        $pay->getDetails();
        $result = $pay->sendMailPaySlip($emp_id);
        if($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'MAIL_D_SUMMARY':
        $pay=new payment();
        $result = $pay->sendMailDoctorSummary($_POST['s_doctor_id'], $_POST['s_from'], $_POST['s_to'],$_POST['x']);
        if($result) {
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