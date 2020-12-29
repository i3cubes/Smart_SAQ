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
        }
    }

    public function getData(){
        if($this->id!=""){
            $str="SELECT * FROM saq_site_model WHERE id='$this->id' AND status='1';";
            $result= dbQuery($str);
            if(dbNumRows($result)>0){
                $row= dbFetchAssoc($result);
                $this->name=$row['name'];
                $this->parent_id=$row['parent_model_id'];
            }
        }
    }
    public function getImages(){
        $str="SELECT * FROM saq_site_model_images WHERE saq_site_model_id='$this->id';";
        $result= dbQuery($str);
        while ($row= dbFetchAssoc($result)){
            array_push($this->files, array($row['id'],$row['name'],$row['type'],$row['base_path']));
        }
        return $this->files;
    }
    public function getChild(){
        $str="SELECT * FROM saq_site_model WHERE parent_model_id='$this->id';";
        $result= dbQuery($str);
        while ($row= dbFetchAssoc($result)){
            $m=new site_model($row['id']);
            $m->getData();
            array_push($array, $m);
        }
        return $this->child;
    }
    public function addImage($type,$name,$path){
        $str="INSERT INTO saq_site_model_images VALUES(NULL,'$name','$type','$path','$this->id');";
        $result= dbQuery($str);
        return $result;
    }
}
