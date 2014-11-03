<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/


class Presentation {
	private $conference_id;
	private $title;
	private $abstract;
	private $track_id;
	private $main_presenter_id;
	private $main_presenter_bio;
	public $presentation_exists = false;
	public $sql_failure = false;
	public $mail_failure = false;
	public $success = NULL;
	public $status = false;
	
	function __construct($conference_id, $title, $abstract, $track_id, $main_presenter_id, $main_presenter_bio)
	{ 
		//Sanitize
		$this->conference_id = trim($conference_id);
		$this->title = trim($title);
		$this->pres_abstract = trim($abstract);
		$this->track_id = trim($track_id);
		$this->main_presenter_id = trim($main_presenter_id);
		$this->main_presenter_bio = trim($main_presenter_bio);
		
		$this->status = true;
	}
	
	public function addPresentation()
	{
		global $mysqli;
		
		//Prevent this function being called if there were construction errors
		if($this->status)
		{
			//Insert the user into the database providing no errors have been found.
			$stmt = $mysqli->prepare("INSERT INTO presentation (
				conference_id,
				title,
				abstract,
				track_id
				)
				VALUES (
				?,
				?,
				?,
				?
				)");
			
			$stmt->bind_param("issi", $this->conference_id, $this->title, $this->pres_abstract, $this->track_id);
			$stmt->execute();
			$presentation_id = $mysqli->insert_id;
			$stmt->close();
			
			//Insert attendee into lookup table
			$stmt = $mysqli->prepare("INSERT INTO presenter  (
				attendee_user_id,
				presentation_id,
				main,
				biography
				)
				VALUES (
				?,
				?,
				1,
				?
				)");
			$stmt->bind_param("iis", $this->main_presenter_id, $presentation_id, $this->main_presenter_bio);
			$stmt->execute();
			$stmt->close();
		}
	}
}

?>