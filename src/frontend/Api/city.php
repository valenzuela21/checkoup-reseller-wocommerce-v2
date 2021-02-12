<?php
include(dirname(__FILE__) . "/load.php");
include(dirname(__FILE__) . './../../admin/xbox/xbox.php');
class City{
    public function _city_select(){
        $xbox = Xbox::get('city_options_config');
        $value = $xbox->get_field_value('playlist');
        header("Content-type: application/json");
        echo json_encode($value) ;
        die();
    }

}
$citys = new City;
$citys->_city_select();