<?php
include_once 'database.php';

class backup {
    public $id, $module, $seq_no,$user_id, $data;
    
    public function __construct($id='') {
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
    public function save(){
        //var_dump($this);
        $data_str= getStringFormatted($this->data);
        if($this->user_id!="" && $this->module!="" && $this->seq_no!=""){
            $str="INSERT INTO saq_backup (module,seq_no,data,saq_us_id) VALUES('$this->module','$this->seq_no',$data_str,'$this->user_id');";
            $result= dbQuery($str);
            return $this->seq_no;
        }
        else{
            return false;
        }
    }
}

?>