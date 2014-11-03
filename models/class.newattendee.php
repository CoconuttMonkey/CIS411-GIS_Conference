<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/


class Attendee {
	private $user_id;
	private $f_name;
	private $l_name;
	private $address_1;
	private $address_2;
	private $city;
	private $state;
	private $postal_code;
	private $country;
	private $phone;
	private $company;
	public $attendee_exists = false;
	public $sql_failure = false;
	public $mail_failure = false;
	public $success = NULL;
	public $status = false;
	
	function __construct($user_id,$f_name,$l_name,$address_1,$address_2,$city,$state,$postal_code,$country,$phone,$company)
	{ 
		//Sanitize
		$this->user_id = trim($user_id);
		$this->f_name = trim($f_name);
		$this->l_name = trim($l_name);
		$this->address_1 = trim($address_1);
		$this->address_2 = trim($address_2);
		$this->city = trim($city);
		$this->state = trim($state);
		$this->postal_code = trim($postal_code);
		$this->country = trim($country);
		$this->phone = trim($phone);
		$this->company = trim($company);
		
		if (userIsAttendee($this->user_id)) {
			$this->attendee_exists = true;
		} else {
			$this->status = true;
		}
	}
	
	public function addAttendee($user_id,$f_name,$l_name,$address_1,$address_2,$city,$state,$postal_code,$country,$phone,$company)
	{
		global $mysqli;
		
		//Prevent this function being called if there were construction errors
		if($this->status)
		{
			//Insert the user into the database providing no errors have been found.
			$stmt = $mysqli->prepare("INSERT INTO attendee (
				user_id,
				f_name,
				l_name,
				address_1,
				address_2,
				city,
				state, 
				postal_code,
				country,
				phone,
				company
				)
				VALUES (
				?,
				?,
				?,
				?,
				?,
				?,
				?,
				?,
				?,
				?,
				?
				)");
			
			$stmt->bind_param("issssssisis", $this->user_id, $this->f_name, $this->l_name, $this->address_1, $this->address_2, $this->city, $this->state, $this->postal_code, $this->country, $this->phone, $this->company);
			$stmt->execute();
			$stmt->close();
				
			$conf_id = date("Y");
			//Insert attendee into lookup table
			$stmt = $mysqli->prepare("INSERT INTO attendee_conference_lookup  (
				attendee_user_id,
				conference_id
				)
				VALUES (
				?,
				?
				)");
			$stmt->bind_param("ii", $this->user_id, $conf_id);
			$stmt->execute();
			$stmt->close();
		}
	}
}

?>