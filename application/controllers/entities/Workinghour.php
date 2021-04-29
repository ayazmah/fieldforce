<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Workinghour extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'entities/workinghour_model',
			'pagination_model',
		));



	}
 
	public function index()
	{   
		$data['title'] = "Working Hour List";		
		$data['workinghours'] = $this->class_model->read();
		$data['content'] = $this->load->view('entities/workinghour_view',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 
 
	public function workinghour_list()
	{  
		$data['title'] = "Working Hour List";
		if ($this->input->post('submit') != '') {
            $data['search'] = $postData = [               
                'wh_name' => $this->input->post('wh_name'),
            ];
            $this->session->set_userdata('search_workinghour', $data['search']);
        } 
		$config["base_url"] = base_url('entities/workinghour_list');
        $config["total_rows"] = $this->pagination_model->read_workinghour_list_count('working_hours', $this->session->userdata('search_workinghour'));
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
        $data['workinghours'] = $this->pagination_model->read_workinghour_list($config["per_page"], $page, $this->session->userdata('search_workinghour'));
        $data['content'] = $this->load->view('entities/workinghour_view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
		
	} 
	
    public function workinghour_form($id = null)
    { 
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('wh_name', display('wh_name') ,'required|min_length[1]');
		if ($this->form_validation->run() === true) { 
			
		}
        /*-------------STORE DATA------------*/
        $curr_datetime = date("Y-m-d h:i");

        $data['workinghour'] = (object)$postData = array( 
			'wh_id'	=> $this->input->post('wh_id'),
            'wh_name'       => trim($this->input->post('wh_name'))
        );  

				
        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) { 
				$sprow = $this->db->query("select wh_name from working_hours where wh_name ='".trim($this->input->post('wh_name'))."' order by wh_name asc limit 1")->result();
				if(strtolower(trim($this->input->post('wh_name')))==strtolower($sprow[0]->wh_name))
				{
					 $this->session->set_flashdata('exception',"Working Hour name already exists!");
					 redirect('entities/workinghour/workinghour_list');
				}
				
                if ($this->workinghour_model->create($postData)) {					
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('entities/workinghour/workinghour_list');
            } else {
                $data['title'] = "Add Working Hour";
                $data['content'] = $this->load->view('entities/workinghour_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) { 
                if ($this->workinghour_model->update($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('entities/workinghour/workinghour_form/'.$postData['wh_id']);
            } else {
                $data['title'] = "Edit Working Hour";
                $data['workinghour'] = $this->workinghour_model->read_by_id($id);
                $data['content'] = $this->load->view('entities/workinghour_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 
        } 
        /*---------------------------------*/
    }
 

    public function delete($id = null) 
    {
        if ($this->workinghour_model->delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect('entities/workinghour/workinghour_list');
    }
  
	
}

