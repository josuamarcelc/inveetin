<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CMS Pages Management class created by CodexWorld
 */
class Manage_cms extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library('admin_init_elements');
		$this->admin_init_elements->is_admin_loggedin();
        $this->admin_init_elements->init_elements();
		$this->adminId = $this->session->userdata('adminId');
        $this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->model('cms');
		
		// Default layout
        $this->layout = 'admin/layout';
		
		// Default controller
		$this->controller = 'admin/manage_cms';
		
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
				$this->session->set_userdata('cmsSearchKeyword',$searchKeyword);
			}else{
				$this->session->unset_userdata('cmsSearchKeyword');
			}
		}elseif($this->input->post('submitSearchReset')){
			$this->session->unset_userdata('cmsSearchKeyword');
		}
		
		// Get total rows count of the cms pages
		$conditions['searchKeyword'] = $this->session->userdata('cmsSearchKeyword');
		$conditions['returnType'] = 'count';
		$totalRec = $this->cms->getRows($conditions);
		
		// Pagination config
		$config['base_url']    = base_url().$this->controller.'/index/';
		$config['uri_segment'] = 4;
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config = adminPaginationConfig($config); // Additional config for label and tags
		$this->pagination->initialize($config);
		
		$page = $this->uri->segment(4);
		$offset = !$page?0:$page;
		
		// Get rows of the cms pages
		$conditions['returnType'] = '';
		$conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		$data['cms'] = $this->cms->getRows($conditions);
		
		// Define some useful variables for view
		$data['listURL'] = base_url().$this->controller;
		$data['addURL'] = base_url().$this->controller.'/add';
		$data['editURL'] = base_url().$this->controller.'/edit/{ID}';
		$data['detailsURL'] = base_url().$this->controller.'/details/{ID}';
		$data['blockURL'] = base_url().$this->controller.'/block/{ID}';
		$data['unblockURL'] = base_url().$this->controller.'/unblock/{ID}';
		$data['deleteURL'] = base_url().$this->controller.'/delete/{ID}';
		$data['searchKeyword'] = $this->session->userdata('cmsSearchKeyword');
		
		// Load cms pages list view
        $this->data['maincontent'] = $this->load->view('admin/manage_cms/index', $data, true);
        $this->load->view($this->layout, $this->data);
    }
	
	/*
     * Add cms page content
     */
	public function add(){
        $data = array();
        $cmsData = array();
		
		// If add request is submitted
        if($this->input->post('cmsSubmit')){
			// Form field validation rules
            $this->form_validation->set_rules('title', 'page title', 'required|callback_title_check');
            $this->form_validation->set_rules('content', 'page content', 'required');
			
			// Prepare cms page data
			$pageTitle = strip_tags($this->input->post('title'));
			$pageSlug = strip_tags($this->input->post('page_slug'));
			if(!empty($pageSlug)){
				$cmsCon['returnType'] = 'count';
				$cmsCon['conditions']['page_slug'] = trim($pageSlug);
				$checkSlug = $this->cms->getRows($cmsCon);
				$pageSlug = ($checkSlug > 0)?$pageSlug.'-'.($checkSlug+1):trim($pageSlug);
			}else{
				$pageSlug = url_title($pageTitle, '-', TRUE);
			}
			
			$pageContent = $_REQUEST['content'];
            $cmsData = array(
                'page_slug' => $pageSlug,
                'title' => $pageTitle,
                'content' => $pageContent,
				'status' => strip_tags($this->input->post('status'))
            );
			
			// Validate submitted form data
            if($this->form_validation->run() == true){
				// Insert cms page data
                $insert = $this->cms->insert($cmsData);
				
				// Check page data insert status
                if($insert){
					// Store the status message
                    $this->session->set_userdata('success_msg', 'CMS page has been added successfully.');
					
					// Redirect to list page
                    redirect($this->controller);
                }else{
                    $data['error_msg'] = 'Some problems occured, please try again.';
                }
            }
        }
		
		// Define some useful variables for view
        $data['cms'] = $cmsData;
		$data['listURL'] = base_url().$this->controller;
		$data['action'] = 'Add';
		
        // Load the add page content view
        $this->data['maincontent'] = $this->load->view('admin/manage_cms/add-edit', $data, true);
        $this->load->view($this->layout, $this->data);
    }
    
    /*
     * Update cms page content
     */
    public function edit($id){
        $data = array();
		
		// Get cms page data
		$cmsData = $this->cms->getRows(array('id'=>$id));
		
		// If update request is submitted
        if($this->input->post('cmsSubmit')){
			// Form field validation rules
			$this->form_validation->set_rules('title', 'page title', 'required|callback_title_check[' . $id . ']');
            $this->form_validation->set_rules('content', 'page content', 'required');
			
			// Prepare cms page data
			$pageTitle = strip_tags($this->input->post('title'));
			$pageSlug = strip_tags($this->input->post('page_slug'));
			if(!empty($pageSlug)){
				$cmsCon['returnType'] = 'count';
				$cmsCon['conditions'] = array('page_slug' => trim($pageSlug), 'id != ' => $id);
				$checkSlug = $this->cms->getRows($cmsCon);
				$pageSlug = ($checkSlug > 0)?$pageSlug.'-'.($checkSlug+1):trim($pageSlug);
			}else{
				$pageSlug = url_title($pageTitle, '-', TRUE);
			}
			
			$pageContent = $_REQUEST['content'];
            $cmsData = array(
                'page_slug' => $pageSlug,
                'title' => $pageTitle,
                'content' => $pageContent,
				'status' => strip_tags($this->input->post('status'))
            );
			
			// Validate submitted form data
            if($this->form_validation->run() == true){
				// Update cms page data
                $update = $this->cms->update($cmsData, array('id'=>$id));
				
				// Check page data update status
                if($update){
                    $data['success_msg'] = 'CMS page has been updated successfully.';
                }else{
                    $data['error_msg'] = 'Some problems occured, please try again.';
                }
            }
        }
		
		// Define some useful variables for view
        $data['cms'] = $cmsData;
		$data['listURL'] = base_url().$this->controller;
		$data['action'] = 'Edit';
		
		// Load the edit page content view
        $this->data['maincontent'] = $this->load->view('admin/manage_cms/add-edit', $data, true);
        $this->load->view($this->layout, $this->data);
    }
	
	/*
     * CMS page details
     */
	public function details($id){
		$data = array();
		
		// Check whether page id is not empty
		if(!empty($id)){
			// Get cms page data
			$data['cms'] = $this->cms->getRows(array('id'=>$id));
			
			$data['listURL'] = base_url().$this->controller;
			
			// Load cms page details view
			$this->data['maincontent'] = $this->load->view('admin/manage_cms/details', $data, true);
			$this->load->view($this->layout, $this->data);
		}else{
			// Redirect to list page
			redirect($this->controller);
		}
	}
	
	/*
     * Delete cms page data
     */
	public function delete($id){
		// Check whether page id is not empty
		if($id){
			// Delete page content
			$delete = $this->cms->delete($id);
			
			// Check page data delete status
			if($delete){
				$this->session->set_userdata('success_msg', 'CMS page been removed successfully.');
			}else{
				$this->session->set_userdata('error_msg', 'Some problems occured, please try again.');
			}
		}
		// Redirect to list page
		redirect($this->controller);
	}
	
	/*
     * Change status of the  CMS page
     */
	public function block($id){
		if($id){
			// Update page status
			$cmsData = array('status'=>'0');
			$update = $this->cms->update($cmsData, array('id'=>$id));
			
			// Check page data update status
			if($update){
				$this->session->set_userdata('success_msg', 'CMS page have been deactivated successfully.');
			}else{
				$this->session->set_userdata('error_msg', 'Some problems occured, please try again.');
			}
		}
		
		// Redirect to list page
		redirect($this->controller);
	}
	
	/*
     * Change status of the  CMS page
     */
	public function unblock($id){
		if($id){
			// Update page status
			$cmsData = array('status'=>'1');
			$update = $this->cms->update($cmsData, array('id'=>$id));
			
			// Check page data update status
			if($update){
				$this->session->set_userdata('success_msg', 'CMS page have been activated successfully.');
			}else{
				$this->session->set_userdata('error_msg', 'Some problems occured, please try again.');
			}
		}
		
		// Redirect to list page
		redirect($this->controller);
	}
    
    /*
     * Existing title check during validation
     */
    public function title_check($str, $id = ''){
        $con['returnType'] = 'count';
        if ($id != '') {
            $con['conditions'] = array('title'=>$str, 'id != ' => $id);
        } else {
            $con['conditions'] = array('title'=>$str);
        }
        $checkEmail = $this->cms->getRows($con);
        if($checkEmail > 0){
            $this->form_validation->set_message('title_check', 'The given title already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
}