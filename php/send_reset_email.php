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
if(isset($_POST['email']) &&  isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['username'])){

$email = $_POST['email'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$username = $_POST['username'];
$button = '<a href="https://omes.exams-council.org.zm/omes/reset_password.php?username='.$username.'&email='.$email.'">
        <button type="submit" style="cursor:pointer; padding:5px; color:white; background-color:green;">Reset Password</button>
        </a>';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = 4;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    // $mail->Host       = 'smtp.zoho.com';                     //Set the SMTP server to send through
    $mail->Host       = 'mail.exams-council.org.zm';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'ems@exams-council.org.zm';                     //SMTP username
    // $mail->Username   = 'joshua.mbewe@zohomail.com';                     //SMTP username
    $mail->Password   = 'Ex@m1n3r2023';                               //SMTP password
    // $mail->Password   = '1m0n%Zoho%';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = '587';                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    // $mail->setFrom('joshua.mbewe@zohomail.com', 'Examinations Council of Zambia');
    $mail->setFrom('ems@exams-council.org.zm', 'Examinations Council of Zambia');
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
    $mail->Subject = 'Password reset request (OMES Grade 9)';
    $mail->Body    = 'Dear '.$first_name.' '.$last_name.'<br /><br /> You had requested for your Online Marks Entry (OMES) Grade 9 account password reset. Click on the Button below to begin the reset process. If you did not request for a password reset, you may ignore this email <br /><br />
    '.$button.' <br /></br />
    Regards<br /> Examinations Council of Zambia';
    $mail->AltBody = 'Dear '.$first_name.' '.$last_name.'<br /><br /> You had requested for your Online Marks Entry (OMES) Grade 9 account password reset. Click on the Button below to begin the reset process. If you did not request for a password reset, you may ignore this email <br /><br />
    '.$button.' <br /></br />
    Regards<br /> Examinations Council of Zambia';

    $mail->send();
    $data_array['status'] = '200';
    $data_array['response_msg'] = 'An email has been sent to '.$email;
} catch (Exception $e) {
        $data_array['status'] = '400';
        $data_array['response_msg'] = "Email could not be sent to '.$email.'. Mailer Error: {$mail->ErrorInfo}";
}
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'All email parameters not set but data is saved.';
}
echo json_encode($data_array);
?>