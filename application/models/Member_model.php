<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Member_model extends CI_Model {

	private $table = 'members';
    
	public function members_by_company($id = null)
	{ 
		return $this->db->select("*")
			->from($this->table)
			->where('company_id',$id)
			->where('designation',3)
			->get()
			->result();
	}
	
	
	public function create($data = [])
	{	 
		 $this->db->insert($this->table,$data);
		 return $this->db->insert_id();
	}
 
	public function read()
	{
		return $this->db->select("*")
			->from("members")
			->where('emp_is_deleted!=1')
			->order_by('id','desc')
			->get()
			->result();
	} 
 
	public function read_by_id($id = null)
	{ 
		return $this->db->select("*")
			->from("members")
			->where('id',$id)
			->order_by('id','desc')
			->get()
			->row();

	} 
	public function team_lead_by_region($id = null)
	{ 
		return $this->db->select("*")
			->from("members")
			->where('designation',1)
			->where('region',$id)
			->get()
			->result();

	} 
	public function zonal_manager_by_region($id = null)
	{ 
		return $this->db->select("*")
			->from("members")
			->where('designation',6)
			->where('region',$id)
			->get()
			->result();

	} 	
	
	public function region_by_company($id = null)
	{ 
		return $this->db->select("*")
			->from("regions")
			->where('re_us_id',$id)
			->get()
			->result();

	}	
		
	public function manager_by_region($id = null)
	{ 
		return $this->db->select("*")
			->from("members")
			->where('designation',5)
			->where('region',$id)
			->get()
			->result();

	} 	
	public function line_by_role($id = null,$cid)
	{ 
		return $this->db->select("*")
			->from("members")
			->where('designation',$id)
			->where('company_id',$cid)
			->order_by('id','desc')
			->get()
			->result();

	} 
	public function zone_by_region($id = null)
	{ 
		return $this->db->select("*")
			->from("zones")
			->where('zo_re_id',$id)
			->order_by('zo_id','desc')
			->get()
			->result();

	} 
 
	public function update($data = [])
	{
		
		return $this->db->where('id',$data['id'])
			->update($this->table,$data); 
	} 
 
	public function delete($id = null)
	{
		$this->db->where('id',$id)
			->delete($this->table);
		
		
//		return $this->db->where('id',$data['id'])
//			->update($this->table,$data); 
//		

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	} 
 
	
 }
