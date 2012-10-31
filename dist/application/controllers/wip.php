<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class WIP extends CI_Controller {

	public $title = 'Work In Progress';
	
	public $layout = 'biouno_v2';
    
	public function index()
	{
		$this->load->view('wip');
	}
}

/* End of file wip.php */
/* Location: ./application/controllers/wip.php */