<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'dashboard_model',
			'setting_model'
        )); 
    }
    
	
	
    public function index()
    {   
        
		
        if($this->session->userdata('isLogIn')) 
        $this->redirectTo(1);

        $this->form_validation->set_rules('email', display('email'),'required|max_length[50]|valid_email');
        $this->form_validation->set_rules('password', display('password'),'required|max_length[32]|md5');
        #-------------------------------#
        $setting = $this->setting_model->read();
        $data['title']   = (!empty($setting->title)?$setting->title:null);
        $data['logo']    = (!empty($setting->logo)?$setting->logo:null); 
        $data['favicon'] = (!empty($setting->favicon)?$setting->favicon:null); 
        $data['footer_text'] = (!empty($setting->footer_text)?$setting->footer_text:null); 

        $data['user'] = (object)$postData = [
            'email'     => $this->input->post('email',true),
            'password'  => md5($this->input->post('password',true)),
            
        ];
		
		#-------------------------------#
        if ($this->form_validation->run() === true) {
            //check user data
            $check_user = $this->dashboard_model->check_user($postData); 

            $check_user->num_rows();

            if ($check_user->num_rows() === 1) {
                //retrive setting data and store to session

                //store data in session
                $this->session->set_userdata([
                    'isLogIn'   => true,
                    'user_id' => ($check_user->row()->us_id),
                    'email'     => $check_user->row()->us_email,
                    'name'  => $check_user->row()->name,

                    'title'     => (!empty($setting->title)?$setting->title:null),
                    'address'   => (!empty($setting->description)?$setting->description:null),
                    'logo'      => (!empty($setting->logo)?$setting->logo:null),
                    'favicon'      => (!empty($setting->favicon)?$setting->favicon:null),
                    'footer_text' => (!empty($setting->footer_text)?$setting->footer_text:null),
                ]);

                //redirect to dashboard home page
				
				
				
               redirect('dashboard/home');

            } else {
                #set exception message
                $this->session->set_flashdata('exception',display('incorrect_email_password'));
                //redirect to login form
                redirect('adminlogin');
            }

        } else {
            $this->load->view('layout/login_wrapper',$data);
        } 
    }  


    public function redirectTo($user_role = null)
    {
        //redirect to dashboard/home page
	
        switch ($user_role) {
	
			case 1:
                    redirect('dashboard/home');
                break;
		    default: 
                    redirect('adminlogin');
                break;
        }        
    }


    public function home()
    {    
	   
        if ($this->session->userdata('isLogIn') == false)
        redirect('adminlogin');  

        $data['title'] = 'Home';
        #------------------------------#
        $data['content']  = $this->load->view('home',$data,true);
        $this->load->view('layout/main_wrapper',$data);
    } 

   
    public function email_check($email, $user_id)
    { 
        $emailExists = $this->db->select('us_email')
            ->where('us_email',$email) 
            ->where_not_in('us_id',$user_id) 
            ->get('users')
            ->num_rows();

        if ($emailExists > 0) {
            $this->form_validation->set_message('email_check', 'The {field} field must contain a unique value.');
            return false;
        } else {
            return true;
        }
    }


    public function form()
    {
        $data['title'] = display('edit_profile');
        $user_id = $this->session->userdata('user_id');
        #-------------------------------#
        $this->form_validation->set_rules('firstname', display('first_name') ,'required|max_length[50]');
        $this->form_validation->set_rules('lastname', display('last_name'),'required|max_length[50]');

        $this->form_validation->set_rules('email',display('email'), "required|max_length[50]|valid_email|callback_email_check[$user_id]");

        $this->form_validation->set_rules('password', display('password'),'required|max_length[32]|md5');

        $this->form_validation->set_rules('phone', display('phone') ,'max_length[20]');
        $this->form_validation->set_rules('mobile', display('mobile'),'required|max_length[20]');
        $this->form_validation->set_rules('sex', display('sex'),'required|max_length[10]');
        $this->form_validation->set_rules('date_of_birth', display('date_of_birth'),'max_length[10]');
        $this->form_validation->set_rules('address',display('address'),'required|max_length[255]');
        $this->form_validation->set_rules('status',display('status'),'required');
        #-------------------------------#
        //picture upload
        $picture = $this->fileupload->do_upload(
            'assets/images/user/',
            'picture'
        );
        // if picture is uploaded then resize the picture
        if ($picture !== false && $picture != null) {
            $this->fileupload->do_resize(
                $picture, 293, 350
            );
        }
        //if picture is not uploaded
        if ($picture === false) {
            $this->session->set_flashdata('exception', display('invalid_picture'));
        }
        #-------------------------------# 
        $data['user'] = (object)$postData = [
            'user_id'      => $this->input->post('user_id',true),
            'firstname'    => $this->input->post('firstname',true),
            'lastname'     => $this->input->post('lastname',true),
            'address'      => $this->input->post('address',true),
            'phone'        => $this->input->post('phone',true),
            'mobile'       => $this->input->post('mobile',true),
            'email'        => $this->input->post('email',true),
            'password'     => md5($this->input->post('password',true)),
            'picture'      => (!empty($picture)?$picture:$this->input->post('old_picture')),
            'date_of_birth' => date('Y-m-d', strtotime($this->input->post('date_of_birth',true))),
            'sex'          => $this->input->post('sex',true),
            'created_by'   => $this->session->userdata('user_id'),
            'create_date'  => date('Y-m-d'),
            'status'       => $this->input->post('status',true),
        ]; 
        #-------------------------------#
        if ($this->form_validation->run() === true) {

            if ($this->dashboard_model->update($postData)) {
                #set success message
                $this->session->set_flashdata('message',display('update_successfully'));
            } else {
                #set exception message
                $this->session->set_flashdata('exception', display('please_try_again'));
            }

            //update profile picture
            if ($postData['user_id'] == $this->session->userdata('user_id')) {                  
                $this->session->set_userdata([
                    'picture'   => $postData['picture'],
                    'fullname'  => $postData['firstname'].' '.$postData['lastname']
                ]); 
            }
            
            redirect('dashboard/form/');

        } else {
            $user_id = $this->session->userdata('user_id');
            $data['user'] = $this->dashboard_model->profile($user_id); 
            $data['content'] = $this->load->view('profile_form',$data,true);
            $this->load->view('layout/main_wrapper',$data);
        } 
    }
 




    public function logout()
    {   
        $this->session->sess_destroy(); 
        redirect('adminlogin');
    } 
 
}
