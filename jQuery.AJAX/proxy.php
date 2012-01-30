<?php

/* load libraries first */
if (!file_exists('classes/class.libraries.php')){
 exit('Required libraries were not found. Please reinstall jQuery.AJAX distribution.');
}
include_once 'classes/class.libraries.php';

/* load up the libraries */
$libs = new libraries;

/* ensure sessions are started */
session_start();

/* Does a GUID exist for this machine? */
if (!isset($_SESSION[$libs->_getRealIPv4()])){
 $_SESSION[$libs->_getRealIPv4()]=$libs->_uuid();
}

/*
 * setup headers if the client set them. we do this just in case
 * the installed web server is not configured to enable these by default.
 * however, because they are set by the client the chance for modification
 * during a MITM attack is greater. the server should set these which
 * in this example the ../index.php script does and here we just mimic
 * what the client requests.
 */
header('X-Alt-Referer: '.getenv('HTTP_X_ALT_REFERER'));
header('X-Forwarded-Proto: '.getenv('HTTP_X_FORWARDED_PROTO'));
header('X-Frame-Options: '.getenv('HTTP_X_FRAME_OPTIONS'));
header('X-XSS-Protection: '.getenv('HTTP_X_XSS_PROTECTION'));

/* regenerate the session ID to help prevent replay' attacks */
session_regenerate_id(true);

/* load & initialize the XMLHttpRequest proxy processor */
if (!file_exists('classes/class.ajax.php')){
 exit('Required libraries were not found. Please reinstall jQuery.AJAX distribution.');
}
include_once 'classes/class.ajax.php';
$a = new ajax;
?>
