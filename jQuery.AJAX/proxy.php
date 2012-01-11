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

/* regenerate the session ID to help prevent replay' attacks */
session_regenerate_id(true);

/* create array of details that are used in the next steps */
$details = array('details'=>array('Remote address'=>$libs->_getRealIPv4(),
                                  'Session ID'=>$_SESSION[$libs->_getRealIPv4()],
                                  'X-Alt-Referer header'=>getenv('HTTP_X_ALT_REFERER'),
                                  'Content-MD5 header'=>getenv('HTTP_CONTENT_MD5'),
                                  'Serialized POST data'=>$libs->_serialize($_POST)));

/* verify an XMLHttpRequest was made */
if (strcmp($_SERVER['HTTP_X_REQUESTED_WITH'], 'XMLHttpRequest')!==0){
 exit($libs->JSONencode(array('error'=>'An XMLHttpRequest was not made',
                              'details'=>$details)));
}

/* verify associated X-ALT-Header value */
if (strcmp($_SERVER['HTTP_X_ALT_REFERER'], $_SESSION[$libs->_getRealIPv4()])!==0){
 exit($libs->JSONencode(array('error'=>'The X-Alt-Referer information recieved is invalid',
                              'details'=>$details)));
}

/* verify associated Content-MD5 header value */
if (!empty($_POST)){
 if (strcmp(base64_decode($_SERVER['HTTP_CONTENT_MD5']), md5($libs->_serialize($_POST)))!==0){
  exit($libs->JSONencode(array('error'=>'The Content-MD5 value is incorrect. Checksum failed on submitted form data',
                               'details'=>$details)));
 }
} else {
 if (strcmp(base64_decode($_SERVER['HTTP_CONTENT_MD5']), md5($_SESSION[$libs->_getRealIPv4()]))!==0){
  exit($libs->JSONencode(array('error'=>'The Content-MD5 value is incorrect. Checksum failed on configured CSRF',
                               'details'=>$details)));
 }
}

exit($libs->JSONencode(array('success'=>'All validation checks passed',
                             'details'=>$details)));

?>
