<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	private $table = "users";
 
	public function check_user($data = [])
	{
		return $this->db->select("*")
			->from($this->table)
			->where('us_email',$data['email'])
			->where('us_password',$data['password'])
			->where('us_is_admin',1)
			->get();
	} 
 


	
	public function profile($user_id = null)
	{
		return $this->db->select("*")
			->from("users") 
			->where('us_id', $user_id)
			->get()
			->row();
	} 

	
	
 
	public function update($data = [])
	{
		return $this->db->where('us_id',$data['user_id'])
			->update("users" ,$data); 
	} 


	

  
}
