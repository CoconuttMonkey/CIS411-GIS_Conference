<?php if (!defined('BASEPATH')) die();
class About extends Main_Controller {

   public function index()
	{
      $this->load->view('include/header');
      $this->load->view('templates/menubar');
      $this->load->view('about');
      $this->load->view('include/footer');
	}
   
}

/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */
