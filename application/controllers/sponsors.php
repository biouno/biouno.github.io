<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sponsors extends CI_Controller {

	public $title = 'Sponsors';
	
	public $layout = 'biouno_v2';
    
	public function index()
	{
		$this->load->view('sponsors');
	}
}

/* End of file sponsors.php */
/* Location: ./application/controllers/sponsors.php */