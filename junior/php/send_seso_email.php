<?php
header('COntent-Type: application/json;charset=utf-8');
header("Access-Control-Allow-Origin: *"); 
// include '../../config.php';
$data_array = array();

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
if(isset($_POST['email']) && isset($_POST['username']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['password']) && isset($_POST['user_type'])){

$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$password = $_POST['password'];
$user_type = $_POST['user_type'];
$work = $user_type == 'ECZ' ? 'administrative duties' : 'co - ordination';
$link = 'https://omes.exams-council.org.zm/omes/';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = 4;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    // $mail->Host       = 'smtp.zoho.com';                     //Set the SMTP server to send through
    $mail->Host       = 'mail.exams-council.org.zm';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;
    // $mail->SMTPDebug = 3;                                   //Enable SMTP authentication
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
    $mail->Subject = 'Registered for Grade 9 '.$work;
    $mail->Body    = 'Dear '.$first_name.' '.$last_name.'<br /><br /> You have been defined by the Examinations Council of Zambia to co-ordinate Grade 9 exams.
    Visit or copy the link below and enter the username <span style="font-weight:bold;">'.$username.'</span> and password <span style="font-weight:bold;">'.$password.'</span>. <br /><br />
    '.$link.' <br /></br />
    Regards<br /> Examinations Council of Zambia';
    $mail->AltBody = 'Dear '.$first_name.' '.$last_name.'<br /><br /> You have been defined by the Examinations Council of Zambia to co-ordinate Grade 9 exams.
    Visit or copy the link below and enter the username <span style="font-weight:bold;">'.$username.'</span> and password <span style="font-weight:bold;">'.$password.'</span>. <br /><br />
    '.$link.' <br /></br />
    Regards<br /> Examinations Council of Zambia';

    $mail->send();
    $data_array['status'] = '200';
    $data_array['response_msg'] = 'Message has been sent to '.$email;
} catch (Exception $e) {
        $data_array['status'] = '400';
        $data_array['response_msg'] = "Message could not be sent but data is saved. Password is: '$password'. Mailer Error: {$mail->ErrorInfo}";
}
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'All email parameters not set but data is saved. Password is: '.$password;
}

echo json_encode($data_array);
?>