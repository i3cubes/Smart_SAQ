<?php

class constants {

    // status 
    public static $active = 1;
    public static $inactive = 0;
    //Kumara
    public static $DELETED = -1;
    public static $DISABALED = 0;
    public static $ACTIVE = 1;
    public static $CANCELLED = 2;
    // designations
    public static $admin = 1;
    public static $business_customer = 2;
    public static $employee = 3;
    public static $nurse = 4;
    public static $Receptionest = 5;
    public static $doctor = 6;
    public static $other = 7;
    
    public static $PAID=2;
    public static $UNPAID=1;
    
    // site status 
    public static $onAir = 1;
    public static $hold = 2;
    public static $removed =3;
    public static $workInProgress = 4;
    
    // site status array
    public static $siteStatus = array('On air', 'Hold', 'Removed', 'Work in progress');


    // sms status
    public static $sent = 1;
    public static $notsent = 0;
    public static $sendFail = 2;

    public static function getPaymentStatus($id){
        $ary_sts=array("Deleted","Unpaid","Paid");
        return $ary_sts[$id];
    }
    // format date mysql format
    public static function convertDate($date) {
        if ($date != '') {
            $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));
        } else {
            $date = '0000-00-00';
        }
        return $date;
    }

    // format date ausi format
    public static function convertBack($date) {
        if ($date != '' && $date != 'NULL' && $date != '0000-00-00') {
            $date = date('d/m/Y', strtotime($date));
        } else {
            $date = '';
        }
        return $date;
    }

    // format time
    static function formatTime($from, $to) {
        $time_str = "";
        if (is_null($from)) {
            if (is_null($to)) {
                $time_str = "OFF";
            } else {
                $time_str = "X -$to";
            }
        } else {
            if (is_null($to)) {
                $time_str = "$from - X";
            } else {
                $time_str = "$from - $to";
            }
        }
        return $time_str;
    }
    
    // remove nulls
    static function removeNull($str) {
        if($str == 'NULL') {            
            $str = '';
        }
        return $str;
    }
         

}

?>