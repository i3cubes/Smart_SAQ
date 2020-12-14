<?php
session_start();
include_once 'database.php';
include_once 'constants.php';
include_once 'cls_date.php';
include_once 'cls_employees.php';
include_once '../mpdf/mpdf.php';

class payment {

    public $id, $date_start, $date_end, $rate, $adjustment, $total_billing, $net_billing,$facility_fee,$paid_date;
    public $gst,$payable,$center_id,$center_name,$center_contact_no,$note,$status;
    public $employee_id,$employee_name,$employee_abn,$employee;
    public $table_name = 'payments';

    public function __construct($id = '') {
        $this->id = $id;
    }
    public function getDetails() {
        $string = "SELECT t1.*,t2.first_name,t2.last_name,t3.name as center_name FROM payments as t1 left join employees as t2 on t1.employees_id=t2.id "
                . "left join centers as t3 on t1.centers_id=t3.id WHERE t1.id = '$this->id';";
        //print$string;
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->date_end = $row['end_date'];
        $this->date_start = $row['start_date'];
        $this->paid_date = $row['paid_date'];
        $this->total_billing = $row['total_amount'];
        $this->adjustment = $row['adjustment'];
        $this->rate = $row['rate'];
        $this->facility_fee = $row['facility_fee'];
        $this->gst = $row['GST'];
        $this->payable=$row['payable'];
        $this->employee_id = $row['employees_id'];
        $this->employee_name =$row['title']." ". $row['first_name'] . ' ' . $row['last_name'];
        $this->center_id = $row['centers_id'];
        $this->center_name = $row['center_name'];      
        $this->note=$row['note'];
    }

    public function save() {
        $d=new ngs_date();
        $str = "INSERT INTO `$this->table_name` ("
                . "`start_date`,"
                . "`end_date`,"
                . "`total_amount`,"
                . "`adjustment`,"
                . "`rate`,"
                . "`facility_fee`,"
                . "`GST`,"
                . "`payable`,"
                . "`employees_id`,"
                . "`centers_id`,"
                . "`note`,"
                . "`status`"
                . ") VALUES ("
                . getStringFormatted($d->transform_date($this->date_start)).","
                . getStringFormatted($d->transform_date($this->date_end)).","
                . getStringFormatted($this->total_billing).","
                . getStringFormatted($this->adjustment).","
                . getStringFormatted($this->rate).","
                . getStringFormatted($this->facility_fee).","
                . getStringFormatted($this->gst).","
                . getStringFormatted($this->payable).","
                . getStringFormatted($this->employee_id).","
                . getStringFormatted($this->center_id).","
                . getStringFormatted($this->note)
                . ",'".constants::$active."');";       
        //print $str;
        $result = dbQuery($str);
        if ($result) {
            return dbInsertId();
        } else {
            return false;
        }
    }

    public function edit() {
        $d=new ngs_date();
        $str = "UPDATE `$this->table_name` SET"
                . "`start_date`=".getStringFormatted($d->transform_date($this->date_start)).","
                . "`end_date`=". getStringFormatted($d->transform_date($this->date_end)).","
                . "`paid_date`=". getStringFormatted($d->transform_date($this->paid_date)).","
                . "`total_amount`=". getStringFormatted($this->total_billing).","
                . "`adjustment`=". getStringFormatted($this->adjustment).","
                . "`rate`=". getStringFormatted($this->rate).","
                . "`facility_fee`=". getStringFormatted($this->facility_fee).","
                . "`GST`=". getStringFormatted($this->gst).","
                . "`payable`=". getStringFormatted($this->payable).","
                . "`centers_id`=". getStringFormatted($this->center_id).","
                . "`note`=". getStringFormatted($this->note)
                . " WHERE `id`='$this->id';";       
        //print $str;
        $result = dbQuery($str);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function delete() {
        $string = "UPDATE `$this->table_name` SET `status` = " . constants::$DELETED . " WHERE `id` = $this->id;";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function cancel() {
        $string = "UPDATE `$this->table_name` SET `status` = " . constants::$CANCELLED . " WHERE `id` = $this->id;";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function setPaid() {
        $d=new ngs_date();
        $string = "UPDATE `$this->table_name` SET `status` = " . constants::$PAID.",paid_date=". getStringFormatted($d->transform_date($this->paid_date)) . " WHERE `id` = $this->id;";
        //sprint $string;
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    function formatNumber($n){
        $n_f=number_format($n,2,'.',',');
        return $n_f;
    }
    function sendMailPaySlip($emp_id){
        //print 'xxxx'.$emp_id;
        $mpdf=new mPDF('c','A4','','',15,15,15,15,10,10);
        //$mpdf->debug = true;
        //$mpdf->SetWatermarkText('');
        //$mpdf->watermark_font = 'DejaVuSansCondensed';
        //$mpdf->showWatermarkText = true;
        //$mpdf->SetHTMLHeader($header);
        $mpdf->setFooter("Print date:$date                                                              *** Private & Confidential ***                                                                          {PAGENO} of {nbpg}");
        //$mpdf->WriteHTML('<p>Hallo World</p>');
        
        //$url="http://127.0.0.1/c2mMedicalCenter/doctor_pay/invoice_body";
        if(SERVER_TYPE=="TEST"){
            $url="http://phpstack-263707-1360365.cloudwaysapps.com/doctor_pay/invoice_body";
        }
        else if(SERVER_TYPE=="LIVE"){
            $url="https://practicemanagment.thoshimedicals.com.au/doctor_pay/invoice_body";
        }
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $to_post="pid=".$this->id."&EMPID=".$emp_id;
        curl_setopt($ch, CURLOPT_POSTFIELDS,$to_post);		
        $body= curl_exec ($ch);
        curl_close ($ch);

        //while (curl_getinfo($ch, CURLINFO_HTTP_CODE)!=200){
        //    usleep(1000);
        //}
        //print $body;
        $file_name= $this->employee_name."_".$this->date_start."-".$this->date_end.".pdf";
        //print $file_name;
        $mpdf->WriteHTML($body);
        //ob_clean(); 
        $mpdf->Output($file_name,'F');
        //$mpdf->Output("/var/www/html/autobavaria/files/estimate.pdf",'F');
        
        $mail=new ngs_mail();
        $emp=new employees($this->employee_id);
        $emp->getDetails();
        //Email
        $ary_to= array($emp->email);
        $ary_cc=array("caryl72@gmail.com","harshani@tmedicals.com.au","neil@tmedicals.com.au");
        $mail->subject=$emp->title." ".$emp->first_name." Pay Advice";
        $mail->address=$ary_to;  //----------------------------------UNCOMM WHEN GO LIVE
        //$mail->names=array('Kumara','Suresh');
        //$mail->atachment_url='/var/log/utrack/speed_report.csv';
        //$mail->atachment_url='estimate.pdf';
        $mail->attachment_url=$file_name;       
        //GET MAIL BODY 
        
        //$url="http://127.0.0.1/c2mMedicalCenter/doctor_pay/invoice_mail_body"; // kumara 
        if(SERVER_TYPE=="TEST"){
        $url="http://phpstack-263707-1360365.cloudwaysapps.com/doctor_pay/invoice_mail_body"; // kumara 
        }
        else if(SERVER_TYPE=="LIVE"){
            $url="https://practicemanagment.thoshimedicals.com.au/doctor_pay/invoice_mail_body";
        }
//        $url="http://127.0.0.1/c2m_MedicalCenter/doctor_pay/invoice_mail_body"; // maleesh
        $mail->flag = 'm';
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $to_post="NAME=".$emp->title." ".$emp->first_name." ".$emp->last_name."&FROM=".$this->date_start."&TO=".$this->date_end;
        curl_setopt($ch, CURLOPT_POSTFIELDS,$to_post);		
        $body= curl_exec ($ch);
        curl_close ($ch);
        //print $body;
        $mail->CC_address=$ary_cc;
        $mail->body=$body;
        
        if(is_file($mail->attachment_url)){
            //Send Mail
            $mail_res=$mail->sendmail();
            if($mail_res){
                //print "SENT";
                $res=true;
            }
            else{
                $res=false;
                //print "NT SENT";
            }
        }
        else{
            //No attachement
            $msg="No Attachement";
            $res=false;
        }
        unlink($file_name);
        return $res;
    }
    function sendMailDoctorSummary($doc_id,$from,$to,$x){
        //print $doc_id.'='.$from."=".$to;
        $mpdf=new mPDF('c','A4-L','','',15,15,15,15,10,10);
        //$mpdf->debug = true;
        //$mpdf->SetWatermarkText('');
        //$mpdf->watermark_font = 'DejaVuSansCondensed';
        //$mpdf->showWatermarkText = true;
        //$mpdf->SetHTMLHeader($header);
        $mpdf->setFooter("Print date:$date                                                                                                      *** Private & Confidential ***                                                                                                                                              {PAGENO} of {nbpg}");
        //$mpdf->WriteHTML('<p>Hallo World</p>');

        if(SERVER_TYPE=="TEST"){
            $url="http://phpstack-263707-1360365.cloudwaysapps.com/doctor_pay/doctor_report_print_body";
        }
        else if(SERVER_TYPE=="LIVE"){
            $url="https://practicemanagment.thoshimedicals.com.au/doctor_pay/doctor_report_print_body";
        }
        //$url="http://127.0.0.1/c2mMedicalCenter/doctor_pay/invoice_body";
        
        
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $to_post="doc_id=".$doc_id."&s_from=".$from."&s_to=".$to."&bcid=".$x;
        curl_setopt($ch, CURLOPT_POSTFIELDS,$to_post);		
        $body= curl_exec ($ch);
        curl_close ($ch);

        //while (curl_getinfo($ch, CURLINFO_HTTP_CODE)!=200){
        //    usleep(1000);
        //}
        //print $body;
        $emp=new employees($doc_id);
        $emp->getDetails();
        
        $file_name= $emp->first_name." ".$emp->last_name."_".$from."-".$to.".pdf";
        //print $file_name;
        $mpdf->WriteHTML($body);
        //ob_clean(); 
        $mpdf->Output($file_name,'F');
        //$mpdf->Output("/var/www/html/autobavaria/files/estimate.pdf",'F');
        
        $mail=new ngs_mail();
        
        //Email
        $ary_to= array($emp->email);
        $ary_cc=array("kumarahhc@gmail.com");
        $mail->subject="Pay Summary";
        $mail->address=$ary_to;  //----------------------------------UNCOMM WHEN GO LIVE
        //$mail->names=array('Kumara','Suresh');
        //$mail->atachment_url='/var/log/utrack/speed_report.csv';
        //$mail->atachment_url='estimate.pdf';
        $mail->attachment_url=$file_name;       
        //GET MAIL BODY 
        
        if(SERVER_TYPE=="TEST"){
            $url="http://phpstack-263707-1360365.cloudwaysapps.com/doctor_pay/doctor_report_mail_body"; // kumara 
        }
        else if(SERVER_TYPE=="LIVE"){
            $url="https://practicemanagment.thoshimedicals.com.au/doctor_pay/doctor_report_mail_body"; // kumara 
        }
        //$url="http://127.0.0.1/c2mMedicalCenter/doctor_pay/invoice_mail_body"; // kumara 
        
//        $url="http://127.0.0.1/c2m_MedicalCenter/doctor_pay/invoice_mail_body"; // maleesh
        $mail->flag = 'm';
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $to_post="NAME=".$emp->first_name." ".$emp->last_name."&FROM=".$from."&TO=".$to;
        curl_setopt($ch, CURLOPT_POSTFIELDS,$to_post);		
        $body= curl_exec ($ch);
        curl_close ($ch);
        //print $body;
        $mail->CC_address=$ary_cc;
        $mail->body=$body;
        
        if(is_file($mail->attachment_url)){
            //Send Mail
            $mail_res=$mail->sendmail();
            if($mail_res){
                //print "SENT";
                $res=true;
            }
            else{
                $res=false;
               // print "NT SENT";
            }
        }
        else{
            //No attachement
            $msg="No Attachement";
            $res=false;
        }
        unlink($file_name);
        return $res;
    }
}

?>