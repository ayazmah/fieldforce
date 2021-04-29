<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visit extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'visit_model',
			'setting_model'
        )); 
	    $this->load->library('session');	
    }
    
	
	
    public function index()
    {   
       
	   $data['title'] = 'Visit List';
	   $data['visits'] = $this->visit_model->read();
	   $data['content'] = $this->load->view('visit_view', $data, true);
	   $this->load->view('layout/main_wrapper', $data);
        
    }  
	
	
	
	 public function view()
    {   
       
	   $data['title'] = 'Visit List';
	   $data['visits'] = $this->visit_model->read();
	   $data['content'] = $this->load->view('visit_view', $data, true);
	   $this->load->view('layout/main_wrapper', $data);
        
    }  
	public function view_target()
    {   
       
	   $data['title'] = 'Visit Target List';
	   $data['visits'] = $this->visit_model->readTarget();
	   $data['content'] = $this->load->view('visit_target_view', $data, true);
	   $this->load->view('layout/main_wrapper', $data);
        
    }  
	
	public function getClients() 
    {
        $cid = $this->input->post('cid');
		$ctype = $this->input->post('ctype');
		if(!empty($cid) && $ctype == 'doctors'){ 
		$result = $this->visit_model->getDoctors($cid);
		$str = '';
		 
		if(count($result) > 0){ 
			$str .= '<option value="0">Please Select</option>'; 
         foreach($result as $row){  
			
			$str .= '<option value="'.$row->id.'">'.$row->dr_doctor_name.'</option>'; 
        } 
		echo $str;	
     }else{ 
        echo '<option value="">No Record Found</option>'; 
      } 
     }
		if(!empty($cid) && $ctype == 'wholesaler'){ 
		$result = $this->visit_model->getWholesaler($cid);
		$str = '';
		 
		if(count($result) > 0){ 
		 $str .= '<option value="0">Please Select</option>'; 	
         foreach($result as $row){  
			
			$str .= '<option value="'.$row->id.'">'.$row->wholesaler_name.'</option>'; 
        } 
		echo $str;	
     }else{ 
        echo '<option value="">No Record Found</option>'; 
      } 
     }
		if(!empty($cid) && $ctype == 'pharmacy'){ 
		$result = $this->visit_model->getPharmacy($cid);
		$str = '';
		 
		if(count($result) > 0){
		 $str .= '<option value="0">Please Select</option>'; 	
         foreach($result as $row){  
			
			$str .= '<option value="'.$row->id.'">'.$row->pharm_pharmacy_name.'</option>'; 
        } 
		echo $str;	
     }else{ 
        echo '<option value="">No Record Found</option>'; 
      } 
     }
		
	}
	
	
	public function getMemebrsByClientType() 
    {
        $cid = $this->input->post('cid');
		$ctype = $this->input->post('ctype');
		if(!empty($cid) && $ctype == 'doctors'){ 
		$result = $this->visit_model->getMemebrsBYDoctor($cid);
		//print_r($result);
		$str = '';
		if(count($result) > 0){ 
         foreach($result as $row){  
			$qrow =$this->db->query("select id,emp_name from members where id=".$row->drmem_member_id)->row();
			$str .= '<option value="'.$qrow->id.'">'.$qrow->emp_name.'</option>'; 
        } 
		echo $str;	
     }else{ 
        echo '<option value="">No Record Found</option>'; 
      } 
     }
		if(!empty($cid) && $ctype == 'pharmacy'){ 
		$result = $this->visit_model->getMemebrsBYPharmacy($cid);
		//print_r($result);
		$str = '';
		if(count($result) > 0){ 
         foreach($result as $row){  
			$qrow =$this->db->query("select id,emp_name from members where id=".$row->pharmem_member_id)->row();
			$str .= '<option value="'.$qrow->id.'">'.$qrow->emp_name.'</option>'; 
        } 
		echo $str;	
     }else{ 
        echo '<option value="">No Record Found</option>'; 
      } 
     }
		if(!empty($cid) && $ctype == 'wholesaler'){ 
		$result = $this->visit_model->getMemebrsBYWholesaler($cid);
		//print_r($result);
		$str = '';
		if(count($result) > 0){ 
         foreach($result as $row){  
			$qrow =$this->db->query("select id,emp_name from members where id=".$row->whmem_member_id)->row();
			$str .= '<option value="'.$qrow->id.'">'.$qrow->emp_name.'</option>'; 
        } 
		echo $str;	
     }else{ 
        echo '<option value="">No Record Found</option>'; 
      } 
     }
	}
	public function getMemebrs() 
    {
        $cid = $this->input->post('cid');
		if(!empty($cid)){ 
		$result = $this->visit_model->getMemebrs($cid);
			//print_r($result);
		$str = '';
		if(count($result) > 0){ 
         foreach($result as $row){  
			
			$str .= '<option value="'.$row->id.'">'.$row->emp_name.'</option>'; 
        } 
		echo $str;	
     }else{ 
        echo '<option value="">No Record Found</option>'; 
      } 
     }
	}	
	
	public function delete()
    {
     
		$cid = $_POST['cid'];

		$deletePassword = $_POST['deletePassword'];
		$logged_user	= $this->session->userdata('user_id');
		$row = $this->db->query("select * from users where us_id = $logged_user")->row();
		
		if( md5(trim($deletePassword)) != $row->us_password )
		{
		  echo json_encode(2);
		
		} else {
		$queryUpdate = $this->db->query("update visit_planner set visit_is_deleted =1 where visit_id = $cid");  
 		  echo json_encode($queryUpdate);	
		}
	}
    
	
	
    public function add($id = null)
    {
        
		
		$this->form_validation->set_rules('visit_company_id', 'Company', 'required');
    	
		$visit_date = $this->input->post('visit_date');
		$visit_time = $this->input->post('timepicker-24-hr');
		
		$datetime =$visit_date.' '.$visit_time;
		
		//$id = $this->input->post('visit_id');
		
		
		
		$data['record'] = (object)$postData = array(
			'visit_id' => $this->input->post('visit_id'),
            'visit_company_id' => $this->input->post('visit_company_id'),
			'visit_client_type' => $this->input->post('visit_client_type'),
			'visit_client_id' => $this->input->post('visit_client_id'),
			'visit_member_id' => $this->input->post('visit_member_id'),
			'visit_datetime' => $datetime,
			'visit_created_datetime' => date("Y-m-d h:i"),
			'visit_created_by' => $this->session->userdata('user_id'),
			'visit_status' => $this->input->post('visit_status')
        );
		
		$data['recordUp'] = (object)$postDataUpdate = array(
			'visit_id' => $this->input->post('visit_id'),
            'visit_company_id' => $this->input->post('visit_company_id'),
			'visit_client_type' => $this->input->post('visit_client_type'),
			'visit_client_id' => $this->input->post('visit_client_id'),
			'visit_member_id' => $this->input->post('visit_member_id'),
			'visit_datetime' => $datetime,
			'visit_status' => $this->input->post('visit_status'),
			'visit_updated_by' => $this->session->userdata('user_id')
        );
		
	   
        /*-----------CHECK ID -----------*/
       
		if (empty($id)) {
			
		    /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) {
			    
			
				if ($this->visit_model->create($postData)) {
					
					#set success message
                    $this->session->set_flashdata('message', 'Added Successfully');
                } else {
				    
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
			
                redirect('visit/add');
            } else {
            
                $data['title'] = 'Add Visit';
                $data['content'] = $this->load->view('visit_form', $data, true);
				
				$this->load->view('layout/main_wrapper', $data);
            }
		} else {
		   
		   if ($this->form_validation->run() === true) {
                if ($this->visit_model->update($postDataUpdate)) {
				  
                    #set success message
                    $this->session->set_flashdata('message', 'Updated Successfully');
                } else {
				    
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
			
                redirect('visit/view/');
            } else {
            
                $data['title'] = 'Edit Visit';
			    $data['row'] = $this->visit_model->read_by_id($id);
                $data['content'] = $this->load->view('visit_form', $data, true);
				$this->load->view('layout/main_wrapper', $data);
            }	
			
			
		}
       
        /*---------------------------------*/
    }
	
	public function target($id = null)
    {
        
		
		$this->form_validation->set_rules('vt_comp_id', 'Company', 'required');
    	
		$vt_month = $this->input->post('vt_month');
		
		$vt_date = date("Y").'-'.$vt_month.'-'.date("d");
		
		
		$data['record'] = (object)$postData = array(
			'vt_id' => $this->input->post('vt_id'),
            'vt_comp_id' => $this->input->post('vt_comp_id'),
			'vt_emp_id' => $this->input->post('vt_emp_id'),
			'vt_month' => $vt_date,
			'vt_doctor_target' => $this->input->post('vt_doctor_target'),
			'vt_whole_seller_target' => $this->input->post('vt_whole_seller_target'),
			'vt_phamacy_target' => $this->input->post('vt_phamacy_target'),
			'vt_revnue_target' => $this->input->post('vt_revnue_target'),
			'vt_status' => $this->input->post('vt_status'),
			'vt_created_by' => $this->session->userdata('user_id'),
			'vt_created_on' => date("Y-m-d h:i")
        );
		
		$data['recordUp'] = (object)$postDataUpdate = array(
			'vt_id' => $this->input->post('vt_id'),
            'vt_comp_id' => $this->input->post('vt_comp_id'),
			'vt_emp_id' => $this->input->post('vt_emp_id'),
			'vt_month' => $vt_date,
			'vt_doctor_target' => $this->input->post('vt_doctor_target'),
			'vt_whole_seller_target' => $this->input->post('vt_whole_seller_target'),
			'vt_phamacy_target' => $this->input->post('vt_phamacy_target'),
			'vt_revnue_target' => $this->input->post('vt_revnue_target'),
			'vt_status' => $this->input->post('vt_status'),
			'vt_updated_by' => $this->session->userdata('user_id'),
			'vt_updated_on' => date("Y-m-d h:i")
        );
		
	   
        /*-----------CHECK ID -----------*/
       
		if (empty($id)) {
			
		    /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) {
			    
			
				if ($this->visit_model->createTarget($postData)) {
					
					#set success message
                    $this->session->set_flashdata('message', 'Added Successfully');
                } else {
				    
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
			
                redirect('visit/target');
            } else {
            
                $data['title'] = 'Add Visit Target';
                $data['content'] = $this->load->view('visit_target_form', $data, true);
				
				$this->load->view('layout/main_wrapper', $data);
            }
		} else {
		   
		   if ($this->form_validation->run() === true) {
                if ($this->visit_model->updateTarget($postDataUpdate)) {
				  
                    #set success message
                    $this->session->set_flashdata('message', 'Updated Successfully');
                } else {
				    
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
			
                redirect('visit/view_target/');
            } else {
            
                $data['title'] = 'Edit Visit';
			    $data['row'] = $this->visit_model->read_target_by_id($id);
                $data['content'] = $this->load->view('visit_target_form', $data, true);
				$this->load->view('layout/main_wrapper', $data);
            }	
			
			
		}
       
        /*---------------------------------*/
    }
	
	public function deleteTarget()
    {
     
		$cid = $_POST['cid'];

		$deletePassword = $_POST['deletePassword'];
		$logged_user	= $this->session->userdata('user_id');
		$row = $this->db->query("select * from users where us_id = $logged_user")->row();
		
		if( md5(trim($deletePassword)) != $row->us_password )
		{
		  echo json_encode(2);
		
		} else {
		$queryUpdate = $this->db->query("update visit_targets set vt_is_deleted =1 where vt_id = $cid");  
 		  echo json_encode($queryUpdate);	
		}
	}
    
 
}
