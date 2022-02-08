<?php
include_once 'constants.php';
include_once 'database.php';

class shared {
    public static function getCleanedData($field, $data, $source = 'API') {
        if ($source == 'WEB' && $data == '') {
            $data = "NULL"; // -----enable set null by web interface when data fiels is empty
        }
        if ($data == 'NULL') {
            return "$field=NULL";
        } else {
            if ($data == '') {
                return false;
            } else {
                return $field . "=" . getStringFormatted($data);
            }
        }
    }
    
    public function updateVariable($value) {
        $string = "UPDATE `variables` SET `value` = ".getStringFormatted($value)." WHERE `id` = 1;";
        $result = dbQuery($string);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getVariable() {
        $string = "SELECT `value` FROM `variables` WHERE `id` = 1;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        return $row['value'];        
    }
}
