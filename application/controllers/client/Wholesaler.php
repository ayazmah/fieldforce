<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wholesaler extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'client/wholesaler_model',
			'pagination_model',
		));


	}
 
	public function index()
	{   
		$data['title'] = "Wholesaler List";		
		$data['wholesalers'] = $this->wholesaler_model->read();
		$data['content'] = $this->load->view('client/wholesaler_view',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 
 
	public function wholesaler_list()
	{  
		$data['title'] = "Wholesaler List";
		if ($this->input->post('submit') != '') {
            $data['search'] = $postData = [               
                'wholesaler_name' => $this->input->post('wholesaler_name'),
				'wholesaler_comp_id' => $this->input->post('company_id')
            ];
            $this->session->set_userdata('search_wholesaler', $data['search']);
        }
		$config["base_url"] = base_url('client/wholesaler/wholesaler_list');
        $config["total_rows"] = $this->pagination_model->read_wholesaler_list_count('wholesaler', $this->session->userdata('search_wholesaler'));
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
        $data['wholesalers'] = $this->pagination_model->read_wholesaler_list($config["per_page"], $page, $this->session->userdata('search_wholesaler'));
        $data['content'] = $this->load->view('client/wholesaler_view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
		
		/*$data['members'] = $this->member_model->read();
		$data['content'] = $this->load->view('members/view',$data,true);
		$this->load->view('layout/main_wrapper',$data);*/
	} 
	
	public function details($member_id = null)
	{   
		$data['title'] = display('wholesaler');
		#-------------------------------#
		$data['member'] = $this->member_model->read_by_id($member_id);
		$data['content'] = $this->load->view('members/details',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 

    public function wholesaler_form($id = null)
    { 
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('wholesaler_name', display('wholesaler_name') ,'required|min_length[3]');
      //  $this->form_validation->set_rules('dr_docotor_id', display('dr_docotor_id'),'required|trim');
        /*-------------STORE DATA------------*/
        $curr_datetime = date("Y-m-d h:i");
		$associated_products = $this->input->post('assigned_members');
		$assigned_members = $this->input->post('assigned_members');
		if ($this->input->post('id') == null) { //create a wholesaler  
        $data['wholesaler'] = (object)$postData = array( 
			'id'	=> $this->input->post('id'),
			'wholesaler_company_id'          => $this->input->post('wholesaler_company_id'),
            'wholesaler_name'       => trim($this->input->post('wholesaler_name')),
            'wholesaler_ID' => trim($this->input->post('wholesaler_ID', true)),
            'wholesaler_working_hours'  => $this->input->post('wholesaler_working_hours'),
            'wholesaler_email_address'   => trim($this->input->post('wholesaler_email_address')),
            'wholesaler_class'   => $this->input->post('wholesaler_class'),
            'wholesaler_segment'      => $this->input->post('wholesaler_segment'),			
			'wholesaler_contact_person'   => trim($this->input->post('wholesaler_contact_person')),
			'wholesaler_primary_contact'  => trim($this->input->post('wholesaler_primary_contact')),
            'wholesaler_secondary_contact'   => trim($this->input->post('wholesaler_secondary_contact')),
            'wholesaler_address'   => trim($this->input->post('wholesaler_address')),
            'wholesaler_city'      => $this->input->post('wholesaler_city'),
			'wholesaler_longitude'   => trim($this->input->post('wholesaler_longitude')),
			'wholesaler_latitude'   => trim($this->input->post('wholesaler_latitude')),
			'wholesaler_remarks'   => trim($this->input->post('wholesaler_remarks')),
			'wholesaler_created_datetime'   => $curr_datetime
        );  
		}else{
			$data['wholesaler'] = (object)$postDataUpdate = array( 
			'id'	=> $this->input->post('id'),
			'wholesaler_company_id'          => $this->input->post('wholesaler_company_id'),
            'wholesaler_name'       => trim($this->input->post('wholesaler_name')),
            'wholesaler_ID' => trim($this->input->post('wholesaler_ID', true)),
            'wholesaler_working_hours'  => $this->input->post('wholesaler_working_hours'),
            'wholesaler_email_address'   => trim($this->input->post('wholesaler_email_address')),
            'wholesaler_class'   => $this->input->post('wholesaler_class'),
            'wholesaler_segment'      => $this->input->post('wholesaler_segment'),			
			'wholesaler_contact_person'   => trim($this->input->post('wholesaler_contact_person')),
			'wholesaler_primary_contact'  => trim($this->input->post('wholesaler_primary_contact')),
            'wholesaler_secondary_contact'   => trim($this->input->post('wholesaler_secondary_contact')),
            'wholesaler_address'   => trim($this->input->post('wholesaler_address')),
            'wholesaler_city'      => $this->input->post('wholesaler_city'),
			'wholesaler_longitude'   => trim($this->input->post('wholesaler_longitude')),
			'wholesaler_latitude'   => trim($this->input->post('wholesaler_latitude')),
			'wholesaler_remarks'   => trim($this->input->post('wholesaler_remarks')),
			'wholesaler_updated_datetime'   => $curr_datetime
			);
			}
				
        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) { 
                if ($last_insert_id = $this->wholesaler_model->create($postData)) {	
				$this->wholesaler_model->create_associated_products($associated_products,$last_insert_id,$this->input->post('wholesaler_company_id'));		
				$this->wholesaler_model->create_assigned_members($assigned_members,$last_insert_id,$this->input->post('wholesaler_company_id'));		
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('client/wholesaler/wholesaler_form');
            } else {
                $data['title'] = "Add Wholesaler";
                $data['content'] = $this->load->view('client/wholesaler_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) { 
                if ($this->wholesaler_model->update($postDataUpdate)) {
					$this->wholesaler_model->update_associated_products($associated_products,$this->input->post('id'),$this->input->post('wholesaler_company_id'));
					$this->wholesaler_model->update_assigned_members($assigned_members,$this->input->post('id'),$this->input->post('wholesaler_company_id'));
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('client/wholesaler/wholesaler_form/'.$postData['id']);
            } else {
                $data['title'] = "Edit Wholesaler";
                $data['wholesaler'] = $this->wholesaler_model->read_by_id($id);
                $data['content'] = $this->load->view('client/wholesaler_form',$data,true);
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
		$queryUpdate = $this->db->query("update wholesaler set wholesaler_is_deleted =1 where id = $cid");  
 		  echo json_encode($queryUpdate);	
		}
	
	}
    public function deleteOld($id = null) 
    {
        if ($this->wholesaler_model->delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect('client/wholesaler');
    }
  
	
}
