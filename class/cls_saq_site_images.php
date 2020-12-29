<?php 

include_once 'database.php';
include_once 'constants.php';

class saq_site_images {
    public $id,$name,$base_path,$saq_sites_id;
    private $table_name = 'saq_site_images';


    public function view($saq_site_id) {
        $array = array();
        $string = "SELECT * FROM `$this->table_name` WHERE `saq_sites_id` = $saq_site_id;";
        $result = dbQuery($string);
        while ($row = dbFetchAssoc($result)) {
            array_push($array, array(
                'id' => $row['id'],
                'name' => $row['name'],
                'base_path' => $row['base_path'],
                'saq_sites_id' => $row['saq_sites_id']
            ));
        }
        return $array;
    }

    public function add() {
        $string = "INSERT INTO `$this->table_name` (`name`,`base_path`,`saq_sites_id`) VALUES ("
                . "".getStringFormatted($this->name).","
                . "".getStringFormatted($this->base_path).","
                . "$this->saq_sites_id"
                . ");";
        $result = dbQuery($string);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function delete($id) {
        $string = "DELETE FROM `$this->table_name` WHERE `id` = $id;";
        $result = dbQuery($string);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
}
?>

