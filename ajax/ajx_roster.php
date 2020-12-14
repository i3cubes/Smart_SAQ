<?php

include_once '../class/cls_roster.php';
include_once '../class/cls_roster_manager.php';
include_once '../class/cls_mail.php';
include_once '../class/cls_employees.php';
include_once '../class/cls_centers.php';
include_once '../class/mail.php';
include_once '../class/sms.php';

include_once '../class/cls_date.php';

$data = json_decode(file_get_contents("php://input"), true);
//print_r($data);
//$data_array = $data['data'];

switch ($data['option']) {
    case 'SAVE':
        // chunk main array to get one column in shedule
//        $column_array = array_chunk($data['data']['shedule'], 11);
        foreach ($data['data'] as $column) {
//            if ($column[5] != "") {
//                $roster_obj = new roster($column[5]);
//
//                $roster_obj->time_in = $column[0];
//                $roster_obj->time_out = $column[1];
//                $roster_obj->centers_id = $column[2];
//                $roster_obj->date = $column[3];
//                $roster_obj->employees_id = $column[4];
//
//                $result = $roster_obj->edit();
//            } else {
            $roster_obj = new roster('');

            // delete same date roster
            $roster_obj->delete($column[4], $column[3]);

            $roster_obj->time_in = date('H:i', strtotime($column[0]));
            $roster_obj->time_out = date('H:i', strtotime($column[1]));
            $roster_obj->centers_id = $column[2];
            $roster_obj->date = $column[3];
            $roster_obj->employees_id = $column[4];

            $result = $roster_obj->add();
//            }
        }
        echo json_encode(array('msg' => 1));
        break;
    case 'SAVEAPPROVEROSTER':
           foreach ($data['data'] as $column) {
            if ($column[4] != "") {
                $roster_obj = new roster($column[4]);

                $roster_obj->approved_start_time = (($column[0]!='') ? date('H:i', strtotime($column[0])):'');
                $roster_obj->approved_start_time = (($column[1]!='') ? date('H:i', strtotime($column[1])) :'');
//                $roster_obj->centers_id = $column[2];
                $roster_obj->date = $column[2];
                $roster_obj->employees_id = $column[3];

                $result = $roster_obj->edit();
            }            
        }
        echo json_encode(array('msg' => 1));
        break;
    case 'SAVESHEDULE':
        if (!is_array($data['data']['week'])) {
            $data['data']['week'] = [$data['data']['week']];
        }
        foreach ($data['data']['week'] as $date) {
//            if ($data['data']['roster_id'] != "") {
//                $roster_obj = new roster($data['data']['roster_id']);
//
//                $roster_obj->time_in = $data['data']['timeIn'];
//                $roster_obj->time_out = $data['data']['timeOut'];
//                $roster_obj->centers_id = $data['data']['center_id'];
//                $roster_obj->date = $date;
//                $roster_obj->employees_id = $data['data']['employees_id'];
//
//                $result = $roster_obj->edit();
//            } else {
//                $roster_obj = new roster('');
//                $roster_obj->view($data['data']['employees_id'], $date);
//                if ($roster_obj->id != '') {
//                    $roster_obj = new roster($roster_obj->id);
//
//                    $roster_obj->time_in = $data['data']['timeIn'];
//                    $roster_obj->time_out = $data['data']['timeOut'];
//                    $roster_obj->centers_id = $data['data']['center_id'];
//                    $roster_obj->date = $date;
//                    $roster_obj->employees_id = $data['data']['employees_id'];
//
//                    $result = $roster_obj->edit();
//                } else {
            $roster_obj = new roster('');

            // delete same date roster
            $roster_obj->delete($data['data']['employees_id'], $date);

            $roster_obj->time_in = date('H:i', strtotime($data['data']['timeIn']));
            $roster_obj->time_out = date('H:i', strtotime($data['data']['timeOut']));
            $roster_obj->centers_id = $data['data']['center_id'];
            $roster_obj->date = $date;
            $roster_obj->employees_id = $data['data']['employees_id'];

            $result = $roster_obj->add();
//                }
//            }
        }
        echo json_encode(array('msg' => 1));
        break;
    case 'SAVEAPPROVE':
        foreach ($data['data'] as $column) {
            if ($column[4] != "") {
                $roster_obj = new roster($column[4]);

                $roster_obj->approved_start_time = (($column[0]!='') ? date('H:i', strtotime($column[0])):'');
                $roster_obj->approved_end_time = (($column[1]!='') ? date('H:i', strtotime($column[1])):'');
//                $roster_obj->centers_id = $column[2];
                $roster_obj->date = $column[2];
                $roster_obj->employees_id = $column[3];
                $roster_obj->approve = 'YES';

                $result = $roster_obj->edit();
            } else {
                $roster_obj = new roster('');

                // delete same date roster
                if ($column[3] != '' && $column[2] != '') {
                    $roster_obj->delete($column[3], $column[2]);
                }
                $roster_obj->approved_start_time = (($column[0]!='') ? date('H:i', strtotime($column[0])):'');
                $roster_obj->approved_end_time = (($column[1]!='') ? date('H:i', strtotime($column[1])):'');
//                $roster_obj->centers_id = $column[2];
                $roster_obj->date = $column[2];
                $roster_obj->employees_id = $column[3];
                $roster_obj->approve = 'YES';

                $result = $roster_obj->add();
            }
        }
        echo json_encode(array('msg' => 1));
        break;
    case 'SAVEALL':
        foreach ($data['data'] as $date) {
            $column_array = array_chunk($date, 6);
            foreach ($column_array as $column) {
//                if ($column[5] != "") {
//                    $roster_obj = new roster($column[5]);
//
//                    $roster_obj->time_in = $column[0];
//                    $roster_obj->time_out = $column[1];
//                    $roster_obj->centers_id = $column[2];
//                    $roster_obj->date = $column[3];
//                    $roster_obj->employees_id = $column[4];
//
//                    $result = $roster_obj->edit();
//                } else {
                $roster_obj = new roster('');

                // delete same date roster
                $roster_obj->delete($column[4], $column[3]);

                $roster_obj->time_in = date('H:i', strtotime($column[0]));
                $roster_obj->time_out = date('H:i', strtotime($column[1]));
                $roster_obj->centers_id = $column[2];
                $roster_obj->date = $column[3];
                $roster_obj->employees_id = $column[4];

                $result = $roster_obj->add();
//                }
            }
        }
        echo json_encode(array('msg' => 1));
        break;
    case 'SAVEALLAPPROVE':
        foreach ($data['data'] as $date) {
            $column_array = array_chunk($date, 5);
            foreach ($column_array as $column) {
                if ($column[4] != "") {
                    $roster_obj = new roster($column[4]);

                    $roster_obj->approved_start_time = ($column[0]!=''?date('H:i', strtotime($column[0])):'');
                    $roster_obj->approved_end_time = ($column[1]!=''?date('H:i', strtotime($column[1])):'');
//                    $roster_obj->centers_id = $column[2];
                    $roster_obj->date = $column[2];
                    $roster_obj->employees_id = $column[3];
//                    $roster_obj->approve = 'YES';

                    $result = $roster_obj->edit();
                }
            }
        }
        echo json_encode(array('msg' => 1));
        break;
    case 'APPROVEALL':
        foreach ($data['data'] as $date) {
            $column_array = array_chunk($date, 5);
            foreach ($column_array as $column) {
                if ($column[4] != "") {
                    $roster_obj = new roster($column[4]);
                    if($column[0] != '' && $column[1] != '') {
                    $roster_obj->approved_start_time = ($column[0]!=''?date('H:i', strtotime($column[0])):'');
                    $roster_obj->approved_end_time = ($column[1]!=''?date('H:i', strtotime($column[1])):'');
//                    $roster_obj->centers_id = $column[2];
                    $roster_obj->date = $column[2];
                    $roster_obj->employees_id = $column[3];
                    $roster_obj->approve = 'YES';
                    
                    $result = $roster_obj->edit();
                    }
                }
            }
        }
        echo json_encode(array('msg' => 1));
        break;
    case 'MAIL':
        $week_dates = array();
        $week_shedule = array();
        $active_date = $data['active_date'];
        for ($i = 0; $i < 7; $i++) {
            array_push($week_dates, $active_date);
            $active_date = strtotime($active_date) + 86400;
            $active_date = date('Y-m-d', $active_date);
        }
        foreach ($week_dates as $date) {
            $roster_obj = new roster('');
            $roster_obj->view($data['emp_id'], $date);
            if ($roster_obj->time_in != "" && $roster_obj->time_out != '' && $roster_obj->date != '') {
                $center_obj = new centers($roster_obj->centers_id);
                $center_obj->getDetails();
                array_push($week_shedule, array(
                    'start_time' => $roster_obj->time_in,
                    'end_time' => $roster_obj->time_out,
                    'date' => $roster_obj->date,
                    'center' => $center_obj->name
                ));
            }
        }
        if (count($week_shedule) > 0) {
            $emp_obj = new employees($data['emp_id']);
            $emp_obj->getDetails();

            $mail_obj = new mail();
            $message_body = $mail_obj->mailBody($emp_obj->first_name . ' ' . $emp_obj->last_name, $week_shedule);

            $php_mailer = new ngs_mail();
            $php_mailer->subject = 'Weekly time sheet';
            $php_mailer->body = $message_body;
            $php_mailer->address = array($emp_obj->email);
//            $php_mailer->address = ['maleeshpamuditha@gmail.com'];
            $result = $php_mailer->sendmail();
        } else {
            $result = false;
        }

        echo json_encode(array('msg' => $result));
        break;
    case 'SMS':
        $week_dates = array();
        $week_shedule = array();
        $active_date = $data['active_date'];       
        for ($i = 0; $i < $data['week']; $i++) {
            array_push($week_dates, $active_date);
            $active_date = strtotime($active_date) + 86400;
            $active_date = date('Y-m-d', $active_date);
        }
        foreach ($week_dates as $date) {
            $roster_obj = new roster('');
            $roster_obj->view($data['emp_id'], $date);
            if ($roster_obj->time_in != "" && $roster_obj->time_out != '' && $roster_obj->date != '') {
                $center_obj = new centers($roster_obj->centers_id);
                $center_obj->getDetails();
                array_push($week_shedule, array(
                    'start_time' => $roster_obj->time_in,
                    'end_time' => $roster_obj->time_out,
                    'date' => $roster_obj->date,
                    'center' => $center_obj->name
                ));
            }
        }        
        if (count($week_shedule) > 0) {
            $sms = new sms();
            $emp_obj = new employees($data['emp_id']);
            $emp_obj->getDetails();

            $msg = "Weekly Roster\n\n";
            foreach ($week_shedule as $obj) {
                $msg .= "Date: " . $obj['date'] . "  " . $obj['start_time'] . " - " . $obj['end_time'] . "\n\n";
            }
            $msg .= "\n" . " Reply with YES/NO, If NO give reason.";
//            $msg = urlencode($msg);
//            print $msg;
            $res_sms = $sms->addSMStoQue($emp_obj->mobile_number, $msg);
//            print $res_sms;
            echo json_encode(array('msg' => $res_sms));
        } else {
            echo json_encode(array('msg' => false));
        }
//        
        break;
    case 'ADDINOUTTIME':
        if ($data['id'] != '') {
            $roster_obj = new roster($data['id']);

            $roster_obj->actual_start_time = $data['time_in'];
            $roster_obj->actual_end_time = $data['time_out'];
            $roster_obj->comment = $data['comment'];
            $roster_obj->lunch = $data['lunch'];
            // edit roster details
            $roster_obj->edit();
            $roster_id = $data['id'];
            //  view roster details
            $roster_obj = new roster($data['id']);
            $roster_details = $roster_obj->getDetails();
//            
            if ($roster_obj->time_in != '' && $roster_obj->actual_start_time) {
                $date_func = new ngs_date();
                $dhm = $date_func->getDuration_DHM(
                        ($roster_obj->date . ' ' . $roster_obj->actual_start_time), ($roster_obj->date . ' ' . $roster_obj->time_in . ':00'));

                if (substr($dhm[1], 0, 1) == '-' || substr($dhm[2], 0, 1) == '-') {
                    $earlyOrLate = 'Early';
                    $hour = substr($dhm[1], 1);
                    $minute = substr($dhm[2], 1);
                } else {
                    $earlyOrLate = 'Late';
                    $hour = $dhm[1];
                    $minute = $dhm[2];
                }
                                
                $approximate_time = $date_func->calculateApproximateTime($roster_obj->time_in, $roster_obj->actual_start_time);
                $roster_obj->approved_start_time = $date_func->convert24Hours($approximate_time);
                
                // edit roster details
                $roster_obj->edit();
                $timeInmsg = "Your Time in: $roster_obj->actual_start_time |"
                        . " You are $earlyOrLate $hour h: $minute m |"
                        . " Your TIME_IN is calculated as: $approximate_time";
            } else {
                $timeInmsg = $roster_obj->actual_start_time;
            }

            if ($roster_obj->time_out != '' && $roster_obj->actual_end_time) {
                $date_func = new ngs_date();
                $dhm = $date_func->getDuration_DHM(
                        ($roster_obj->date . ' ' . $roster_obj->actual_end_time), ($roster_obj->date . ' ' . $roster_obj->time_out . ':00'));

                if (substr($dhm[1], 0, 1) == '-' || substr($dhm[2], 0, 1) == '-') {
                    $earlyOrLate = 'Early';
                    $hour = substr($dhm[1], 1);
                    $minute = substr($dhm[2], 1);
                } else {
                    $earlyOrLate = 'Late';
                    $hour = $dhm[1];
                    $minute = $dhm[2];
                }

                $timeOutmsg = "You are finishing $earlyOrLate : $hour h: $minute m |"
                        . " Your TIME_OUT is calculated as : ".$date_func->convertAMPM($roster_obj->actual_end_time)." | Your Lunch Time: $roster_obj->lunch |"
                        . " Your Comments Today: " . (($roster_obj->comment != 'NULL' && $roster_obj->comment != '') ? $roster_obj->comment : 'None') . "";
            } else {
                $timeOutmsg = "";
            }
        } else {
            $roster_obj = new roster();
            $roster_obj->actual_start_time = $data['time_in'];
            $roster_obj->actual_end_time = $data['time_out'];
            $roster_obj->comment = $data['comment'];
            $roster_obj->lunch = $data['lunch'];
            $roster_obj->centers_id = 4;
            $roster_obj->employees_id = $_SESSION['EMPID'];
            $roster_obj->date = date('Y-m-d');

            $inserted_id = $roster_obj->empRosterAdd();
            $roster_id = $inserted_id;
            $roster_obj = new roster($inserted_id);
            $roster_details = $roster_obj->getDetails();

            if ($roster_obj->actual_start_time != '') {
                $timeInmsg = 'Your Time in: ' . $roster_obj->actual_start_time;
            }

            if ($roster_obj->actual_end_time != '') {
                $timeOutmsg = 'Your Time out: ' . $roster_obj->actual_end_time;
            }
        }
        $roster_mgr_obj = new roster_manager();
        $calcRosterArray = $roster_mgr_obj->calculateRosterHours();
        print json_encode(array(
                            'timeinmsg' => $timeInmsg,
                            'timeoutmsg' => $timeOutmsg,
                            'calcRosterArray' => $calcRosterArray,
                            'roster_id' => $roster_id));
        break;
    case 'GETEMPREPORT':
        $roster_mng_oj = new roster_manager();
        $reportEmp = $roster_mng_oj->searchByEmployee($data['empID'], $data['start_date'], $data['end_date']);
        if(count($reportEmp)>0) {
            $summary = $roster_mng_oj->calculateRosterHoursSummary($reportEmp);
        }
        print json_encode(array('roster' => $reportEmp, 'summary' => $summary));
        break;
    case 'GETCENTERREPORT':
        $roster_mng_oj = new roster_manager();
        $reportCenter = $roster_mng_oj->searchByCenter($data['centerID'], $data['start_date'], $data['end_date']);
        if(count($reportCenter)>0) {
            $summary = $roster_mng_oj->calculateRosterHoursSummary($reportCenter);
        }
        print json_encode(array('roster' => $reportCenter, 'summary' => $summary));
        break;
    case 'DELETEROSTERSHEDULE':
        $roster_delete_shedule = new roster();
        $del_result = $roster_delete_shedule->delete($data['emp_id'], $data['date']);
        if ($del_result) {
            print json_encode(array('msg' => 1));
        } else {
            print json_encode(array('msg' => 0));
        }
        break;
    default :
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}
?>

