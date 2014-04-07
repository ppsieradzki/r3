<?PHP  

        $message = '<html><body>';
        $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
        $message .= "<tr style='background: #eee;'><td><strong>First Name:</strong> </td><td>" . strip_tags($_POST['firstName']) . "</td></tr>";
        $message .= "<tr><td><strong>Last Name:</strong> </td><td>" . strip_tags($_POST['lastName']) . "</td></tr>";
        $message .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($_POST['email']) . "</td></tr>";
        $message .= "<tr><td><strong>Phone:</strong> </td><td>" . strip_tags($_POST['phone']) . "</td></tr>";
        $message .= "<tr><td><strong>Message:</strong> </td><td>" . strip_tags($_POST['comments']) . "</td></tr>";
        $message .= "</table>";
        $message .= "</body></html>";

        $headers = "From: " . strip_tags($_POST['email']) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
          


        //SEND Mail:
        if(mail("contact@r3printing.com", "Contact Request", $message, $headers)){
          echo "Your message was sent successfully!";
        }else{
          echo "Oops! Something went wrong! Your message was not sent, could you try submitting again?";
        }
                                                                                                                                   
        $header2 = "From: contact@r3printing.com\r\n";
        $header2 .= "MIME-Version: 1.0\r\n";
        $header2 .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        
        $message2 = '<html><body>';
        $message2 .= "<p>Dear " . $_POST["firstName"] . ",<br><br>Thank you for contacting R3 Printing! <br><br> Your message has been received and a representative will contact you shortly.";
        $message2 .= "</body></html>";
        if(mail( $_POST["email"] , "R3 Printing Question/Comment Submission" , $message2, $header2 )){
          echo "<br><br>We sent a confimation email to the address you provided. <br>Please check your email to ensure you provided the correct address.";
        }else{
          echo "Oops! Something went wrong! Your confirmation email was not sent, could you try submitting again?";
        }

        echo "<script>window.location = 'http://r3printing.com/index.html#Contact'</script>";
?>