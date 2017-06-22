<?php

require_once('phpmailer/class.phpmailer.php');

$mail = new PHPMailer();

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if( $_POST['contactform-name'] != '' AND $_POST['contactform-email'] != '' AND $_POST['contactform-message'] != '' ) {

        $name = $_POST['contactform-name'];
        $email = $_POST['contactform-email'];
        $phone = $_POST['contactform-phone'];
        $service = $_POST['contactform-service'];
        $subject = $_POST['contactform-subject'];
        $message = $_POST['contactform-message'];

        $subject = isset($subject) ? $subject : 'New Message From Contact Form';

        $botcheck = $_POST['contactform-botcheck'];

        $toemail = 'my@email.com'; // Your Email Address
        $toname = 'Your Name'; // Your Name

        if( $botcheck == '' ) {

            $mail->SetFrom( $email , $name );
            $mail->AddReplyTo( $email , $name );
            $mail->AddAddress( $toemail , $toname );
            $mail->Subject = $subject;

            $name = isset($name) ? "Name: $name<br><br>" : '';
            $email = isset($email) ? "Email: $email<br><br>" : '';
            $phone = isset($phone) ? "Phone: $phone<br><br>" : '';
            $service = isset($service) ? "Service: $service<br><br>" : '';
            $message = isset($message) ? "Message: $message<br><br>" : '';

            $referrer = $_SERVER['HTTP_REFERER'] ? '<br><br><br>This Form was submitted from: ' . $_SERVER['HTTP_REFERER'] : '';

            $body = "$name $email $phone $service $message $referrer";

            $mail->MsgHTML( $body );
            $sendEmail = $mail->Send();

            if( $sendEmail == true ):
                echo 'We have successfully received your Message and will get Back to you as soon as possible.';
            else:
                echo 'Email could not be sent due to some Unexpected Error. Please Try Again later.<br /><br />Reason:<br />' . $mail->ErrorInfo . '';
            endif;
        } else {
            echo 'Bot Detected.!';
        }
    } else {
        echo 'Please Fill up all the Fields and Try Again.';
    }
} else {
    echo 'An unexpected error occured. Please Try Again later.';
}

?>