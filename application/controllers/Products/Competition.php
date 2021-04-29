<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Competition extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'products/competition_model',
			'pagination_model',
		));



	}
 
	public function index()
	{  
		$data['title'] = "Product List";		
		$data['competitions'] = $this->competition_model->read();
		$data['content'] = $this->load->view('products/competition_view',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 
 
	public function competition_list()
	{  
		$data['title'] = "Competion Product List";
		if ($this->input->post('submit') != '') {
            $data['search'] = $postData = [               
                'competition_product_name' => $this->input->post('competition_product_name'),				
				'competition_comp_id' => $this->input->post('company_id')
            ];
            $this->session->set_userdata('search_competition', $data['search']);
        }
		$config["base_url"] = base_url('products/competition_list');
        $config["total_rows"] = $this->pagination_model->read_competition_list_count('competition', $this->session->userdata('search_competition'));
        $config["per_page"] = 5;
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
        $data['competitions'] = $this->pagination_model->read_competition_list($config["per_page"], $page, $this->session->userdata('search_competition'));
        $data['content'] = $this->load->view('products/competition_view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
		
		/*$data['members'] = $this->member_model->read();
		$data['content'] = $this->load->view('members/view',$data,true);
		$this->load->view('layout/main_wrapper',$data);*/
	} 


    public function competition_form($id = null)
    { 
	
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('competition_product_name', "Competition name" ,'required|min_length[3]');
        /*-------------STORE DATA------------*/
        $curr_datetime = date("Y-m-d h:i");
		if ($this->input->post('id') == null) { //create a product  
        $data['competition'] = (object)$postData = array( 
			'competition_id'	=> $this->input->post('id'),
			'competition_company_id'          => trim($this->input->post('competition_company_id')),
            'competition_product_name'          => trim($this->input->post('competition_product_name')),
            'competition_productID'       => trim($this->input->post('competition_productID')),
            'competition_generic_name' => trim($this->input->post('competition_generic_name')),
            'competition_brand_name'  => trim($this->input->post('competition_brand_name')),
			'competition_dosage_form'   => trim($this->input->post('competition_dosage_form')),
            'competition_dosage'   => trim($this->input->post('competition_dosage')),
            'competition_product_id'      => trim($this->input->post('competition_product_id')),
			'competition_price'   => trim($this->input->post('competition_price')),
			'competition_url'   => trim($this->input->post('competition_url')),
			'competition_created_datetime'   => $curr_datetime
        );  
		}else
		{
			$data['competition'] = (object)$postData = array( 
			'competition_id'	=> $this->input->post('id'),
			'competition_company_id'          =>  trim($this->input->post('competition_company_id')),
            'competition_product_name'          => trim($this->input->post('competition_product_name')),
            'competition_productID'       => trim($this->input->post('competition_productID')),
            'competition_generic_name' => trim($this->input->post('competition_generic_name')),
            'competition_brand_name'  => trim($this->input->post('competition_brand_name')),
			'competition_dosage_form'   => trim($this->input->post('competition_dosage_form')),
            'competition_dosage'   => trim($this->input->post('competition_dosage')),
            'competition_product_id'      => trim($this->input->post('competition_product_id')),
			'competition_price'   => trim($this->input->post('competition_price')),
			'competition_url'   => trim($this->input->post('competition_url')),
			'competition_updated_datetime'   => $curr_datetime
        );  
		}
				
        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) { 
				$prodnamerow = $this->db->query("select competition_product_name from competition where competition_product_name ='".trim($this->input->post('competition_product_name'))."' order by competition_product_name asc limit 1")->result();
				
				$prodIDrow = $this->db->query("select competition_productID from competition where competition_productID ='".trim($this->input->post('competition_productID'))."' order by competition_id asc limit 1")->result();
				
				if(strtolower(trim($this->input->post('competition_product_name')))==strtolower($prodnamerow[0]->competition_product_name))
				{
					 $this->session->set_flashdata('exception',"Product name already exists!");
					 redirect('products/competition/competition_form/'.$postData['competition_id']);
				}
				else if(strtolower(trim($this->input->post('competition_productID')))==strtolower($prodIDrow[0]->competition_productID))
				{
					 $this->session->set_flashdata('exception',"Product ID already exists!");
					 redirect('products/competition/competition_form/'.$postData['competition_id']);
				}
				
                if ($this->competition_model->create($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('products/competition/competition_form');
            } else {
                $data['title'] = "Add Competition Product";
                $data['content'] = $this->load->view('products/competition_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) { 
			//var_dump($postData);die();
                if ($this->competition_model->update($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('products/competition/competition_form/'.$postData['competition_id']);
            } else {
                $data['title'] = "Edit Competition Product";
                $data['competition'] = $this->competition_model->read_by_id($id);
                $data['content'] = $this->load->view('products/competition_form',$data,true);
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
		$queryUpdate = $this->db->query("update competition set competition_is_deleted = 1 where competition_id = $cid");  
 		  echo json_encode($queryUpdate);	
		}
	
	}

    
  
	
}
