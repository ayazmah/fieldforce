<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pharmacy extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'client/pharmacy_model',
			'pagination_model',
		));



	}
 
	public function index()
	{   
		$data['title'] = "Pharmacy List";		
		$data['pharmacies'] = $this->pharmacy_model->read();
		$data['content'] = $this->load->view('client/pharmacy_view',$data,true);
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
			
		 $gmr = $this->db->query("select pharmem_member_id from pharmacy_members where pharmem_pharmacy_id = ".$did." AND pharmem_member_id = ".$crow->id." AND pharmem_is_deleted=0")->row();		
		 if($gmr->pharmem_member_id == $crow->id) {  
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
		
			
		echo $drpr = $this->db->query("select pharmprod_product_id from pharmacy_products where pharmprod_pharmacy_id = ".$did." AND pharmprod_product_id = ".$crow->id." AND pharmprod_is_deleted =0")->row();	
			
		 if($drpr->pharmprod_product_id == $crow->id) {  
		  $checked ='checked="checked"'; 
		  } else {
			 $checked ="";
		  }	
		
	      $str .="<li><label><input id=".$crow->product_name." data-id=".$i." class='item-option' value=".$crow->id." type='checkbox' name='associated_products[]' $checked> $crow->product_name</label></li>";	
	
		$i++; 
		}
		echo $str;
	}
	
	public function pharmacy_list()
	{  
		$data['title'] = "Pharmacy List";
		if ($this->input->post('submit') != '') {
            $data['search'] = $postData = [               
                'pharm_pharmacy_name' => $this->input->post('pharm_pharmacy_name'),
				'pharm_comp_id' => $this->input->post('company_id')
            ];
            $this->session->set_userdata('search_pharmacy', $data['search']);
        }
		$config["base_url"] = base_url('client/pharmacy/pharmacy_list');
        $config["total_rows"] = $this->pagination_model->read_pharmacy_list_count('pharmacy', $this->session->userdata('search_pharmacy'));
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
        $data['pharmacies'] = $this->pagination_model->read_pharmacy_list($config["per_page"], $page, $this->session->userdata('search_pharmacy'));
        $data['content'] = $this->load->view('client/pharmacy_view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
		
		/*$data['members'] = $this->member_model->read();
		$data['content'] = $this->load->view('members/view',$data,true);
		$this->load->view('layout/main_wrapper',$data);*/
	} 

    public function pharmacy_form($id = null)
    { 
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('pharm_pharmacy_name', display('pharm_pharmacy_name') ,'required|min_length[3]');
      //  $this->form_validation->set_rules('dr_docotor_id', display('dr_docotor_id'),'required|trim');
        /*-------------STORE DATA------------*/
        $curr_datetime = date("Y-m-d h:i");
		$associated_products = $this->input->post('assigned_members');
		$assigned_members = $this->input->post('assigned_members');
		if ($this->input->post('id') == null) { //create a pharmacy  
        $data['pharmacy'] = (object)$postData = array( 
			'id'	=> $this->input->post('id'),
			'pharm_company_id'          => $this->input->post('pharm_company_id'),
            'pharm_pharmacy_name'       => trim($this->input->post('pharm_pharmacy_name')),
            'pharm_pharmacy_ID' => trim($this->input->post('pharm_pharmacy_ID', true)),
            'pharm_working_hours'  => $this->input->post('pharm_working_hours'),
            'pharm_email_address'   => trim($this->input->post('pharm_email_address')),
            'pharm_class'   => $this->input->post('pharm_class'),
            'pharm_segment'      => $this->input->post('pharm_segment'),			
			'pharm_contact_person'   => trim($this->input->post('pharm_contact_person')),
			'pharm_primary_contact'  => $this->input->post('pharm_primary_contact'),
            'pharm_secondary_contact'   => $this->input->post('pharm_secondary_contact'),
            'pharm_address'   => trim($this->input->post('pharm_address')),
            'pharm_city'      => $this->input->post('pharm_city'),
			'pharm_longitude'   => trim($this->input->post('pharm_longitude')),
			'pharm_latitude'   => trim($this->input->post('pharm_latitude')),
			'pharm_created_datetime'   => $curr_datetime
        );  
		}else{
			$data['pharmacy'] = (object)$postDataUpdate = array( 
			'id'	=> $this->input->post('id'),
			'pharm_company_id'          => $this->input->post('pharm_company_id'),
            'pharm_pharmacy_name'       => trim($this->input->post('pharm_pharmacy_name')),
            'pharm_pharmacy_ID' => trim($this->input->post('pharm_pharmacy_ID', true)),
            'pharm_working_hours'  => $this->input->post('pharm_working_hours'),
            'pharm_email_address'   => trim($this->input->post('pharm_email_address')),
            'pharm_class'   => $this->input->post('pharm_class'),
            'pharm_segment'      => $this->input->post('pharm_segment'),			
			'pharm_contact_person'   => trim($this->input->post('pharm_contact_person')),
			'pharm_primary_contact'  => trim($this->input->post('pharm_primary_contact')),
            'pharm_secondary_contact'   => trim($this->input->post('pharm_secondary_contact')),
            'pharm_address'   => trim($this->input->post('pharm_address')),
            'pharm_city'      => $this->input->post('pharm_city'),
			'pharm_longitude'   => trim($this->input->post('pharm_longitude')),
			'pharm_latitude'   => trim($this->input->post('pharm_latitude')),
			'pharm_updated_datetime'   => $curr_datetime
        ); 
			}
				
        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) { 
                if ($last_insert_id = $this->pharmacy_model->create($postData)) {		
				$this->pharmacy_model->create_associated_products($associated_products,$last_insert_id,$this->input->post('pharm_company_id'));		
				$this->pharmacy_model->create_assigned_members($assigned_members,$last_insert_id,$this->input->post('pharm_company_id'));					
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('client/pharmacy/pharmacy_form');
            } else {
                $data['title'] = "Add Pharmacy";
                $data['content'] = $this->load->view('client/pharmacy_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) { 
                if ($this->pharmacy_model->update($postDataUpdate)) {
					
					$this->db->where('pharmem_id', $id)->delete('pharmacy_members');
					$this->db->where('pharmprod_id', $id)->delete('pharmacy_products');	

					$this->pharmacy_model->create_associated_products($associated_products,$id,$this->input->post('pharm_company_id'));
					$this->pharmacy_model->create_assigned_members($assigned_members,$id,$this->input->post('pharm_company_id'));
					#set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('client/pharmacy/pharmacy_form/'.$postData['id']);
            } else {
                $data['title'] = "Edit Pharmacy";
                $data['pharmacy'] = $this->pharmacy_model->read_by_id($id);
                $data['content'] = $this->load->view('client/pharmacy_form',$data,true);
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
		$queryUpdate = $this->db->query("update pharmacy set pharm_is_deleted =1 where id = $cid");  
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
