<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'team_model'
		));

        

	}
 
	public function index()
	{  
		$data['title'] = "Teams List";		
		$data['teams'] = $this->team_model->read();
		$data['content'] = $this->load->view('team_view',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 
 
	public function view()
	{  
		$data['title'] = "Members List";
		
		$config["base_url"] = base_url('member/members_list');
        $config["total_rows"] = $this->pagination_model->read_member_list_count('members', $this->session->userdata('search_patient'));
        $config["per_page"] = 5;
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
        $data['members'] = $this->pagination_model->read_member_list('members', $config["per_page"], $page, $this->session->userdata('search_patient'));
        $data['content'] = $this->load->view('team_view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
		
		/*$data['members'] = $this->member_model->read();
		$data['content'] = $this->load->view('view',$data,true);
		$this->load->view('layout/main_wrapper',$data);*/
	} 
	
	public function details($member_id = null)
	{   
		$data['title'] = display('noticeboard');
		#-------------------------------#
		$data['member'] = $this->member_model->read_by_id($member_id);
		$data['content'] = $this->load->view('details',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 

    public function add($id = null)
    { 
	
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('team_name', display('team_name') ,'required|min_length[3]');
        //$this->form_validation->set_rules('team_id', display('team_id'),'required|trim');
        /*-------------STORE DATA------------*/
        $curr_datetime = date("Y-m-d h:i");

        $data['team'] = (object)$postData = array( 
			'company_id'=> $this->input->post('company_id'),
            'team_name' => $this->input->post('team_name'),
            'campaign_id' => 1,
            'region_id'  => $this->input->post('region_id'),
            'area_id'   => $this->input->post('area_id'),
            'geofence_id'   => $this->input->post('geofence_id'),
            'regional_manager_id'      => $this->input->post('regional_manager_id'),
			'area_manager_id'   => $this->input->post('area_manager_id'),
			'teamlead_id'   => $this->input->post('teamlead_id'),
			'assigned_members'   => $this->input->post('assigned_members'),			
			'assigned_products'   => $this->input->post('assigned_products'),
			'datetime'   => $curr_datetime
        );  

				
        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) { 
				$insert_id = $this->team_model->create($postData);
                if ($insert_id) {
					
					$rec = array( 
                    'team_id'=> $insert_id.'-'.$this->input->post('company_id').'TMFF'
                   );

					$this->db->where('id', $insert_id);
					$this->db->update('team_management', $rec);
					
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('team/add');
            } else {
                $data['title'] = "Add Team";
                $data['content'] = $this->load->view('team_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) { 
                if ($this->member_model->update($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('member/add/'.$postData['id']);
            } else {
				
                $data['title'] = "Edit Team";
                $data['team'] = $this->team_model->read_by_id($id);
                $data['content'] = $this->load->view('team_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 
        } 
        /*---------------------------------*/
    }
 

    public function delete($id = null) 
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
