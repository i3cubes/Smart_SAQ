<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cls_site
 *
 * @author kumar
 */
class site {
    //put your code here
    public $id;
    public $name,$code,$type,$address,$site_ownership,$operator_name,$tower_height,$building_height,$land_area;
    public $on_air_date,$category,$lat,$lon,$access_type,$manual_distance,$access_permision_type;
    public $lo_name,$lo_address,$lo_nic_brc,$lo_mobile,$lo_land_number,$contact_person_number,$lo_fax,$lo_email;
    public $district_id,$district_name,$ds_id,$ds_name,$la_id,$la_name,$police_station_id,$police_station_name;
    public $region_id,$region_name,$dns_office_id,$dns_office_name;
    
    public function __construct($id = '') {
        $this->id = $id;
    }
}
