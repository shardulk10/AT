<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->table_department_name = 'tbl_department';
        $this->table_user_name = 'tbl_user';
    }

    function checkDepartmentExists($deptname)
    {
        $this->db->select("dept_title");
        $this->db->from($this->table_department_name);
        $this->db->where("dept_title", $deptname);   
        $query = $this->db->get();

        return $query->num_rows();;
    }

    function getDeptId($deptname)
    {

        $this->db->select("id");
        $this->db->from($this->table_department_name);
        $this->db->where("dept_title", $deptname);   
        $query = $this->db->get();
        $data = $query->row();
        
        if(!empty($data->id)) {
            return $data->id;
        } else {
            return 0;
        }
    }

    function addNewDepartment($dataArray) {
        $this->db->insert($this->table_department_name, $dataArray);    
        return $this->db->insert_id();
    }

    function checkUserExists($email)
    {
        $this->db->select("email");
        $this->db->from($this->table_user_name);
        $this->db->where("email", $email);   
        $query = $this->db->get();
        return $query->num_rows();
    }

    function addNewUser($dataArray) {
        $this->db->insert($this->table_user_name, $dataArray);    
        return $this->db->insert_id();
    }

    function deleteUser($email) {
        $this->db->where('id', $slideId);
        $this->db->delete('tbl_faqs');
    }

    function getUserDetailsData($email)
    {

        $this->db->select("id");
        $this->db->from($this->table_user_name);
        $this->db->where("email", $email);   
        $query = $this->db->get();
        $data = $query->row();
        
        if(!empty($data->id)) {
            return $data->id;
        } else {
            return 0;
        }
    }
    
}

  