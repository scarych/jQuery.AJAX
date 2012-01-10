
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
  native base64 and md5 encoding

## OPTIONS:
* appID:       Application ID or CSRF token option
* cache:       Enable or disable caching mechanisms
* context:     Executes form submission and processes responses in context of current form
* type:        Supports json (default), jsonp (for cross-domain support), xml, script and html data types
* callback:    Optional function used once server recieves encrypted data
* preCallback: Executes specified function prior to form submission
* errCallback: Executes specified function when a problem occurs in XMLHttpRequest

## EXAMPLES:

### Default usage
```javascript
$('#form').AJAX();
```

### Using CSRF token (here we use PHP $_SESSION['token'])
Please see NOTES section for more information about this feature and the checksum feature.

```javascript
$('#form').AJAX(appID:'<?echo $_SESSION['token']); ?>'});
```

### Disable caching
```javascript
$('#form').AJAX({cache:false});
```

### Changing execution context
```javascript
$('#form').AJAX({context:$('#DOMElement')});
```

### Disabling same-origin policy
```javascript
$('#form').AJAX({type:'jsonp'});
```

### Executing callback function on AJAX success response
```javascript
$('#form').AJAX({callback:function(x){
  alert(x);
 }
});
```

### Executing callback function pre AJAX submission
```javascript
$('#form').AJAX({preCallback:function(x){
  alert(x);
 }
});
```

### Executing callback function on AJAX error response
```javascript
$('#form').AJAX({errCallback:function(x){
  alert(x);
 }
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
also see the proxy.php script for more information on this feature.

Author: Jason Gerfen <jason.gerfen@gmail.com>
License: GPL (see LICENSE)
