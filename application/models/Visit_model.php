<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Visit_model extends CI_Model {

	private $table = 'visit_planner';
    
	public function members_by_company($id = null)
	{ 
		return $this->db->select("*")
			->from($this->table)
			->where('company_id',$id)
			->where('designation',3)
			->get()
			->result();
	}
	
	public function createTarget($data = [])
	{	 
		 $this->db->insert('visit_targets',$data);
		 return $this->db->insert_id();
	}
	public function create($data = [])
	{	 
		 $this->db->insert($this->table,$data);
		 return $this->db->insert_id();
	}
	
	public function getMemebrsBYPharmacy($cid)
	{
		return $this->db->select("pharmem_member_id")
			->from("pharmacy_members")
			->where('pharmem_pharmacy_id',$cid)
			->order_by('pharmem_id','desc')
			->get()
			->result();	
         
	}	
	
	public function getMemebrsBYWholesaler($cid)
	{
		return $this->db->select("whmem_member_id")
			->from("wholesaler_members")
			->where('whmem_wholesaler_id',$cid)
			->order_by('whmem_id','desc')
			->get()
			->result();	
         
	}	
		
	public function getMemebrsBYDoctor($cid)
	{
		return $this->db->select("drmem_member_id")
			->from("doctor_members")
			->where('drmem_doctor_id',$cid)
			->order_by('drmem_id','desc')
			->get()
			->result();	
         
	}
	
    public function getMemebrs($cid)
	{
		return $this->db->select("*")
			->from("members")
			->where('emp_company_id',$cid)
			->where('emp_is_deleted!=1')
			->where('emp_status!=0')
			->order_by('id','desc')
			->get()
			->result();
	}
	public function getPharmacy($cid)
	{
		return $this->db->select("*")
			->from("pharmacy")
			->where('pharm_company_id',$cid)
			->where('pharm_is_deleted!=1')
			->where('pharm_status!=0')
			->order_by('id','desc')
			->get()
			->result();
	}
	public function getWholesaler($cid)
	{
		return $this->db->select("*")
			->from("wholesaler")
			->where('wholesaler_company_id',$cid)
			->where('wholesaler_is_deleted!=1')
			->where('wholesaler_status!=1')
			->order_by('id','desc')
			->get()
			->result();
	}
		
	public function getDoctors($cid)
	{
		return $this->db->select("*")
			->from("doctors")
			->where('dr_company_id',$cid)
			->where('dr_is_deleted!=1')
			->where('dr_status!=1')
			->order_by('id','desc')
			->get()
			->result();
	} 
	
	
		
	public function read_target_by_id($id = null)
	{ 
		return $this->db->select("*")
			->from("visit_targets")
			->where('vt_id',$id)
			->get()
			->row();

	} 
	public function readTarget()
	{
		return $this->db->select("*")
			->from('visit_targets')
			->where('vt_is_deleted!=1')
			->order_by('vt_id','desc')
			->get()
			->result();
	} 
	
	
	public function read()
	{
		return $this->db->select("*")
			->from('visit_planner')
			->where('visit_is_deleted!=1')
			->order_by('visit_id','desc')
			->get()
			->result();
	} 
 
	public function read_by_id($id = null)
	{ 
		return $this->db->select("*")
			->from("visit_planner")
			->where('visit_id',$id)
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
    public function updateTarget($data = [])
	{
		
		return $this->db->where('vt_id',$data['vt_id'])
			->update('visit_targets',$data); 
	} 
	public function update($data = [])
	{
		
		return $this->db->where('visit_id',$data['visit_id'])
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
