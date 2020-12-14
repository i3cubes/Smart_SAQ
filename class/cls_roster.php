<?php

include_once 'database.php';
include_once 'constants.php';

class roster {

    public $id, $time_in, $time_out, $actual_start_time, $actual_end_time,$approved_start_time,$approved_end_time, $date, $centers_id,
            $employees_id, $comment, $approve,$lunch, $employee_name, $total_hours = [], $hrs_worked = [], $extra_hrs = [];
    private $table_name = 'roster';

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getDetails() {
        $string = "SELECT * FROM `$this->table_name` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->time_in = $row['start_time'];
        $this->time_out = $row['end_time'];
        $this->actual_start_time = $row['actual_start_time'];
        $this->actual_end_time = $row['actual_end_time'];
        $this->approved_start_time = $row['approved_start_time'];
        $this->approved_end_time = $row['approved_end_time'];
        $this->date = $row['date'];
        $this->comment = $row['comment'];
        $this->approve = $row['approve'];
        $this->lunch = $row['lunch'];
        $this->centers_id = $row['centers_id'];
        $this->employees_id = $row['employees_id'];        
    }

    public function view($emp_id, $date, $center_id = 0) {        
        if ($emp_id != "" && $date != "") {
            $sub_string = "";
            if($center_id != 0) {
                $sub_string = " AND `centers_id` = $center_id";
            } 
            $string = "SELECT * FROM `$this->table_name` WHERE `employees_id` = $emp_id AND `date` = '$date' $sub_string;";
           
            $result = dbQuery($string);
            $row = dbFetchAssoc($result);
            $this->id = $row['id'];
            $this->time_in = $row['start_time'];
            $this->time_out = $row['end_time'];
            $this->actual_start_time = $row['actual_start_time'];
            $this->actual_end_time = $row['actual_end_time'];
            $this->approved_start_time = $row['approved_start_time'];
            $this->approved_end_time = $row['approved_end_time'];
            $this->date = constants::convertBack($row['date']);
            $this->centers_id = $row['centers_id'];
            $this->employees_id = $row['employees_id'];
            $this->comment = $row['comment'];
            $this->approve = $row['approve'];
        } else {
            return false;
        }
    }        

    public function add() {               
        if (($this->time_in != ''
                && $this->time_out != ''
                && $this->date != ''
                && $this->centers_id != ''
                && $this->employees_id != '') 
               ) {            
            $string = "INSERT INTO `$this->table_name` (`start_time`,`end_time`,`date`,`lunch`,`centers_id`,`actual_start_time`,`actual_end_time`,`comment`,`employees_id`" . (($this->approve != '') ? ',`approve`' : '') . ") VALUES ("
                    . "". getStringFormatted($this->time_in).","
                    . "". getStringFormatted($this->time_out).","
                    . "". getStringFormatted($this->date).","
                    . "". getStringFormatted($this->lunch).","
                    . "". getStringFormatted($this->centers_id).","
                    . "". getStringFormatted($this->actual_start_time).","
                    . "". getStringFormatted($this->actual_end_time).","
                    . "". getStringFormatted($this->comment).","                  
                    . "$this->employees_id"
                    . "" . (($this->approve != '') ? ',' . constants::$active : '') . ""
                    . ")";
//            print $string;
            $result = dbQuery($string);
            if ($result) {
                return dbInsertId();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function empRosterAdd() {
        $string = "INSERT INTO `$this->table_name` ("
                . "`actual_start_time`,"
                . "`actual_end_time`,"
                . "`approved_start_time`,"
                . "`approved_end_time`,"
                . "`date`,"
                . "`comment`,"
                . "`lunch`,"
                . "`centers_id`,"
                . "`employees_id`) VALUES ("
                . "". getStringFormatted($this->actual_start_time).","
                . "". getStringFormatted($this->actual_end_time).","
                . "". getStringFormatted($this->actual_start_time).","
                . "". getStringFormatted($this->approved_end_time).","
                . "". getStringFormatted($this->date).","
                . "". getStringFormatted($this->comment).","
                . "". getStringFormatted($this->lunch).","
                . "$this->centers_id,"
                . "$this->employees_id"
                . ")";
        $result = dbQuery($string);
        if($result) {
            return dbInsertId();
        } else {
            return false;
        }
    }

    public function edit() {
        $query_array = array();       

        if ($this->time_in != '') {
            array_push($query_array, " `start_time`=". getStringFormatted($this->time_in)."");
        }
        if ($this->time_out != '') {
            array_push($query_array, " `end_time`=". getStringFormatted($this->time_out)." ");
        }
        if ($this->date != '') {
            array_push($query_array, " `date`=". getStringFormatted($this->date)." ");
        }
        if ($this->centers_id != '') {
            array_push($query_array, " `centers_id`=". getStringFormatted($this->centers_id)." ");
        }
        if ($this->employees_id != '') {
            array_push($query_array, " `employees_id`=". getStringFormatted($this->employees_id)." ");
        }
        if ($this->actual_start_time != '') {
            array_push($query_array, " `actual_start_time`=". getStringFormatted($this->actual_start_time)." ");
        }
        if ($this->actual_end_time != '') {
            array_push($query_array, " `actual_end_time`=". getStringFormatted($this->actual_end_time)." ");
        }
        if ($this->approved_start_time != '') {
            array_push($query_array, " `approved_start_time`=". getStringFormatted($this->approved_start_time)." ");
        }
        if ($this->approved_end_time != '') {
            array_push($query_array, " `approved_end_time`=". getStringFormatted($this->approved_end_time)." ");
        }
        if ($this->comment != '') {
            array_push($query_array, " `comment`=". getStringFormatted($this->comment)." ");
        }
        if($this->lunch != '') {
            array_push($query_array, "`lunch`=". getStringFormatted($this->lunch)."");
        }
        if ($this->approve != '') {
            array_push($query_array, " `approve`=" . constants::$active . " ");
        }

        if (count($query_array) > 0) {
            $string_array = implode(',', $query_array);
            $string = "UPDATE `$this->table_name` SET $string_array WHERE `id` = $this->id;";
//            print $string;
            $result = dbQuery($string);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function delete($employee_id, $date) {
        $date = getStringFormatted($date);
        $string = "DELETE FROM `$this->table_name` WHERE `employees_id` = $employee_id AND `date` = $date;";
//        print $string;
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}
?>

