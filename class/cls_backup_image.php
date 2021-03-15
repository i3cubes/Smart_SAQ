<?php
include_once 'database.php';

class backup_image {
    public $id, $module,$user_id, $tag,$path,$type;
    
    public function __construct($id='') {
        $this->id = $id;
    }
    
    public function getData() {
        $str = "SELECT * FROM `saq_backup_images` WHERE `id` = $this->id;";
        $result = dbQuery($str);
        if($result) {
            $row = dbFetchAssoc($result);
            $this->module = $row['module'];
            $this->tag = $row['tag'];
            $this->user_id = $row['saq_us_id'];
            $this->path = $row['path'];
            $this->type = $row['type'];
            $this->id = $row['id'];
        } else {
            return false;
        }
    }
    public function save(){
        if($this->user_id!="" && $this->module!="" && $this->path!=""){
            $str="INSERT INTO saq_backup_images (module,tag,path,type,saq_us_id) VALUES('$this->module','$this->tag','$this->path','$this->type','$this->user_id');";
            $result= dbQuery($str);
            return dbInsertId();
        }
        else{
            return false;
        }
    }
}

?>