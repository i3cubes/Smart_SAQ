<?php
include_once 'database.php';
include_once 'cls_backup_image.php.php';

class user_backup_image {
    public $user_id, $module,$backup_image;
    
    public function __construct($id,$module) {
        $this->user_id = $id;
        $this->module=$module;
    }
    public function getBackupImages(){
        $ary_result=array();
        $str="SELECT * FROM saq_backup_images WHERE module='$this->module' AND saq_us_id='$this->user_id';";
        $result= dbQuery($str);
        while ($row= dbFetchAssoc($result)){
            $bkp_img=new backup_image($row['id']);
            $bkp_img->module=$row['module'];
            $bkp_img->tag=$row['tag'];
            $bkp_img->path=$row['path'];
            $bkp_img->type=$row['type'];
            array_push($ary_result, $bkp_img);
        }
        return $ary_result;
    }
}

?>