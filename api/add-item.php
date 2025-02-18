<?php

	include_once(dirname( __FILE__) . '/helpers.php');


	// Get the method and data
	$method = get_method();
	$data = get_request_data();

	// The redirect URL
	$redirect = 'http://localhost:8888/_temp/php/';



	// Only support POST method
	if ($method !== 'POST') {
		send_response(array(
			'message' => 'This method is not supported.',
		), 400, $redirect);
	}

	// Make sure all required data is provided
	if (!isset($data['item']) || empty($data['item'])) {
		send_response(array(
			'message' => 'Please provide an item to add.',
		), 400, $redirect);
	}



	// Get the user items, with an empty array as a fallback
	$user_items = get_file('items', '[]');

	// Add the new item to it
	$user_items[] = $data['item'];

	// Save the data back down
	set_file('items', $user_items);



	// Send a success response
	send_response(array(
		'message' => 'Item added to the list!'
	), 200, $redirect);
