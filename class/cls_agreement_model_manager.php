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

class agreement_model_manager {

    public function getParentNodes() {
        $array = array();
        $str="SELECT * FROM `saq_sample_agreement` WHERE `parent_agreement_id` IS NULL AND `status` = ".constants::$ACTIVE.";";
        //print $str;
        $result= dbQuery($str);
        while ($row = dbFetchAssoc($result)) {
            $agreement_model=new agreement_model($row['id']);
            $agreement_model->name=$row['name'];
            $agreement_model->parent_id=$row['parent_agreement_id'];
            array_push($array,$agreement_model);
        }
        return $array;
    }

}
