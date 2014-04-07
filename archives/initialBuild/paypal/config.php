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
$title = "R3Printing.com Payment Terminal"; //site title
$company = "R3 Printing"; //company or store name
$store_email = "contact@r3printing.com"; //business email of store owner.
$admin_email = "contact@r3printing.com"; //this email is for notifications about new payments
$item_description = "3D Printing"; //Default payment description
$item_id = "0001"; //The number you want to show next to item description in paypal invoice screen.
$script_base = "localhost:8888/paypal/";// full script location URL
$script_location = "localhost:8888/paypal/thank_you.php"; // full thank_you.php file location URL
?>