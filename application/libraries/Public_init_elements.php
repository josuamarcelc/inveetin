<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Public Init Elements Class
 *
 * This class separates view by elements for the frontend
 *
 * @package		CodeIgniter
 * @category	Libraries
 * @author		CodexWorld Dev Team
 * @link		https://www.codexworld.com/
 * @license	http://www.codexworld.com/license
 */
class Public_init_elements {

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
		$this->init_nav();
        $this->init_header();
        $this->init_footer();
    }
	
	/*
	 * Head view
	 */
    function init_head() {
        $data = array();
		$this->CI->load->model('settings');
        $data['siteSettings'] = $this->CI->settings->getRow();
        $this->CI->data['head'] = $this->CI->load->view('elements/head', $data, true);
    }
	
	/*
	 * Top navigation view
	 */
    function init_nav() {
        $data = array();
        $this->CI->data['navigation'] = $this->CI->load->view('elements/navigation', $data, true);
    }
    
	/*
	 * Header view
	 */
    function init_header() {
        $data = array();
        $this->CI->data['header'] = $this->CI->load->view('elements/header', $data, true);
    }
	
	/*
	 * Footer view
	 */
    function init_footer() {
        $data = array();
        $this->CI->data['footer'] = $this->CI->load->view('elements/footer', $data, true);
    }

}
