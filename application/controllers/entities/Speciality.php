<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Speciality extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'entities/speciality_model',
			'pagination_model',
		));



	}
 
	public function index()
	{   
		$data['title'] = "Speciality List";		
		$data['specialities'] = $this->speciality_model->read();
		$data['content'] = $this->load->view('entities/speciality_view',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 
 
	public function speciality_list()
	{  
		$data['title'] = "Speciality List";
		if ($this->input->post('submit') != '') {
            $data['search'] = $postData = [               
                'sp_name' => $this->input->post('sp_name'),
            ];
            $this->session->set_userdata('search_speciality', $data['search']);
        } 
		$config["base_url"] = base_url('entities/speciality_list');
        $config["total_rows"] = $this->pagination_model->read_speciality_list_count('speciality', $this->session->userdata('search_speciality'));
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
        $data['specialities'] = $this->pagination_model->read_speciality_list($config["per_page"], $page, $this->session->userdata('search_speciality'));
        $data['content'] = $this->load->view('entities/speciality_view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
		
	} 
	
    public function speciality_form($id = null)
    { 
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('sp_name', display('sp_name') ,'required|min_length[1]');		
        /*-------------STORE DATA------------*/
        $curr_datetime = date("Y-m-d h:i");

        $data['speciality'] = (object)$postData = array( 
			'sp_id'	=> $this->input->post('sp_id'),
            'sp_name'       => trim($this->input->post('sp_name'))
        );  

				
        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) { 
				$sprow = $this->db->query("select sp_name from speciality where sp_name ='".trim($this->input->post('sp_name'))."' order by sp_name asc limit 1")->result();
			if(strtolower(trim($this->input->post('sp_name')))==strtolower($sprow[0]->sp_name))
			{
				 $this->session->set_flashdata('exception',"Speciality name already exists!");
				 redirect('entities/speciality/speciality_list');
			}
                if ($this->speciality_model->create($postData)) {					
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('entities/speciality/speciality_list');
            } else {
                $data['title'] = "Add Speciality";
                $data['content'] = $this->load->view('entities/speciality_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) { 
                if ($this->speciality_model->update($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('entities/speciality/speciality_form/'.$postData['sp_id']);
            } else {
                $data['title'] = "Edit Speciality";
                $data['speciality'] = $this->speciality_model->read_by_id($id);
                $data['content'] = $this->load->view('entities/speciality_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 
        } 
        /*---------------------------------*/
    }
 

    public function delete($id = null) 
    {
        if ($this->speciality_model->delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect('entities/speciality');
    }
  
	
}
