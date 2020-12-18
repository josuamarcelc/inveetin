<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Reset new password email sender function
 */
if(! function_exists('forgotPassEmail')){
	function forgotPassEmail($userEmail){
        $ci =& get_instance();
		$ci->load->model('settings');
		$ci->load->library('email');
		
		$siteSettings = $ci->settings->getRow();

		$linkPart = 'admin/administrative/resetPassword/';
		
		$ci->load->model('admin_user');
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'email' => $userEmail
        );
        $user = $ci->admin_user->getRows($con);
        $resetPassLink = base_url().$linkPart.$user['forgot_pass_identity'];
        $mailContent = '<p>Dear <strong>'.$user['first_name'].'</strong>,</p>
        <p>Recently a request was submitted to reset a password for your account. If this was a mistake, just ignore this email and nothing will happen.</p>
        <p>To reset your password, visit the following link: <a href="'.$resetPassLink.'">'.$resetPassLink.'</a></p>
        <p>Regards,<br/><strong>Team '.$siteSettings['name'].'</strong></p>';
		
		if($siteSettings['email_type'] == '2' && !empty($siteSettings['smtp_host']) && !empty($siteSettings['smtp_port']) && !empty($siteSettings['smtp_user']) && !empty($siteSettings['smtp_pass'])){
			$ci->email->set_mailtype("html");
			$ci->email->set_newline("\r\n");
			
			// SMTP & mail configuration
			$config = array(
				'protocol'  => 'smtp',
				'smtp_host' => $siteSettings['smtp_host'],
				'smtp_port' => $siteSettings['smtp_port'],
				'smtp_user' => $siteSettings['smtp_user'],
				'smtp_pass' => $siteSettings['smtp_pass'],
				'mailtype'  => 'html',
				'charset'   => 'utf-8'
			);
		}else{
			$config['mailtype'] = 'html';
		}
        $ci->email->initialize($config);
        $ci->email->to($user['email']);
        $ci->email->from($siteSettings['contact_email'], $siteSettings['name']);
        $ci->email->subject('Password Update Request | '.$siteSettings['name']);
        $ci->email->message($mailContent);
		$ci->email->send();
        return true;
    }
}