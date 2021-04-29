<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Segment_model extends CI_Model {

	private $table = 'segment';

	public function create($data = [])
	{	 
		return $this->db->insert($this->table,$data);
	}
 
	public function read()
	{
		return $this->db->select("*")
			->from($this->table)
			->order_by('seg_id','desc')
			->get()
			->result();
	} 
 
	public function read_by_id($id = null)
	{ 
		return $this->db->select("*")
			->from($this->table)
			->where('seg_id',$id)
			->order_by('seg_id','desc')
			->get()
			->row();

	} 
 
	public function update($data = [])
	{
		return $this->db->where('seg_id',$data['seg_id'])
			->update($this->table,$data); 
	} 
 
	public function delete($id = null)
	{
		$this->db->where('seg_id',$id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	} 
 
	
 }
