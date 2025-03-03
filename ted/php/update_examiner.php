<?php
session_start();
header('Content-Type:application/json; charset=utf-8;');
include '../../config.php';
$data_array = array();

if(isset($_POST['nrc'])){

    $nrc = $_POST['nrc'];
    
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $phone_number = $_POST['phone_number'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $title = $_POST['title'];
  $role = $_POST['role'];
  $tpin = $_POST['tpin'];
  
  $tpin = $_POST['tpin'];
  $belt_number = $_POST['belt_no'];
  $attendance = $_POST['attendance'];
  $no_of_days = $_POST['no_of_days'];
//   $subject = $_POST['subject'];
//   $paper = $_POST['paper'];
  $bank = $_POST['bank'];
  $branch = $_POST['branch'];
  $account_number = $_POST['account_no'];

  
  if(!preg_match('/^[a-zA-Z \']+$/', $first_name) || !preg_match('/^[a-zA-Z \']+$/',$last_name)){
         $data_array['status'] = '400';
         $data_array['response_msg'] = 'Enter correct names';
  }else if(!preg_match('/\d{10}/',$tpin)){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Enter 10 digit tpin number';
}else if(!preg_match('/\d{10}/',$phone_number)){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Enter 10 digit phone number';
}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Enter correct email address';
}else if(!preg_match('/\d{13}/',$account_number)){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Enter 13 digit tpin number';
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
        $sql = $db_ted->prepare('UPDATE examiner SET tpin =:tpin,first_name =:first_name,last_name =:last_name,phone_number =:phone,email =:email, address =:address,
                                title =:title,role =:role, belt_no =:belt_no, attendance =:attendance, no_of_days =:no_of_days, 
                                bank =:bank, branch =:branch, account_no =:account_no WHERE nrc =:nrc');
        $sql->execute(array(
          ':tpin'=>$tpin,
          ':first_name'=>$first_name,
          ':last_name'=>$last_name,
          ':phone'=>$phone_number,
          ':email'=>$email,
          ':address'=>$address,
          ':title'=>$title,
          ':role'=>$role,
          ':belt_no'=>$belt_number,
          ':attendance'=>$attendance,
          ':no_of_days'=>$no_of_days,
        //   ':subject_code'=>$subject,
        //   ':paper_no'=>$paper,
          ':bank'=>$bank,
          ':branch'=>$branch,
          ':account_no'=>$account_number,
          ':nrc'=>$nrc
        //   ':id'=>$id
        ));
        if($sql->rowCount() > 0){
            $data_array['status'] = '200';
            $data_array['response_msg'] = 'Examiner details successfully updated';
        }else{
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Could not update examiner details. Try again';
        }

    }catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There wan an error updating details: '.$e->getMessage();
    }
}
}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Id parameter unrecognised';
}
echo json_encode($data_array);
?>