<?php 
defined('BASEPATH') OR exit('No direct script access allowed');



 if ( ! function_exists('random')){
   function random(){
         $number = rand(1111,9999);
         return $number;
       }
   }

 if ( ! function_exists('getCategoryTreeIDs')){
 function getCategoryTreeIDs($catID) {
	    $ci =& get_instance();
        $ci->load->database();
	    $ids = [strval($catID)];
		$row = $row = $ci->db->query("select * from location where location_id =".$catID)->row();
        if (!$row->location_parent_id == 0) {
		$row->location_parent_id;
		$ids = array_merge($ci->getCategoryTreeIDs($row->location_parent_id), $ids);
		} 
		return $ids;
  }
 }
	 
 if ( ! function_exists('getCategoryTitle')){
 function getCategoryTitle($id){
  	    $ci =& get_instance();
        $ci->load->database();
  		$c = $row = $ci->db->query("select * from location where location_id =".$id)->row();	
  		return $c->location_name;
 }
}