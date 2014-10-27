<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/


class Presentation {
	private $main_presenter;
	private $presenter_bio;
	private $presentation_title;
	private $presentation_abstract;
	private $presentation_track;
	private $presentation_day_request;
	public $presentation_exists = false;
	public $sql_failure = false;
	public $mail_failure = false;
	public $success = NULL;
	public $status = false;
	
	function __construct($main_presenter,$presenter_bio,$presentation_title,$presentation_abstract,$presentation_track,$presentation_day_request)
	{ //Sanitize
		$this->main_presenter = trim($main_presenter);
		$this->presenter_bio = trim($presenter_bio);
		$this->presentation_title = trim($presentation_title);
		$this->presentation_abstract = trim($presentation_abstract);
		$this->presentation_track = trim($presentation_track);
		$this->presentation_day_request = trim($presentation_day_request);
		
		if(presentationExists($main_presenter, $presentation_title)) {
			$this->presentation_exists = true;
		} else {
			$this->status = true;
		}
	}
	
	public function addPresentation($main_presenter,$presenter_bio,$presentation_title,$presentation_abstract,$presentation_track,$presentation_day_request)
	{
		global $mysqli,$websiteUrl;
		
		//Prevent this function being called if there were construction errors
		if($this->status)
		{
			//Insert the user into the database providing no errors have been found.
			$stmt = $mysqli->prepare("INSERT INTO conf_presentation (
				main_presenter,
				presenter_bio,
				title,
				abstract,
				address_2,
				city,
				state, 
				zip
				)
				VALUES (
				".$this->main_presenter.",
				".$this->presenter_bio.",
				".$this->presentation_title.",
				".$this->presentation_abstract.",
				".$this->presentation_track.",
				".$this->presentation_day_request."
				)");
			
			$stmt->execute();
			$stmt->close();
		}
	}
}

?>