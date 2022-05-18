<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cls_tree_node
 *
 * @author kumar
 */
include_once 'database.php';
include_once 'constants.php';

include_once 'cls_tree_node.php';

class site_model extends tree_node {
    public $child=array();
    
    public function __construct($id = '') {
        parent::__construct($id);
        $this->file_type="image";
    }
    public function save(){       
        if($this->name!=""){
            $str="INSERT INTO saq_site_model VALUES(NULL,'$this->name','1',".getStringFormatted($this->parent_id).");";
            $result= dbQuery($str);
            $this->id= dbInsertId();
            return true;
        } else {
            return false;
        }
    }
    
    public function edit() {
        $str="UPDATE `saq_site_model` SET `name` = '$this->name' WHERE `id` = $this->id;";
        $result= dbQuery($str);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getParentNodes() {
        $array = array();
        $str="SELECT * FROM `saq_site_model` WHERE `parent_model_id` IS NULL AND `status` = ".constants::$ACTIVE.";";
//        print $str;
        $result= dbQuery($str);
        while ($row = dbFetchAssoc($result)) {
            array_push($array, array(
                'id' => $row['id'],
                'name' => $row['name'],
                'status' => $row['status'],
                'parent_model_id' => $row['parent_model_id']
             ));
        }
        return $array;
    }

    public function getData(){
        if($this->id!=""){
            $str="SELECT * FROM saq_site_model WHERE id='$this->id' AND status='1';";
            $result= dbQuery($str);
            if(dbNumRows($result)>0){
                $row= dbFetchAssoc($result);
                $this->id=$row['id'];
                $this->name=$row['name'];
                $this->parent_id=$row['parent_model_id'];
            }
        }
    }
    public function getImages(){
        $str="SELECT * FROM saq_site_model_images WHERE saq_site_model_id='$this->id';";
        $result= dbQuery($str);
        while ($row= dbFetchAssoc($result)){
//            $img = file_get_contents('../'.$row['base_path']);
//            $img_data = base64_encode($img);
            array_push($this->files, array(
                'id' => $row['id'],
                'name' => $row['name'],
                'type' => $row['type'],
                'base_path' => $row['base_path'],
                'saq_site_model_id' => $row['saq_site_model_id']    
            ));
        }
        return $this->files;
    }
    public function getChild(){
        $array = array();
        $str="SELECT * FROM saq_site_model WHERE parent_model_id='$this->id' AND status = ".constants::$ACTIVE.";";        
        $result= dbQuery($str);
        while ($row= dbFetchAssoc($result)){
            $m=new site_model($row['id']);
            $m->getData();
            array_push($this->child, $m);
        }        
        return $this->child;
    }
    public function addImage($type,$name,$path){
        $str="INSERT INTO saq_site_model_images VALUES(NULL,'$name','$type','$path','$this->id');";
        $result= dbQuery($str);
        return $result;
    }
    
    public function deleteImage($id){
        $str="DELETE FROM `saq_site_model_images` WHERE `id` = $id;";
        $result= dbQuery($str);
        return $result;
    }
    
    public function delete() {
        $str="UPDATE `saq_site_model` SET `status` = ".constants::$inactive." WHERE `id` = $this->id;";
        $result = dbQuery($str);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
}
