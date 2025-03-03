<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../functions.php';
include '../../config.php';
$data_array = array();
if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset( $_POST['nrc_number']) && isset($_POST['phone_number']) && isset($_POST['address']) && isset($_POST['title']) && isset($_POST['role']) && isset($_POST['tpin']) && isset($_POST['belt_number']) && isset($_POST['attendance']) && isset($_POST['no_of_days']) && $_POST['marking_centre'] && isset($_POST['subject']) && isset($_POST['paper']) && isset($_POST['bank']) && isset($_POST['branch']) && isset($_POST['account_number'])){

  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $nrc_number = $_POST['nrc_number'];
  $phone_number = $_POST['phone_number'];
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $address = $_POST['address'];
  $title = $_POST['title'];
  $roles = $_POST['role'];
  $role_id = explode(':',$roles)[0];
  $role = explode(':',$roles)[1];
  $rand_password = substr(md5(rand(10000,99999)),1,5);
  $option = array('cost'=>12);
  $hash_password = password_hash($rand_password,PASSWORD_BCRYPT,$option);
  $deo = 'DEO';
  $activation_status_deo = '1';
  
 
  $tpin = $_POST['tpin'];
  $belt_number = $role_id == 4 || $role_id == 5 ? 0 :  $_POST['belt_number'];
  $attendance = $_POST['attendance'];
  
  $no_of_days = $_POST['no_of_days'];
  $marking_centre = $_POST['marking_centre'];
  $subject = $_POST['subject'];
  $paper = $_POST['paper'];
  $bank = $_POST['bank'];
  $branch = $_POST['branch'] ?? '';
  $account_number = $_POST['account_number'];

  $exception_banks = 3 ?? 11;
  
//   $deo_username = deo_username($db_9,$subject,$paper,$deo);

  if(!preg_match('/^[a-zA-Z \']+$/', $first_name) || !preg_match('/^[a-zA-Z \']+$/',$last_name)){
         $data_array['status'] = '400';
         $data_array['response_msg'] = 'Enter correct names';
  }else if (($role_id == 4 || $role_id == 5) && $belt_number != 0){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Chief Examiners should be belted at 0';
  }else if(this_examiner_role_id($db_9,$subject,$paper,$role_id,$_SESSION['marking_centre_code'],$_SESSION['province_code']) == '5'){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There is a Chief Examiner already registered';
  }else if(team_leader_exists($db_9,$subject,$paper,$role_id,$belt_number,$_SESSION['marking_centre_code'],$_SESSION['province_code']) == 'true'){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There is a Team Leader in belt '.$belt_number;
  }else if(checker_exists($db_9,$subject,$paper,$role_id,$belt_number,$_SESSION['marking_centre_code'],$_SESSION['province_code']) == 'true'){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There is a Checker in belt '.$belt_number;
  }else if(($role_id  == 1 || $role_id == 2 || $role_id == 3) && $belt_number == 0){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Give the examiner a valid belt number either than 0';
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
  }else if(nrc_exists($db_9,$nrc_number) != 'false'){
            $data_array['status'] = '401';
            $data_array['id'] = $nrc_number;
            $data_array['message'] = 'The NRC number '.$nrc_number.' is already in use by '.nrc_exists($db_9,$nrc_number);
  }else if(!empty($email) && email_exists($db_9,$email) == 'true'){
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'The email address '.$email.' is already in use';
  }else if(tpin_exists($db_9,$tpin) != 'false'){
            $data_array['status'] = '401';
            $data_array['id'] = $tpin;
            $data_array['message'] = 'The TPIN '.$tpin.' is already in use by '.tpin_exists($db_9,$tpin);
  }else if($bank == 3 && strlen($account_number) != 10){
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Enter 10 digit bank account number for ABSA';
  }else if($bank == 16 && strlen($account_number) != 11){
          $data_array['status'] = '400';
          $data_array['response_msg'] = 'Enter 11 digit bank account number for FIRST NATIONAL BANK (FNB)';
  }else if(($bank != 16 && $bank != 3) && strlen($account_number) != 13){
          $data_array['status'] = '400';
          $data_array['response_msg'] = 'Enter 13 digit bank account number';
}else{
          try{
  $sql = $db_9->prepare('INSERT IGNORE INTO examiner (nrc,tpin,first_name,last_name,phone_number,email,address,title,role,belt_no,attendance,no_of_days,marking_centre,province,subject_code,paper_no,branch,account_no,session)
                          VALUES (:nrc,:tpin,:first_name,:last_name,:phone,:email,:address,:title,:role,:belt_no,:attendance,:no_of_days,:marking_centre,:province_code,:subject_code,:paper_no,:branch,:account_no,:session)');
  $sql->execute(array(
          ':nrc'=>$nrc_number,
          ':tpin'=>$tpin,
          ':first_name'=>$first_name,
          ':last_name'=>$last_name,
          ':phone'=>$phone_number,
          ':email'=>$email,
          ':address'=>$address,
          ':title'=>$title,
          ':role'=>$role_id,
          ':belt_no'=>$belt_number,
          ':attendance'=>$attendance,
          ':no_of_days'=>$no_of_days,
          ':marking_centre'=>$marking_centre,
          ':province_code'=>$_SESSION['province_code'],
          ':subject_code'=>$subject,
          ':paper_no'=>$paper,
          ':branch'=>$branch,
          ':account_no'=>$account_number,
          ':session'=>$_SESSION['session_id']
  ));
  
  if($sql->rowCount() > 0){
    $paper_no = $paper == '1' ? '2' : '1';
    if(subject_more_than_1_paper($db_9,$subject) == 'true'){
      $sql2 = $db_9->prepare('CALL paper_maintenance(:nrc,:tpin,:first_name,:last_name,:phone,:email,:address,:title,:role,:belt_no,:attendance,:no_of_days,:marking_centre,:province_code,:subject_code,:paper_no,:branch,:account_no,:session)');
      $sql2->execute(array(
        ':nrc'=>$nrc_number,
          ':tpin'=>$tpin,
          ':first_name'=>$first_name,
          ':last_name'=>$last_name,
          ':phone'=>$phone_number,
          ':email'=>$email,
          ':address'=>$address,
          ':title'=>$title,
          ':role'=>$role_id,
          ':belt_no'=>$belt_number,
          ':attendance'=>$attendance,
          ':no_of_days'=>$no_of_days,
          ':marking_centre'=>$marking_centre,
          ':province_code'=>$_SESSION['province_code'],
          ':subject_code'=>$subject,
          ':paper_no'=>$paper_no,
          ':branch'=>$branch,
          ':account_no'=>$account_number,
          ':session'=>$_SESSION['session_id']
      ));
      if($sql2->rowCount() > 0){
        $data_array['status'] = '200';
        $data_array['response_msg'] = $role.' details successfully added and paper maintenance applied';
        
      }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was a problem applying paper maintenance to '.$role;
        
      }
    }else{
      $data_array['status'] = '200';
      $data_array['response_msg'] = $role.' details successfully added';
      
    }
      
      
  }else{
      $data_array['status'] = '400';
      $data_array['response_msg'] = 'Could not add '.$role.'. Please try again';
     
  }
 
}catch(PDOEXCEPTION $e){
      $data_array['status'] = '400';
      $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
 
}

  }
}else{
      $data_array['status'] = '400';
      $data_array['response_msg'] = 'Not all parameters are set';
}
echo json_encode($data_array);
?>