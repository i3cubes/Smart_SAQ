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
    public $file_type,$file_name,$file_base_path; 
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
            $this->file_type=$row['type'];
            $this->file_base_path=$row['base_path'];
            $this->version=$row['version'];
            $this->description=$row['description'];
            $this->status=$row['status'];
        }
    }
}
