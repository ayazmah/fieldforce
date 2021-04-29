<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'member_model',
			'pagination_model'
		));
        $this->load->helper('my_helper');
        
        //$this->load->helper('location_helper');

	}
 
	public function index()
	{  
		$data['title'] = "Members List";		
		$data['members'] = $this->member_model->read();
		$data['content'] = $this->load->view('member_view',$data,true);
		$this->load->view('layout/main_wrapper',$data);
		
	} 
	
	
 
	public function view()
	{  
		$data['title'] = "Members List";
		//$loc = $this->getCategoryTreeIDs(32);
		
		if ($this->input->post('submit') != '') {
            $data['search'] = $postData = [               
                'emp_name' => $this->input->post('emp_name'),
				'emp_comp_id' => $this->input->post('company_id')
            ];
            $this->session->set_userdata('search_member', $data['search']);
        }
		
		$config["base_url"] = base_url('member/view');
        $config["total_rows"] = $this->pagination_model->read_member_list_count('members', $this->session->userdata('search_member'));

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
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['links'] = $this->pagination->create_links();
		
        $data['members'] = $this->pagination_model->read_member_list( $config["per_page"], $page, $this->session->userdata('search_member'));
		
        $data['content'] = $this->load->view('member_view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
		
		/*$data['members'] = $this->member_model->read();
		$data['content'] = $this->load->view('view',$data,true);
		$this->load->view('layout/main_wrapper',$data);*/
	} 
	
	public function details($member_id = null)
	{   
		$data['title'] = display('noticeboard');
		#-------------------------------#
		$data['member'] = $this->member_model->read_by_id($member_id);
		$data['content'] = $this->load->view('details',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 
    
    
	public function getCategoryTreeIDs($catID) {
		
		
		$ids = [strval($catID)];
		
		$row = $row = $this->db->query("select * from location where location_id =".$catID)->row();
       if (!$row->location_parent_id == 0) {
		$row->location_parent_id;
		$ids = array_merge($this->getCategoryTreeIDs($row->location_parent_id), $ids);
		
		} 
		return $ids;
}
	
   public function getCategoryTreeIdsByCate($catID) {
	   $a = "";
	   $a .= $this->getCategoryTreeIDs($catID);
	   return $a;
	   
   }

public function getCategoryTitle($id){
  	
  		$c = $row = $this->db->query("select * from location where location_id =".$id)->row();	
  		return $c->location_name;
}
	
    public function findHierarchy($id = null)
    { 
		$row = $this->query("select * from location where location_id =".$id)->row();
		
		for($i=0; $i<=$row->location_level; $i++){
			
			$row = $this->query("select location_name from location where location_id =".$id)->row();
			$arr[] =$row->location_name;
			
			
		}			
		
	}
	
    public function add($id = null)
    { 
	   
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('emp_name', display('emp_name') ,'required|min_length[3]');
        //$this->form_validation->set_rules('emp_id', display('email_address') ,'required|min_length[5]');
        /*-------------STORE DATA------------*/
        $curr_datetime = date("Y-m-d h:i");
		
		// 
		
        $data['member'] = (object)$postData = array( 
			'emp_company_id' => $this->input->post('company_id'),
            'emp_name' => $this->input->post('emp_name'),
			'emp_id' => $this->input->post('emp_id'),
            'emp_email_address' => $this->input->post('emp_email_address', true),
            'emp_designation'  => $this->input->post('emp_designation'),
            'emp_mobile' => $this->input->post('emp_mobile'),
            'emp_location_id' => $this->input->post('emp_location_id'),
			'emp_country' => 163,
			'emp_role_id' => $this->input->post('emp_role_id'),
			'emp_image_link' => $this->input->post('emp_image_link'),
			'emp_status' => 0,
			'emp_created_datetime'=> $curr_datetime
			
			
        );  
       
		 $data['memberUpdate'] = (object)$postDataUp = array( 
			'id' => $this->input->post('id'),
			'emp_company_id' => $this->input->post('company_id'),
            'emp_name' => $this->input->post('emp_name'),
			'emp_id' => $this->input->post('emp_id'),
            'emp_email_address' => $this->input->post('emp_email_address', true),
            'emp_designation'  => $this->input->post('emp_designation'),
            'emp_mobile'   => $this->input->post('emp_mobile'),
            'emp_location_id'   => $this->input->post('emp_location_id'),
			'emp_country'   => 163,
			'emp_role_id'   => $this->input->post('emp_role_id'),
			'emp_image_link'   => $this->input->post('emp_image_link'),
			'emp_status'   => 0,
			'emp_updated_datetime'   => $curr_datetime
			
			
        );  
		
//		print_r($data['member']);
//		die;
//        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) { 
				$insert_id =$this->member_model->create($postData);
                if ($insert_id) {
					
					$rec = array( 
                    'emp_id'=> $insert_id.'-'.$this->input->post('company_id').'FieldForce'
                   );

					$this->db->where('id', $insert_id);
					$this->db->update('members', $rec);
					
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('member/add');
            } else {
                $data['title'] = "Add Member";
				$data['content'] = $this->load->view('member_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) { 
				
                if ($this->member_model->update($postDataUp)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('member/view/');
            } else {
                $data['title'] = 'Member Edit';
                $data['member'] = $this->member_model->read_by_id($id);
                $data['content'] = $this->load->view('member_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 
        } 
        /*---------------------------------*/
    }
    
	
	public function getTeamLeads() 
    {
        $id = $this->input->post('re_id');
		if(!empty($id )){ 
		$result = $this->member_model->team_lead_by_region($id);
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
	
	public function getZonalManagers() 
    {
        $id = $this->input->post('re_id');
		if(!empty($id )){ 
		$result = $this->member_model->zonal_manager_by_region($id);
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
		
    public function getRegionalManagers() 
    {
        $id = $this->input->post('re_id');
		if(!empty($id )){ 
		$result = $this->member_model->manager_by_region($id);
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
	public function getZones() 
    {
        $id = $this->input->post('re_id');
		if(!empty($id )){ 
		$result = $this->member_model->zone_by_region($id);
		if(count($result) > 0){ 
		$str = '<option value=""></option>'; 	
         foreach($result as $row){  
            $str .= '<option value="'.$row->zo_id.'">'.$row->zo_name.'</option>'; 
        } 
		echo $str;	
       }else{ 
        echo '<option value="">No Record Found</option>'; 
      } 
     }
	}
	public function getRegions() 
    {
        $id = $this->input->post('company_id');
		if(!empty($id )){ 
		$result = $this->member_model->region_by_company($id);
		if(count($result) > 0){ 
			$str = '<option value=""></option>'; 
         foreach($result as $row){  
            $str .= '<option value="'.$row->re_id.'">'.$row->re_name.'</option>'; 
        } 
		echo $str;	
       }else{ 
        echo '<option value="">No Record Found</option>'; 
      } 
     }
	}
	
	public function getLineManager() 
    {
        $id = $this->input->post('role_id');
		$cid = $this->input->post('cid');
		if(!empty($cid)){
		if(!empty($id )){ 
		  if($id==4)
		   $manager_id =0;
		  elseif($id==5)
		   $manager_id =4;
		  elseif($id==6)
		   $manager_id =5;
		  elseif($id==1)
		   $manager_id =6;
		  else	
		   $manager_id =0;
			
		$result = $this->member_model->line_by_role($manager_id,$cid);
		if(count($result) > 0){ 
			$str = '<option value=""></option>'; 
         foreach($result as $row){  
            $str .= '<option value="'.$row->id.'">'.$row->emp_name.'</option>'; 
        } 
		echo $str;	
     }else{ 
        echo '<option value=""></option>'; 
      } 
     }
	}else{
			
		 echo '<option value="">Select Company First</option>'; 	
		}
	}
	public function getMembers() 
    {
        $id = $this->input->post('company_id');
		if(!empty($id )){ 
		$result = $this->member_model->members_by_company($id);
		if(count($result) > 0){ 
		$str = '<option value=""></option>'; 	
         foreach($result as $row){  
            $str .= '<option value="'.$row->id.'">'.$row->emp_name.'</option>'; 
        } 
		echo $str;	
       }else{ 
        echo '<option value="">No Record Found</option>'; 
      } 
     }
	}
	
    public function delete($id = null) 
    {
	
	    $cid = $_POST['cid'];
		$deletePassword = $_POST['deletePassword'];
		$logged_user	= $this->session->userdata('user_id');
		$row = $this->db->query("select * from users where us_id = $logged_user")->row();
		
		if( md5(trim($deletePassword)) != $row->us_password )
		{
		  echo json_encode(2);
		
		} else {
		$queryUpdate = $this->db->query("update members set emp_is_deleted =1 where id = $cid");  
 		  echo json_encode($queryUpdate);	
		}
	
	}
  
	
}
