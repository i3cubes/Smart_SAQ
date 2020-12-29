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
class guidline {
    //put your code here
    public $id,$name,$version,$description;
    public $files=array();//array of files {name,type,path} 
    public $status;
    
    public function __construct($id = '') {
        $this->id = $id;
    }
    public function getData(){
        $str="SELECT * FROM saq_guidelines WHERE id='$this->id';";
        $result= dbQuery($str);
        if(dbNumRows($result)>0){
            $row= dbFetchAssoc($result);
            $this->name=$row['name'];
            $this->version=$row['version'];
            $this->description=$row['description'];
            $this->status=$row['status'];
        }
    }
    public function getFiles(){
        $str="SELECT * FROM saq_guideline_files WHERE saq_guideline_id='$this->id';";
        $result= dbQuery($str);
        while ($row= dbFetchAssoc($result)){
            array_push($this->files, array('name'=> $row['name'],'type'=>$row['type'],'path'=>$row['location']));
        }
    }
}
