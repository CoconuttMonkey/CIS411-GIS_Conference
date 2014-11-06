<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/


class Sponsor {
	private $main_contact;
	private $company;
	private $exhibit_comp_profile;
	private $website_url;
	private $sponsor_lvl;
	public $sponsor_exists = false;
	public $sql_failure = false;
	public $mail_failure = false;
	public $success = NULL;
	public $status = false;
	
	function __construct($main_contact,$company_name,$company_address,$logo,$website_url,$sponsor_lvl)
	{ 
		//Sanitize
		$this->main_contact = trim($main_contact);
		$this->company_name = trim($company_name);
		$this->company_address = trim($company_address);
		$this->logo = trim($logo);
		$this->website_url = trim($website_url);
		$this->sponsor_lvl = trim($sponsor_lvl);
		$this->status = true;
	}
	
	public function addSponsor()
	{
		global $mysqli;
		
		//Prevent this function being called if there were construction errors
		if($this->status)
		{
			//Insert the user into the database providing no errors have been found.
			$stmt = $mysqli->prepare("INSERT INTO sponsor (
				main_contact,
				company_name,
				company_address,
				logo,
				url,
				sponsor_lvl
				)
				VALUES (
				?,
				?,
				?,
				?,
				?,
				?,
				?
				)");
			
			$stmt->bind_param("issssi", $this->main_contact, $this->company_name, $this->company_address, $this->logo, $this->website_url, $this->sponsor_lvl);
			$stmt->execute();
			$inserted_id = $mysqli->insert_id;
			$stmt->close();
				
			$conf_id = date("Y");
			//Insert attendee into lookup table
			$stmt = $mysqli->prepare("INSERT INTO sponsor_conference_lookup  (
				sponsor_id,
				conference_id
				)
				VALUES (
				?,
				?
				)");
			$stmt->bind_param("ii", $inserted_id, $conf_id);
			$stmt->execute();
			$stmt->close();
			
			//Update title to Attendee
			updateTitle($this->user_id, "Attendee");
		}
	}
}

?>