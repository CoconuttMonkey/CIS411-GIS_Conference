<?php
	

//Retrieve information for all presentations
function fetchAllPresentations()
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		presentation_id, 
		title,
		abstract, 
		session_id, 
		track_id, 
		gallery_id, 
		active
		FROM conf_presentation");
	$stmt->execute();
	$stmt->bind_result($presentation_id, $title, $abstract, $session_id, $track_id, $gallery_id, $active);
	
	
	while ($stmt->fetch()){
		$row[] = array('presentation_id' => $presentation_id, 
									 'title' => $title, 
									 'abstract' => $abstract, 
									 'session_id' => $session_id, 
									 'track_id' => $track_id, 
									 'gallery_id' => $gallery_id, 
									 'active' => $active);
	}
	$stmt->close();
	return ($row);
}

//Retrieve information for all attendees
function fetchAllAttendees()
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		user_id, 
		phone,
		address_1, 
		address_2, 
		city, 
		state, 
		zip,
		country,
		company,
		attendee_type
		FROM conf_attendees");
	$stmt->execute();
	$stmt->bind_result($user_id, $phone, $address_1, $address_2, $city, $state, $zip, $country, $company, $attendee_type);
	
	while ($stmt->fetch()){
		$row[] = array('user_id' => $user_id, 'phone' => $phone, 'address_1' => $address_1, 'address_2' => $address_2, 'city' => $city, 'state' => $state, 'zip' => $zip, 'country' => $country, 'company' => $company, 'attendee_type' => $attendee_type);
	}
	$stmt->close();
	return ($row);
}
?>