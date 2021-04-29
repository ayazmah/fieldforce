<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zone extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'zone_model',
			'setting_model'
        )); 
    }
    
	
	
    public function index()
    {   
       $data['title'] = 'Zone List';
	   $data['rows'] = $this->zone_model->read();
	   $data['content'] = $this->load->view('zone_view', $data, true);
       $this->load->view('layout/main_wrapper', $data);
        
    }  
	
	public function delete($id)
    {
      if($id != "") {
	    if ($this->zone_model->delete($id)) {
				  
           $this->session->set_flashdata('message', 'Deleted Successfully');
         } else {
		  
		   $this->session->set_flashdata('exception', display('please_try_again')); 
        }
	  } else {
		  
		  $this->session->set_flashdata('exception', display('please_try_again'));
		  
	  }
	 redirect('zone');	
		
	}
    public function add($id = null)
    {
        
		
		$this->form_validation->set_rules('zo_name', 'name', 'required');
    	
		
        $data['record'] = (object)$postData = array(
            'zo_id' => $this->input->post('zo_id'),
			'zo_name' => $this->input->post('zo_name'),
			'zo_re_id' => $this->input->post('zo_re_id'),
			'zo_status' => $this->input->post('zo_status'),
			'zo_created_on' => date("Y-m-d"),
        );
		$data['record_update'] = (object)$postDataUpdate = array(
            'zo_id' => $this->input->post('zo_id'),
			'zo_name' => $this->input->post('zo_name'),
			'zo_re_id' => $this->input->post('zo_re_id'),
			'zo_status' => $this->input->post('zo_status'),
			'zo_updated_on' => date("Y-m-d"),
        );
		
		/*-----------CHECK ID -----------*/
       
		if (empty($id)) {
		    /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) {
			    
				
				
                if ($this->zone_model->insert($postData)) {
				  
                    #set success message
                    $this->session->set_flashdata('message', 'Added Successfully');
                } else {
				    
				   
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
			
                redirect('zone/add/');
            } else {
             
                $data['title'] = 'Add zone';
                $data['content'] = $this->load->view('zone_form', $data, true);
				$this->load->view('layout/main_wrapper', $data);
				
            }
		} else {
		   
		   if ($this->form_validation->run() === true) {
			    
				 
				
				
                if ($this->zone_model->update($postDataUpdate)) {
				  
                    #set success message
                    $this->session->set_flashdata('message', 'Updated Successfully');
                } else {
				    
				   
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
			
                redirect('zone/add/'.$id);
            } else {
             
                $data['title'] = 'Edit zone';
			    $data['row'] = $this->zone_model->read_by_id($id);
                $data['content'] = $this->load->view('zone_form', $data, true);
				$this->load->view('layout/main_wrapper', $data);
            }	
			
			
		}
       
        /*---------------------------------*/
    }
    
 
}
