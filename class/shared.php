<?php
include_once 'constants.php';

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
}
