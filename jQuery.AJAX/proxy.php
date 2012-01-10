<?php

/* CSRF helper (this must match the appID from client) */
$appID = 'jQuery.AJAX';

/* verify an XMLHttpRequest was made */
if (strcmp($_SERVER['HTTP_X_REQUESTED_WITH'], 'XMLHttpRequest')!==0){
 exit(JSONencode(array('error'=>'An XMLHttpRequest was not made')));
}

/* verify associated X-ALT-Header value */
if (strcmp($_SERVER['HTTP_X_ALT_REFERER'], $appID)!==0){
 exit(JSONencode(array('error'=>'The X-Alt-Referer information recieved is invalid')));
}

/* verify associated Content-MD5 header value */
if (!empty($_POST)){
 if (strcmp(base64_decode($_SERVER['HTTP_CONTENT_MD5']), md5(_serialize($_POST)))!==0){
  exit(JSONencode(array('error'=>'The Content-MD5 value is incorrect. Checksum failed on submitted form data')));
 }
} else {
 if (strcmp(base64_decode($_SERVER['HTTP_CONTENT_MD5']), md5($appID))!==0){
  exit(JSONencode(array('error'=>'The Content-MD5 value is incorrect. Checksum failed on configured CSRF')));
 }
}

function _serialize($array)
{
 if (count($array)>0){
  $x = '';
  foreach($array as $key => $value){
   $x .= $key.'='.$value.'&';
  }
  $x = substr($x, 0, -1);
 }
 return (strlen($x)>0) ? $x : false;
}

function JSONencode($array){
 if (!function_exists('json_encode')) {
  return arr2json($array);
 } else {
  return json_encode($array);
 }
}

function arr2json($array)
{
 if (is_array($array)) {
  foreach($array as $key => $value) $json[] = $key . ':' . self::php2js($value);
  if(count($json)>0) return '{'.implode(',',$json).'}';
  else return '';
 }
}

function php2js($value)
{
 if(is_array($value)) return self::arr2json($val);
 if(is_string($value)) return '"'.addslashes($value).'"';
 if(is_bool($value)) return 'Boolean('.(int) $value.')';
 if(is_null($value)) return '""';
 return $value;
}
?>
