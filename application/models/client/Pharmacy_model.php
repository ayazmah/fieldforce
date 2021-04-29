<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pharmacy_model extends CI_Model {

	private $table = 'pharmacy';

	public function create($data = [])
	{	 
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
 
 	public function create_associated_products($associated_products,$pharmacy_id,$company_id)
	{	
		for($j=0; $j < count($associated_products); $j++)  
	    {  
		
			if($j < (count($associated_products)))
			{ 
				$data['pharmprod_products'] = (object)$postData = array( 					
					'pharmprod_company_id'          => $company_id,
					'pharmprod_pharmacy_id'          => $pharmacy_id,
					'pharmprod_product_id'          => $associated_products[$j],
					'pharmprod_is_deleted'   => 0
				);  
				$this->db->insert("pharmacy_products",$postData);
			}
	   	}   
		
		return;
	}
	
	public function create_assigned_members($assigned_members,$pharmacy_id,$company_id)
	{	
		for($j=0; $j < count($assigned_members); $j++)  
	    {  		
			if($j < (count($assigned_members)))
			{ 
				$data['pharmacy_members'] = (object)$postData = array( 					
					'pharmem_company_id'          => $company_id,
					'pharmem_pharmacy_id'          => $pharmacy_id,
					'pharmem_member_id'          => $assigned_members[$j],
					'pharmem_is_deleted'   => 0
				);  
				$this->db->insert("pharmacy_members",$postData);
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
 
 	public function update_associated_products($associated_products,$pharmacy_id,$company_id)
	{
		for($j=0; $j < count($associated_products); $j++)  
	    {  
			if($j < (count($associated_products)))
			{ 
				$data['pharmacy_products'] = (object)$postData = array( 					
					'pharmprod_company_id'          => $company_id,
					'pharmprod_pharmacy_id'          => $pharmacy_id,
					'pharmprod_product_id'          => $associated_products[$j],
					'pharmprod_is_deleted'   => 0
				);  
						
				$res = $this->db->select("*")
					->from("pharmacy_products")
					->where('pharmprod_product_id',$associated_products[$j])->where('pharmprod_pharmacy_id',$pharmacy_id)->where('pharmprod_company_id',$company_id)
					->order_by('pharmprod_id','desc')
					->get()
					->row(); 
					if(count($res)>0){						
						$this->db->where('pharmprod_id',$pharmacy_id)
							->update("pharmacy_products",$postData); 
					}
					else
					{
						$this->db->insert("pharmacy_products",$postData);
					}
			}
	   	}   
		return ;
	} 
	
	public function update_assigned_members($assigned_members,$pharmacy_id,$company_id)
	{
		for($j=0; $j < count($assigned_members); $j++)  
	    {  
			if($j < (count($assigned_members)))
			{ 
				$data['pharmacy_members'] = (object)$postData = array( 					
					'pharmem_company_id'          => $company_id,
					'pharmem_pharmacy_id'          => $pharmacy_id,
					'pharmem_member_id'          => $assigned_members[$j],
					'pharmem_is_deleted'   => 0
				);  
				
				$res = $this->db->select("*")
					->from("pharmacy_members")
					->where('pharmem_member_id',$assigned_members[$j])->where('pharmem_pharmacy_id',$pharmacy_id)->where('pharmem_company_id',$company_id)
					->order_by('pharmem_id','desc')
					->get()
					->row();
					if(count($res)>0){						
						$this->db->where('pharmem_id',$pharmacy_id)
							->update("pharmacy_members",$postData); 
					}
					else
					{
						$this->db->insert("pharmacy_members",$postData);
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
