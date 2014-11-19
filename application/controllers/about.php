<?php if (!defined('BASEPATH')) die();
class About extends Main_Controller {

   public function index()
	{
		// Load dependencies
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
		
		
		// Load view
    $this->load->view('include/header');
    $this->load->view('templates/menubar');
    $this->load->view('about');
    $this->load->view('include/footer');
	}
   
}

/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */
