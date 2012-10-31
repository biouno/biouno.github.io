<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Team extends CI_Controller {

	public $title = 'Team';
	
	public $layout = 'biouno_v2';
    
	public function index()
	{
		$this->load->view('team');
	}
}

/* End of file team.php */
/* Location: ./application/controllers/team.php */