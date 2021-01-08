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

include_once 'cls_site_model.php';

class site_model_manager {
    
    public function getParentNodes() {
        $array = array();
        $str="SELECT * FROM `saq_site_model` WHERE `parent_model_id` IS NULL AND `status` = ".constants::$ACTIVE.";";
//        print $str;
        $result= dbQuery($str);
        while ($row = dbFetchAssoc($result)) {
            $site_model=new site_model($row['id']);
            $site_model->name=$row['name'];
            $site_model->parent_id=$row['parent_model_id'];
            
            array_push($array, $site_model);
        }
        return $array;
    }
}
