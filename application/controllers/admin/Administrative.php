<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Administrative account management class created by CodexWorld
 */
class Administrative extends CI_Controller {
   
    function __construct() {
        parent::__construct();
        $this->load->library('admin_init_elements');
        $this->admin_init_elements->init_elements();
		
		$this->load->library('form_validation');
        $this->load->model('admin_user');
		
		// Check whether user ID is available in cookie or session
		$this->load->helper('cookie');
		$rememberAdminId = get_cookie('rememberAdminId');
		$isAdminLoggedIn = $this->session->userdata('isAdminLoggedIn');
		if(!$isAdminLoggedIn && !empty($rememberAdminId)){
			// Get admin account info
			$adminInfo = $this->admin_user->getRows(array('id' => $rememberAdminId));
			$sessData = array('isAdminLoggedIn' => TRUE, 'adminId' => $rememberAdminId, 'adminFirstName' => $adminInfo['first_name'], 'adminLastName' => $adminInfo['last_name'], 'adminEmail' => $adminInfo['email'], 'adminPicture' => $adminInfo['picture']);
            $this->session->set_userdata($sessData);
			$this->adminId = $rememberAdminId;
		}elseif($isAdminLoggedIn){
            $this->adminId = $this->session->userdata('adminId');
        }else{
            $this->adminId = '';
        }
		
		// Default upload dir
        $this->uploadDir = $this->config->item('upload_path').'profile_picture/';
		
		// Default layout
        $this->layout = 'admin/layout';

		// Default login layout
        $this->layoutLogin = 'admin/layout-login';
    }
   
    public function index(){
		// Load dashboard for logged-in user, login page for other user
        if($this->adminId){
            $this->dashboard();
        }else{
            $this->login();
        }
    }
	
	/*
     * Admin login
     */
    public function login(){
		// Redirect logged in user to dashboard
        if($this->adminId){
            redirect('/admin/dashboard');
        }
		
		$data = array();      
        
		// Get messages from the session
        if($this->session->userdata('success_msg')){
            $data['success_msg'] = $this->session->userdata('success_msg');
            $this->session->unset_userdata('success_msg');
        }
        if($this->session->userdata('error_msg')){
            $data['error_msg'] = $this->session->userdata('error_msg');
            $this->session->unset_userdata('error_msg');
        }
		
		// If login request is submitted
        if($this->input->post('loginSubmit')){
			// Form field validation rules
            $this->form_validation->set_rules('username', 'username', 'required');
            $this->form_validation->set_rules('password', 'password', 'required');
			
			// Validate submitted form data
            if ($this->form_validation->run() == true) {
				// Check whether user exists in the database
				$username = $this->input->post('username');
				$password = $this->input->post('password');
                $condition = array(
                    'username' => $username,
                    'status' => 'Active',
                    'is_deleted' => '0'
                   
                );
                $checkLogin = $this->admin_user->loginCheck($condition);
                if($checkLogin && password_verify($password, $checkLogin['password'])){
					// If remember me is checked
					if ($this->input->post('rememberMe') == 1) {
						$remeberCookie = array(
							'name' => 'rememberAdminId',
							'value' => $checkLogin['id'],
							'expire' => time() + 86400,
						);
						$this->input->set_cookie($remeberCookie);
					}
					
					// Set variables in session
                    $sessData = array('isAdminLoggedIn' => TRUE, 'adminId' => $checkLogin['id'], 'adminFirstName' => $checkLogin['first_name'], 'adminLastName' => $checkLogin['last_name'], 'adminEmail' => $checkLogin['email'], 'adminPicture' => $checkLogin['picture']);
                    $this->session->set_userdata($sessData);
					
					// Redirect to dashboard
                    redirect('/admin');
                }else{
                    $data['error_msg'] = 'Wrong username or password, please try again.';
                }
            }
        }
		
		// Load the login view
        $this->data['maincontent'] = $this->load->view('admin/administrative/login', $data, true);
        $this->load->view($this->layoutLogin, $this->data);
    }
	
	/*
     * Admin account forgot password
     */
    public function forgotPassword(){
		// Redirect logged in user to dashboard
        if($this->adminId){
            redirect('/admin/dashboard');
        }
		
        $data = array();
        $userData = array();
        $frmDis = 1;
		
		// If forgot password request is submitted
        if($this->input->post('forgotSubmit')){
			// Form field validation rules
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_forgot_email_check');
			
			// Posted form data
            $email = strip_tags($this->input->post('email'));
            $userData = array(
                'email' => $email
            );
			
			// Validate submitted form data
            if($this->form_validation->run() == true){
				// Unique forgot password identity code
                $uniqidStr = md5(uniqid(mt_rand()));
				
				// Insert unique code
                $forgotData = array('forgot_pass_identity' => $uniqidStr);
                $update = $this->admin_user->update($forgotData, array('email' => $email));
				
				// Check unique code update status
                if($update){
					// Send reset password email
                    forgotPassEmail($email);
					
					// Store the status message
                    $data['success_msg'] = 'Please check your e-mail, we\'ve sent a password reset link to your registered email.';
                }else{
                    $data['error_msg'] = 'Some problems occured, please try again.';
                }
                $frmDis = 0;
            }
        }
        $data['frmDis'] = $frmDis;
        $data['user'] = $userData;
		
        // Load the forgot password view
        $this->data['maincontent'] = $this->load->view('admin/administrative/forgot-password', $data, true);
        $this->load->view($this->layoutLogin, $this->data);
    }
    
    /*
     * Admin account reset password
     */
    public function resetPassword($fp_code){
		// Redirect logged in user to dashboard
        if($this->adminId){
            redirect('/admin/dashboard');
        }
		
		$data = array();
		
		// If unique forgot password identity code is available
        if(!empty($fp_code)){
			// If reset password request is submitted
            if($this->input->post('resetSubmit')){
				// Form field validation rules
                $this->form_validation->set_rules('password', 'password', 'required');
                $this->form_validation->set_rules('conf_password', 'confirm password', 'required|matches[password]');
                
				// Validate submitted form data
                if($this->form_validation->run() == true){
					// Check whether the unique code exists in the database
                    $con['returnType'] = 'count';
                    $con['conditions'] = array(
                        'forgot_pass_identity' => $fp_code
                    );
                    $checkUser = $this->admin_user->getRows($con);
					
					// If forgot password identity code is matched
                    if($checkUser > 0){
						// Update new password
						$password = $this->input->post('password');
                        $resetData = array('password' => password_hash($password, PASSWORD_DEFAULT));
                        $update = $this->admin_user->update($resetData, array('forgot_pass_identity' => $fp_code));
						
						// Check password update status
                        if($update){
							// Store the status message
                            $this->session->set_userdata('success_msg', 'Your account password has been reset successfully. Please login with your new password.');
							
							// Redirect to login page
                            redirect('admin/login');
                        }else{
                            $data['error_msg'] = 'Some problems occured, please try again.';
                        }
                    }else{
                        $this->session->set_userdata('error_msg', 'You does not authorized to reset new password of this account.');
                        redirect('admin/login');
                    }
                }
            }

            // Load the admin reset password view
            $this->data['maincontent'] = $this->load->view('admin/administrative/reset-password', $data, true);
            $this->load->view($this->layoutLogin, $this->data);
        }else{
            redirect('admin/login/');
        }
    }
    
    /*
     * Admin logout
     */
    public function logout(){
		// Remove cookie data
		delete_cookie('rememberAdminId');
		
		// Remove session data
        $this->session->unset_userdata('isAdminLoggedIn');
        $this->session->unset_userdata('adminId');
        $this->session->sess_destroy();
		
		// Redirect to login page
        redirect('admin/login/');
    }
	
	/*
     * Admin dashboard
     */
    public function dashboard(){
		$data = array();
		
		// Check admin login status
        $this->admin_init_elements->is_admin_loggedin();
		
		// Load respective models
		$this->load->model('user');
		$this->load->model('cms');
		
		// Get memebers count
		$conM['returnType'] = 'count';
		$data['totalMemberNum'] = $this->user->getRows($conM);
		
		// Get cms pages count
		$conP['returnType'] = 'count';
		$data['totalCmsNum'] = $this->cms->getRows($conP);
		
		// Load admin dashboard view
        $this->data['maincontent'] = $this->load->view('admin/administrative/dashboard', $data, true);
        $this->load->view($this->layout, $this->data);
    }
    
    /*
     * Admin account information update
     */
    public function profile(){
		// Check admin login status
        $this->admin_init_elements->is_admin_loggedin();
		
        $data = array();
		$data['infoTab'] = 'active';
		$data['settingsTab'] = '';
		
		// Get admin information
		$userData = $this->admin_user->getRows(array('id' => $this->adminId));
		$prevPicture = $userData['picture'];
		
		// If update request is submitted
        if($this->input->post('updateProfile')){
			// Form field validation rules
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check[' . $this->adminId . ']');
			$this->form_validation->set_rules('username', 'Username', 'callback_username_check[' . $this->adminId . ']');
			$this->form_validation->set_rules('file', '', 'callback_file_check');
			
			// Get submitted form data
			$first_name = strip_tags($this->input->post('first_name'));
			$last_name = strip_tags($this->input->post('last_name'));
			$email = strip_tags($this->input->post('email'));
            $userData = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email
            );
			$username = strip_tags($this->input->post('username'));
			if(!empty($username)){
				$userData['username'] = $username;
			}
			
			// Validate form data
            if($this->form_validation->run() == true){
				// Profile picture upload
				$uploadedFile = '';
                if(isset($_FILES['picture']['name']) && $_FILES['picture']['name']!=""){

					// Upload configuration
					$targetDir = $this->uploadDir;
					$config['upload_path']   = $targetDir;
					$config['allowed_types'] = 'gif|jpg|png|pdf';
					$this->load->library('upload', $config);
					
					// Upload profile picture
					if($this->upload->do_upload('picture')){
						// Load upload helper
						$this->load->helper('upload');
						
						$uploadData = $this->upload->data();
						$uploadedFile = $uploadData['file_name'];
						
						// Create thumbnail
						$sourceImage = $targetDir.$uploadedFile;
						$thumbPath = $targetDir."thumb/";
						create_thumb($sourceImage, $uploadedFile, $thumbPath, 128, 128);
						
						$userData['picture'] = $uploadedFile;
					}else{
						$data['error_msg'] = $this->upload->display_errors();
					}
                }
				
				// Update admin account data
                $update = $this->admin_user->update($userData, array('id' => $this->adminId));
				
				// Store status message
                if($update){
					// Delete previous profile picture
					if(!empty($uploadedFile)){
						@unlink($this->uploadDir.$prevPicture);
						@unlink($this->uploadDir.'thumb/'.$prevPicture);
						
						// Update admin picture in session
						$this->session->unset_userdata('adminPicture');
						$this->session->set_userdata('adminPicture', $uploadedFile);
					}
					
					// Update admin name in session
					$this->session->unset_userdata('adminFirstName');
					$this->session->set_userdata('adminFirstName', $first_name);
					$this->session->unset_userdata('adminLastName');
					$this->session->set_userdata('adminLastName', $last_name);
						
                    $data['success_msg'] = 'Your profile information has been updated successfully.';
                }else{
                    $data['error_msg'] = 'Some problems occured, please try again.';
                }
				$this->admin_init_elements->init_elements();
            }
			$data['infoTab'] = '';
			$data['settingsTab'] = 'active';
        }elseif($this->input->post('updatePassword')){
			// Form field validation rules
            $this->form_validation->set_rules('old_password', 'old password', 'required|callback_oldpass_check[' . $this->adminId . ']');
            $this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_rules('conf_password', 'confirm password', 'required|matches[password]');
			
			// Validate submitted form data
			if($this->form_validation->run() == true){
				// Prepare admin data
				$password = $this->input->post('password');
                $newPassword = password_hash($password, PASSWORD_DEFAULT);
				$userDataP = array('password' => $newPassword);
				
				// Update admin account data
                $update = $this->admin_user->update($userDataP, array('id' => $this->adminId));
				
				// Store status message
				if($update){ 
					$data['success_msg'] = 'Your profile password has been updated successfully.';
				}else{
					$data['error_msg'] = 'Some problems occured, please try again.';
				}
			}
			$data['infoTab'] = '';
			$data['settingsTab'] = 'active';
        }
		
		// Get admin account data
        $data['user'] = $userData;
		
		// Load update form view
        $this->data['maincontent'] = $this->load->view('admin/administrative/profile', $data, true);
        $this->load->view($this->layout, $this->data);
    }
	
	/*
     * Old password check during validation
     */
    public function oldpass_check($str, $id){
        $con = array('id' => $id);
        $checkPass = $this->admin_user->getRows($con);
        if($checkPass && password_verify($str, $checkPass['password'])){
            return TRUE;
        } else {
            $this->form_validation->set_message('oldpass_check', 'The given old password does not match with your account password.');
            return FALSE;
        }
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
        $checkEmail = $this->admin_user->getRows($con);
        if($checkEmail > 0){
            $this->form_validation->set_message('email_check', 'The given email already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
	/*
     * Existing username check during validation
     */
	public function username_check($str, $id = ''){
		if(!empty($str)){
			$con['returnType'] = 'count';
			if ($id != '') {
				$con['conditions'] = array('username'=>$str, 'id != ' => $id);
			} else {
				$con['conditions'] = array('username'=>$str);
			}
			$checkUsername = $this->admin_user->getRows($con);
			if($checkUsername > 0){
				$this->form_validation->set_message('username_check', 'The given username already exists.');
				return FALSE;
			} else {
				return TRUE;
			}
		}else{
			return TRUE;
		}
    }
    
	/*
     * Existing email check during forgot password validation
     */
    public function forgot_email_check($str){
        $checkEmail = $this->admin_user->fieldValueCheck(array('email'=>$str));
        if($checkEmail){
            return TRUE;
        } else {
            $this->form_validation->set_message('forgot_email_check', 'Given email is not associated with admin account.');
            return FALSE;
        }
    }
	
	/*
     * file value and type check during validation
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