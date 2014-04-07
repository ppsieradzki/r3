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
#******************************************************************************
require_once('config.php');  // include the config file
require_once('paypal.class.php');  // include the class file
$paypal = new paypal_class;             // initiate an instance of the class
$paypal->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title;?></title>
</head>

<body>
<div align="center">
<?php
switch ($_GET['action']) { 
    case 'success':      // Order was successful...
      echo "<div id='form-content'><div class='success'>Thank you for your payment, we will contact you shortly!</div></div>";
	break;
      
    case 'cancel':       // Order was canceled...
      echo "<div id='form-content'><div class='cancelled'>The payment was canceled!</div><a href='".$script_base."'>Click here</a> to return to terminal</div>";
	break;
      
   case 'ipn':          // Paypal is calling page for IPN validation...
   	  if ($paypal->validate_ipn()) {		  
		//-----> send notification 
		//creating message for sending
		$headers  = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=utf-8\n";
		$headers .= "From: '".$title."' <".$store_email."> \n";
		$subject = "New Payment Received";
		$message =  "New payment was successfully recieved through paypal payment terminal \n";
        $message .= "from ".$paypal->pp_data['payer_email']." on ".date('m/d/Y');
        $message .= " at ".date('g:i A');	
		mail($admin_email,$subject,$message,$headers);
		//-----> send notification end 			 
      }
      break;
 }     

?>
</div>
</body>
</html>

