<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../functions.php';
include '../../config.php';
$data_array = array();
if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['nrc_number']) && isset($_POST['phone_number']) && isset($_POST['address']) && isset($_POST['title']) && isset($_POST['role']) && isset($_POST['tpin']) && isset($_POST['marking_centre']) && isset($_POST['bank']) && isset($_POST['branch']) && isset($_POST['account_number'])){

  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $nrc_number = $_POST['nrc_number'];
  $phone_number = $_POST['phone_number'];
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $address = $_POST['address'];
  $title = $_POST['title'];
  $role = $_POST['role'];

  
 
  $tpin = $_POST['tpin'];
  
  $marking_centre = $_POST['marking_centre'];
  $bank = $_POST['bank'];
  $branch = $_POST['branch'] ?? '';
  $account_number = $_POST['account_number'];
  
//   $deo_username = deo_username($db_9,$subject,$paper,$deo);

  if(!preg_match('/^[a-zA-Z \']+$/', $first_name) || !preg_match('/^[a-zA-Z \']+$/',$last_name)){
         $data_array['status'] = '400';
         $data_array['response_msg'] = 'Enter correct names';
  }else if(!preg_match('/\d{6}\/\d{2}\/\d{1}/',$nrc_number)){
         $data_array['status'] = '400';
         $data_array['response_msg'] = 'Enter the NRC number in the format 000000/00/0';
  }else if(!preg_match('/\d{10}/',$tpin)){
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Enter 10 digit tpin number';
  }else if(!preg_match('/\d{10}/',$phone_number)){
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Enter 10 digit phone number';
  }else if(!empty($email) && !filter_var($email,FILTER_VALIDATE_EMAIL)){
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Enter correct email address';
  }else if(nrc_exists_for_transcriber($db_9,$nrc_number) != 'false'){
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'The Transcriber NRC number '.$nrc_number.' is already in use by '.nrc_exists_for_transcriber($db_9,$nrc_number);
  }else if(!empty($email) && email_exists_for_transcriber($db_9,$email) == 'true'){
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'The email address '.$email.' is already in use';
  }else if(tpin_exists_for_transcriber($db_9,$tpin) != 'false'){
            $data_array['status'] = '401';
            $data_array['id'] = $tpin;
            $data_array['message'] = 'The TPIN '.$tpin.' is already in use by '.tpin_exists($db_9,$tpin);
  }else if($bank == 3 && strlen($account_number) != 10){
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Enter 10 digit bank account number for ABSA';
  }else if($bank == 11 && strlen($account_number) != 15){
          $data_array['status'] = '400';
          $data_array['response_msg'] = 'Enter 15 digit bank account number for INVESTRUST';
  }else if($bank == 16 && strlen($account_number) != 11){
          $data_array['status'] = '400';
          $data_array['response_msg'] = 'Enter 11 digit bank account number for FIRST NATIONAL BANK (FNB)';
  }else if(($bank != 16 && $bank != 11 && $bank != 3) && strlen($account_number) != 13){
          $data_array['status'] = '400';
          $data_array['response_msg'] = 'Enter 13 digit bank account number';
}else{
          try{
  $sql = $db_9->prepare('INSERT IGNORE INTO transcriber (nrc,tpin,first_name,last_name,phone_number,email,address,title,role,marking_centre,province,branch,account_no,session)
                          VALUES (:nrc,:tpin,:first_name,:last_name,:phone_number,:email,:address,:title,:role,:marking_centre,:province_code,:branch,:account_no,:session)');
  $sql->execute(array(
          ':nrc'=>$nrc_number,
          ':tpin'=>$tpin,
          ':first_name'=>$first_name,
          ':last_name'=>$last_name,
          ':phone_number'=>$phone_number,
          ':email'=>$email,
          ':address'=>$address,
          ':title'=>$title,
          ':role'=>$role,
          ':marking_centre'=>$marking_centre,
          ':province_code'=>$_SESSION['province_code'],
          ':branch'=>$branch,
          ':account_no'=>$account_number,
          ':session'=>$_SESSION['session_id']
  ));
  
  if($sql->rowCount() > 0){

      $data_array['status'] = '200';
      $data_array['response_msg'] = $role.' details successfully added'; 
  }else{
      $data_array['status'] = '400';
      $data_array['response_msg'] = 'Could not add transcriber. Please try again';
     
  }
 
}catch(PDOEXCEPTION $e){
      $data_array['status'] = '400';
      $data_array['response_msg'] = 'There was an error adding marker / examiner: '.$e->getMessage();
 
}

  }
}else{
      $data_array['status'] = '400';
      $data_array['response_msg'] = 'Not all parameters are set';
}
echo json_encode($data_array);
?>