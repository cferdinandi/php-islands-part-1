<?php

	//
	// API Requests
	//

	/**
	 * Get the API method
	 * @return String The API method
	 */
	function get_method () {
		return $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * Get data object from API data
	 * @return Object The data object
	 */
	function get_request_data () {
		return array_merge(empty($_POST) ? array() : $_POST, (array) json_decode(file_get_contents('php://input'), true), $_GET);
	}

	/**
	 * Check if request is Ajax
	 * @return boolean If true, request is ajax
	 */
	function is_ajax () {
		return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
	}

	/**
	 * Send an API response
	 * @param  array   $response The API response
	 * @param  integer $code     The response code
	 * @param  string  $redirect A URL to redirect to
	 * @param  string  $query    The string to use for the redirect query string
	 */
	function send_response ($response, $code = 200, $redirect = null, $query = 'message') {

		// If ajax, respond
		if (is_ajax()) {
			http_response_code($code);
			die(json_encode($response));
		}

		// If redirect URL, redirect
		$url = array_key_exists('url', $response) ? $response['url'] : $redirect;
		$message = !array_key_exists('url', $response) && !empty($redirect) ? (strpos($redirect, '?') === false ? '?' : '&') . $query . '=' . $response['message'] . '&success=' . ($code === 200 ? 'true' : 'false') : '';
		if (!empty($url)) {
			header('Location: ' . $url . $message);
			exit;
		}

		// Otherwise, show message
		die($response['message']);

	}



	//
	// Flat JSON Storage
	//

	/**
	 * Get file
	 * @param  String  $filename  The filename
	 * @param  *       $fallback  Fallback content if the file isn't found
	 * @param  Boolean $as_string Return string instead of decoded object
	 * @return *                The file content
	 */
	function get_file ($filename, $fallback = '{}') {

		// File path
		$path = dirname(__FILE__) . '/secret/' . $filename . '.json';

		// If file exists, return it
		if (file_exists($path)) {
			$file = file_get_contents($path);
			return json_decode($file, true);
		}

		// Otherwise, return a fallback
		return json_decode($fallback, true);

	}

	/**
	 * Create/update a file
	 * @param String $filename The filename
	 * @param *      $content  The content to save
	*/
	function set_file ($filename, $content, $fallback = '{}') {

		// File path
		$path = dirname(__FILE__) . '/secret/' . $filename . '.json';

		// If there's no content but there's a fallback, use it
		if (empty($content)) {
			file_put_contents($path, $fallback);
			return;
		}

		// Otherwise, save the content
		file_put_contents($path, json_encode($content));

	}



	//
	// Items
	//

	function get_user_stuff () {
		return get_file('items', '[]');
	}
