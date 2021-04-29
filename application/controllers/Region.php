<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Region extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'region_model',
			'setting_model'
        )); 
    }
    
	
	
    public function index()
    {   
       $data['title'] = 'Regions List';
	   $data['rows'] = $this->region_model->read();
	   $data['content'] = $this->load->view('region_view', $data, true);
       $this->load->view('layout/main_wrapper', $data);
        
    }  
	
	public function delete($id)
    {
      if($id != "") {
	    if ($this->region_model->delete($id)) {
				  
           $this->session->set_flashdata('message', 'Deleted Successfully');
         } else {
		  
		   $this->session->set_flashdata('exception', display('please_try_again')); 
        }
	  } else {
		  
		  $this->session->set_flashdata('exception', display('please_try_again'));
		  
	  }
	 redirect('region');	
		
	}
    public function add($id = null)
    {
        
		
		$this->form_validation->set_rules('re_name', 'name', 'required');
		
		
        $data['record'] = (object)$postData = array(
            're_id' => $this->input->post('re_id'),
			're_name' => $this->input->post('re_name'),
			're_us_id' => $this->input->post('re_us_id'),
			're_status' => $this->input->post('re_status'),
			're_created_on' => date("Y-m-d"),
        );
		$data['record_update'] = (object)$postDataUpdate = array(
            're_id' => $this->input->post('re_id'),
			're_name' => $this->input->post('re_name'),
			're_us_id' => $this->input->post('re_us_id'),
			're_status' => $this->input->post('re_status'),
			're_updated_on' => date("Y-m-d"),
        );
		
		 $rlrows = $this->db->query('select * from user_roles where ur_status = 1 order by ur_order')->result();
	     $region_caption = $rlrows[1]->text_caption;
		
		/*-----------CHECK ID -----------*/
       
		if (empty($id)) {
		    /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) {
			    
				
				
                if ($this->region_model->insert($postData)) {
				  
                    #set success message
                    $this->session->set_flashdata('message', 'Added Successfully');
                } else {
				    
				   
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
			
                redirect('region/add/');
            } else {
             
                $data['title'] = $region_caption;
                $data['content'] = $this->load->view('region_form', $data, true);
				$this->load->view('layout/main_wrapper', $data);
				
            }
		} else {
		   
		   if ($this->form_validation->run() === true) {
			    
				 
				
				
                if ($this->region_model->update($postDataUpdate)) {
				  
                    #set success message
                    $this->session->set_flashdata('message', 'Updated Successfully');
                } else {
				    
				   
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
			
                redirect('region/add/'.$id);
            } else {
             
                $data['title'] = 'Edit Region';
			    $data['row'] = $this->region_model->read_by_id($id);
                $data['content'] = $this->load->view('region_form', $data, true);
				$this->load->view('layout/main_wrapper', $data);
            }	
			
			
		}
       
        /*---------------------------------*/
    }
    
 
}
