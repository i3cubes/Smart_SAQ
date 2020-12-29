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
class tree_node {
    //put your code here
    public $id,$name,$parent_id;
    public $file_type; //Image or file
    public $files=array();// array of files with type
    
    public function __construct($id = '') {
        $this->id = $id;
    }
}
