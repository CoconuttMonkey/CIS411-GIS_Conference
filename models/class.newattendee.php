<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/


class Attendee {
	private $user_id;
	private $country;
	private $phone;
	private $address_1;
	private $address_2;
	private $city;
	private $state;
	private $zip;
	public $attendee_exists = false;
	public $sql_failure = false;
	public $mail_failure = false;
	public $success = NULL;
	public $status = false;
	
	function __construct($user_id,$country,$phone,$address_1,$address_2,$city,$state,$zip)
	{ //Sanitize
		$this->user_id = trim($user_id);
		$this->country = trim($country);
		$this->phone = trim($phone);
		$this->address_1 = trim($address_1);
		$this->address_2 = trim($address_2);
		$this->city = trim($city);
		$this->state = trim($state);
		$this->zip = trim($zip);
		
		if(userIsAttendee($user_id)) {
			$this->attendee_exists = true;
		} else {
			$this->status = true;
		}
	}
	
	public function confAddAttendee($user_id,$country,$phone,$address_1,$address_2,$city,$state,$zip)
	{
		global $mysqli,$websiteUrl;
		
		//Prevent this function being called if there were construction errors
		if($this->status)
		{
			//Insert the user into the database providing no errors have been found.
			$stmt = $mysqli->prepare("INSERT INTO conf_attendees (
				user_id,
				country,
				phone,
				address_1,
				address_2,
				city,
				state, 
				zip
				)
				VALUES (
				?,
				?,
				?,
				?,
				?,
				?,
				?,
				?
				)");
			
			$stmt->bind_param("issssssi", $this->user_id, $this->country, $this->phone, $this->address_1, $this->address_2, $this->city, $this->state, $this->zip);
			$stmt->execute();
			$stmt->close();
		}
	}
}

?>