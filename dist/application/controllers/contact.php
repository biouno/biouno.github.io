<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

	public $title = 'Contact';
	
	public $layout = 'biouno_v2';
    
	public function index()
	{
		$this->load->view('contact');
	}
}

/* End of file contact.php */
/* Location: ./application/controllers/contact.php */