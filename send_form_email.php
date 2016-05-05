<?php
require_once("vendor/phpmailer/phpmailer/PHPMailerAutoload.php"); // this will include smtp and pop files.

if(isset($_POST['email'])) {
    
    $email_to_first = "shane325@gmail.com";//"bushidoft@gmail.com";
    $email_to_second = "shane@buildeasyapp.com";//"nicoyamipoya13@gmail.com";
 
    function died($error) {
            // your error code can go here
            echo "We are very sorry, but there were error(s) found with the form you submitted. ";
            echo "These errors appear below.<br /><br />";
            echo $error."<br /><br />";
            echo "Please go back and fix these errors.<br /><br />";
            die();
    }
    
    // validation expected data exists
    if(!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['message'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }

    $name = $_POST['name']; // required
    $email_from = $_POST['email']; // required
//    $email_subject = $_POST['subject']; //required
    $comments = $_POST['message']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if(!preg_match($email_exp,$email_from)) {
        $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if(!preg_match($string_exp,$name)) {
    $error_message .= 'The First Name you entered does not appear to be valid.<br />';
    }

    if(strlen($comments) < 2) {
    $error_message .= 'The Message you entered does not appear to be valid.<br />';
    }

    if(strlen($error_message) > 0) {
    died($error_message);
    }

    $email_message = "You got an email from the Bushido Fight Team website. Here are the details:\n\n";

    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);

    }

    $email_message .= "Name: ".clean_string($name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
//    $email_message .= "Subject: ".clean_string($email_subject)."\n";
    $email_message .= "Message: ".clean_string($comments)."\n";

    $mail = new PHPMailer(true);

    //Send mail using gmail
//    if($send_using_gmail){
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->SMTPSecure = "ssl"; // sets the prefix to the server
        $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
        $mail->Port = 465; // set the SMTP port for the GMAIL server
        $mail->Username = "bushidofightteam415@gmail.com"; // GMAIL username
        $mail->Password = "Bushido2051"; // GMAIL password
//    }

    //Typical mail data
    $mail->AddAddress($email_to_first);
    $mail->AddAddress($email_to_second);
    $mail->SetFrom($email_from, $name);
    $mail->Subject = "Bushido Fight Team message";
    $mail->Body = $email_message;

    try{
        $mail->Send();
        echo "Thank you for contacting us. We will be in touch with you very soon.!";
    } catch(Exception $e){
        //Something went bad
        echo "Fail - " . $mail->ErrorInfo;
    }
    
    ?>
    <!-- include your own success html here -->
<!--    Thank you for contacting us. We will be in touch with you very soon.-->

    <?php

}
?>
