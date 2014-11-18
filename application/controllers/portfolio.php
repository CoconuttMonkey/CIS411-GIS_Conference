<?php if (!defined('BASEPATH')) die();
class Portfolio extends Main_Controller {

  public function index() {
	  
	  // Load models and helpers
	  $this->load->helper('text');
    $this->load->model('project_model');
    
    // Load Data
    $data['query'] = $this->project_model->get_all();
	  
	  // Load page views
    $this->load->view('include/header');
    $this->load->view('templates/menubar');
    $this->load->view('portfolio',$data);
    $this->load->view('include/footer');
	}
	
	public function project($project_id) {
		
	  // Load models and helpers
		$this->load->model('project_model');
    $project = $this->project_model->get_project($project_id);
		$this->load->library('breadcrumbs');
    
    // Load Data
    $data["title"] = $project["title"];
    $data["body"]  = $project["body"];
    $data["date"]  = $project["date"];
    $data["thumb"] = $project["thumb"];
    $data["img"]	 = $project["img"];
    $data["url"]	 = $project["url"];
		
		// add breadcrumbs
		$this->breadcrumbs->push('Portfolio', site_url('portfolio') );
		$this->breadcrumbs->push($data["title"], site_url('portfolio/project') );
		
		// unshift crumb
		$this->breadcrumbs->unshift('Home', site_url('') );
    
 	  // Load page views
    $this->load->view('include/header');
    $this->load->view('templates/menubar');
    
    $this->load->view('project',$data);
    $this->load->view('include/footer');
	}
   
}

/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */
