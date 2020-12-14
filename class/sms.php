<?php

include_once 'database.php';
//include_once 'cls_fault_ticket.php';
include_once 'ESMSWS.php';

//require_once("../lib/config.php");

class sms {

    public function sendSMS($ary_to, $msg) {
        $ary_result = array();
        foreach ($ary_to as $to) {
            //$res=$this->send_DLG($to, $msg);
            //$res=$this->send_Mobitel($to, $msg);
            $res = $this->addSMStoQue($to, $msg);
            array_push($ary_result, $res);
        }
        return $ary_result;
    }

    public function addSMStoQue($to, $msg) {
        //$to_str=  implode(",", $to);
        $str = "INSERT INTO sms_que (mobile,date_time,message,status) VALUES('$to',NOW(),'$msg','0');";
        $res = dbQuery($str);
        return $res;
    }

    public function updateSMSQueStatus($id, $status) {
        $str = "UPDATE sms_que SET status='$status' WHERE id='$id';";
        $res = dbQuery($str);
        return $res;
    }

    public function updateRetryCount($id) {
        $str = "UPDATE sms_que SET retry_count=retry_count+1 WHERE id='$id';";
        $res = dbQuery($str);
        return $res;
    }

    public function send_Mobitel($to, $msg) {
        if ($to != '') {
            $to_ary = array();
            if (strlen($to) > 10) {
                $ary_num = explode('[,; ]', $to);
                foreach ($ary_num as $num) {
                    $to_new = ltrim($num, '0');
                    $to = '94' . $to_new;
                    array_push($to_ary, $to_new);
                }
            } else {
                $to_new = ltrim($to, '0');
                $to = '94' . $to_new;
                array_push($to_ary, $to_new);
            }
            $session = createSession('', 'esmsusr_168l', '2pr8jmh', '');
            $res = sendMessages($session, 'Fentons', $msg, $to_ary);
            return $res;
        } else {
            return false;
        }
    }

    public function send_SMS($to, $msg) { //Energynets
        if ($to != '') {
            //print "TO:".$to;
            if (strlen($to) > 10) {
                $ary_num = explode('[,; ]', $to);                
                $url = "http://smsnow.com.au/api/index";
                    // Setup request to send json via POST
                    $data = array(
                        'user_name' => 'api_user',
                        'key' => 'gVuWUDHZXMFUafa',
                        'message' => $msg,
                        'numbers' => $ary_num
                    );
                    $payload = json_encode($data);
                    //print $url;
                    $ch = curl_init($url);
                    // Attach encoded JSON string to the POST fields
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                    // Set the content type to application/json
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    //$to_post="destination=".$to."&message =".$msg."&q=14763686082015";
                    //curl_setopt($ch, CURLOPT_POSTFIELDS,$to_post);		
                    $res = json_decode(curl_exec($ch), true);

                    curl_close($ch);
            } else {
//                $message = str_replace(" ", "%20", $msg);
                $url = "http://smsnow.com.au/api/index";
                // Setup request to send json via POST
                $data = array(
                    'user_name' => 'api_user',
                    'key' => 'gVuWUDHZXMFUafa',
                    'message' => $msg,
                    'numbers' => [
                        $to
                    ]
                );
                $payload = json_encode($data);
                //print $url;
                $ch = curl_init($url);
                // Attach encoded JSON string to the POST fields
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                // Set the content type to application/json
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                //$to_post="destination=".$to."&message =".$msg."&q=14763686082015";
                //curl_setopt($ch, CURLOPT_POSTFIELDS,$to_post);		
                $res = json_decode(curl_exec($ch), true);

                curl_close($ch);
            }

            $log = "DLG::" . date('Y-m-d H:i:s') . " : TO-" . $to . " || MSG:" . $res['status']['msg'] . " || RES:" . $res['status']['msg'] . " ERR:" . curl_error($ch);
            $log_file = "../logs/sms_log_" . date('Ym') . ".txt";
            if ($file = fopen($log_file, "a+")) {
                fputs($file, "$log \n");
                fclose($file);
            } else {
                
            }

            if ($res['result'] == 1) {
                return true;
            } else {
                return $res['status']['msg'];
            }
        } else {
            return false;
        }
    }

}

?>