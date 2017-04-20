<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lenguaje extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->CI = & get_instance();
	}

	public function langs()
	{
		$lenguaje = $this->input->post('lang');
		$langs = ($lenguaje != '') ? $lenguaje : 'espanish';
		$this->session->set_userdata('zeo_site',$langs);

		$data['lang'] = $this->session->set_userdata('zeo_site',$langs);
		//echo $this->uri->uri_string();
		echo json_encode($data);

	}

	private function changes($langi)
	{

		$this->CI->load->helper('language');

		$langs = ($langi != '') ? $langi : 'espanish';
		$this->session->set_userdata('zeo_site',$langs);
		$this->CI->lang->load('pagez',$this->session->userdata('zeo_site'));

		redirect(base_url(),'location');

	}

}

/* End of file  */
/* Location: ./application/controllers/ */