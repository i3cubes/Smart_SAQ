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

class agreement_model extends tree_node {
    public $child=array();
    
    public function __construct($id = '') {
        parent::__construct($id);
        $this->file_type="file";
    }
    public function save(){
        if($this->name!=""){
            $str="INSERT INTO saq_sample_agreement VALUES(NULL,'$this->name','1',".getStringFormatted($this->parent_id).");";
            $result= dbQuery($str);
            $this->id= dbInsertId();
            if($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function edit() {
        $str="UPDATE `saq_sample_agreement` SET `name` = '$this->name' WHERE `id` = $this->id;";
        $result= dbQuery($str);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
    public function getData(){
        if($this->id!=""){
            $str="SELECT * FROM saq_sample_agreement WHERE id='$this->id' AND status='1';";
            $result= dbQuery($str);
            if(dbNumRows($result)>0){
                $row= dbFetchAssoc($result);
                $this->id=$row['id'];
                $this->name=$row['name'];
                $this->parent_id=$row['parent_agreement_id'];
            }
        }
    }
    
    public function getParentNodes() {
        $array = array();
        $str="SELECT * FROM `saq_sample_agreement` WHERE `parent_agreement_id` IS NULL AND `status` = ".constants::$ACTIVE.";";
//        print $str;
        $result= dbQuery($str);
        while ($row = dbFetchAssoc($result)) {
            array_push($array, array(
                'id' => $row['id'],
                'name' => $row['name'],
                'status' => $row['status'],
                'parent_agreement_id' => $row['parent_agreement_id']
             ));
        }
        return $array;
    }
    public function getFiles(){
        $str="SELECT * FROM saq_sample_agreement_files WHERE saq_sample_agreement_id=$this->id;";
        $result= dbQuery($str);
        while ($row= dbFetchAssoc($result)){
            array_push($this->files, array(
                'id'=>$row['id'],
                'name'=>$row['name'],
                'type'=>$row['type'],
                'base_path'=>$row['base_path'],
                'saq_sample_agreement_id'=>$row['saq_sample_agreement_id']
            ));
        }
        return $this->files;
    }
    public function getChild(){
        $str="SELECT * FROM saq_sample_agreement WHERE parent_agreement_id='$this->id' AND status = ".constants::$ACTIVE.";";
        $result= dbQuery($str);
        while ($row= dbFetchAssoc($result)){
            $agr=new agreement_model($row['id']);
            $agr->getData();
            array_push($this->child, $agr);
        }
        return $this->child;
    }
    public function addFile($type,$name,$path){
        $str="INSERT INTO saq_sample_agreement_files VALUES(NULL,'$name','$type','$path','$this->id');";
        $result= dbQuery($str);
        return $result;
    }
    
    public function deleteFile($id) {
        $str = "DELETE FROM `saq_sample_agreement_files` WHERE `id` = $id;";
        $result = dbQuery($str);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function delete() {
        $str="UPDATE `saq_sample_agreement` SET `status` = ".constants::$inactive." WHERE `id` = $this->id;";
        $result = dbQuery($str);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
}
