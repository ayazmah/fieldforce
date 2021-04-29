<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Groups_model extends CI_Model {

	private $table = 'groups';
	private $table_group_members = 'group_members';

	public function create($data = [])
	{	 
		 $this->db->insert($this->table,$data);
		 return $this->db->insert_id();
	}
 	public function create_assigned_members($assigned_members,$group_id,$company_id)
	{	
		for($j=0; $j < count($assigned_members); $j++)  
	    {  
		
			if($j < (count($assigned_members)))
			{ 
				$data['group_members'] = (object)$postData = array( 					
					'gm_company_id'          => $company_id,
					'gm_group_id'          => $group_id,
					'gm_member_id'          => $assigned_members[$j],
					'gm_is_deleted'   => 0
				);  
				$this->db->insert("group_members",$postData);
			}
	   	}   
		
		return;
	}
	public function create_assigned_products($assigned_products,$group_id,$company_id)
	{	
		for($j=0; $j < count($assigned_products); $j++)  
	    {  
		
			if($j < (count($assigned_products)))
			{ 
				$data['group_products'] = (object)$postData = array( 					
					'gp_company_id'          => $company_id,
					'gp_group_id'          => $group_id,
					'gp_product_id'          => $assigned_products[$j],
					'gp_is_deleted'   => 0
				);  
				$this->db->insert("group_products",$postData);
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
 
 	public function update_assigned_members($assigned_members,$group_id,$company_id)
	{
		for($j=0; $j < count($assigned_members); $j++)  
	    {  
			if($j < (count($assigned_members)))
			{ 
				$data['group_members'] = (object)$postData = array( 					
					'gm_company_id'          => $company_id,
					'gm_group_id'          => $group_id,
					'gm_member_id'          => $assigned_members[$j],
					'gm_is_deleted'   => 0
				);  
				
				$res = $this->db->select("*")
					->from("group_members")
					->where('gm_member_id',$assigned_members[$j])->where('gm_group_id',$group_id)->where('gm_company_id',$company_id)
					->order_by('gm_id','desc')
					->get()
					->row();
					if(count($res)>0){						
						$this->db->where('gm_id',$group_id)
							->update("group_members",$postData); 
					}
					else
					{
						$this->db->insert("group_members",$postData);
					}				
				
			}
	   	}   
		return ;
	} 
	
	public function update_assigned_products($assigned_products,$group_id,$company_id)
	{
		for($j=0; $j < count($assigned_products); $j++)  
	    {  
			if($j < (count($assigned_products)))
			{ 
				$data['group_products'] = (object)$postData = array( 					
							'gp_company_id'          => $company_id,
							'gp_group_id'          => $group_id,
							'gp_product_id'          => $assigned_products[$j],
							'gp_is_deleted'   => 0
						);  
						
				$res = $this->db->select("*")
					->from("group_products")
					->where('gp_product_id',$assigned_products[$j])->where('gp_group_id',$group_id)->where('gp_company_id',$company_id)
					->order_by('gp_id','desc')
					->get()
					->row(); 
					if(count($res)>0){						
						$this->db->where('gp_id',$group_id)
							->update("group_products",$postData); 
					}
					else
					{
						$this->db->insert("group_products",$postData);
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
