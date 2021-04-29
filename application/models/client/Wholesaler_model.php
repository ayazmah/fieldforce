<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Wholesaler_model extends CI_Model {

	private $table = 'wholesaler';

	public function create($data = [])
	{	 
		 $this->db->insert($this->table,$data);
		 return $this->db->insert_id();
	}
	
 	public function create_associated_products($associated_products,$wholesaler_id,$company_id)
	{	
		for($j=0; $j < count($associated_products); $j++)  
	    {  
		
			if($j < (count($associated_products)))
			{ 
				$data['wholesaler_products'] = (object)$postData = array( 					
					'whprod_company_id'          => $company_id,
					'whprod_wholesaler_id'          => $wholesaler_id,
					'whprod_product_id'          => $associated_products[$j],
					'whprod_is_deleted'   => 0
				);  
				$this->db->insert("wholesaler_products",$postData);
			}
	   	}   
		
		return;
	}
	
	public function create_assigned_members($assigned_members,$wholesaler_id,$company_id)
	{	
		for($j=0; $j < count($assigned_members); $j++)  
	    {  		
			if($j < (count($assigned_members)))
			{ 
				$data['wholesaler_members'] = (object)$postData = array( 					
					'whmem_company_id'          => $company_id,
					'whmem_wholesaler_id'          => $wholesaler_id,
					'whmem_member_id'          => $assigned_members[$j],
					'whmem_is_deleted'   => 0
				);  
				$this->db->insert("wholesaler_members",$postData);
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
 
 	public function update_associated_products($associated_products,$wholesaler_id,$company_id)
	{
		for($j=0; $j < count($associated_products); $j++)  
	    {  
			if($j < (count($associated_products)))
			{ 
				$data['wholesaler_products'] = (object)$postData = array( 					
					'whprod_company_id'          => $company_id,
					'whprod_wholesaler_id'          => $wholesaler_id,
					'whprod_product_id'          => $associated_products[$j],
					'whprod_is_deleted'   => 0
				);  
						
				$res = $this->db->select("*")
					->from("wholesaler_products")
					->where('whprod_product_id',$associated_products[$j])->where('whprod_wholesaler_id',$wholesaler_id)->where('whprod_company_id',$company_id)
					->order_by('whprod_id','desc')
					->get()
					->row(); 
					if(count($res)>0){						
						$this->db->where('whprod_id',$pharmacy_id)
							->update("wholesaler_products",$postData); 
					}
					else
					{
						$this->db->insert("wholesaler_products",$postData);
					}
			}
	   	}   
		return ;
	} 
	
	public function update_assigned_members($assigned_members,$wholesaler_id,$company_id)
	{
		for($j=0; $j < count($assigned_members); $j++)  
	    {  
			if($j < (count($assigned_members)))
			{ 
				$data['wholesaler_members'] = (object)$postData = array( 					
					'whmem_company_id'          => $company_id,
					'whmem_wholesaler_id'          => $wholesaler_id,
					'whmem_member_id'          => $assigned_members[$j],
					'whmem_is_deleted'   => 0
				);  
				
				$res = $this->db->select("*")
					->from("wholesaler_members")
					->where('whmem_member_id',$assigned_members[$j])->where('whmem_wholesaler_id',$wholesaler_id)->where('whmem_company_id',$company_id)
					->order_by('whmem_id','desc')
					->get()
					->row();
					if(count($res)>0){						
						$this->db->where('whmem_id',$doctor_id)
							->update("wholesaler_members",$postData); 
					}
					else
					{
						$this->db->insert("wholesaler_members",$postData);
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
