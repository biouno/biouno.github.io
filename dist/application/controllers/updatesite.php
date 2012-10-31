<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UpdateSite extends CI_Controller {

	public $title = 'Update Site';
	
	public $layout = 'biouno_v2';
    
	public function index()
	{
		$this->load->view('updatesite');
	}
}

/* End of file updatesite.php */
/* Location: ./application/controllers/updatesite.php */