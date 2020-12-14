<?php

include_once 'database.php';
include_once 'constants.php';
include_once 'cls_payment.php';

class payment_manager {
    
    public function search($from,$to,$emp_id,$center_id,$status="") {
        $return_array=array();
        $ary_sql=array();
        if($from!=""){
            if($to==""){
                $to=date("Y-m-d");
            }
            array_push($ary_sql, "t1.paid_date>='$from'");
            array_push($ary_sql, "t1.paid_date<='$to'");
        }
        if($emp_id!=""){
            array_push($ary_sql, "t1.employees_id='$emp_id'");
        }
        if($center_id!=""){
            array_push($ary_sql, "t1.centers_id='$center_id'");
        }
        if($status!=""){
            array_push($ary_sql, "t1.status='$status'");
        }
        if(count($ary_sql)>0){
            array_push($ary_sql, "t1.status<>'0'");
            $where= implode(" AND ", $ary_sql)." ORDER BY t1.id DESC";
        }
        else{
            $where=" t1.status<>".constants::$DELETED." ORDER BY t1.id DESC LIMIT 50";
        }
        $str="SELECT t1.*,t2.title,t2.first_name,t2.last_name,t3.name as CenterName,t4.abn FROM payments as t1 left join employees as t2 on t1.employees_id=t2.id"
                . " left join centers as t3 on t1.centers_id=t3.id left join doctor_data as t4 on t4.employees_id=t2.id WHERE ".$where;
        //print $str;
        $result = dbQuery($str);
        while ($row = dbFetchAssoc($result)) {
            $p=new payment($row['id']);
            $p->date_start=$row['start_date'];
            $p->date_end=$row['end_date'];
            $p->paid_date=$row['paid_date'];
            $p->total_billing=$row['total_amount'];
            $p->adjustment=$row['adjustment'];
            $p->rate=$row['rate'];
            $p->facility_fee=$row['facility_fee'];
            $p->gst=$row['GST'];
            $p->payable=$row['payable'];
            $p->employee=new employees($row['employees_id']);
            $p->employee_name=$row['title']." ".$row['first_name']." ".$row['last_name'];
            $p->employee_abn=$row['abn'];
            $p->center_name=$row['CenterName'];
            $p->center_contact_no=$row['CenterContactNo'];
            $p->net_billing=$row['total_amount']+$row['adjustment'];
            $p->status=$row['status'];
            $p->note=$row['note'];
            array_push($return_array,$p);
        }
        return $return_array;
    }

}

?>