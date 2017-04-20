<?php 

class LenguajeLoad {

    function __construct() {
       $this->CI = & get_instance();
    }

	function inicializar(){
		
		$this->CI->load->helper('language');

		$sitiolang = $this->CI->session->userdata('zeo_site');
		if($sitiolang){
			$this->CI->lang->load('pagez',$this->CI->session->userdata('zeo_site'));
		} else {
			$this->CI->lang->load('pagez','espanish');
		}

	}

}