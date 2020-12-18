<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Homepage management class created by CodexWorld
 */
class Home extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library('public_init_elements');
        $this->public_init_elements->init_elements();
		
		// Default layout
        $this->layout = 'layout';
		
		// Default controller
		$this->controller = 'home';
    }
    
    public function index(){
        $data = array();
		
		// Load homepage view
        $this->data['maincontent'] = $this->load->view('home/index', $data, true);
        $this->load->view($this->layout, $this->data);
    }
}