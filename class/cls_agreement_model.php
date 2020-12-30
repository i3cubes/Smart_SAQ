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
        }
    }
    public function getData(){
        if($this->id!=""){
            $str="SELECT * FROM saq_sample_agreement WHERE id='$this->id' AND status='1';";
            $result= dbQuery($str);
            if(dbNumRows($result)>0){
                $row= dbFetchAssoc($result);
                $this->name=$row['name'];
                $this->parent_id=$row['parent_agreement_id'];
            }
        }
    }
    public function getFiles(){
        $str="SELECT * FROM saq_sample_agreement_files WHERE saq_sample_agreement_id='$this->id';";
        $result= dbQuery($str);
        while ($row= dbFetchAssoc($result)){
            array_push($this->files, array($row['id'],$row['name'],$row['type'],$row['base_path']));
        }
        return $this->files;
    }
    public function getChild(){
        $str="SELECT * FROM saq_sample_agreement WHERE parent_agreement_id='$this->id';";
        $result= dbQuery($str);
        while ($row= dbFetchAssoc($result)){
            $agr=new agreement_model($row['id']);
            $agr->getData();
            array_push($array, $agr);
        }
        return $this->child;
    }
    public function addFile($type,$name,$path){
        $str="INSERT INTO saq_sample_agreement_files VALUES(NULL,'$name','$type','$path','$this->id');";
        $result= dbQuery($str);
        return $result;
    }
}
