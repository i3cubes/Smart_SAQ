<?php

include_once 'dataase.php';
include_once 'constants.php';

include_once 'cls_roster.php';
include_once 'cls_employees.php';
include_once 'cls_date.php';

class roster_manager {

    // search roster by employee
    public function searchByEmployee($emp_id, $start_date, $end_date) {
        $query_array = array();
        $return_array = array();

        $start_date = getStringFormatted(constants::convertDate($start_date));
        $end_date = getStringFormatted(constants::convertDate($end_date));

        if ($emp_id != '') {
            array_push($query_array, "`employees_id`=$emp_id");
        }

        if ($start_date != 'NULL') {
            if ($end_date != 'NULL') {
                array_push($query_array, "`date`>=$start_date AND `date`<=$end_date");
            } else {
                array_push($query_array, "`date`>=$start_date");
            }
        } else if ($end_date != 'NULL') {
            array_push($query_array, "`date`<=$end_date");
        }

        if (count($query_array) > 0) {
            $string_where = implode(" AND ", $query_array);
            $string = "SELECT * FROM `roster` WHERE $string_where";
            $result = dbQuery($string);
            while ($row = dbFetchAssoc($result)) {
                $emp_obj = new employees($row['employees_id']);
                $emp_obj->getDetails();
                $roster_obj = new roster($row['id']);
                $roster_obj->id = $row['id'];
                $roster_obj->time_in = (($row['start_time']!='')?date("g:i a", strtotime($row['start_time'])):'');
                $roster_obj->time_out = (($row['end_time']!='')?date("g:i a", strtotime($row['end_time'])):'');
                if ($row['start_time'] != '' && $row['end_time'] != '') {
                    $date_oj = new ngs_date();
                    $roster_obj->total_hours = $date_oj->getDuration_DHM(
                                    ($row['date'] . ' ' . $row['end_time'] . ':00'), ($row['date'] . ' ' . $row['start_time'] . ':00')
                    );
                }
                $roster_obj->actual_start_time = (($row['approve'] == constants::$active && $row['actual_start_time'] != '') ? $row['actual_start_time'] : 'NOT APPROVED');
                $roster_obj->actual_end_time = (($row['approve'] == constants::$active && $row['actual_end_time'] != '') ? $row['actual_end_time'] : 'NOT APPROVED');
                if ($row['actual_start_time'] != '' && $row['actual_end_time'] != '') {
                    $date_oj = new ngs_date();
                    $roster_obj->hrs_worked = $date_oj->getDuration_DHM(
                                    ($row['date'] . ' ' . $row['actual_end_time'] . ':00'), ($row['date'] . ' ' . $row['actual_start_time'] . ':00')
                    );
                }
                $roster_obj->extra_hrs = (($roster_obj->hrs_worked != null && $roster_obj->total_hours != null) ? (array(($roster_obj->hrs_worked[1]-$roster_obj->total_hours[1]),($roster_obj->hrs_worked[2]-$roster_obj->total_hours[2]))) : []);
                $roster_obj->date = constants::convertBack($row['date']);
                $roster_obj->comment = $row['comment'];
                $roster_obj->centers_id = $row['centers_id'];
                $roster_obj->employees_id = $row['employees_id'];
                $roster_obj->employee_name = $emp_obj->first_name . ' ' . $emp_obj->last_name;
                $roster_obj->approve = $row['approve'];
                $roster_obj->lunch = $row['lunch'];

                array_push($return_array, $roster_obj);
            }
        }
        return $return_array;
    }
    
    // calculate roster hours 
    public function calculateRosterHoursSummary($roster_report_array = array()) {
        $total_hours_weekdays = 0;
        $total_minutes_weekdays = 0;
        $total_payable_hours_weekdays = 0;
        $total_payable_minutes_weekdays = 0;
        $total_payable_hours_saturdays = 0;        
        $total_payable_minutes_saturdays = 0;
        $total_payable_hours_sundays = 0;
        $total_payable_minutes_sundays = 0;
        
        $total_extra_hours_saturdays = 0;
        $total_extra_minutes_saturdays = 0;
        $total_extra_hours_sundays = 0;
        $total_extra_minutes_sundays = 0;
        $total_extra_hours_weekdays = 0;
        $total_extra_minutes_weekdays = 0;
        
        foreach ($roster_report_array as $roster) {
            if($roster->date != '') {
                $dayType = strtolower(date('l', strtotime(constants::convertDate($roster->date))));
                if($dayType == "saturday") {
//                    print $roster->date;
                    if(count($roster->hrs_worked)>0) {
                     $total_payable_hours_saturdays += $roster->hrs_worked[1];  
                     $total_payable_minutes_saturdays += $roster->hrs_worked[2];  
                    }
                    if(count($roster->extra_hrs)>0) {
                        $total_extra_hours_saturdays += $roster->extra_hrs[0];
                        $total_extra_minutes_saturdays += $roster->extra_hrs[1];
                    }                    
                } else if($dayType == "sunday") {
                    if(count($roster->hrs_worked)>0) {
                        $total_payable_hours_sundays += $roster->hrs_worked[1];
                        $total_payable_minutes_sundays += $roster->hrs_worked[2];
                    }
                    if(count($roster->extra_hrs)>0) {
                        $total_extra_hours_sundays += $roster->extra_hrs[0];
                        $total_extra_minutes_sundays += $roster->extra_hrs[1];
                    }                    
                } else {
                    if(count($roster->total_hours)>0) {
                        $total_hours_weekdays += $roster->total_hours[1];
                        $total_minutes_weekdays += $roster->total_hours[2];
                    }
                    if(count($roster->hrs_worked)>0) {
                        $total_payable_hours_weekdays += $roster->hrs_worked[1];
                        $total_payable_minutes_weekdays += $roster->hrs_worked[2];
                    }
                    if(count($roster->extra_hrs)>0) {
                        $total_extra_hours_weekdays += $roster->extra_hrs[0];
                        $total_extra_minutes_weekdays += $roster->extra_hrs[1];
                    }                    
                }
            }
        }
        return array(
            'total_hours_weekdays' => array($total_hours_weekdays,$total_minutes_weekdays),
            'total_payable_hours_weekdays' => array($total_payable_hours_weekdays,$total_payable_minutes_weekdays),
            'total_extra_hours_weekdays' => array($total_extra_hours_weekdays,$total_extra_minutes_weekdays),
            'total_payable_hours_saturdays' => array($total_payable_hours_saturdays,$total_payable_minutes_saturdays),
            'total_extra_hours_saturdays' => array($total_extra_hours_saturdays,$total_extra_minutes_saturdays),
            'total_payable_hours_sundays' => array($total_payable_hours_sundays,$total_payable_minutes_sundays),
            'total_extra_hours_sundays' => array($total_extra_hours_sundays,$total_extra_minutes_sundays)
            );
    }

    // search roster by center
    public function searchByCenter($center_id, $start_date, $end_date) {
        $query_array = array();
        $return_array = array();

        $start_date = getStringFormatted(constants::convertDate($start_date));
        $end_date = getStringFormatted(constants::convertDate($end_date));

        if ($center_id != '') {
            array_push($query_array, "`centers_id`=$center_id");
        }

//        if ($emp_id != '') {
//            array_push($query_array, "`employees_id`=$emp_id");
//        }

        if ($start_date != 'NULL') {
            if ($end_date != 'NULL') {
                array_push($query_array, "`date`>=$start_date AND `date`<=$end_date");
            } else {
                array_push($query_array, "`date`>=$start_date");
            }
        } else if ($end_date != 'NULL') {
            array_push($query_array, "`date`<=$end_date");
        }

        if (count($query_array) > 0) {
            $string_where = implode(" AND ", $query_array);
            $string = "SELECT * FROM `roster` WHERE $string_where";
//            print $string;
            $result = dbQuery($string);
            while ($row = dbFetchAssoc($result)) {
                 $emp_obj = new employees($row['employees_id']);
                $emp_obj->getDetails();
                $roster_obj = new roster($row['id']);
                $roster_obj->id = $row['id'];
                $roster_obj->time_in = (($row['start_time']!='')?date("g:i a", strtotime($row['start_time'])):'');
                $roster_obj->time_out = (($row['end_time']!='')?date("g:i a", strtotime($row['end_time'])):'');
                if ($row['start_time'] != '' && $row['end_time'] != '') {
                    $date_oj = new ngs_date();
                    $roster_obj->total_hours = $date_oj->getDuration_DHM(
                                    ($row['date'] . ' ' . $row['end_time'] . ':00'), ($row['date'] . ' ' . $row['start_time'] . ':00')
                    );
                }
                $roster_obj->actual_start_time = (($row['approve'] == constants::$active && $row['actual_start_time'] != '') ? $row['actual_start_time'] : 'NOT APPROVED');
                $roster_obj->actual_end_time = (($row['approve'] == constants::$active && $row['actual_end_time'] != '') ? $row['actual_end_time'] : 'NOT APPROVED');
                if ($row['actual_start_time'] != '' && $row['actual_end_time'] != '') {
                    $date_oj = new ngs_date();
                    $roster_obj->hrs_worked = $date_oj->getDuration_DHM(
                                    ($row['date'] . ' ' . $row['actual_end_time'] . ':00'), ($row['date'] . ' ' . $row['actual_start_time'] . ':00')
                    );
                }
                $roster_obj->extra_hrs = (($roster_obj->hrs_worked != null && $roster_obj->total_hours != null) ? (array(($roster_obj->hrs_worked[1]-$roster_obj->total_hours[1]),($roster_obj->hrs_worked[2]-$roster_obj->total_hours[2]))) : []);
                $roster_obj->date = constants::convertBack($row['date']);
                $roster_obj->comment = $row['comment'];
                $roster_obj->centers_id = $row['centers_id'];
                $roster_obj->employees_id = $row['employees_id'];
                $roster_obj->employee_name = $emp_obj->first_name . ' ' . $emp_obj->last_name;
                $roster_obj->approve = $row['approve'];
                $roster_obj->lunch = $row['lunch'];

                array_push($return_array, $roster_obj);
            }
        }
        return $return_array;
    }

    public function viewByDateCenter($center_id, $date) {
        $return_array = array();
        if ($center_id != '' && $date != '') {
            $string = "SELECT * FROM `roster` WHERE `centers_id` = $center_id AND `date` = '$date';";
            $result = dbQuery($string);
            while ($row = dbFetchAssoc($result)) {
                $roster_obj = new roster($row['id']);
                $roster_obj->getDetails();
                array_push($return_array, $roster_obj);
            }
        } else {
            return false;
        }
        return $return_array;
    }

    public function calculateRosterHours() {
        $fortnightWeek = array();
        $totalReosteredHours = 0;
        $totalRosterHours = 0;
        $start_date = date('Y-m-d');
        $date_obj = new ngs_date();
        $start_date = $date_obj->x_week_start($start_date);
        for ($i = 1; $i <= 14; $i++) {
            array_push($fortnightWeek, $start_date);
            $start_date = strtotime($start_date) + 86400;
            $start_date = date('Y-m-d', $start_date);
        }
        
        foreach ($fortnightWeek as $date) {
            $roster_obj = new roster();
            $roster = $roster_obj->view($_SESSION['EMPID'], $date);
            if($roster_obj->time_in != '' && $roster_obj->time_out != '') {                
                $totalRosterHours += (int) $date_obj->getDuration(($date . ' ' . $roster_obj->time_out . ':00'),
                                            ($date . ' ' . $roster_obj->time_in . ':00'));
            }
            
            if($roster_obj->actual_start_time != '' && $roster_obj->actual_end_time != '') {
                $totalReosteredHours += (int) $date_obj->getDuration(($date . ' ' . $roster_obj->actual_end_time),
                                            ($date . ' ' . $roster_obj->actual_start_time));
            }
        }
        
        return array($totalRosterHours,$totalReosteredHours);
    }
       

}

?>