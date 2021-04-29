<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosage extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'entities/dosage_model',
			'pagination_model',
		));


	}
 
	public function index()
	{   
		$data['title'] = "Dosage List";		
		$data['dosages'] = $this->dosage_model->read();
		$data['content'] = $this->load->view('entities/dosage_view',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 
 
	public function dosage_list()
	{  
		$data['title'] = "Dosage List";
		if ($this->input->post('submit') != '') {
            $data['search'] = $postData = [               
                'dosage_name' => $this->input->post('dosage_name'),
            ];
            $this->session->set_userdata('search_dosage', $data['search']);
        }
		$config["base_url"] = base_url('entities/dosage_list');
        $config["total_rows"] = $this->pagination_model->read_dosage_list_count('dosage', $this->session->userdata('search_dosage'));
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
        $data['dosages'] = $this->pagination_model->read_dosage_list($config["per_page"], $page, $this->session->userdata('search_dosage'));
        $data['content'] = $this->load->view('entities/dosage_view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
		
	} 
	
    public function dosage_form($id = null)
    { 
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('dosage_name', "Dosage name" ,'required|min_length[1]');		
		 if ($this->form_validation->run() === true) { 
		 	
		 }
        /*-------------STORE DATA------------*/
        $curr_datetime = date("Y-m-d h:i");

        $data['dosage'] = (object)$postData = array( 
			'dosage_id'	=> $this->input->post('id'),
            'dosage_name'       => trim($this->input->post('dosage_name'))
        );  

				
        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
				if ($this->form_validation->run() === true) { 
					$dosagerow = $this->db->query("select dosage_name from dosage where dosage_name ='".trim($this->input->post('dosage_name'))."' order by dosage_name asc limit 1")->result();
				if(strtolower(trim($this->input->post('dosage_name')))==strtolower($dosagerow[0]->dosage_name))
				{
					 $this->session->set_flashdata('exception',"Dosage name already exists!");
					 redirect('entities/dosage/dosage_list');
				}
						
                if ($this->dosage_model->create($postData)) {					
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('entities/dosage/dosage_list');
            } else {
                $data['title'] = "Add Dosage";
                $data['content'] = $this->load->view('entities/dosage_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) { 				
                if ($this->dosage_model->update($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('entities/dosage/dosage_form/'.$postData['dosage_id']);
            } else {
                $data['title'] = "Edit Dosage";
                $data['dosage'] = $this->dosage_model->read_by_id($id);
                $data['content'] = $this->load->view('entities/dosage_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 
        } 
        /*---------------------------------*/
    }
 

    public function delete($id = null) 
    {
        if ($this->dosage_model->delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect('entities/dosage/dosage_list');
    }
  
	
}
