<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor_model extends CI_Model {

	private $table = 'doctors';

	public function create($data = [])
	{	 
		 $this->db->insert($this->table,$data);
		  return $this->db->insert_id();
	}
	
	
	public function email_check($company,$email)
    {
        $emailExists = $this->db->select('dr_email_address')
            ->where('dr_email_address', $email)
			->where('dr_company_id', $company)
            ->get('doctors')
            ->num_rows();

        return $emailExists;
    }
 
 	public function create_associated_products($associated_products,$doctor_id,$company_id)
	{	
		for($j=0; $j < count($associated_products); $j++)  
	    {  
		
			if($j < (count($associated_products)))
			{ 
				$data['doctor_products'] = (object)$postData = array( 					
					'drprod_company_id'          => $company_id,
					'drprod_doctor_id'          => $doctor_id,
					'drprod_product_id'          => $associated_products[$j],
					'drprod_is_deleted'   => 0
				);  
				$this->db->insert("doctor_products",$postData);
			}
	   	}   
		
		return;
	}
	
	public function create_assigned_members($assigned_members,$doctor_id,$company_id)
	{	
		for($j=0; $j < count($assigned_members); $j++)  
	    {  		
			if($j < (count($assigned_members)))
			{ 
				$data['doctor_members'] = (object)$postData = array( 					
					'drmem_company_id'          => $company_id,
					'drmem_doctor_id'          => $doctor_id,
					'drmem_member_id'          => $assigned_members[$j],
					'drmem_is_deleted'   => 0
				);  
				$this->db->insert("doctor_members",$postData);
			}
	   	}   
		
		return;
	}
	
	public function read()
	{
		return $this->db->select("*")
			->from($this->table)
			->order_by('id','desc')
			->get()
			->result();
	} 
 
	public function read_by_id($id = null)
	{ 
		return $this->db->select("*")
			->from($this->table)
			->where('id',$id)
			->order_by('id','desc')
			->get()
			->row();

	} 
 
	public function update($data = [])
	{
		return $this->db->where('id',$data['id'])
			->update($this->table,$data); 
	} 
 
	public function update_associated_products($associated_products,$doctor_id,$company_id)
	{
		for($j=0; $j < count($associated_products); $j++)  
	    {  
			if($j < (count($associated_products)))
			{ 
				$data['doctor_products'] = (object)$postData = array( 					
					'drprod_company_id'          => $company_id,
					'drprod_doctor_id'          => $doctor_id,
					'drprod_product_id'          => $associated_products[$j],
					'drprod_is_deleted'   => 0
				);  
						
				$res = $this->db->select("*")
					->from("doctor_products")
					->where('drprod_product_id',$associated_products[$j])->where('drprod_doctor_id',$doctor_id)->where('drprod_company_id',$company_id)
					->order_by('drprod_id','desc')
					->get()
					->row(); 
					if(count($res)>0){						
						$this->db->where('drprod_id',$doctor_id)
							->update("doctor_products",$postData); 
					}
					else
					{
						$this->db->insert("doctor_products",$postData);
					}
			}
	   	}   
		return ;
	} 
	
	public function update_assigned_members($assigned_members,$doctor_id,$company_id)
	{
		for($j=0; $j < count($assigned_members); $j++)  
	    {  
			if($j < (count($assigned_members)))
			{ 
				$data['doctor_members'] = (object)$postData = array( 					
					'drmem_company_id'          => $company_id,
					'drmem_group_id'          => $doctor_id,
					'drmem_member_id'          => $assigned_members[$j],
					'drmem_is_deleted'   => 0
				);  
				
				$res = $this->db->select("*")
					->from("doctor_members")
					->where('drmem_member_id',$assigned_members[$j])->where('drmem_doctor_id',$doctor_id)->where('drmem_company_id',$company_id)
					->order_by('drmem_id','desc')
					->get()
					->row();
					if(count($res)>0){						
						$this->db->where('drmem_id',$doctor_id)
							->update("doctor_members",$postData); 
					}
					else
					{
						$this->db->insert("doctor_members",$postData);
					}				
				
			}
	   	}   
		return ;
	} 
	
	public function delete($id = null)
	{
		$this->db->where('id',$id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	} 
 
	
 }
