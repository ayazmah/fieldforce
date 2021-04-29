<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosageform extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'entities/dosageform_model',
			'pagination_model',
		));



	}
 
	public function index()
	{   
		$data['title'] = "Dosage Form List";		
		$data['dosageforms'] = $this->dosageform_model->read();
		$data['content'] = $this->load->view('entities/dosageform_view',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 
 
	public function dosageform_list()
	{  
		$data['title'] = "Dosage Form List";
		if ($this->input->post('submit') != '') {
            $data['search'] = $postData = [               
                'dosageform_name' => $this->input->post('dosageform_name'),
            ];
            $this->session->set_userdata('search_dosageform', $data['search']);
        }
		$config["base_url"] = base_url('entities/dosageform_list');
        $config["total_rows"] = $this->pagination_model->read_dosageform_list_count('dosage_form', $this->session->userdata('search_dosageform'));
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
        $data['dosageforms'] = $this->pagination_model->read_dosageform_list($config["per_page"], $page, $this->session->userdata('search_dosageform'));
        $data['content'] = $this->load->view('entities/dosageform_view', $data, true);
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

    public function dosageform_form($id = null)
    { 
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('dosageform_name', display('dosageform_name') ,'required|min_length[2]');
        /*-------------STORE DATA------------*/
        $curr_datetime = date("Y-m-d h:i");

        $data['dosageform'] = (object)$postData = array( 
			'df_id'	=> $this->input->post('id'),
            'df_name'       => trim($this->input->post('dosageform_name'))
        );  

				
        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
				if ($this->form_validation->run() === true) { 
					$dfrow = $this->db->query("select df_name from dosage_form where df_name ='".trim($this->input->post('dosageform_name'))."' order by df_name asc limit 1")->result();
				if(strtolower(trim($this->input->post('dosageform_name')))==strtolower($dfrow[0]->df_name))
				{
					 $this->session->set_flashdata('exception',"Dosage Form already exists!");
					 redirect('entities/dosageform/dosageform_list');
				}
				
                if ($this->dosageform_model->create($postData)) {					
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('entities/dosageform/dosageform_list');
            } else {
                $data['title'] = "Add Dosage Form";
                $data['content'] = $this->load->view('entities/dosageform_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) { 
                if ($this->dosageform_model->update($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('entities/dosageform/dosageform_form/'.$postData['df_id']);
            } else {
                $data['title'] = "Edit Dosage Form";
                $data['dosageform'] = $this->dosageform_model->read_by_id($id);
                $data['content'] = $this->load->view('entities/dosageform_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 
        } 
        /*---------------------------------*/
    }
 

    public function delete($id = null) 
    {
        if ($this->dosageform_model->delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect('entities/dosageform/dosageform_list');
    }
  
	
}
