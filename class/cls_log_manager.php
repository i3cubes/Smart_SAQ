<?php

include_once 'database.php';
include_once 'cls_log.php';

class log_manager {

    public function search($module, $date_from, $date_to, $user_id) {
        $search_array = array();
        $return_array = array();
        $module = getStringFormatted($module);
        $date_from = getStringFormatted($date_from);
        $date_to = getStringFormatted($date_to);
        $user_id = getStringFormatted($user_id);

        if ($module != 'NULL') {
            array_push($search_array, "`module`=$module");
        }
        if ($date_from != 'NULL') {
            if ($date_to != 'NULL') {
                array_push($search_array, "`date_time`>$date_from AND `date_time`<$date_to");
            } else {
                array_push($search_array, "`date_time`>$date_from");
            }
        }
        if ($user_id != 'NULL') {
            array_push($search_array, "`user_id`=$user_id");
        }

        if (count($search_array) > 0) {
            $search_string = implode('AND', $search_array);
            $string = "SELECT * FROM `log` WHERE $search_string;";
            $result = dbQuery($string);
            if ($result) {
                while ($row = dbFetchAssoc($result)) {
                    $log_obj = new log($row['id']);
                    $log_obj->getDetails();
                    array_push($return_array, [
                        'id' => $log_obj->id,
                        'module' => $log_obj->module,
                        'date_time' => $log_obj->date_time,
                        'log' => $log_obj->log,
                        'user_id' => $log_obj->user_id
                    ]);
                }
            }
        }
        return $return_array;
    }

}

?>