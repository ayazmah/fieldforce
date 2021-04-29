<?php defined('BASEPATH') OR exit('No direct script access allowed');

class invoice_model extends CI_Model {

	private $table = "invoices";
 
	
    
	public function read()
	{
		return $this->db->select("*")
			->from($this->table) 
			->order_by('inv_id','desc')
			->get()
			->result();
	} 
	
 
	public function read_by_id($inv_id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('inv_id', $inv_id) 
			->get()
			->row();
	} 
    
	public function insert($data = [])
	{
		return $this->db->insert($this->table,$data); 
	} 
	
	public function update($data = [])
	{
		return $this->db->where('inv_id',$data['inv_id']) 
			->update($this->table,$data); 
	} 
 
	
   public function delete($id) {
    
    $this->db->where('inv_id', $id);
    $del=$this->db->delete($this->table);   
    return $del;

}

  
}
