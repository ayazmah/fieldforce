<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Segment extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'entities/segment_model',
			'pagination_model',
		));



	}
 
	public function index()
	{   
		$data['title'] = "Segment List";		
		$data['segments'] = $this->segment_model->read();
		$data['content'] = $this->load->view('entities/segment_view',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 
 
	public function segment_list()
	{  
		$data['title'] = "Segment List";
		if ($this->input->post('submit') != '') {
            $data['search'] = $postData = [               
                'seg_name' => $this->input->post('seg_name'),
            ];
            $this->session->set_userdata('search_segment', $data['search']);
        } 
		$config["base_url"] = base_url('entities/segment_list');
        $config["total_rows"] = $this->pagination_model->read_segment_list_count('segment', $this->session->userdata('search_segment'));
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
        $data['segments'] = $this->pagination_model->read_segment_list($config["per_page"], $page, $this->session->userdata('search_segment'));
        $data['content'] = $this->load->view('entities/segment_view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
		
	} 
	
    public function segment_form($id = null)
    { 
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('seg_name', "Segment name" ,'required|min_length[1]');
		
        /*-------------STORE DATA------------*/
        $curr_datetime = date("Y-m-d h:i");

        $data['segment'] = (object)$postData = array( 
			'seg_id'	=> $this->input->post('seg_id'),
            'seg_name'       => trim($this->input->post('seg_name'))
        );  

		
        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) { 
				$segmentrow = $this->db->query("select seg_name from segment where seg_name ='".trim($this->input->post('seg_name'))."' order by seg_name asc limit 1")->result();
				if(strtolower(trim($this->input->post('seg_name')))==strtolower($segmentrow[0]->seg_name))
				{
					 $this->session->set_flashdata('exception',"Segment name already exists!");
					 redirect('entities/segment/segment_list');
				}
				
                if ($this->segment_model->create($postData)) {					
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('entities/segment/segment_list');
            } else {
                $data['title'] = "Add Segment";
                $data['content'] = $this->load->view('entities/segment_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 

        } else {
			
			
			
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) { 
				
                if ($this->segment_model->update($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('entities/segment/segment_list/');
            } else {
				
                $data['title'] = "Edit Segment";
                $data['segment'] = $this->segment_model->read_by_id($id);
                $data['content'] = $this->load->view('entities/segment_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 
        } 
        /*---------------------------------*/
    }
 

    public function delete($id = null) 
    {
        if ($this->segment_model->delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect('entities/segment/segment_list');
    }
  
	
}
