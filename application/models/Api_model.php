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

    function deleteUser($userid) {
        $this->db->where('id', $userid);
        $this->db->delete($this->table_user_name);
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

    function getAllUserDetailsData($dataArray)
    {
        $this->db->select("*");
        $this->db->from($this->table_user_name);

        $likeCriteria = array();
        if(!empty($dataArray['name'])) {
            $likeCriteria[] = "(name  LIKE '%".$dataArray['name']."%') ";
        }
        
        if(!empty($dataArray['email'])) {
            $likeCriteria[] = "(email LIKE '%".$dataArray['email']."%') ";
        }

        if(!empty($dataArray['mobile'])) {
            $likeCriteria[] = "(mobile LIKE '%".$dataArray['mobile']."%') ";
        }

        $likeCriteria =  !empty($likeCriteria) ? implode(" OR ",$likeCriteria) : "";
        if($likeCriteria != "") {
            
            $this->db->where($likeCriteria.' AND 1=1 ');
            $query = $this->db->get();

            if($query->num_rows() > 0) {
                return $query->result('array');
            }
        } else {
            return false;
        }
    }
    
}

  