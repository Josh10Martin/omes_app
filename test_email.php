<?php
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$mail = new PHPMailer();

// $fname = $_POST['fname'];
//     $lname = $_POST['lname'];
//     $email = $_POST['email'];
//     $password = $_POST['password'];
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = 'mail.exams-council.org.zm'; // address of mail server
    $mail->Port = '587';
    $mail->SMTPDebug = 3;
    // $mail->SMTPOptions = [
    //   'ssl' => [
    //     'verify_peer' => false,
    //     'verify_peer_name' => false,
    //     'allow_self_signed' => true
    //   ]
    // ];
    $mail->SMTPAuth = true;
   // $mail->Username = 'ovrs@exams-council.org.zm';
   $mail->Username = 'ems@exams-council.org.zm';;
    // $mail->Password = '0vrs@3seez';
    $mail->Password = 'Ex@m1n3r2023';
    $mail->SMTPSecure = 'tls'; // ssh / tls
    $mail->setFrom('ems@exams-council.org.zm', 'Examinations Council of Zambia');
    $mail->addAddress('joshua.mbewe@gmail.com','joshua','mbewe'); // receipient email address
    $mail->isHTML('isHtml', true);
  $mail->Subject = 'Successfully added to Online Results Verification'; // sample subject
  $mail->Body = 'Dear sir / madam. This is a test email'; // email body
  if($mail->Send()){
echo 'email sent';
  }else{
      echo 'Email not sent';
  }

?>