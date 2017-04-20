<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alegraapi
{
	protected $ci;

	public function __construct()
	{
        $this->ci =& get_instance();

		$xml_data=array(
			'name'=>'pedrito'
			);
        $url = "https://app.alegra.com/api/v1/contacts";
        $page = "/contacts";
        $headers = array(
            //"method: POST",
            "Accept: */*",
            "Accept: text/xml",
            "accept-encoding: gzip, deflate",
            "content-type: application/json",
            //"Pragma: no-cache",
            //"SOAPAction: \"run\"",
            //"Content-length: ".strlen($xml_data),
            "authorization: Basic " . 'ZGF2aWRfMzRfNjEyQGhvdG1haWwuY29tOjNkNzQ2ZmU4ZGQzNjRjZGFiZGNl'
        );
      
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
       
        // Apply the XML to our curl call
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($xml_data));

        $data = curl_exec($ch); 


	}

	

}

/* End of file alegraApi.php */
/* Location: ./application/libraries/alegraApi.php */
