<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

class Conference {
	private $title;
	private $tagline;
	private $conf_start;
	private $conf_end;
	private $reg_open;
	private $reg_close;
	private $conf_abstract;
	private $banner_location;
	private $schedule_location;
	public $sql_failure = false;
	public $mail_failure = false;
	public $success = NULL;
	public $status = false;
	
	function __construct($title,$tagline,$conf_start,$conf_end,$reg_open,$reg_close,$conf_abstract,$banner_location,$schedule_location)
	{ //Sanitize
		$this->title = trim($title);
		$this->tagline = trim($tagline);
		$this->conf_start = trim($conf_start);
		$this->conf_end = trim($conf_end);
		$this->reg_open = trim($reg_open);
		$this->reg_close = trim($reg_close);
		$this->conf_abstract = trim($conf_abstract);
		$this->banner_location = trim($banner_location);
		$this->schedule_location = trim($schedule_location);
		
		$this->status = true;
	}
	
	public function addConference()
	{ //Prevent this function being called if there were construction errors
		
		global $mysqli;
		
		if($this->status)
		{ //Insert the presentation into the database providing no errors have been found. Session set 0 => Unscheduled / Pending
			$stmt = $mysqli->prepare("INSERT INTO conf_settings (
				title,
				tagline,
				conf_startDate,
				conf_endDate,
				reg_openDate,
				reg_closeDate,
				abstract,
				banner_img,
				schedule_pdf)
				VALUES (
				?,
				?,
				?,
				?,
				?,
				?,
				?,
				?,
				?);");
			$stmt->bind_param("sssssssss", $this->title, $this->tagline, $this->conf_start , $this->conf_end, $this->reg_open, $this->reg_close, $this->conf_abstract, $this->banner_location, $this->schedule_location);
			$stmt->execute();
			$stmt->close();
		}
	}
}

?>