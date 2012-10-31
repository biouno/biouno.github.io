<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class JenkinsPlugins extends CI_Controller {

	public $title = 'Jenkins Plug-ins';
	
	public $layout = 'biouno_v2';
    
	public function index()
	{
		$this->load->view('jenkinsplugins');
	}
}

/* End of file jenkinsplugins.php */
/* Location: ./application/controllers/jenkinsplugins.php */