<?PHP require_once("./STLStats/STLStats.php"); 
$output_dir = "uploads/";
include("BoundingBox/STLBox.php");
 
    
        if(isset($_FILES["file"]))
        {
            
                
            if($_POST['unit'] == 1){
                    $unit = "mm";
            }else if($_POST['unit'] == 2){
                    $unit = "cm";
            }else if($_POST['unit'] == 3){
                    $unit = "m";
            }else if($_POST['unit'] == 4){
                    $unit = "inch";
            }else{
                    $unit = "feet";
            }


            if($_POST['resolution'] == 2){
                    $resolution = 5.00;
                    $resolutionVal = "High";
            }else{
                    $resolution = 0.00;
                    $resolutionVal = "Normal";
            }

           

            if($_POST['rush'] == 1){
                    $rush = 0.00;
                    $rushVal = "No";
            }else if($_POST['rush'] == 2){
                    $rush = 6.00;
                    $rushVal = "48-72 Hours";
            }else{
                    $rush = 11.00;
                    $rushVal = "24 Hours";
            }
            
            if($_POST['material'] == 1){
                    $material = 2.00;
                    $color = 5.00;
                    $materialVal = "Flexible White";
            }else if($_POST['material'] == 2){
                    $material = 1.22;
                    $color = 5.00;
                    $materialVal = "Translucent Blue";
            }else if($_POST['material'] == 3){
                    $material = 1.40;
                    $color = 5.00;
                    $materialVal = "Glow in the dark Green";
            }else if($_POST['material'] == 4){
                    $material = 1.00;
                    $color = 0.00;
                    $materialVal = "Normal Natural";
            }else if($_POST['material'] == 5){
                    $material = 1.00;
                    $color = 5.00;
                    $materialVal = "Normal White";
            }else if($_POST['material'] == 6){
                    $material = 1.00;
                    $color = 5.00;
                    $materialVal = "Normal Black";
            }else if($_POST['material'] == 7){
                    $material = 1.00;
                    $color = 5.00;
                    $materialVal = "Normal Red";
            }else if($_POST['material'] == 8){
                    $material = 1.00;
                    $color = 5.00;
                    $materialVal = "Normal Blue";
            }else if($_POST['material'] == 9){
                    $material = 1.00;
                    $color = 5.00;
                    $materialVal = "Normal Purple";
            }else if($_POST['material'] == 10){
                    $material = 1.00;
                    $color = 5.00;
                    $materialVal = "Normal Green";
            }else{
                    $material = 1.00;
                    $color = 5.00;
                    $materialVal = "Normal Yellow";
            }

            $copies = $_POST['copies'];
            
            //move the uploaded file to uploads folder
            move_uploaded_file($_FILES["file"]["tmp_name"],$output_dir. $_FILES["file"]["name"]);
         
                 $obj = new STLStats($output_dir. $_FILES["file"]["name"]);
                 


                 $volume = $obj->getVolume("cm");

                 // If volume is zero, return error
                 if($volume == 0){
                         echo "<div id='costPanel' class='panel panel-danger'><div class='panel-heading'>Processing Error</div>
                                <div id='panelContent' class='panel-body'>It appears that the file you gave us is disagreeing with our volume-calculating script.
                                 This could be for several reasons. The most common are that your file is not 'Manifold' or 'Watertight'. Another could be that you have 'Inverted Normals'. 
                                 Both are usually can easy fix using free software such as MeshLab: http://meshlab.sourceforge.net</div>  
                                              </div>";
                 }

                 $x = $copies * $volume;
                 if($x < 418){
                         $precost = (-4.91132*pow(10, -10))*(pow($x, 3))+(8.9526921*pow(10, -7))*(pow($x, 2))+(-4.911974*pow(10, -4))*($x)+.27;
                 }else{
                         $precost = .15;
                 }

                 if($unit == "inch"){
                         $newVolume = $volume*0.061024;
                         $unitPlural = "inches";
                         $rounding = 3;
                 }else if($unit == "mm"){
                         $newVolume = $volume*1000;
                         $unitPlural = "millimeters";
                         $rounding = 2;
                 }else if($unit == "m"){
                         $newVolume = $volume*.000001;
                         $unitPlural = "meters";
                         $rounding = 7;
                 }else if($unit == "feet"){
                         $newVolume = $volume*0.0000353;
                         $unitPlural = "feet";
                         $rounding = 7;
                 }else{
                  $unitPlural = "centimeters";
                  $rounding = 2;
                  $newVolume = $volume;
                 }

                 $cost = $precost*$material+.30+($copies*3.00)+$resolution+$rush+$color;
                 $cost = round($cost, 2, PHP_ROUND_HALF_UP);

                 //////////BOUNDING BOX//////////////

                  $obj2 = new STLStats2($output_dir. $_FILES["file"]["name"]);                  
                  $bbox = $obj2->getBBox("cm");
                  $bbv = $obj2->getBBoxVolume("cm");               

                 ///////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////
                 



                 if (isset($_POST['calculate'])) {
                         /* if($unit == "cm"){
                         echo "<div id='costPanel' class='panel panel-info'><div class='panel-heading'>Volume/Cost Calculation</div>
                                <div id='panelContent' class='panel-body'>Volume: " . round($volume, 2, PHP_ROUND_HALF_UP) . " cubic centimeters" . " <br>Total Cost: $" . $cost . "</div>  
                                              </div>";
                         }else if($unit == "inch"){
                                 echo "<div id='costPanel' class='panel panel-info'><div class='panel-heading'>Volume/Cost Calculation</div>
                                <div id='panelContent' class='panel-body'>Volume: " . round($newVolume, 2, PHP_ROUND_HALF_UP) . " cubic inches" . " <br>Total Cost: $" . $cost . "</div>  
                                              </div>";
                         }else if($unit == "mm"){
                                 echo "<div id='costPanel' class='panel panel-info'><div class='panel-heading'>Volume/Cost Calculation</div>
                                <div id='panelContent' class='panel-body'>Volume: " . round($newVolume, 2, PHP_ROUND_HALF_UP) . " cubic mm" . " <br>Total Cost: $" . $cost . "</div>  
                                              </div>";
                         }else if($unit == "m"){
                                 echo "<div id='costPanel' class='panel panel-info'><div class='panel-heading'>Volume/Cost Calculation</div>
                                <div id='panelContent' class='panel-body'>Volume: " . round($newVolume, 10, PHP_ROUND_HALF_UP) . " cubic meters" . " <br>Total Cost: $" . $cost . "</div>  
                                              </div>";
                         }else if($unit == "feet"){
                                 echo "<div id='costPanel' class='panel panel-info'><div class='panel-heading'>Volume/Cost Calculation</div>
                                <div id='panelContent' class='panel-body'>Volume: " . round($newVolume, 7, PHP_ROUND_HALF_UP) . " cubic feet" . " <br>Total Cost: $" . $cost . "</div>  
                                              </div>";
                         } 

                                         echo "<div id='costPanel' class='panel panel-info'><div class='panel-heading'>Volume/Cost Calculation</div>
                                <div id='panelContent' class='panel-body'> <script type='text/javascript'> var stlFile =" . $output_dir. $_FILES["file"]["name"] . "; </script>  <script src='jsstl-master/stlScript.js'></script></div>  
                                              </div>";
                                        */

                                              echo "Volume: " . round($newVolume, $rounding, PHP_ROUND_HALF_UP) . " cubic " . $unitPlural  . " <br>Total Cost: $" . $cost . "<br>Dimensions: " . round($bbox["length"]) . "cm (L) x <br>" . round($bbox["width"]) . "cm (W) <br>" . round($bbox["height"]) . "cm (H)<br>" . round($bbv) .
                                              " cubic cm</div><iframe name='iframe2' id='iframe2' src='uploads/stlScript.html' width='100%'' height='300'></iframe><br><br>
                                              If you have any questions about your order or about our automatic pricing system, email 
                                              <a href='mailto:contact@r3printing.com?Subject=Print%20Form%20Question' target='_top'>contact@r3printing.com</a> for assistance.";

                 }else {


        
                
                        $message = '<html><body>';
                        $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
                        $message .= "<tr style='background: #eee;'><td><strong>First Name:</strong> </td><td>" . strip_tags($_POST['firstName']) . "</td></tr>";
                        $message .= "<tr><td><strong>Last Name:</strong> </td><td>" . strip_tags($_POST['lastName']) . "</td></tr>";
                        $message .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($_POST['email']) . "</td></tr>";
                        $message .= "<tr><td><strong>Phone:</strong> </td><td>" . strip_tags($_POST['phone']) . "</td></tr>";
                        $message .= "<tr><td><strong>Units:</strong> </td><td>" . strip_tags($unit) . "</td></tr>";
                        $message .= "<tr><td><strong>Resolution:</strong> </td><td>" . strip_tags($resolutionVal) . "</td></tr>";
                        $message .= "<tr><td><strong>Material/Color:</strong> </td><td>" . strip_tags($materialVal) . "</td></tr>";
                        $message .= "<tr><td><strong>Rush:</strong> </td><td>" . strip_tags($rushVal) . "</td></tr>";
                        $message .= "<tr><td><strong>Copies:</strong> </td><td>" . strip_tags($copies) . "</td></tr>";
                        $message .= "<tr><td><strong>Comments:</strong> </td><td>" . strip_tags($_POST['comments']) . "</td></tr>";
                        $message .= "<tr><td><strong>Cost:</strong> </td><td>" . "$" . strip_tags($cost) . "</td></tr>";
                        $message .= "<tr><td><strong>File:</strong> </td><td><a href='www.r3printing.com/uploads/"  . $_FILES["file"]["name"] . "'>www.r3printing.com/uploads/" . $_FILES["file"]["name"] . "</a></td></tr>";
                        $message .= "</table>";
                        $message .= "<br><br><br></body></html>http://www.r3printing.com/uploads/" . $_FILES["file"]["name"];

                        $file = $output_dir . $_FILES["file"]["name"];
                    $file_size = filesize($file);
                    $handle = fopen($file, "r");
                    $content = fread($handle, $file_size);
                    fclose($handle);
                    $content = chunk_split(base64_encode($content));
                    $uid = md5(uniqid(time()));

                        // a random hash will be necessary to send mixed content
                    $separator = md5(time());

                    // carriage return type (we use a PHP end of line constant)
                    $eol = PHP_EOL;

                    // main header (multipart mandatory)
                    $headers = "From: " . strip_tags($_POST['email']) . $eol;
                    $headers .= "MIME-Version: 1.0" . $eol;
                    //$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol . $eol;
                    //$headers .= "Content-Transfer-Encoding: 7bit" . $eol;
                    //$headers .= "This is a MIME encoded message." . $eol . $eol;

                    // message
                    //$headers .= "--" . $separator . $eol;
                    $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"" . $eol;
                    $headers .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;
                    //$headers .= $message . $eol . $eol;

                    // attachment
                    /*$headers .= "--" . $separator . $eol;
                    $headers .= "Content-Type: application/octet-stream; name=\"" . $_FILES["file"]["name"] . "\"" . $eol;
                    $headers .= "Content-Transfer-Encoding: base64" . $eol;
                    $headers .= "Content-Disposition: attachment" . $eol . $eol;
                    $headers .= $content . $eol . $eol;
                    $headers .= "--" . $separator . "--";
                */
                    //SEND Mail

                    //if (mail("paul.sieradzki@r3printing.com", "Print Request", $message, $headers)) {
                     if (mail("paul.sieradzki@r3printing.com", "Print Request", $message, $headers)) { 
                         echo "<div id='costPanel' class='panel panel-success'><div class='panel-heading'>Submission Successful!</div>
                                <div id='panelContent' class='panel-body'>Thank you for your order! Total cost: $<div style='display: inline-block' name='costResult' id='costResult' value='" . $cost . "'>" . $cost ."</div><br>Please continue to payment submission to complete the process.</div>  
                                              </div>";  
                                                                                                                                      
                      } else {
                        echo "<div id='costPanel' class='panel panel-danger'><div class='panel-heading'>Processing Error</div>
                                <div id='panelContent' class='panel-body'>Process has not gone through - please contact R3</div>  
                                              </div>";
                      }

                    $header2 = "From: contact@r3printing.com" . $eol;
                        $header2 .= "MIME-Version: 1.0\r\n";
                        $header2 .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        
                        $message2 = '<html><body>';
                        $message2 .= "<p>Dear " . $_POST["firstName"] . ",<br><br>Your object " . $_FILES["file"]["name"] . " was successfuly submitted for printing at <a href='www.r3printing.com'>r3printing.com</a>. ";
                        $message2 .= "<br<br>Below is a table of the print parameters you provided.</p><br><br>";
                        $message2 .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
                        $message2 .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" . strip_tags($_POST['name']) . "</td></tr>";
                        $message2 .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($_POST['email']) . "</td></tr>";
                        $message2 .= "<tr><td><strong>Phone:</strong> </td><td>" . strip_tags($_POST['phone']) . "</td></tr>";
                        $message2 .= "<tr><td><strong>Units:</strong> </td><td>" . strip_tags($unit) . "</td></tr>";
                        $message2 .= "<tr><td><strong>Resolution:</strong> </td><td>" . strip_tags($resolutionVal) . "</td></tr>";
                        $message2 .= "<tr><td><strong>Material/Color:</strong> </td><td>" . strip_tags($materialVal) . "</td></tr>";
                        $message2 .= "<tr><td><strong>Rush:</strong> </td><td>" . strip_tags($rushVal) . "</td></tr>";
                        $message2 .= "<tr><td><strong>Copies:</strong> </td><td>" . strip_tags($copies) . "</td></tr>";
                        $message2 .= "<tr><td><strong>Comments:</strong> </td><td>" . strip_tags($_POST['comments']) . "</td></tr>";
                        $message2 .= "<tr><td><strong>Cost:</strong> </td><td>" . "$" . strip_tags($cost) . "</td></tr>";
                        $message2 .= "</table>";
                        $message2 .= "<p>If you have any questions, please <a href='www.r3printing.com/contact'>contact us</a>.";
                        $message2 .= "<br><br>An R3 representative will contact you when your print is complete and ready for pickup!<br><br>Sincerely,<br><br>";
                        $message2 .= "The R3 Printing Team</p>";
                        $message2 .= "</body></html>";
                        mail( $_POST["email"] , "R3 Printing Submission Confirmation" , $message2, $header2 );

                }

        }
        else{
                echo "Error uploading file";
        }

?>