<?php

include_once 'cls_saq_guideline.php';
include_once 'database.php';
include_once 'constants.php';
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
class saq_guideline_manager {

    //put your code here
    public function getGuidlines() {
        $res = array();
        $str = "SELECT * FROM saq_guideline WHERE status=" . constants::$ACTIVE . ";";
        $result = dbQuery($str);
        if (dbNumRows($result) > 0) {
            while ($row = dbFetchAssoc($result)) {
                $gl = new saq_guideline($row['id']);
                $gl->name = $row['name'];
                $gl->description = $row['description'];
                $gl->status = $row['status'];
                $gl->date = $row['uploaded_date_time'];
                //$gl-> getFiles();
                array_push($res, $gl);
            }
        }
        return $res;
    }

}
