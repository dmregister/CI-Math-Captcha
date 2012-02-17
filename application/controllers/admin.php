<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Login extends CI_Controller  {

	public function __construct(){
		parent::__construct();
		$this->load->library(array('Mathcaptcha','form'));
    }
	
	public function index(){
		$this->load->view('login');
	}
	
	public function login(){
		
		$data['message'] = null;
		$data['captcha_error'] = null;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'username', 'required|xss_clean');			
		$this->form_validation->set_rules('password', 'password', 'required|xss_clean');
		$this->form_validation->set_rules('secure', 'captcha', 'required|xss_clean');
		
		$this->form_validation->set_error_delimiters('<br /><span class="error">', '</span><br />');
	
		if ($this->form_validation->run() == TRUE && $this->input->post('secure') == $this->session->userdata('security_number')) 
		{	
			echo "login successful";
			
		}
		else
		{	
			$data['captcha_error'] = 'Incorrect captcha answer. Its ok to use a calculator.';
			$this->load->view('admin/login', $data);
		}
	}
	
	public function captcha(){
		echo "<img src='".$this->mathcaptcha->generate_captcha()."' alt='captcha'/>";
	}
	
}