<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Site Settings Management class created by CodexWorld
 */
class Site_settings extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library('admin_init_elements');
		$this->admin_init_elements->is_admin_loggedin();
        $this->admin_init_elements->init_elements();
		$this->adminId = $this->session->userdata('adminId');
        $this->load->library('form_validation');
		$this->load->model('settings');
		
		// Default layout
        $this->layout = 'admin/layout';
		
		// Default controller
		$this->controller = 'admin/site_settings';
		
		// Per page data limit
		$this->perPage = 10;
    }
    
    public function index(){
        $this->edit();
    }
    
    /*
     * Update site settings
     */
    public function edit(){
        $data = array();
		
		// Get site settings
		$siteData = $this->settings->getRow();
		
		// If update request is submitted
        if($this->input->post('siteSubmit')){
			// Form field validation rules
            $this->form_validation->set_rules('title', 'site title', 'required');
			$this->form_validation->set_rules('name', 'site name', 'required');
			$this->form_validation->set_rules('admin_email', 'admin email', 'required');
			$this->form_validation->set_rules('contact_email', 'contact email', 'required');
			
			// Prepare settings data
            $siteData = array(
				'title' => strip_tags($this->input->post('title')),
				'name' => strip_tags($this->input->post('name')),
				'admin_email' => strip_tags($this->input->post('admin_email')),
				'contact_email' => strip_tags($this->input->post('contact_email')),
				'email_type' => strip_tags($this->input->post('email_type')),
				'smtp_host' => strip_tags($this->input->post('smtp_host')),
				'smtp_port' => strip_tags($this->input->post('smtp_port')),
				'smtp_user' => strip_tags($this->input->post('smtp_user')),
				'smtp_pass' => strip_tags($this->input->post('smtp_pass')),
				'facebook_url' => strip_tags($this->input->post('facebook_url')),
				'twitter_url' => strip_tags($this->input->post('twitter_url')),
				'linkedin_url' => strip_tags($this->input->post('linkedin_url'))
            );
			
			// Validate submitted form data
            if($this->form_validation->run() == true){
				// Update site settings
                $update = $this->settings->update($siteData);
				
				// Check page data update status
                if($update){
                    $data['success_msg'] = 'Site settings has been updated successfully.';
                }else{
                    $data['error_msg'] = 'Some problems occured, please try again.';
                }
            }
        }
		
		// Define some useful variables for view
        $data['settings'] = $siteData;
		$data['listURL'] = base_url().$this->controller;
		$data['action'] = 'Edit';
		
		// Load the edit page content view
        $this->data['maincontent'] = $this->load->view('admin/site_settings/edit', $data, true);
        $this->load->view($this->layout, $this->data);
    }

}