<?php

// Report error.
ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);

// Load third party.
require_once "vendor/autoload.php";

// Define application constant.
define('APP_PATH', 'app/');
define('MAILGUN_KEY', 'key-8aca73fe155aa1eb250828053ace9b64');
define('MAILGUN_PUBKEY', 'pubkey-549208ad995507c17a77e3555955a111');
define('MAILGUN_DOMAIN', 'sandboxad8f7cf2e9ec4e24a48dd69862d46e52.mailgun.org');
define('MAILGUN_LIST', 'test_list@sandboxad8f7cf2e9ec4e24a48dd69862d46e52.mailgun.org');
define('MAILGUN_SECRET', 'teaching');

// Get the request page.
if(isset($_GET['url_page']))
{	
	$q_param = explode('/', $_GET['url_page']);
	$filename = $q_param[0] . 'php';

	// Check if file doesn't exist, and it will throw 404 page not found;
	if(!file_exists($filename))
	{
		header("HTTP/1.0 404");
		exit();
	}
}
else
{
	$filename = 'send.php'; // Default page.
}

// Show page base on user request.
require_once APP_PATH . $filename;