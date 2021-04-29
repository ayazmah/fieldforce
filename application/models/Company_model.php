<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Company_model extends CI_Model {

	private $table = "companies";
 
	public function create($data = [])
	{	 
		return $this->db->insert($this->table,$data);
	}
    public function delete($id) {
    
    $this->db->where('comp_id', $id);
    $del=$this->db->delete($this->table);   
    return $del;

    }
    public function read_admin()
	{
		return $this->db->select("*")
			->from($this->table) 
			->where('us_is_admin',1)
			->get()
			->row();
	} 
	public function read()
	{
		return $this->db->select("*")
			->from($this->table) 
			->where('comp_is_deleted!=1')
			->order_by('comp_id','desc')
			->get()
			->result();
	} 
	
	public function name_check($email)
    {
        $nameExists = $this->db->select('comp_name')
            ->where('comp_name', $email)
            ->get('companies')
            ->num_rows();

        return $nameExists;
    }
	public function email_check($email)
    {
        $emailExists = $this->db->select('us_email')
            ->where('us_email', $email)
            ->where('comp_id!=1')
            ->get('users')
            ->num_rows();

        return $emailExists;
    }
 
	public function read_by_id($comp_id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('comp_id', $comp_id) 
			->get()
			->row();
	} 
    
	public function insert($data = [])
	{
		 $this->db->insert($this->table,$data); 
		 return $this->db->insert_id();
	} 
	
	public function update($data = [])
	{
		return $this->db->where('comp_id',$data['comp_id']) 
			->update($this->table,$data); 
	} 
 
	public function deleteRecord($id) {

    $this->db->where('comp_id', $id);
    $del=$this->db->delete($this->table);   
    return $del;

}


  
}
