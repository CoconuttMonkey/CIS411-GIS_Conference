<?php if (!defined('BASEPATH')) die();
class Frontpage extends Main_Controller {

   public function index()
	{	
			// Load Data
			
			$data = array();	
			$data["title"]		= "NW PA GIS Conference";
			$data["prefix"]		= "9th Annual";
			$data["theme"] 		= "Geospatial Solutions for Emergency Preparedness";
			$data["date"]			= "Oct 16th and 17th 2014";
			$data["content"] 	= "<p>It is our pleasure to welcome you to the 9th Annual NW PA GIS Conference. This conference presents some of the best geographic information system (GIS) practices in our community today.</p>
			<p>Preparedness, response, and recovery are three key words that have a tremendous significance in emergency and disaster management situations. GIS has played and will continue to play a great role in critical conditions where large amounts of data, spatial and non-spatial, are organized and prepared for the time it is needed most: Emergencies.</p>
			<p>Join us at the 9th Annual NW PA GIS Conference to participate in exciting discussions about how to improve our preparedness using geospatial technologies tools. Collaborate in a productive environment of training, sharing, and debating issues that pertain to data exploration and use, and spatial analysis methods and modeling techniques that are designed to help us improve our community preparedness for any unfortunate event that might rise in the future.</p>
			<p>Your colleagues will share their experience in project management, data modeling and strategies for disseminating data and knowledge. You will learn how other professionals are using GIS to integrate workflows, enhance communication, and build better partnerships.</p>";
			
			// Load Views
			
      $this->load->view('include/header');
      $this->load->view('templates/menubar');
      $this->load->view('frontpage', $data);
      $this->load->view('include/footer');
	}
   
   
}

/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */
