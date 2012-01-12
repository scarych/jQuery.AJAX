
#jQuery plugin for AJAX functionality

  Simple wrapper for XMLHttpRequests using jQuery. This wrapper does however
  support many of the current .ajax() functions configurable parameters in
  addition to providing some customized header options I perfer to use
  accross all form posts. See features for more details on this.

  Fork me @ https://www.github.com/jas-/jQuery.AJAX

## REQUIREMENTS:
* jQuery libraries (required - http://www.jquery.com)

## FEATURES:
* Caching support
* Same origin restrictions (jsonp data types)
* Additonal datatypes json, xml, script, html
* pre form submission callback function support
* error response callback function support
* success response callback function support
* CSRF identifier option specified in X-Alt-Referer header (can be verified on server
  as well as generating customized CSRF tokens on server and assigning them on a per
  form basis)
* Checksum support for serialized form data using the Content-MD5 header value due to
  native base64 and md5 encoding (RFC-2616.14-15)

## OPTIONS:
* appID:       Application ID or CSRF token option
* cache:       Enable or disable caching mechanisms
* context:     Executes form submission and processes responses in context of current form
* type:        Supports json (default), jsonp (for cross-domain support), xml, script and html data types
* clickjack:   This enables the X-Frame-Options header which supports the default 'deny' option or 'sameorigin'
* xss:         Here you can enable/disable (defaults to true) the 'X-XSS-Protection' header to help with XSS attacks
* proxy:       Enable or disable proxy forwarding from https to http and vice versa. Allows http or https.
* callback:    Optional function used once server recieves encrypted data
* preCallback: Executes specified function prior to form submission
* errCallback: Executes specified function when a problem occurs in XMLHttpRequest

## EXAMPLES:

### Default usage
The default usage for this plug-in is as follows.

```javascript
$('#form').AJAX();
```

### Using CSRF token (here we use PHP $_SESSION['token'])
Please see NOTES section for more information about the CSRF feature. The proxy.php script accompanying
this distribution has additional example usage as well.

```javascript
$('#form').AJAX({appID:'<?echo $_SESSION["token"]); ?>'});
```

### Disable caching
Need to disable caching? You can do that with the following option.

```javascript
$('#form').AJAX({cache:false});
```

### Changing execution context
Occasionally you may find that you need to execute a form within the context of a different DOM element. You can
do that using the following option.

```javascript
$('#form').AJAX({context:$('#DOMElement')});
```

### Disabling same-origin policy
By using the JSONP data-type you can disable same-origin policy restrictions. Below is an example.

```javascript
$('#form').AJAX({type:'jsonp'});
```

### Enable 'ClickJacking' support
This particular feature enables prevention methods within the users browser to prevent loading responses within
a <frame> or <iframe> helping protect clients from nefarious users stealing authentication credentials etc. The
first example will prevent all attempts to load content within a frame while the second option will only allow
loading content within a frame from the same domain.

```javascript
$('#form').AJAX({clickjack:'deny'});
```

```javascript
$('#form').AJAX({clickjack:'sameorigin'});
```

### Enable 'XSS' support
While support for this particular feature may be limited across the spectrum of browsers enabling the for
XMLHttpRequests will help your browsers with XSS attack vectors.

```javascript
$('#form').AJAX({xss:true});
```

### Enable prevention of proxy forwarding
Proxy servers. Occasionally a user may use a proxy service which will not provide secure end to end
communication.

Example; client->https->proxy->http->server or server->https->proxy->http->server.

If your site uses HTTPS/SSL/TLS then you will want to enable this feature which will force proxy server
requests to use the specified protocols.

```javascript
$('#form').AJAX({proxy:'https'});
```

### Executing callback function on AJAX success response
This feature can come in handy if you wish to (recommended) display response messages from the server about
form submission statuses.

```javascript
$('#form').AJAX({callback:function(x){
  alert(x);
 }
});
```

### Executing callback function pre AJAX submission
Ever want to add that fancy animated gif spinner once a form has been submitted? You can load that using
the pre-callback method as shown below.

```javascript
$('#form').AJAX({preCallback:function(x){
  alert(x);
 }
});
```

### Executing callback function on AJAX error response
Wish to provide some messaging to the user if something goes wrong? Here is a great method for doing just
that.

```javascript
$('#form').AJAX({errCallback:function(x){
  alert(x);
 }
});
```

### Using all option available
Here is a real-world example of using all of the available options to make effecient usage of this plugin. Of course
this example simply pushes each callback method to the console you could use modal windows, alert boxes, message boxes
and other means of notifications fairly easily.

```javascript
$(document).ready(function(){
 /* send everything to the console */
 function _log(obj){
  $.each(obj, function(k, v){
   console.log(k+' => 'v);
  });
 }
 /* callback before send */
 function _pre(obj){
  return _log(obj);
 }
 /* callback on error */
 function _err(obj){
  return _log(obj);
 }
 /* callback on success */
 function _success(obj){
  return _log(obj);
 }
 /* bind our ajax call to the form and setup some params */
 $('#formID').AJAX({
  appID:        '<?php echo $_SESSION["token"]; ?>',
  cache:        true,
  context:      $('#messageBoxID'),
  type:         'jsonp',
  clickjack:    'sameorigin',
  xss:          true,
  proxy:        'https',
  callback:     _success(this),
  preCallback:  _pre(this),
  errCallback:  _err(this)
 });
});
```

## NOTES

### CSRF (Cross Site Request Forgery)
Using a customized appID option you can enable Cross Site Request Forgery
prevention. To do this a server side component must be preset to generate
a custom CSRF token and attach it to the configuration options as seen in
the examples section. Please see the proxy.php script for more information
on methods of using this prevention method.

### Checksuming form data
This project includes a transparent method of checksumming the submitted
form data. Native base64 and md5 encoding has been added to dynamically
serialize the form data to be processed and generating a value for the
Content-MD5 header which (if needed) can be verified on the server. Please
also see the proxy.php script for more information on this feature. For more
information regarding the 'Content-MD5' header option please see the following
link http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.15

Author: Jason Gerfen <jason.gerfen@gmail.com>
License: GPL (see LICENSE)
