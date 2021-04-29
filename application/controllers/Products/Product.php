<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'products/product_model',
			'pagination_model',
		));

       

	}
 
	public function index()
	{  
		$data['title'] = "Product List";		
		$data['products'] = $this->team_model->read();
		$data['content'] = $this->load->view('products/view',$data,true);
		$this->load->view('layout/main_wrapper',$data);
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
		$queryUpdate = $this->db->query("update products set product_is_deleted =1 where id = $cid");  
 		  echo json_encode($queryUpdate);	
		}
	
	}
	
	public function products_list()
	{  
		$data['title'] = "Product List";
		if ($this->input->post('submit') != '') {
            $data['search'] = $postData = [               
                'product_name' => $this->input->post('product_name'),
				'product_comp_id' => $this->input->post('company_id')
            ];
            $this->session->set_userdata('search_product', $data['search']);
        }
		$config["base_url"] = base_url('products/products_list');
        $config["total_rows"] = $this->pagination_model->read_competition_list_count('products', $this->session->userdata('search_product'));
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
        $data['products'] = $this->pagination_model->read_product_list($config["per_page"], $page, $this->session->userdata('search_product'));
        $data['content'] = $this->load->view('products/product_view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
		
		/*$data['members'] = $this->member_model->read();
		$data['content'] = $this->load->view('members/view',$data,true);
		$this->load->view('layout/main_wrapper',$data);*/
	} 
	
	public function details($member_id = null)
	{   
		$data['title'] = display('noticeboard');
		#-------------------------------#
		$data['member'] = $this->member_model->read_by_id($member_id);
		$data['content'] = $this->load->view('members/details',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 

    public function product_form($id = null)
    { 
	   
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('product_name', display('product_name') ,'required|min_length[3]');
        /*-------------STORE DATA------------*/
        $curr_datetime = date("Y-m-d h:i");
		if ($this->input->post('id') == null) { //create a product  
        $data['product'] = (object)$postData = array( 
			'id'	=> $this->input->post('id'),
			'product_company_id'          => trim($this->input->post('product_company_id')),
            'product_name'          => trim($this->input->post('product_name')),
            'product_productID'       => trim($this->input->post('product_productID')),
            'product_generic_name' => trim($this->input->post('product_generic_name')),
            'product_brand_name'  => trim($this->input->post('product_brand_name')),
			'product_dosage_form'   => trim($this->input->post('product_dosage_form')),
            'product_dosage'   => trim($this->input->post('product_dosage')),
            'product_description'      => trim($this->input->post('product_description')),
			'product_side_effects'   => trim($this->input->post('product_side_effects')),
			'product_url'   => trim($this->input->post('product_url')),
			'product_created_datetime'   => $curr_datetime
        );  
		}else
		{
			$data['product'] = (object)$postData = array( 
			'id'	=> $this->input->post('id'),
			'product_company_id'          => trim($this->input->post('product_company_id')),
            'product_name'          => trim($this->input->post('product_name')),
            'product_productID'       => trim($this->input->post('product_productID')),
            'product_generic_name' => trim($this->input->post('product_generic_name')),
            'product_brand_name'  => trim($this->input->post('product_brand_name')),
			'product_dosage_form'   => trim($this->input->post('product_dosage_form')),
            'product_dosage'   => trim($this->input->post('product_dosage')),
            'product_description'      => trim($this->input->post('product_description')),
			'product_side_effects'   => trim($this->input->post('product_side_effects')),
			'product_url'   => trim($this->input->post('product_url')),
			'product_updated_datetime'   => $curr_datetime
        );  
		}
				
        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) { 
				$prodnamerow = $this->db->query("select product_name from products where product_name ='".trim($this->input->post('product_name'))."' order by product_name asc limit 1")->result();
				$prodIDrow = $this->db->query("select product_productID from products where product_productID ='".trim($this->input->post('product_productID'))."' order by id asc limit 1")->result();
				if(strtolower(trim($this->input->post('product_name')))==strtolower($prodnamerow[0]->product_name))
				{
					 $this->session->set_flashdata('exception',"Product name already exists!");
					 redirect('products/product/product_form/'.$postData['id']);
				}
				else if(strtolower(trim($this->input->post('product_productID')))==strtolower($prodIDrow[0]->product_productID))
				{
					 $this->session->set_flashdata('exception',"Product ID already exists!");
					 redirect('products/product/product_form/'.$postData['id']);
				}
				
                if ($this->product_model->create($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('products/product/product_form');
            } else {
                $data['title'] = "Add Product";
                $data['content'] = $this->load->view('products/product_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) { 
			//var_dump($postData);die();
                if ($this->product_model->update($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('products/product/product_form/'.$postData['id']);
            } else {
                $data['title'] = "Edit Product";
                $data['product'] = $this->product_model->read_by_id($id);
                $data['content'] = $this->load->view('products/product_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 
        } 
        /*---------------------------------*/
    }
 

    public function deleteOld($id = null) 
    {
        if ($this->product_model->delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect('products/product');
    }
  
	
}
