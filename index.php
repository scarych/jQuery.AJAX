<?php

/* load libraries first */
if (!file_exists('jQuery.AJAX/classes/class.libraries.php')){
 exit('Required libraries were not found. Please reinstall jQuery.AJAX distribution.');
}
include_once 'jQuery.AJAX/classes/class.libraries.php';

/* load up the libraries */
$libs = new libraries;

/* ensure sessions are started */
session_start();

/* Does a GUID exist for this machine? */
if (!isset($_SESSION[$libs->_getRealIPv4()])){
 $_SESSION[$libs->_getRealIPv4()]=$libs->_uuid();
}

/* setup headers */
header('X-Alt-Referer: '.$_SESSION[$libs->_getRealIPv4()]);
header('X-Forwarded-Proto: http');
header('X-Frame-Options: deny');
header('X-XSS-Protecton: 1;mode=deny');

/* regenerate the session ID to help prevent replay's */
session_regenerate_id(true);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <title>jQuery AJAX Plugin Demo</title>

 <!-- this stylesheet was ripped from an article on net tuts -->
 <link rel="stylesheet" href="jQuery.AJAX/css/style.css" type="text/css" media="screen" />

 <!-- Load the jQuery libraries -->
 <script src="http://code.jquery.com/jquery.js"></script>

 <!-- Load the jQuery handleStorage plugin -->
 <script src="jQuery.AJAX/js/jQuery.AJAX.js"></script>

 <!-- Global _message function to handle AJAX returns -->
 <script>
  var $j = jQuery.noConflict();
  $j(document).ready(function(){
   function _message(obj){
    var details = '';
    $j.each(obj, function(k, v){
     if (k=='error'){
      $j('#message').html('<div class="error">'+v+'</div>').fadeIn(1000);
     }
     if (k=='warning'){
      $j('#message').html('<div class="warning">'+v+'</div>').fadeIn(1000);
     }
     if (k=='info'){
      $j('#message').html('<div class="info">'+v+'</div>').fadeIn(1000);
     }
     if (k=='success'){
      $j('#message').html('<div class="success">'+v+'</div>').fadeIn(1000);
     }
     if (typeof v=='object'){
      $j('#message').append(_details(v)).fadeIn(1000);
     }
    });
   }
   function _details(obj){
    var details = '<b>Details:</b><br/>';
    $j.each(obj, function(a, b){
     details += '<b>'+a+'</b>'+': '+b+'<br/>';
    });
    return details;
   }
   $j('#default').AJAX({appID:'<?php echo $_SESSION[$libs->_getRealIPv4()]; ?>',callback:function(){ _message(this); },strict:true});
  });
 </script>
</head>

<body>
 <div id="contact-form" class="clearfix">
  <h2><strong>jQuery AJAX plug-in demo</strong></h2>
  <p>
   Here is my version of a AJAX plug-in. Supports caching, same-origin restricitons,
   multiple data types, pre, success and error callback methods and some additional
   header verifications that can be further explained by viewing the proxy.php
   file accompanying this distribution.
  </p>
  <p>
   I know, I know... another AJAX plug-in for jQuery? Well yes, the main difference
   with my version is that I have built in a few options that come in handy. CSRF
   token passing using customized headers, using customized headers to provide
   dynamic checksums of processed form data.
  </p>
 </div>

 <div id="contact-form" class="clearfix">
  <h3>An example of the possibilities of the plug-in</h3>
  <p>
   Here is a demonstration that uses unique CSRF tokens generated and registered
   on the server and which are then passed to the plug-in and re-sent as
   custom header options. A simple callback example demonstrates error and
   success message handling.
  </p>
  <div id="message"></div>
  <form id="default" name="default" style="default" method="post" action="jQuery.AJAX/proxy.php">
   <label for="name">Name: <span class="required">*</span></label>
    <input type="text" id="name" name="name" value="" placeholder="John Doe" required="required" />
   <label for="email">Email Address: <span class="required">*</span></label>
    <input type="email" id="email" name="email" value="" placeholder="johndoe@example.com" required="required" />
   <label for="message">Message: <span class="required">*</span></label>
    <textarea id="message" name="message" placeholder="Your message must be greater than 20 charcters" required="required" data-minlength="20"></textarea>
   <span id="loading"></span>
    <input type="submit" value="Send it" id="submit-button" />
    <p id="req-field-desc"></p>
  </form>
 </div>
</body>
</html>
