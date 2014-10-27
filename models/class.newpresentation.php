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
		
		if (!userIsAttendee($this->main_presenter)) {
			$this->status = false;
		} else {
			$this->status = true;
		}
	}
	
	public function addPresentation()
	{ //Prevent this function being called if there were construction errors
		
		global $mysqli;
		
		if($this->status)
		{ //Insert the presentation into the database providing no errors have been found. Session set 0 => Unscheduled / Pending
			$stmt = $mysqli->prepare("INSERT INTO conf_presentations (
				main_presenter,
				title,
				abstract,
				session_id,
				track_id)
				VALUES (
				?,
				?,
				?,
				'0',
				?);");
			$stmt->bind_param("issi", $this->main_presenter, $this->presentation_title, $this->presentation_abstract, $this->presentation_track);
			$stmt->execute();
			$inserted_id = $mysqli->insert_id;
			$stmt->close();
			
			//Insert the presenter into the database
			$stmt = $mysqli->prepare("INSERT INTO conf_presenters (
				user_id,
				presentation_id,
				biography)
				VALUES (
				?,
				?,
				?);");
			$stmt->bind_param("iis", $this->main_presenter, $inserted_id, $this->presenter_bio);
			$stmt->execute();
			$stmt->close();
		}
	}
}

?>