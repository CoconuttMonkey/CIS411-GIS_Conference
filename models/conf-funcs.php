<?php
	
//Checks if a username exists in the DB
function userIsAttendee($user_id)
{
	global $mysqli;
	$stmt = $mysqli->prepare("SELECT *
		FROM conf_attendees
		WHERE
		user_id = ?
		LIMIT 1");
	$stmt->bind_param("i", $user_id);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

function fetchAttendeeDetails($user_id) {
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
			conf_attendees.user_id, 
	 		user_users.first_name,
	 		user_users.last_name,
			user_users.email,
			user_users.active,
			user_users.title,
			user_users.sign_up_stamp,
			conf_attendees.phone,
			conf_attendees.address_1, 
			conf_attendees.address_2, 
			conf_attendees.city, 
			conf_attendees.state, 
			conf_attendees.zip,
			conf_attendees.country,
			conf_attendees.company,
			conf_attendees.attendee_type
			FROM conf_attendees
	INNER JOIN `user_users` ON conf_attendees.user_id = {$user_id}
    											AND user_users.id = {$user_id};");
	$stmt->execute();
	$stmt->bind_result($user_id, $first_name, $last_name, $email, $active, $title, $signUp, $phone, $address_1, $address_2, $city, $state, $zip, $country, $company, $attendee_type);
	
	while ($stmt->fetch()){
		$row = array('user_id' => $user_id, 'first_name' => $first_name, 'last_name' => $last_name, 'email' => $email,'active' => $active, 'title' => $title, 'sign_up_stamp' => $signUp, 'phone' => $phone, 'address_1' => $address_1, 'address_2' => $address_2, 'city' => $city, 'state' => $state, 'zip' => $zip, 'country' => $country, 'company' => $company, 'attendee_type' => $attendee_type);
	}
	$stmt->close();
	return ($row);
}

//Retrieve information for all attendees
function fetchAllAttendees()
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
			conf_attendees.user_id, 
	 		user_users.first_name,
	 		user_users.last_name,
			user_users.email,
			user_users.active,
			user_users.title,
			user_users.sign_up_stamp,
			conf_attendees.phone,
			conf_attendees.address_1, 
			conf_attendees.address_2, 
			conf_attendees.city, 
			conf_attendees.state, 
			conf_attendees.zip,
			conf_attendees.country,
			conf_attendees.company,
			conf_attendees.attendee_type
			FROM conf_attendees
	INNER JOIN `user_users` on conf_attendees.user_id = user_users.id;");
	$stmt->execute();
	$stmt->bind_result($user_id, $first_name, $last_name, $email, $active, $title, $signUp, $phone, $address_1, $address_2, $city, $state, $zip, $country, $company, $attendee_type);
	
	while ($stmt->fetch()){
		$row[] = array('user_id' => $user_id, 'first_name' => $first_name, 'last_name' => $last_name, 'email' => $email,'active' => $active, 'title' => $title, 'sign_up_stamp' => $signUp, 'phone' => $phone, 'address_1' => $address_1, 'address_2' => $address_2, 'city' => $city, 'state' => $state, 'zip' => $zip, 'country' => $country, 'company' => $company, 'attendee_type' => $attendee_type);
	}
	$stmt->close();
	return ($row);
}

//Update attendee field
function updateAttendeeDetail($user_id, $field, $value) {
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE conf_attendees
		SET `{$field}` = '{$value}'
		WHERE
		user_id = {$user_id}");
	$result = $stmt->execute();
	$stmt->close();
}

//Retrieve information for all attendees
function fetchPresentations($filter = NULL)
{
	if ($filter == 'pending') {
		$filter = ' AND conf_presentations.session_id = 0';
	} else {
		$filter = '';
	}
	
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
			conf_presentations.presentation_id, 
	 		conf_presentations.main_presenter,
	 		conf_presentations.title,
			conf_presentations.session_id,
			conf_presentations.track_id,
			conf_presentations.gallery_id,
			conf_presentations.active,
			user_users.first_name, 
			user_users.last_name
			FROM conf_presentations
	INNER JOIN `user_users` ON conf_presentations.main_presenter = user_users.id".$filter.";");
	$stmt->execute();
	$stmt->bind_result($presentation_id, $main_presenter_id, $presenation_title, $presenation_session_id, $presenation_track_id, $presenation_gallery_id, $presenation_active, $first_name, $last_name);
	
	while ($stmt->fetch()){
		$row[] = array('presentation_id' => $presentation_id, 'main_presenter' => $main_presenter_id, 'presentation_title' => $presenation_title, 'presentation_session' => $presenation_session_id, 'presentation_track' => $presenation_track_id, 'gallery_id' => $presenation_gallery_id, 'active' => $presenation_active, 'first_name' => $first_name, 'last_name' => $last_name);
	}
	$stmt->close();
	return ($row);
}

//Change a user from inactive to active
function fetchTrackName($track_id)
{
	global $mysqli;
	$stmt = $mysqli->prepare("SELECT
		track_id,
		short_name,
		full_name
		FROM
		conf_track
		WHERE track_id = {$track_id}");
	$stmt->execute();
	$stmt->bind_result($track_id, $short_name, $full_name);
	
	while ($stmt->fetch()){
		$row = array('track_id' => $track_id, 'short_name' => $short_name, 'full_name' => $full_name);
	}
	$stmt->close();
	return ($row);
}
?>