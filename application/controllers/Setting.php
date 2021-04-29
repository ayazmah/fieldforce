<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'setting_model'
		));

		if ($this->session->userdata('isLogIn') == false) 
		redirect('adminlogin'); 
	}
 

	public function index()
	{
		
		$data['title'] = display('application_setting');
		#-------------------------------#
		//check setting table row if not exists then insert a row
		$this->check_setting();
		#-------------------------------#
		$data['setting'] = $this->setting_model->read();
		$data['content'] = $this->load->view('setting',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 
	
	
	public function actions($id = null)
	{           
		
		if(!empty($id)) {
		
		for($i=0; $i<=count($_POST['id']); $i++){
		$data['record'] = (object)$postData = array(
		'ur_id' => $_POST['id'][$i],
		'text_caption' => $_POST['us_name'][$i],
			
         );
			
		$flag	= $this->setting_model->update_captions($postData);
			
			
		} 
				
                if ($flag) {
				  
                    #set success message
                    $this->session->set_flashdata('message', 'Updated Successfully');
                } else {
				    
				   
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
			
                redirect('setting/update/');
		}
            
		
	}	
	
	public function update($id = null)
    {
        
		
		$this->form_validation->set_rules('action', 'name', 'required');
		
		
		
		
		
		
        /*-----------CHECK ID -----------*/
       
		   if ($this->form_validation->run() === true) {} else {
            
                $data['title'] = 'Edit Captions';
			    //$data['row'] = $this->company_model->read_by_id($id);
                $data['content'] = $this->load->view('caption_form', $data, true);
				$this->load->view('layout/main_wrapper', $data);
            }	
			
			
	
       
        /*---------------------------------*/
    }
	
    // version manaagment 
	
	
	public function create()
	{
		$data['title'] = display('application_setting');
		#-------------------------------#
		$this->form_validation->set_rules('title',display('website_title'),'required|max_length[50]');
		$this->form_validation->set_rules('description', display('address') ,'max_length[255]');
		$this->form_validation->set_rules('email',display('email'),'max_length[100]|valid_email');
		$this->form_validation->set_rules('phone',display('phone'),'max_length[20]');
		$this->form_validation->set_rules('footer_text',display('footer_text'),'max_length[255]'); 
		#-------------------------------#
		//logo upload
		$logo = $this->fileupload->do_upload(
			'assets/images/apps/',
			'logo'
		);
		// if logo is uploaded then resize the logo
		if ($logo !== false && $logo != null) {
			$this->fileupload->do_resize(
				$logo, 
				210,
				48
			);
		}
		//if logo is not uploaded
		if ($logo === false) {
			$this->session->set_flashdata('exception', display('invalid_logo'));
		}


		//favicon upload
		$favicon = $this->fileupload->do_upload(
			'assets/images/icons/',
			'favicon'
		);
		// if favicon is uploaded then resize the favicon
		if ($favicon !== false && $favicon != null) {
			$this->fileupload->do_resize(
				$favicon, 
				32,
				32
			);
		}
		//if favicon is not uploaded
		if ($favicon === false) {
			$this->session->set_flashdata('exception',  display('invalid_favicon'));
		}		
		#-------------------------------#
         
		 
		$data['setting'] = (object)$postData = [
			'st_id'  => $this->input->post('setting_id'),
			'st_title' 	  => $this->input->post('title'),
			'st_description' => $this->input->post('description', false),
			'st_email' 	  => $this->input->post('email'),
			'st_phone' 	  => $this->input->post('phone'),
			'st_insta_link' 	  => $this->input->post('st_insta_link'),
			'st_fb_link' 	  => $this->input->post('st_fb_link'),
			'st_tw_link' 	  => $this->input->post('st_tw_link'),
			'st_phone' 	  => $this->input->post('phone'),
			'st_logo' 	      => (!empty($logo)?$logo:$this->input->post('old_logo')),
			'st_favicon' 	  => (!empty($favicon)?$favicon:$this->input->post('old_favicon')),
			'st_footer_text' => $this->input->post('footer_text', false),
		]; 
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $setting_id then insert data
			if (empty($postData['st_id'])) {
			
				if ($this->setting_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message',display('save_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception',display('please_try_again'));
				}
			} else {
		
				if ($this->setting_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message',display('update_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception', display('please_try_again'));
				} 
			}
            // unset($_SESSION['footer_text']);
			//update session data
			
			$this->session->set_userdata([
				'title' 	  => $postData['title'],
				'address' 	  => $postData['description'],
				'email' 	  => $postData['email'],
				'phone' 	  => $postData['phone'],
				'logo' 		  => $postData['logo'],
				'favicon' 	  => $postData['favicon'],
				'footer_text' => $postData['footer_text'],
			]);
           
			redirect('setting');

		} else { 
			$data['content'] = $this->load->view('setting',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		} 
	}

	//check setting table row if not exists then insert a row
	public function check_setting()
	{
		if ($this->db->count_all('setting') == 0) {
			$this->db->insert('setting',[
				'title' => 'Calix Limited',
				'description' => 'Street, State-12345, Demo',
				'time_zone' => 'Asia/Karachi',
				'footer_text' => '2019&copy;Copyright',
			]);
		}
	}


   


}
