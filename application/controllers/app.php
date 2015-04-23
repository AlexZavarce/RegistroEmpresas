<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class App extends CI_Controller {
	public function home()
	{
		$this->load->view('app');
	}
}
