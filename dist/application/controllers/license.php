<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class License extends CI_Controller {

	public $title = 'License';
	
	public $layout = 'biouno_v2';
    
	public function index()
	{
		$this->load->view('license');
	}
}

/* End of file license.php */
/* Location: ./application/controllers/license.php */