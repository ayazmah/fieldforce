<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Competition_model extends CI_Model {

	private $table = 'competition';

	public function create($data = [])
	{	 
		return $this->db->insert($this->table,$data);
	}
 
	public function read()
	{
		return $this->db->select("*")
			->from("competition")
			->order_by('competition_id','desc')
			->get()
			->result();
	} 
 
	public function read_by_id($id = null)
	{ 
		return $this->db->select("*")
			->from("competition")
			->where('competition_id',$id)
			->order_by('competition_id','desc')
			->get()
			->row();

	} 
 
	public function update($data = [])
	{
		return $this->db->where('competition_id',$data['competition_id'])
			->update($this->table,$data); 
	} 
 
	public function delete($id = null)
	{
		$this->db->where('competition_id',$id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	} 
 
	
 }
