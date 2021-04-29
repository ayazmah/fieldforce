<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'teams/groups_model',
			'pagination_model',
		));
        
	}
 
	public function index()
	{  
		$data['title'] = "Teams List";		
		$data['groups'] = $this->groups_model->read();
		$data['content'] = $this->load->view('teams/view',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 
 
	public function groups_list()
	{  
		$data['title'] = "Groups List";
		if ($this->input->post('submit') != '') {
            $data['search'] = $postData = [               
                'group_name' => $this->input->post('group_name'),
				'group_comp_id' => $this->input->post('company_id')
            ];
            $this->session->set_userdata('search_group', $data['search']);
        }
		$config["base_url"] = base_url('teams/groups/groups_list');
        $config["total_rows"] = $this->pagination_model->read_groups_list_count('groups', $this->session->userdata('search_group'));
		$config["per_page"] = 10;
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
        $data['groups'] = $this->pagination_model->read_groups_list($config["per_page"], $page, $this->session->userdata('search_group'));
        $data['content'] = $this->load->view('teams/view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
		
		/*$data['members'] = $this->member_model->read();
		$data['content'] = $this->load->view('members/view',$data,true);
		$this->load->view('layout/main_wrapper',$data);*/
	} 
	

    public function form($id = null)
    { 
	
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('group_name', display('group_name') ,'required|min_length[2]');
        /*-------------STORE DATA------------*/
        $curr_datetime = date("Y-m-d h:i");
		$assigned_members = $this->input->post('assigned_members');
		$assigned_products = $this->input->post('assigned_products');
		
		/*$mem="";  
		for($j=0; $j < count($assigned_members); $j++)  
	    {  
			if($j==(count($assigned_members)-1))
			{
				$mem = $mem.$assigned_members[$j]; 
			}
			else
			{
				$mem = $mem.$assigned_members[$j].",";
			}
	   	}   */
		if ($this->input->post('id') == null) { //create a group  
        $data['group'] = (object)$postData = array( 
			'id'	=> $this->input->post('id'),
			'group_company_id'          => $this->input->post('company_id'),
            'group_name'          => $this->input->post('group_name'),
            /*'group_assigned_members'       => $mem,
            'group_assigned_products' => $this->input->post('group_assigned_products'),*/
			'group_created_datetime'   => $curr_datetime
        );  
		}
		else
		{
			$data['group'] = (object)$postData = array( 
			'id'	=> $this->input->post('id'),
			'group_company_id'          => $this->input->post('company_id'),
            'group_name'          => $this->input->post('group_name'),
			'group_updated_datetime'   => $curr_datetime
        );  
		}
				
        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) { 
                if ($last_insert_id = $this->groups_model->create($postData)) {
					$this->groups_model->create_assigned_members($assigned_members,$last_insert_id,$this->input->post('company_id'));
					$this->groups_model->create_assigned_products($assigned_products,$last_insert_id,$this->input->post('company_id'));
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('teams/groups/form');
            } else {
                $data['title'] = "Add Group";
                $data['content'] = $this->load->view('teams/form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) {  
                if ($this->groups_model->update($postData)) {
					$this->groups_model->update_assigned_members($assigned_members,$this->input->post('id'),$this->input->post('company_id'));
					$this->groups_model->update_assigned_products($assigned_products,$this->input->post('id'),$this->input->post('company_id'));
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('teams/groups/form/'.$postData['id']);
            } else {
                $data['title'] = "Edit Team";
                $data['group'] = $this->groups_model->read_by_id($id);
                $data['content'] = $this->load->view('teams/form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 
        } 
        /*---------------------------------*/
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
		$queryUpdate = $this->db->query("update groups set group_is_deleted = 1 where id = $cid");  
 		  echo json_encode($queryUpdate);	
		}
	
	}

   
  
	
}
