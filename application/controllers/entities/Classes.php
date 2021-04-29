<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'entities/classes_model',
			'pagination_model',
		));


	}
 
	public function index()
	{   
		$data['title'] = "Class List";		
		$data['classes'] = $this->class_model->read();
		$data['content'] = $this->load->view('entities/class_view',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 
 
	public function class_list()
	{  
		$data['title'] = "Class List";
		if ($this->input->post('submit') != '') {
            $data['search'] = $postData = [               
                'cl_name' => $this->input->post('cl_name'),
            ];
            $this->session->set_userdata('search_class', $data['search']);
        } 
		$config["base_url"] = base_url('entities/class_list');
        $config["total_rows"] = $this->pagination_model->read_class_list_count('classes', $this->session->userdata('search_class'));
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
        $data['classes'] = $this->pagination_model->read_class_list($config["per_page"], $page, $this->session->userdata('search_class'));
        $data['content'] = $this->load->view('entities/class_view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
		
	} 
	
    public function class_form($id = null)
    { 
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('cl_name', "class name" ,'required|min_length[1]');
        /*-------------STORE DATA------------*/
        $curr_datetime = date("Y-m-d h:i");

        $data['class'] = (object)$postData = array( 
			'cl_id'	=> $this->input->post('cl_id'),
            'cl_name'       => trim($this->input->post('cl_name'))
        );  

				
        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) { 	
				$classrow = $this->db->query("select cl_name from classes where cl_name ='".trim($this->input->post('cl_name'))."' order by cl_name asc limit 1")->result();
				if(strtolower(trim($this->input->post('cl_name')))==strtolower($classrow[0]->cl_name))
				{
					 $this->session->set_flashdata('exception',"Class name already exists!");
					 redirect('entities/classes/class_list');
				}	
					
                if ($this->classes_model->create($postData)) {					
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('entities/classes/class_list');
            } else {
                $data['title'] = "Add Class";
                $data['content'] = $this->load->view('entities/class_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) { 
                if ($this->classes_model->update($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('entities/classes/class_form/'.$postData['cl_id']);
            } else {
                $data['title'] = "Edit Class";
                $data['class'] = $this->classes_model->read_by_id($id);
                $data['content'] = $this->load->view('entities/class_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 
        } 
        /*---------------------------------*/
    }
 

    public function delete($id = null) 
    {
        if ($this->classes_model->delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect('entities/classes/class_list');
    }
  
	
}
