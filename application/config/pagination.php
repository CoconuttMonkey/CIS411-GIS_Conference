<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	public function news() {
		$this->load->library('pagination');  // load pagination library
		$config['base_url'] = base_url() . 'front/news';
		$config['total_rows'] = $this->Fronts->totalNews(); // get no of news in my database
		$config['per_page'] = 20; // no of news per page view
		$config['full_tag_open'] = '<div class="pagination pagination-small pagination-centered"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['prev_link'] = '&lt; Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Next &gt;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['first_link'] = FALSE;
		$config['last_link'] = FALSE;
		$this->pagination->initialize($config);
		$data['content'] = $this->Fronts->getAllNewsNotice(1, $config['per_page'], $this->uri->segment(3));
		$this->load->view('inner/all_news', $data);
		}
// --------------------------------------------------------------------------
 
/* End of file pagination.php */
/* Location: ./config/pagination.php */