<?php
include_once 'cls_saq_guideline.php';
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
class guidline_manager {
    //put your code here
    public function getGuidlines(){
        $res=array();
        $str="SELECT * FROM saq_guidelines WHERE status='1';";
        $result= dbQuery($str);
        if(dbNumRows($result)>0){
            $row= dbFetchAssoc($result);
            $gl=new saq_guideline($row['id']);
            $gl->name=$row['name'];
            $gl->version=$row['version'];
            $gl->description=$row['description'];
            $gl->status=$row['status'];
            $gl->getFiles();
            array_push($res, $gl);
        }
        return $res;
    }
}
