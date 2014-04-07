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
#  CHANGELOG & VERION HISTORY:
#
#      v1.0. [22.06.2009] - Initial Version
#
#******************************************************************************

require("config.php"); //important file. Don't forget to edit it!
$show_form=1;
$mess="";

	//FORM SUBMISSION PROCESSING 
	# PLEASE DO NOT EDIT FOLLOWING LINES ------->
	if(!empty($_POST["process"]) && $_POST["process"]=="yes"){
				if(!empty($_POST["amount"]) && is_numeric($_POST["amount"] )){ 	
				$amount = (!empty($_POST["amount"]))?strip_tags(str_replace("'","",$_POST["amount"])):'';
				$show_form=0;
				require_once('paypal.class.php'); 
				$paypal = new paypal_class;
				$paypal->add_field('business', $store_email);
				$paypal->add_field('return', $script_location.'?action=success');
				$paypal->add_field('cancel_return', $script_location.'?action=cancel');
				$paypal->add_field('notify_url', $script_location.'?action=ipn');
				$paypal->add_field('item_name_1', strip_tags(str_replace("'","",$_POST["description"])));
				$paypal->add_field('amount_1', $amount);
				$paypal->add_field('item_number_1', $item_id);
				$paypal->add_field('quantity_1', '1');
				$paypal->add_field('custom', $_SERVER['REMOTE_ADDR']);
				$paypal->add_field('upload', 1);
				$paypal->add_field('cmd', '_cart'); 
				$paypal->add_field('txn_type', 'cart'); 
				$paypal->add_field('num_cart_items', 1);
				$paypal->add_field('payment_gross', $amount);
				$paypal->add_field('currency_code', strip_tags(str_replace("'","",$_POST["currency"])));
			  	$paypal->submit_paypal_post(); // submit the fields to paypal
				$show_form=0;
				} elseif(!is_numeric($_POST["amount"]) || empty($_POST["amount"])) { 
					$mess="<span class='error'>Please type amount to pay for services!</span>"; 
					$show_form=1; 
				} 
			}  
	# END OF PLEASE DONT EDIT <----------	
			if($show_form==1){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title;?></title>
</head>

<body>
<div align="center" class="wrapper">

<script type="text/JavaScript">
<!--
  
function checkForm() {
	var err=0;
<?php
$reqFields=array(
	"description",
	"amount"
);

foreach ($reqFields as $v) { ?>

	if (document.getElementById('<?php echo $v;?>').value==0) {
		if (err==0) {
			document.getElementById('<?php echo $v;?>').focus();
		}
		document.getElementById('<?php echo $v;?>').style.backgroundColor='#ffa5a5';
		err=1;
	} <?php } ?>

if (err==0) {
		return true;
	} else {
		alert("Please complete all highlited fields to continue.");
		return false;
	}
}

function checkFieldBack(fieldObj) {
	if (fieldObj.value!=0) {
		fieldObj.style.backgroundColor='#FFFFFF';
	}
}
function noAlpha(obj){
	reg = /[^0-9.,]/g;
	obj.value =  obj.value.replace(reg,"");
 }

<!-- onkeyup="checkFieldBack(this);noAlpha(this);"  onKeyPress='noAlpha(this)' -->
//-->
</script>
  <h1>Welcome to <?php echo $company;?> PayPal Terminal</h1>
  <p><img src="images/paypalLogo.jpg" alt="PayPal.com - Secure Payments" /><br /><?php echo $mess;?></p>
  	<p><img src="../images/logo.png" /><br /><?php echo $mess;?></p>
	
    <p>&nbsp;</p>
	<form id="ff1" name="ff1" method="post" action="" enctype="multipart/form-data" onsubmit="return checkForm();">
    <div id="form-content">
        <p>
            <label>Description:</label>
            <input name="description" id="description" type="text"  value="<?php echo $item_description;?>" onkeyup="checkFieldBack(this);" readonly>
        </p>
        <div class="clear"></div>
        <p>
            <label>Amount:</label>
            <input name="amount" id="amount" type="text"  value="<?php echo $_POST['cost'];?>" onkeyup="checkFieldBack(this);noAlpha(this);" onkeypress="noAlpha(this);" readonly>
        </p>
        <div class="clear"></div>
        <p>
            <label>Currency:</label>
            <input name="currency" id="currency" value="USD" readonly>
        </p>
        <div class="clear"></div>
    </div>
    <br />
    <input type="submit" name="Submit" value="Pay <?php echo $company;?>" />
    <input type="hidden" name="process" value="yes" />			
  	</form>
</div>
</body>
</html>
<?php } ?>