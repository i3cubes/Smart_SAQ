<?php

include_once 'database.php';
include_once 'sms.php';

ini_set('display_errors', 1);

$sms=new sms();

$cmd = "SELECT * FROM sms_que WHERE  status = 0 order by id ASC limit 100";
    $arr = array();
    $result = dbQuery($cmd);
    if (dbNumRows($result) > 0) {
        while ($row=  dbFetchAssoc($result)){
            $res=$sms->send_SMS($row['mobile'], $row['message']);
            if($res){
                //sent
                $sms->updateSMSQueStatus($row['id'],'1');
                $log_str="ID:".$row['id']." || To:".$row['mobile']." || Result: SENT";
            }
            else{
                //failed
                $log_str="ID:".$row['id']." || To:".$row['mobile']." || Result: NOT SENT Error: $res";
                if($row['retry_count']>10){
                    //$sms->updateSMSQueStatus($row['id'],'0');
                    $sms->updateRetryCount($row['id']);
                }
                else{
                    $sms->updateSMSQueStatus($row['id'],'2');
                }
            }
            print $log_str."<br>";
            $log_file="../logs/sms_log.txt";
            $str=date("Y-m-d H:i:s")." || ".$log_str;
            if ($file=fopen($log_file, "a+")) {
                fputs($file,"$str \n");
                fclose($file);
            }
        }
    }
    else{
        $log_str="Empty DB result";
    }
    $log_file="../logs/sms_log.txt";
    $str=date("Y-m-d H:i:s")." || ".$log_str;
    if ($file=fopen($log_file, "a+")) {
        fputs($file,"$str \n");
        fclose($file);
    }
ini_set('display_errors', 0);  
