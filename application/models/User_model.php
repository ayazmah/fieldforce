<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	private $table = "users";
 
	public function create($data = [])
	{	 
		return $this->db->insert($this->table,$data);
	}
    public function get_caption($id)
	{
		return $this->db->select("*")
			->from('user_roles') 
			->where('ur_id='.$id)
			->get()
			->result();
	} 
    public function read_admin()
	{
		return $this->db->select("*")
			->from($this->table) 
			->where('us_is_admin',1)
			->get()
			->row();
	} 
	public function read($user_type)
	{
		return $this->db->select("*")
			->from($this->table) 
			->where('is_admin!=1')
			->order_by('us_id','desc')
			->get()
			->result();
	} 
 
	public function read_by_id($us_id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('us_id', $us_id) 
			->get()
			->row();
	} 
 
	public function update($data = [])
	{
		return $this->db->where('us_id',$data['us_id']) 
			->update($this->table,$data); 
	} 
 
	


  
}
