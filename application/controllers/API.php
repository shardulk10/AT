<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
    {
        parent::__construct();
        $this->load->model('api_model');
    }

	public function index()
	{
		
	}

	// http://localhost/AT/API/createDepartment
	// Form Data : title, description
	public function createDepartment()
	{
		$deptName = !empty($_POST['title']) ? trim($_POST['title']) : "";
		$deptDescription = !empty($_POST['description']) ? trim($_POST['description']) : "";
		$error = array();
		$success = array();
		$dataArray = array();

		if($deptName == "") {
			$error['001'] = "Please Enter Title";
		} else {
			$dataArray['dept_title'] = $deptName; 
		} 

		if($deptDescription == "") {
			$error['002'] = "Please Enter Description";
		} else {
			$dataArray['dept_description'] = $deptDescription; 
		} 

		if(!empty($deptName) && $this->api_model->checkDepartmentExists($deptName) > 0) {
			$error['003'] = "Department with same name already exist. Please try with different name.";
		}

		if(count($error) > 0) {
			echo json_encode($error);
		} else {
			if(!empty($this->api_model->addNewDepartment($dataArray))) {
				$success['001'] = "Department Added Successfully.";
				echo json_encode($success);
			}
		}
	}

	// http://localhost/AT/API/addUser
	// Form Data : name, email, mobile, deptname
	public function addUser()
	{
		$name = !empty($_POST['name']) ? trim($_POST['name']) : "";
		$email = !empty($_POST['email']) ? trim($_POST['email']) : "";
		$mobile = !empty($_POST['mobile']) ? trim($_POST['mobile']) : "";
		$deptname = !empty($_POST['deptname']) ? trim($_POST['deptname']) : "";

		$error = array();
		$success = array();
		$dataArray = array();

		if($name == "") {
			$error['001'] = "Please Enter Name";
		} else {
			$dataArray['name'] = $name; 
		}

		if($email == "") {
			$error['002'] = "Please Enter Email";
		} else {
			$dataArray['email'] = $email; 
		}

		if($mobile == "") {
			$error['003'] = "Please Enter mobile";
		} else {
			$dataArray['mobile'] = $mobile; 
		} 

		if($deptname == "") {
			$error['004'] = "Please Enter Department Name.";
		} else {
			$deptId = $this->api_model->getDeptId($deptname);
			if(empty($deptId)) {
				$error['005'] = "Department is not available. Please add department first.";
			} else {
				$dataArray['deptid'] = $deptId; 
			}
		}

		if($email != "" && $this->api_model->checkUserExists($email) > 0) {
				$error['006'] = "User already exist.";
		} 

		if(count($error) > 0) {
			echo json_encode($error);
		} else {
			if(!empty($this->api_model->addNewUser($dataArray))) {
				$success['001'] = "User Added Successfully.";
				echo json_encode($success);
			}
		}
	}

	public function editUser()
	{

		
	}

	// http://localhost/AT/API/deleteeUser
	// Form Data Email
	public function deleteeUser()
	{
		$email = !empty($_POST['email']) ? trim($_POST['email']) : "";
		
		$error = array();
		$success = array();
		$dataArray = array();

		if($email == "") {
			$error['001'] = "Please Enter Email";
		}

		if($email != "" && $this->api_model->checkUserExists($email) > 0) {
			$userId = $this->api_model->getUserDetailsData($email);
			$this->api_model->deleteUser($userId);
			$success['001'] = "User Deleted Successfully.";
			echo json_encode($success);
			exit();
		} else {
			$error['002'] = "User Not Exist";
		}
		echo json_encode($error);
		exit();
		
	}

	// http://localhost/AT/API/searchUser
	// Form Data : name, email, mobile
	public function searchUser()
	{
		$dataArray = array();
		$dataArray['name'] = !empty($_POST['name']) ? trim($_POST['name']) : "";
		$dataArray['email'] = !empty($_POST['email']) ? trim($_POST['email']) : "";
		$dataArray['mobile'] = !empty($_POST['mobile']) ? trim($_POST['mobile']) : "";
		
		$data = $this->api_model->getAllUserDetailsData($dataArray);
		if(empty($data)) {
			echo json_encode(array("001"=>" No Records Found"));	
		} else {
			echo json_encode($data);
		}
		
		exit();
	}
}
