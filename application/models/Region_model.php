<?php defined('BASEPATH') OR exit('No direct script access allowed');

class region_model extends CI_Model {

	private $table = "regions";
 
	
    
	public function read()
	{
		return $this->db->select("*")
			->from($this->table) 
			->order_by('re_id','desc')
			->get()
			->result();
	} 
	
 
	public function read_by_id($re_id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('re_id', $re_id) 
			->get()
			->row();
	} 
    
	public function insert($data = [])
	{
		return $this->db->insert($this->table,$data); 
	} 
	
	public function update($data = [])
	{
		return $this->db->where('re_id',$data['re_id']) 
			->update($this->table,$data); 
	} 
 
	
   public function delete($id) {
    
    $this->db->where('re_id', $id);
    $del=$this->db->delete($this->table);   
    return $del;

}

  
}
