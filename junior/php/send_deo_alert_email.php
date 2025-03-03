<?php
header('COntent-Type: application/json;charset=utf-8');
header("Access-Control-Allow-Origin: *");
$data_array = array();
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['centre_code']) && isset($_POST['centre_name']) && isset($_POST['email'])){
    // $data = json_decode(file_get_contents("php://input"),JSON_OBJECT_AS_ARRAY);

     
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
// $centre_code = $_POST['centre_code'];
// $centre_name = $_POST['centre_name'];
$email = $_POST['email'];


$centre_names = is_array($_POST['centre_name']) ? $_POST['centre_name'] : array($_POST['centre_name']);
$centre_code = is_array($_POST['centre_code']) ? $_POST['centre_code'] : array($_POST['centre_code']);
    //Create an instance; passing `true` enables exceptions
    if (count($centre_names) === count($centre_codes)) {
        // Combine the two arrays
        $centres = array_combine($centre_names, $centre_codes);
    
        // Now you can use the $centres array as needed
        foreach ($centres as $name => $code) {
            $affected_centres = $code.' - '.$code.'<br />';
        }

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
    $mail->Subject = 'Removed from payment schedule';
    $mail->Body    = 'Dear '.$first_name.' '.$last_name.'<br /><br /> You have been removed from the payment schedule you had submited because your Senior Examinations Standards Officer (SESO) shifted an examination centre that you may have entered for, from your marking centre to another. <br /><br />
    The affected examination centre(s) is are:'.$affected_centres.' 
    You are requested to log into your account and resubmit your claim.<br /></ />
    Regards<br /> Examinations Council of Zambia';
    $mail->AltBody = 'Dear '.$first_name.' '.$last_name.'<br /><br /> You have been removed from the payment schedule you had submited because your Senior Examinations Standards Officer (SESO) shifted an examination centre that you may have entered for, from your marking centre to another. <br /><br />
    The affected examination centre(s) is are:'.$affected_centres.' 
    You are requested to log into your account and resubmit your claim.<br /></br />
   Regards<br /> Examinations Council of Zambia';

    $mail->send();
    $data_array['status'] = '200';
} catch (Exception $e) {
        $data_array['status'] = '400';
        $data_array['response_msg'] = "Message could not be sent but data is saved. Password is: '$password'. Mailer Error: {$mail->ErrorInfo}";
}


    }

    }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Not al parameters are set';
    }

echo json_encode($data_array);
?>