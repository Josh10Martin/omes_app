<?php
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
if(isset($_POST['email']) && isset($_POST['username']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['password']) && isset($_POST['marking_centre_name']) && isset($_POST['user_type'])){

$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$password = $_POST['password'];
$user_type = $_POST['user_type'];
$person = $user_type == 'DATA ENTRY OPERATOR' ? 'Systems Administrator' : 'Senior Education Standards Officer (SESO)';
$marking_centre_name = $_POST['marking_centre_name'];
$link = 'https://omes.exams-council.org.zm/omes/';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = 4;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.zoho.com';                     //Set the SMTP server to send through
    // $mail->Host       = 'mail.exams-council.org.zm';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    // $mail->Username   = 'ovrs@exams-council.org.zm';                     //SMTP username
    $mail->Username   = 'joshua.mbewe@zohomail.com';                     //SMTP username
    // $mail->Password   = '0vrs@3seez';                               //SMTP password
    $mail->Password   = '1m0n%Zoho%';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = '587';                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('joshua.mbewe@zohomail.com', 'Examinations Council of Zambia');
    // $mail->setFrom('ovrs@exams-council.org.zm', 'Examinations Council of Zambia');
    $mail->addAddress($email, $first_name.' '.$last_name);     //Add a recipient
//     $mail->addAddress('ellen@example.com');               //Name is optional
//     $mail->addReplyTo('info@example.com', 'Information');
//     $mail->addCC('cc@example.com');
//     $mail->addBCC('bcc@example.com');

    //Attachments
//     $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//     $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'CHOSEN AS '.$user_type.' FOR GRADE 9 MARKING SESSION';
    $mail->Body    = 'Dear '.$first_name.' '.$last_name.'<br /><br /> You have been chosen by the '.$person.' to be '.$user_type.' for Grade 9 marking session at '.$marking_centre_name.'.
    Visit or copy the link below and enter the username <span style="font-weight:bold;">'.$username.'</span> and password <span style="font-weight:bold;">'.$password.'</span>. <br /><br />
    '.$link.' <br /></br />
    Regards<br /> Examinations Council of Zambia';
    $mail->AltBody = 'Dear '.$first_name.' '.$last_name.'<br /><br /> You have been chosen by the Senior Education Standards Officer (SESO) to be '.$user_type.' for Grade 9 marking session at '.$marking_centre_name.'.
    Visit or copy the link below and enter the username <span style="font-weight:bold;">'.$username.'</span> and password <span style="font-weight:bold;">'.$password.'</span>. <br /><br />
    '.$link.' <br /></br />
    Regards<br /> Examinations Council of Zambia';

    $mail->send();
    $data_array['status'] = '200';
    $data_array['response_msg'] = 'Message has been sent to '.$email;
} catch (Exception $e) {
        $data_array['status'] = '400';
        $data_array['response_msg'] = "Message could not be sent to '.$email.' but data is saved. Mailer Error: {$mail->ErrorInfo}";
}
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'All email parameters not set but data is saved';
}

echo json_encode($data_array);
?>