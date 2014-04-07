<?php
#******************************************************************************
#                      PHP Paypal Payment Terminal v1.0
#******************************************************************************
#      Author:     Sergey Suhanov
#      Email:      admin@rxnk.com
#      Website:    http://www.rxnk.com
#
#      Version:    1.0
#      Copyright:  (c) 2009 - Sergey Suhanov 
#      
#		!!!DONT EDIT THIS FILE!!!
#******************************************************************************

class paypal_class {

   var $response;                
   var $pp_data = array(); 
   var $fields = array();           
 
 
 
 
   function paypal_class() {   
      // constructor.  
      $this->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
      $this->response = '';
      $this->add_field('rm','2');           
      $this->add_field('cmd','_xclick');    
   }
   
   
   
   
   
   function add_field($field, $value) {
	   //form field pair creator
      $this->fields["$field"] = $value;
   }






   function submit_paypal_post() {
	   //submit to paypal function
 	?><head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Processing Order...</title>
    </head>
    <?php echo "<body onLoad=\"document.forms['paypal_form'].submit();\">\n";?>
    
    <center>
    <div id="form-content">
    Processing Order...<br />
	<?php
	echo "<center><div class='wait_msg'>Please wait, your order is being processed and you will be redirected to the paypal website.</div></center>\n";  
	echo "<form method=\"post\" name=\"paypal_form\" ";
	echo "action=\"".$this->paypal_url."\">\n";
	foreach ($this->fields as $name => $value) {
		echo "<input type=\"hidden\" name=\"$name\" value=\"$value\"/>\n";
	}
	echo "<center><br/><br/>If you are not automatically redirected to ";
	echo "paypal within 5 seconds...<br/><br/>\n";
	echo "<input type=\"submit\" class=\"submitProcessing\" value=\"Click Here\"></center>\n";
	echo "</form>\n";
	?>
    </div>
    </center>
	<?php } 
   
   
   
   
   function validate_ipn() {
      // parse the paypal URL
      $url_parsed=parse_url($this->paypal_url);        
	  
      $post_string = '';    
      foreach ($_POST as $field=>$value) { 
         $this->pp_data["$field"] = $value;
         $post_string .= $field.'='.urlencode(stripslashes($value)).'&'; 
      }
      $post_string.="cmd=_notify-validate"; 
      // open the connection to paypal
      $fp = fsockopen($url_parsed[host],"80",$err_num,$err_str,30); 
      if(!$fp) {
         return false;
      } else { 
         // Post the data back to paypal
         fputs($fp, "POST $url_parsed[path] HTTP/1.1\r\n"); 
         fputs($fp, "Host: $url_parsed[host]\r\n"); 
         fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n"); 
         fputs($fp, "Content-length: ".strlen($post_string)."\r\n"); 
         fputs($fp, "Connection: close\r\n\r\n"); 
         fputs($fp, $post_string . "\r\n\r\n"); 
         // loop through the response from the server and append to variable
         while(!feof($fp)) { 
            $this->response .= fgets($fp, 1024); 
         } 
         fclose($fp); // close connection
      }
      if (eregi("VERIFIED",$this->response)) {
         // Valid IPN transaction.
         return true;          
      } else {
         // Invalid IPN transaction.
         return false;    
      } 
   }
   
}  //class end       
?>
