<?php
include_once 'database.php';
include_once 'cls_backup.php';

class user_backup {
    public $user_id, $module,$backup;
    
    public function __construct($id,$module) {
        $this->user_id = $id;
        $this->module=$module;
        $this->backup=new backup();
        $this->backup->module= $module;
        $this->backup->user_id=$id;
    }
    
    public function saveBackup($data){
        $this->backup->data=$data;
        $this->backup->seq_no= $this->getNextSequenceNumber();
        $res= $this->backup->save();
        return $res;
    }
    public function getBackup($seq_no){
        if($seq_no!=''){
            $s=" AND seq_no='$seq_no'";
        }
        else{
            $s="ORDER BY seq_no LIMIT 1";
        }
        $str="SELECT * FROM saq_backup WHERE module='$this->module' AND saq_us_id='$this->user_id' $s;";
        $result= dbQuery($str);
        if(dbNumRows($result)==1){
            $row= dbFetchAssoc($result);
            $bkp=new backup($row['id']);
            $bkp->module=$row['module'];
            $bkp->seq_no=$row['seq_no'];
            $bkp->data=$row['data'];
            $bkp->user_id=$row['saq_us_id'];
            return $bkp;
        }
        else{
            return false;
        }
        
    }
    public function getNextAvailableSequenceNo($seq_no){
        if($seq_no==""){
            $seq_no=0;
        }
        $str="SELECT seq_no FROM saq_backup WHERE module='$this->module' AND saq_us_id='$this->user_id' AND seq_no>'$seq_no' ORDER BY seq_no LIMIT 1;";
        $result= dbQuery($str);
        if(dbNumRows($result)==1){
            $row= dbFetchArray($result);
            return $row[0];
        }
        else{
            return "";
        }
    }

    private function getNextSequenceNumber(){
        $str="SELECT MAX(seq_no) FROM saq_backup WHERE module='$this->module' AND saq_us_id='$this->user_id';";
        $result= dbQuery($str);
        if(dbNumRows($result)>0){
            $row= dbFetchArray($result);
            return $row[0]+1;
        }
        else{
            return 1;
        }
    }
}

?>