<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../functions.php';
include '../../config.php';
$data_array = array();
if(isset($_POST['first_name'])){

  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $nrc_number = $_POST['nrc_number'];
  $phone_number = $_POST['phone_number'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $title = $_POST['title'];
  $roles = $_POST['role'] ??'';
  $role_id = explode(':',$roles)[0];
  $role = explode(':',$roles)[1];
  $rand_password = substr(md5(rand(10000,99999)),1,5);
  $option = array('cost'=>12);
  $hash_password = password_hash($rand_password,PASSWORD_BCRYPT,$option);
  $deo = 'DEO';
  $activation_status_deo = '1';
  
 
  $tpin = $_POST['tpin'];
  $belt_number = $_POST['belt_number'];
  $attendance = $_POST['attendance'];
  
  $no_of_days = $_POST['no_of_days'];
  $marking_centre = $_POST['marking_centre'];
  $subject = $_POST['subject'];
  $paper = $_POST['paper'];
  $bank = $_POST['bank'];
  $branch = $_POST['branch'] ?? '';
  $account_number = $_POST['account_number'];

  
//   $deo_username = deo_username($db_ted,$subject,$paper,$deo);

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
  }else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Enter correct email address';
  
  }else if($bank == 3 && strlen($account_number) != '10'){
      $data_array['status'] = '400';
      $data_array['response_msg'] = 'Enter 10 digit bank account number for ABSA';
  }else if($bank == 11 && strlen($account_number) != '15'){
          $data_array['status'] = '400';
          $data_array['response_msg'] = 'Enter 15 digit bank account number for INVESTRUST';
  }else if(($bank != 11 && $bank != 3) && strlen($account_number) != '13'){
          $data_array['status'] = '400';
          $data_array['response_msg'] = 'Enter 13 digit bank account number';
}else{
          try{
  $sql = $db_ted->prepare('INSERT IGNORE INTO examiner (nrc,tpin,first_name,last_name,phone_number,email,address,title,role,belt_no,attendance,no_of_days,marking_centre,subject_code,paper_no,bank,branch,account_no,session)
                          VALUES (:nrc,:tpin,:first_name,:last_name,:phone,:email,:address,:title,:role,:belt_no,:attendance,:no_of_days,:marking_centre,:subject_code,:paper_no,:bank,:branch,:account_no,:session)');
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
          ':subject_code'=>$subject,
          ':paper_no'=>$paper,
          ':bank'=>$bank,
          ':branch'=>$branch,
          ':account_no'=>$account_number,
          ':session'=>$_SESSION['session_id']
  ));
  if($sql->rowCount() > 0){

      $data_array['status'] = '200';
      $data_array['response_msg'] = $role.' details successfully added';
      
                  
      
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
      $data_array['response_msg'] = 'First name parameter not set';
}
echo json_encode($data_array);
?>