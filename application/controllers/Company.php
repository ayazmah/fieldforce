<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'company_model',
			'setting_model'
        )); 
	    $this->load->library('session');	
    }
    
	
	
    public function index()
    {   
       
	   $data['title'] = 'Companies List';
	   $data['rows'] = $this->company_model->read();
	   $data['content'] = $this->load->view('company_view', $data, true);
	   $this->load->view('layout/main_wrapper', $data);
        
    }  
	
	public function delete()
    {
     
		$cid = $_POST['cid'];

		$deletePassword = $_POST['deletePassword'];
		$logged_user	= $this->session->userdata('user_id');
		$row = $this->db->query("select * from users where us_id = $logged_user")->row();
		
		if( md5(trim($deletePassword)) != $row->us_password )
		{
		  echo json_encode(2);
		
		} else {
		$queryUpdate = $this->db->query("update companies set comp_is_deleted =1 where comp_id = $cid");  
 		  echo json_encode($queryUpdate);	
		}
	}
    
	public function hierarchy()
    {
	    $data['title'] = 'Add Company Hierarchy';
        $data['content'] = $this->load->view('company_hierarchy', $data, true);
	    $this->load->view('layout/main_wrapper', $data);
		
	}
	
	public function hierarchyAdd()
    {
		$cid = $_POST['cid'];
		$name = $_POST['name'];
		$company_id = $_POST['company_id'];
        if($cid == 'treeview')
		$cid =0;
		
		$row = $this->db->query("select * from location where location_company_id =$company_id  and location_id = $cid")->row();
		
		if(count($row) > 0){
			
		 $level =$row->location_level+1;	
			
		} else{
			
		 $level =1;	
			
		}
		
		
		if($level != 6){
		
		$data = array(
		location_name => $name,
		location_company_id => $company_id,
		location_parent_id => $cid,
		location_level => $level	
		);
		$this->db->insert('location',$data);
		$id = $this->db->insert_id();
		echo json_encode($id);
		} else {
		echo json_encode(0);	
		}

	}
	
	
	public function renameNode($id = null)
    {
		$nid = $_POST['renameSelectedId'];
		$name = $_POST['renameSelectedName'];
		
		$companyId = $_POST['companyId'];
		
		$data = array(
		'location_name' => $name  
		
		);
		
		$row = $this->db->query("select location_parent_id from location where location_id = $nid")->row();
		
		if($row->location_parent_id !=0){
		$this->db->where('location_id', $nid);
		$flag = $this->db->update('location',$data);
		
		if ($flag) {
           $this->session->set_flashdata('message', 'Updated Successfully');
           } else {
		   $this->session->set_flashdata('exception', display('please_try_again')); 
         }
		
		} else {
			
		 $this->session->set_flashdata('exception', 'Root Node Cannot Be updated'); 	
			
		}
		
		redirect('company/hierarchy/'.$companyId);
	}
	
	
	
	public function hierarchyDelete()
    {
		$cid = $_POST['cid'];

		$deletePassword = $_POST['deletePassword'];
		$logged_user	= $this->session->userdata('user_id');
		$row = $this->db->query("select * from users where us_id = $logged_user")->row();
		
		if( md5(trim($deletePassword)) != $row->us_password )
		{
		  echo json_encode(2);
		
		} else {
			
		
		if(!empty($cid)){
			
			
			
			
			
		$row = $this->db->query("select location_id from location where location_parent_id = 0 and location_id = $cid")->row();
			
		if(count($row) > 0){
			
		 echo json_encode(0);
			
		} else {
			
		$queryParent = $this->db->query("update location set location_is_deleted =1 where location_parent_id = $cid");
		$result = $this->db->query("update location set location_is_deleted =1 where location_id = $cid");		
				
//		$queryParent = $this->db->query("delete from location where location_parent_id = $cid");
//		$result = $this->db->query("delete from location where location_id = $cid");	
		
		 echo json_encode($result);
		 }
		}
	  }	
	}
	
	public function hierarchyFetch()
    {
	    $cid = $_POST['company_id'];
		
		if(!empty($cid)) {
			
		$rows = $this->db->query("select * from location where location_is_deleted!=1 and location_company_id = $cid")->result_array();
		if(count($rows)>0) {	
		foreach($rows as $row)
		{
			$sub_data["id"] = $row["location_id"];
			$sub_data["name"] = $row["location_name"];
			$sub_data["text"] = $row["location_name"];
			$sub_data["parent_id"] = $row["location_parent_id"];
			$data[] = $sub_data;
		}
		foreach($data as $key => &$value)
		{
		    $output[$value["id"]] = &$value;
		}
		foreach($data as $key => &$value)
		{
		if($value["parent_id"] && isset($output[$value["parent_id"]]))
		{
			$output[$value["parent_id"]]["nodes"][] = &$value;
		}
		}
		foreach($data as $key => &$value)
		{
		if($value["parent_id"] && isset($output[$value["parent_id"]]))
		{
			unset($data[$key]);
		}
		}
		echo json_encode($data);
	  } else {
			$data = array();
		echo json_encode($data);
			
		}
		
	 } 
		
		
	}
	
	function get_top_parent($category_id, $root_id=0)
{
    // Grab the id's and category's
    $item_list = array();
    foreach($this->items as $item) {
        $item_list[$item['id']] = $item['category_id'];
    }

    $current_category = $category_id;

    while(TRUE) {
        if ($item_list[$current_category] == $root_id) {
            // Check to see if we have found the parent category.
            return $current_category;
        } else {
            // update our current category
            $current_category = $item_list[$current_category];
        }
    }

}
	
	
    public function add($id = null)
    {
        
		
		$this->form_validation->set_rules('comp_name', 'name', 'required');
		$this->form_validation->set_rules('comp_address', 'Address','required');
    	
		$data['record'] = (object)$postData = array(
			'comp_id' => $this->input->post('comp_id'),
            'comp_name' => $this->input->post('comp_name'),
			'comp_address' => $this->input->post('comp_address'),
			'comp_country_id' => $this->input->post('comp_country_id'),
			'comp_city_id' => $this->input->post('comp_city_id'),
			'comp_phone' => $this->input->post('comp_phone'),
			'comp_description' => $this->input->post('comp_description'),
			'comp_rateperuser' => $this->input->post('comp_rateperuser'),
			'comp_ratepermanager' => $this->input->post('comp_ratepermanager'),
			'comp_discount' => $this->input->post('comp_discount'),
			'comp_status' => $this->input->post('comp_status'),
			'comp_created_datetime' => date("Y-m-d h:i"),
        );
		
		$name =$this->input->post('comp_name');
		
		//$email = $this->input->post('us_email');
        /*-----------CHECK ID -----------*/
       
		if (empty($id)) {
		    /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) {
			    
				if(!empty($name)) {
					
				 $crow=$this->company_model->name_check($name);
				 if($crow > 0){
				
				   $this->session->set_flashdata('exception', 'Company Name Already Exists');
				   $this->session->set_flashdata('dataArr', $postData);
                   redirect('company/add/');
				 }   
				}
				 $company_id = $this->company_model->insert($postData);
                if ($company_id) {
					$crow = $this->company_model->read_by_id($company_id);
					$data = array(
					location_name => 'Pakistan',
					location_company_id => $company_id,
					location_parent_id => 0,
					location_level => 1	

					);
					$this->db->insert(location,$data);
					
                    #set success message
                    $this->session->set_flashdata('message', 'Added Successfully');
                } else {
				    
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
			
                redirect('company/add/');
            } else {
             
                $data['title'] = 'Add Company';
                $data['content'] = $this->load->view('company_form', $data, true);
				$this->load->view('layout/main_wrapper', $data);
            }
		} else {
		   
		   if ($this->form_validation->run() === true) {
                if ($this->company_model->update($postData)) {
				  
                    #set success message
                    $this->session->set_flashdata('message', 'Updated Successfully');
                } else {
				    
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
			
                redirect('company/add/'.$postData['comp_id']);
            } else {
             
                $data['title'] = 'Edit Company';
			    $data['row'] = $this->company_model->read_by_id($id);
                $data['content'] = $this->load->view('company_form', $data, true);
				$this->load->view('layout/main_wrapper', $data);
            }	
			
			
		}
       
        /*---------------------------------*/
    }
    
 
}
