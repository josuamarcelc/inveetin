<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CMS Page management class created by CodexWorld
 */
class Cms_Pages extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library('public_init_elements');
        $this->public_init_elements->init_elements();
		
		$this->load->model('cms');
		
		// Default layout
        $this->layout = 'layout';
    }
    
    public function index($slug){
        $data = array();
		
		// Check whether page id is not empty
		if(!empty($slug)){
			// Get cms page data
			$con = array(
				'conditions' => array(
					'page_slug' => $slug,
					'status' => '1'
				),
				'returnType' => 'single'
			);
			$data['page'] = $this->cms->getRows($con);
			// debugvar($this->config->item('base_url'));
			// Load cms page view
			$this->data['maincontent'] = $this->load->view('cms_pages/index', $data, true);
			$this->load->view($this->layout, $this->data);
		}else{
			// Redirect to list page
			redirect('/');
		}
    }
}