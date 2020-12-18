<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User Management class created by CodexWorld
 */
class Manage_users extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library('admin_init_elements');
		$this->admin_init_elements->is_admin_loggedin();
        $this->admin_init_elements->init_elements();
		$this->adminId = $this->session->userdata('adminId');
        $this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->model('user');
		
		// Default layout
        $this->layout = 'admin/layout';
		
		// Default controller
		$this->controller = 'admin/manage_users';
		
		// Default upload dir
		$this->uploadDir = $this->config->item('upload_path').'profile_picture/';
		
		// Per page data limit
		$this->perPage = 10;
    }
    
    public function index(){
        $data = array();
		$searchKeyword = '';
		
		// Get messages from the session
		if($this->session->userdata('success_msg')){
			$data['success_msg'] = $this->session->userdata('success_msg');
			$this->session->unset_userdata('success_msg');
		}
		if($this->session->userdata('error_msg')){
			$data['error_msg'] = $this->session->userdata('error_msg');
			$this->session->unset_userdata('error_msg');
		}
		
		// If search request is submitted
		if($this->input->post('submitSearch')){
			$inputKeywords = $this->input->post('searchKeyword');
			$searchKeyword = strip_tags($inputKeywords);
			if(!empty($searchKeyword)){
				$this->session->set_userdata('userSearchKeyword',$searchKeyword);
			}else{
				$this->session->unset_userdata('userSearchKeyword');
			}
		}elseif($this->input->post('submitSearchReset')){
			$this->session->unset_userdata('userSearchKeyword');
		}
		
		// Get total rows count of the users
		$conditions['searchKeyword'] = $this->session->userdata('userSearchKeyword');
		$conditions['returnType'] = 'count';
		$totalRec = $this->user->getRows($conditions);
		
		// Pagination config
		$config['base_url']    = base_url().$this->controller.'/index/';
		$config['uri_segment'] = 4;
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config = adminPaginationConfig($config); // Additional config for label and tags
		$this->pagination->initialize($config);
		
		$page = $this->uri->segment(4);
		$offset = !$page?0:$page;
		
		// Get rows of the users
		$conditions['returnType'] = '';
		$conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		$data['users'] = $this->user->getRows($conditions);
		
		// Define some useful variables for view
		$data['listURL'] = base_url().$this->controller;
		$data['addURL'] = base_url().$this->controller.'/add';
		$data['editURL'] = base_url().$this->controller.'/edit/{ID}';
		$data['detailsURL'] = base_url().$this->controller.'/details/{ID}';
		$data['blockURL'] = base_url().$this->controller.'/block/{ID}';
		$data['unblockURL'] = base_url().$this->controller.'/unblock/{ID}';
		$data['deleteURL'] = base_url().$this->controller.'/delete/{ID}';
		$data['searchKeyword'] = $this->session->userdata('userSearchKeyword');
		
		// Load users list view
        $this->data['maincontent'] = $this->load->view('admin/manage_users/index', $data, true);
        $this->load->view($this->layout, $this->data);
    }
	
	/*
     * Add user information
     */
	public function add(){
        $data = array();
        $userData = array();
		
		// If add request is submitted
        if($this->input->post('userSubmit')){
			// Form field validation rules
			$this->form_validation->set_rules('file', '', 'callback_file_check');
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
            $this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_rules('conf_password', 'confirm password', 'required|matches[password]');
			
			// Prepare user data
			$dob = strip_tags($this->input->post('dob'));
			$dob = date("Y-m-d",strtotime($dob));
			$password = $this->input->post('password');
            $userData = array(
                'first_name' => strip_tags($this->input->post('first_name')),
                'last_name' => strip_tags($this->input->post('last_name')),
                'email' => strip_tags($this->input->post('email')),
				'phone' => strip_tags($this->input->post('phone')),
                'password' => password_hash($password, PASSWORD_DEFAULT),
				'gender' => strip_tags($this->input->post('gender')),
				'dob' => $dob,
                'bio' => strip_tags($this->input->post('bio')),
				'status' => strip_tags($this->input->post('status'))
            );
			
			// Validate submitted form data
            if($this->form_validation->run() == true){
				// Profile picture upload
                if(isset($_FILES['picture']['name']) && $_FILES['picture']['name']!=""){
					
					// Upload configuration
					$targetDir = $this->uploadDir;
					$config['upload_path']   = $targetDir;
					$config['allowed_types'] = 'gif|jpg|png|pdf';
					$this->load->library('upload', $config);
					
					// If picture upload is successful
					if($this->upload->do_upload('picture')){
						// Load upload helper
						$this->load->helper('upload');
						
						// Uploaded file data
						$uploadData = $this->upload->data();
						
						// Thumbnail creation
						$uploadedFile = $uploadData['file_name'];
						$sourceImage = $targetDir.$uploadedFile;
						$thumbPath = $targetDir."thumb/";
						create_thumb($sourceImage, $uploadedFile, $thumbPath, 120, 120);
						
						// Uploaded picture name
						$userData['picture'] = $uploadedFile;
					}else{
						$data['error_msg'] = $this->upload->display_errors();
					}
                }
				
				// Insert user data
                $insert = $this->user->insert($userData);
				
				// Check user data insert status
                if($insert){
                    $this->session->set_userdata('success_msg', 'User has been added successfully.');
                    redirect($this->controller);
                }else{
                    $data['error_msg'] = 'Some problems occured, please try again.';
                }
            }
        }
		
		// Define some useful variables for view
        $data['user'] = $userData;
		$data['listURL'] = base_url().$this->controller;
		$data['action'] = 'Add';
        
		// Load the view
        $this->data['maincontent'] = $this->load->view('admin/manage_users/add-edit', $data, true);
        $this->load->view($this->layout, $this->data);
    }
    
    /*
     * User account update
     */
    public function edit($id){
        $data = array();
		
		// Get user data by id
		$userData = $this->user->getRows(array('id'=>$id));
		$prevPicture = $userData['picture'];
		
		// If update request is submitted
        if($this->input->post('userSubmit')){
			// Form field validation rules
			$this->form_validation->set_rules('file', '', 'callback_file_check');
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check[' . $id . ']');
			
			// Prepare user data
			$password = $this->input->post('password');
			if(!empty($password)){
				$this->form_validation->set_rules('password', 'password', 'required');
				$this->form_validation->set_rules('conf_password', 'confirm password', 'required|matches[password]');
			}
			$dob = strip_tags($this->input->post('dob'));
			$dob = date("Y-m-d",strtotime($dob));
            $userData = array(
                'first_name' => strip_tags($this->input->post('first_name')),
                'last_name' => strip_tags($this->input->post('last_name')),
                'email' => strip_tags($this->input->post('email')),
				'phone' => strip_tags($this->input->post('phone')),
                'gender' => strip_tags($this->input->post('gender')),
				'dob' => $dob,
                'bio' => strip_tags($this->input->post('bio')),
				'status' => strip_tags($this->input->post('status'))
            );
			
			if(!empty($password)){
				$userData['password'] = password_hash($password, PASSWORD_DEFAULT);
			}
			
			// Validate submitted form data
            if($this->form_validation->run() == true){
                // Profile picture upload
                if(isset($_FILES['picture']['name']) && $_FILES['picture']['name']!=""){
					// Upload configuration
					$targetDir = $this->uploadDir;
					$config['upload_path']   = $targetDir;
					$config['allowed_types'] = 'gif|jpg|png|pdf';
					$this->load->library('upload', $config);
					
					// If picture upload is successful
					if($this->upload->do_upload('picture')){
						// Load upload helper
						$this->load->helper('upload');
						
						// Uploaded file data
						$uploadData = $this->upload->data();
						
						// Thumbnail creation
						$uploadedFile = $uploadData['file_name'];
						$sourceImage = $targetDir.$uploadedFile;
						$thumbPath = $targetDir."thumb/";
						create_thumb($sourceImage, $uploadedFile, $thumbPath, 120, 120);
						
						// Uploaded picture name
						$userData['picture'] = $uploadedFile;
						
						// Delete previous profile picture
						@unlink($targetDir.$prevPicture);
						@unlink($thumbPath.'thumb/'.$prevPicture);
					}else{
						$data['error_msg'] = $this->upload->display_errors();
					}
                }
				
				// Update user data
                $update = $this->user->update($userData, array('id'=>$id));
				
				// Check user data update status
                if($update){
                    $data['success_msg'] = 'User profile information has been updated successfully.';
                }else{
                    $data['error_msg'] = 'Some problems occured, please try again.';
                }
            }
        }
		
		// Define some useful variables for view
        $userData['picture'] = !empty($userData['picture'])?$userData['picture']:$prevPicture;
        $data['user'] = $userData;
		$data['listURL'] = base_url().$this->controller;
		$data['action'] = 'Edit';
		
		// Load the edit page content view
        $this->data['maincontent'] = $this->load->view('admin/manage_users/add-edit', $data, true);
        $this->load->view($this->layout, $this->data);
    }
	
	/*
     * User profile details
     */
	public function details($id){
		$data = array();
		
		// Check whether user id is not empty
		if(!empty($id)){
			// Get user data
			$data['user'] = $this->user->getRows(array('id'=>$id));
			$data['listURL'] = base_url().$this->controller;
			
			// Load user details view
			$this->data['maincontent'] = $this->load->view('admin/manage_users/details', $data, true);
			$this->load->view($this->layout, $this->data);
		}else{
			// Redirect to list page
			redirect($this->controller);
		}
	}
	
	/*
     * Delete user profile data
     */
	public function delete($id){
		// Check whether page id is not empty
		if($id){
			// Get user data by id
			$userData = $this->user->getRows(array('id'=>$id));
			$prevFile = $userData['picture'];
			
			// Delete user data
			$delete = $this->user->delete($id);
			
			// Check user data delete status
			if($delete){
				// Delete previous file
				@unlink($this->uploadDir.$prevFile);
				@unlink($this->uploadDir.'thumb/'.$prevFile);
				$this->session->set_userdata('success_msg', 'User been removed successfully.');
			}else{
				$this->session->set_userdata('error_msg', 'Some problems occured, please try again.');
			}
		}
		
		// Redirect to list page
		redirect($this->controller);
	}
	
	/*
     * Active user
     */
	public function block($id){
		if($id){
			// Update user status
			$userData = array('status'=>'0');
			$update = $this->user->update($userData, array('id'=>$id));
			
			// Check user data update status
			if($update){
				$this->session->set_userdata('success_msg', 'User have been deactivated successfully.');
			}else{
				$this->session->set_userdata('error_msg', 'Some problems occured, please try again.');
			}
		}
		
		// Redirect to list page
		redirect($this->controller);
	}
	
	/*
     * Inactive user
     */
	public function unblock($id){
		if($id){
			// Update user status
			$userData = array('status'=>'1');
			$update = $this->user->update($userData, array('id'=>$id));
			
			// Check user data update status
			if($update){
				$this->session->set_userdata('success_msg', 'User have been activated successfully.');
			}else{
				$this->session->set_userdata('error_msg', 'Some problems occured, please try again.');
			}
		}
		
		// Redirect to list page
		redirect($this->controller);
	}
    
    /*
     * Existing email check during validation
     */
    public function email_check($str, $id = ''){
        $con['returnType'] = 'count';
        if ($id != '') {
            $con['conditions'] = array('email'=>$str, 'id != ' => $id);
        } else {
            $con['conditions'] = array('email'=>$str);
        }
        $checkEmail = $this->user->getRows($con);
        if($checkEmail > 0){
            $this->form_validation->set_message('email_check', 'The given email already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /*
     * Existing email check during forgot validation
     */
    public function forgot_email_check($str){
        $con['returnType'] = 'count';
        $con['conditions'] = array('email'=>$str);
        $checkEmail = $this->user->getRows($con);
        if($checkEmail > 0){
            return TRUE;
        } else {
            $this->form_validation->set_message('email_check', 'Given email is not associated with any account.');
            return FALSE;
        }
    }
    
    /*
     * Old password check during validation
     */
    public function oldpass_check($str, $id){
        $con = array('id' => $id);
        $checkPass = $this->user->getRows($con);
        if($checkPass && password_verify($str, $checkPass['password'])){
            return TRUE;
        } else {
            $this->form_validation->set_message('oldpass_check', 'The given old password does not match with your account password.');
            return FALSE;
        }
    }
	
	/*
     * File value and type check during validation
     */
    public function file_check($str){
        $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['picture']['name']);
        if(isset($_FILES['picture']['name']) && $_FILES['picture']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only gif/jpg/png file.');
                return false;
            }
        }else{
            return true;
        }
    }
}