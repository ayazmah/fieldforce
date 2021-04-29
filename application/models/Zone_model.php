<?php defined('BASEPATH') OR exit('No direct script access allowed');

class zone_model extends CI_Model {

	private $table = "zones";
 
	
    
	public function read()
	{
		return $this->db->select("*")
			->from($this->table) 
			->order_by('zo_id','desc')
			->get()
			->result();
	} 
	
 
	public function read_by_id($zo_id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('zo_id', $zo_id) 
			->get()
			->row();
	} 
    
	public function insert($data = [])
	{
		return $this->db->insert($this->table,$data); 
	} 
	
	public function update($data = [])
	{
		return $this->db->where('zo_id',$data['zo_id']) 
			->update($this->table,$data); 
	} 
 
	
   public function delete($id) {
    
    $this->db->where('zo_id', $id);
    $del=$this->db->delete($this->table);   
    return $del;

}

  
}
