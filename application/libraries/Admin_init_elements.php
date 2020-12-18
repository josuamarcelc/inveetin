<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Admin Init Elements Class
 *
 * This class separates view by elements for the admin panel
 *
 * @package		CodeIgniter
 * @category	Libraries
 * @author		CodexWorld Dev Team
 * @link		https://www.codexworld.com/
 * @license	http://www.codexworld.com/license
 */
class Admin_init_elements {

    var $CI;
    var $data;

    function __construct() {
        $this->CI = & get_instance();
    }
	
	/*
	 * Initialize elements
	 */
    function init_elements($args = array()) {
        $this->init_head();
        $this->init_header();
        $this->init_navigation();
        $this->init_footer();
    }
	
	/*
	 * Check admin login status
	 */
    function is_admin_loggedin() {
        if (!$this->CI->session->userdata('isAdminLoggedIn') && $this->CI->session->userdata('adminId') == '') {
            redirect('admin/login');
        }
    }
	
	/*
	 * Head view
	 */
    function init_head() {
        $data = array();
		$this->CI->load->model('settings');
        $data['siteSettings'] = $this->CI->settings->getRow();
        $this->CI->data['head'] = $this->CI->load->view('admin/elements/head', $data, true);
    }
    
	/*
	 * Header view
	 */
    function init_header() {
        $data = array();
		$adminSessName = $this->CI->session->userdata('adminFirstName').' '.$this->CI->session->userdata('adminLastName');
		$adminSessPic = $this->CI->session->userdata('adminPicture');
		$adminPicURL = $this->CI->config->item('upload_url').'profile_picture/thumb/'.$adminSessPic;
		$adminPicPath = 'uploads/profile_picture/thumb/'.$adminSessPic;
        $adminPic = !empty($adminSessPic) && file_exists($adminPicPath)?$adminPicURL:$this->CI->config->item('public_url_admin').'images/admin-profile-pic.png';
        $data['userSessPic'] = $adminPic;
        $data['userSessName'] = $adminSessName;
		$this->CI->load->model('settings');
        $data['siteSettings'] = $this->CI->settings->getRow();
        $this->CI->data['header'] = $this->CI->load->view('admin/elements/header', $data, true);
    }
    
	/*
	 * Header left navigation bar view
	 */
    function init_navigation() {
        $data = array();
		$this->CI->load->model('settings');
        $data['siteSettings'] = $this->CI->settings->getRow();
        $this->CI->data['navigation_sidebar'] = $this->CI->load->view('admin/elements/navigation-sidebar', $data, true);
    }
	
	/*
	 * Footer view
	 */
    function init_footer() {
        $data = array();
        $this->CI->data['footer'] = $this->CI->load->view('admin/elements/footer', $data, true);
    }

}
