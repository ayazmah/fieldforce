<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'invoice_model',
			'setting_model'
        )); 
    }
    
	
	
    public function index()
    {   
       $data['title'] = 'Invoice List';
	   $data['rows'] = $this->invoice_model->read();
	   $data['content'] = $this->load->view('invoice_view', $data, true);
       $this->load->view('layout/main_wrapper', $data);
        
    }  
	
	public function delete($id)
    {
      if($id != "") {
	    if ($this->invoice_model->delete($id)) {
				  
           $this->session->set_flashdata('message', 'Deleted Successfully');
         } else {
		  
		   $this->session->set_flashdata('exception', display('please_try_again')); 
        }
	  } else {
		  
		  $this->session->set_flashdata('exception', display('please_try_again'));
		  
	  }
	 redirect('Invoice');	
		
	}
    public function add($id = null)
    {
        
		
		$this->form_validation->set_rules('inv_name', 'Name', 'required');
		$this->form_validation->set_rules('inv_us_id', 'Compay','required');
    	
		
        $data['record'] = (object)$postData = array(
            'inv_id' => $this->input->post('inv_id'),
			'inv_name' => $this->input->post('inv_name'),
			'inv_us_id' => $this->input->post('inv_us_id'),
			'inv_unit_price' => $this->input->post('inv_unit_price'),
			'inv_total_users' => $this->input->post('inv_total_users'),
			'inv_total_price' => $this->input->post('inv_total_price'),
			'inv_status' => $this->input->post('inv_status'),
			'inv_created_on' => date("Y-m-d"),
        );
		$data['record_update'] = (object)$postDataUpdate = array(
            'inv_id' => $this->input->post('inv_id'),
			'inv_name' => $this->input->post('inv_name'),
			'inv_us_id' => $this->input->post('inv_us_id'),
			'inv_total_users' => $this->input->post('inv_total_users'),
			'inv_unit_price' => $this->input->post('inv_unit_price'),
			'inv_total_price' => $this->input->post('inv_total_price'),
			'inv_status' => $this->input->post('inv_status'),
			'inv_updated_on' => date("Y-m-d"),
        );
		
		/*-----------CHECK ID -----------*/
       
		if (empty($id)) {
		    /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) {
			    
				
				
                if ($this->invoice_model->insert($postData)) {
				  
                    #set success message
                    $this->session->set_flashdata('message', 'Added Successfully');
                } else {
				    
				   
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
			
                redirect('invoice/add/');
            } else {
             
                $data['title'] = 'Add Invoice';
                $data['content'] = $this->load->view('invoice_form', $data, true);
				$this->load->view('layout/main_wrapper', $data);
				
            }
		} else {
		   
		   if ($this->form_validation->run() === true) {
			    
				 
				
				
                if ($this->invoice_model->update($postDataUpdate)) {
				  
                    #set success message
                    $this->session->set_flashdata('message', 'Updated Successfully');
                } else {
				    
				   
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
			
                redirect('invoice/add/'.$id);
            } else {
             
                $data['title'] = 'Edit Invoice';
			    $data['row'] = $this->invoice_model->read_by_id($id);
                $data['content'] = $this->load->view('invoice_form', $data, true);
				$this->load->view('layout/main_wrapper', $data);
            }	
			
			
		}
       
        /*---------------------------------*/
    }
    
 
}
