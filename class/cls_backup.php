<?php
include_once 'database.php';

class backup {
    public $id, $module, $seq_no,$user_id, $data;
    
    public function __construct($id) {
        $this->id = $id;
    }
    
    public function getData() {
        $str = "SELECT * FROM `saq_backup` WHERE `id` = $this->id;";
        $result = dbQuery($str);
        if($result) {
            $row = dbFetchAssoc($result);
            $this->module = $row['module'];
            $this->seq_no = $row['seq_no'];
            $this->user_id = $row['saq_us_id'];
            $this->data = $row['data'];
            $this->id = $row['id'];
        } else {
            return false;
        }
    }
}

?>