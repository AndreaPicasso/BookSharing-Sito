<?php
require_once('PHPMailer/PHPMailerAutoload.php');


function sendMail($address, $subject, $text){

        $mail = new PHPMailer;

        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.mail.yahoo.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'B00KSHARING@yahoo.com';                 // SMTP username
        $mail->Password = '123stella';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom('B00KSHARING@yahoo.com', 'Book Sharing');
        $mail->addAddress($address);     // Add a recipient
        $mail->isHTML(true);  

        $mail->Subject = $subject;
        $mail->Body    = $text;
        $mail->AltBody = $text;

        if(!$mail->send()) {
            echo '<script type="text/javascript">window.alert("Mailer Error:'.$mail->ErrorInfo.'")</script>';
        }
        
        
    
   
}


 ?>