<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'client/doctor_model',
			'pagination_model',
		));

	}
 
	public function index()
	{   
		$data['title'] = "Doctor List";		
		$data['doctors'] = $this->doctor_model->read();
		$data['content'] = $this->load->view('client/doctor_view',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 
	public function getAssociatedMembers()
	{  
		$cid = $this->input->post('cid');
		$did = $this->input->post('did');
		
		$crows = $this->db->query("select * from members where emp_status!=1 and emp_is_deleted!=1  and emp_company_id =$cid order by emp_name asc")->result();
		if($did=="" || $did== null)
		{$did=0;}
												 

		$str ="";
	    foreach($crows as $crow){
			
		 $gmr = $this->db->query("select drmem_member_id from doctor_members where drmem_doctor_id = ".$did." AND drmem_member_id = ".$crow->id." AND drmem_is_deleted=0 order by drmem_id asc")->row();		
		 if($gmr->drmem_member_id == $crow->id) {  
		  $checked ='checked="checked"'; 
		  } else {
			 $checked ="";
		  }	
		
	      $str .="<li><label><input id=".$crow->emp_name." data-id=".$i." class='item-option1' value=".$crow->id." type='checkbox' name='assigned_members[]' $checked> $crow->emp_name</label></li>";	
	
		$i++; 
		}
	  
		echo $str;
	}
	
	
	
    public function getAssociatedProducts()
	{  
		$cid = $this->input->post('cid');
		$did = $this->input->post('did');
		$crows = $this->db->query("select * from products where product_status!=1 and product_is_deleted!=1 and product_company_id =$cid order by product_name asc")->result();
		$i=0;
		if($did=="" || $did== null)
		{$did=0;}
		
		$str ="";
		foreach($crows as $crow){
		
			
		$drpr = $this->db->query("select drprod_product_id from doctor_products where  drprod_doctor_id = ".$did." AND drprod_product_id = ".$crow->id." AND drprod_is_deleted =0")->row();	
			
		 if($drpr->drprod_product_id == $crow->id) {  
		  $checked ='checked="checked"'; 
		  } else {
			 $checked ="";
		  }	
		
	      $str .="<li><label><input id=".$crow->product_name." data-id=".$i." class='item-option' value=".$crow->id." type='checkbox' name='associated_products[]' $checked> $crow->product_name</label></li>";	
	
		$i++; 
		}
		echo $str;
	}
	public function doctor_list()
	{  
		$data['title'] = "Doctor List";
		if ($this->input->post('submit') != '') {
            $data['search'] = $postData = [               
                'dr_doctor_name' => $this->input->post('dr_doctor_name'),				
				'dr_comp_id' => $this->input->post('company_id')
            ];
            $this->session->set_userdata('search_doctor', $data['search']);
        }
		$config["base_url"] = base_url('client/doctor/doctor_list');
        $config["total_rows"] = $this->pagination_model->read_doctor_list_count('doctors', $this->session->userdata('search_doctor'));
        $config["per_page"] = 15;
        $config["uri_segment"] = 4;
        $config["num_links"] = 5;

        /* This Application Must Be Used With BootStrap 3 * */
        $config['next_link']        = 'Next';
		$config['prev_link']        = 'Prev';
		$config['first_link']       = false;
		$config['last_link']        = false;
		$config['full_tag_open']    = '<ul class="pagination justify-content-center">';
		$config['full_tag_close']   = '</ul>';
		$config['attributes']       = ['class' => 'page-link'];
		$config['first_tag_open']   = '<li class="page-item">';
		$config['first_tag_close']  = '</li>';
		$config['prev_tag_open']    = '<li class="page-item">';
		$config['prev_tag_close']   = '</li>';
		$config['next_tag_open']    = '<li class="page-item">';
		$config['next_tag_close']   = '</li>';
		$config['last_tag_open']    = '<li class="page-item">';
		$config['last_tag_close']   = '</li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['num_tag_open']     = '<li class="page-item">';
		$config['num_tag_close']    = '</li>';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data['links'] = $this->pagination->create_links();
        $data['doctors'] = $this->pagination_model->read_doctor_list($config["per_page"], $page, $this->session->userdata('search_doctor'));
        $data['content'] = $this->load->view('client/doctor_view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
		
		/*$data['members'] = $this->member_model->read();
		$data['content'] = $this->load->view('members/view',$data,true);
		$this->load->view('layout/main_wrapper',$data);*/
	} 
	
	public function details($member_id = null)
	{   
		$data['title'] = display('noticeboard');
		#-------------------------------#
		$data['member'] = $this->member_model->read_by_id($member_id);
		$data['content'] = $this->load->view('members/details',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 

    public function doctor_form($id = null)
    { 
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('dr_doctor_name', display('dr_doctor_name') ,'required|min_length[3]');
      //  $this->form_validation->set_rules('dr_docotor_id', display('dr_docotor_id'),'required|trim');
        /*-------------STORE DATA------------*/
        $curr_datetime = date("Y-m-d h:i");
		$associated_products = $this->input->post('associated_products');
		$assigned_members = $this->input->post('assigned_members');
	if ($this->input->post('id') == null) { //create a doctor  
        $data['doctor'] = (object)$postData = array( 
			'id'	=> $this->input->post('id'),
			'dr_company_id'          => $this->input->post('dr_company_id'),
            'dr_doctor_name'       => $this->input->post('dr_doctor_name'),
            'dr_doctor_id' => $this->input->post('dr_doctor_id', true),
            'dr_working_hours'  => $this->input->post('dr_working_hours'),
            'dr_email_address'   => $this->input->post('dr_email_address'),
            'dr_clinic_name'   => $this->input->post('dr_clinic_name'),
            'dr_speciality'      => $this->input->post('dr_speciality'),
			'dr_class'   => $this->input->post('dr_class'),
			'dr_segment'   => $this->input->post('dr_segment'),
			/*'dr_associated_products'   => $this->input->post('dr_associated_products'),	*/		
			'dr_contact_person'   => $this->input->post('dr_contact_person'),
			'dr_primary_contact'  => $this->input->post('dr_primary_contact'),
            'dr_secondary_contact'   => $this->input->post('dr_secondary_contact'),
            'dr_address'   => $this->input->post('dr_address'),
            'dr_city'      => $this->input->post('dr_city'),
			'dr_longitude'   => $this->input->post('dr_longitude'),
            'dr_latitude'      => $this->input->post('dr_latitude'),
			/*'dr_location_url'   => $this->input->post('dr_location_url'),
			'dr_region'   => $this->input->post('dr_region'),
			'dr_area'   => $this->input->post('dr_area'),			
			'dr_team_id'   => $this->input->post('dr_team_id'),
			'dr_historical_data'   => $this->input->post('dr_historical_data'),*/
			'dr_created_datetime'   => $curr_datetime
			
        );  
	}else { // update doctor
		$data['doctor'] = (object)$postDataUpdate = array( 
            'id'	=> $this->input->post('id'),
			'dr_company_id'          => $this->input->post('dr_company_id'),
            'dr_doctor_name'       => $this->input->post('dr_doctor_name'),
            'dr_doctor_id' => $this->input->post('dr_doctor_id', true),
            'dr_working_hours'  => $this->input->post('dr_working_hours'),
            'dr_email_address'   => $this->input->post('dr_email_address'),
            'dr_clinic_name'   => $this->input->post('dr_clinic_name'),
            'dr_speciality'      => $this->input->post('dr_speciality'),
			'dr_class'   => $this->input->post('dr_class'),
			'dr_segment'   => $this->input->post('dr_segment'),
			/*'dr_associated_products'   => $this->input->post('dr_associated_products'),	*/		
			'dr_contact_person'   => $this->input->post('dr_contact_person'),
			'dr_primary_contact'  => $this->input->post('dr_primary_contact'),
            'dr_secondary_contact'   => $this->input->post('dr_secondary_contact'),
            'dr_address'   => $this->input->post('dr_address'),
            'dr_city'      => $this->input->post('dr_city'),
			'dr_longitude'   => $this->input->post('dr_longitude'),
            'dr_latitude'      => $this->input->post('dr_latitude'),
			'dr_updated_datetime'   => $curr_datetime
           ); 
        }
		$company = $this->input->post('dr_company_id');
		$email = $this->input->post('dr_email_address');
        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) { 
				
				if(!empty($email)) {
					
				 $crow = $this->doctor_model->email_check($company,$email);
				 if($crow > 0){
				
				   $this->session->set_flashdata('exception', 'Email Name Already Exists');
				   $this->session->set_flashdata('dataArr', $postData);
                   redirect('client/doctor/doctor_form');
				 }   
				}
				
				
                if ($last_insert_id = $this->doctor_model->create($postData)) {	
				$this->doctor_model->create_associated_products($associated_products,$last_insert_id,$this->input->post('dr_company_id'));				
				$this->doctor_model->create_assigned_members($assigned_members,$last_insert_id,$this->input->post('dr_company_id'));
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('client/doctor/doctor_form');
            } else { 
                $data['title'] = "Add Doctor";
                $data['content'] = $this->load->view('client/doctor_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) { 
                if ($this->doctor_model->update($postDataUpdate)) {
					/////////////////////////////////////////////////////
				
				
				$this->db->where('drmem_doctor_id', $id)->delete('doctor_members');
				$this->db->where('drprod_doctor_id', $id)->delete('doctor_products');	
					
				$this->doctor_model->create_associated_products($associated_products,$id,$this->input->post('dr_company_id'));$this->doctor_model->create_assigned_members($assigned_members,$id,$this->input->post('dr_company_id'));
               
					
					////////////////////////////////////////////////////////
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('client/doctor/doctor_form/'.$postDataUpdate['id']);
            } else {
                $data['title'] = "Edit Doctor";
                $data['doctor'] = $this->doctor_model->read_by_id($id);
                $data['content'] = $this->load->view('client/doctor_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 
        } 
        /*---------------------------------*/
    }
    
	public function delete($id = null) 
    {
	
	    $cid = $_POST['cid'];
		$deletePassword = $_POST['deletePassword'];
		$logged_user	= $this->session->userdata('user_id');
		$row = $this->db->query("select * from users where us_id = $logged_user")->row();
		
		if( md5(trim($deletePassword)) != $row->us_password )
		{
		  echo json_encode(2);
		
		} else {
		$queryUpdate = $this->db->query("update doctors set dr_is_deleted =1 where id = $cid");  
 		  echo json_encode($queryUpdate);	
		}
	
	}

    public function deleteOld($id = null) 
    {
        if ($this->notice_model->delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect('noticeboard/notice');
    }
  
	
}
