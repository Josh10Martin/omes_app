<?php
session_start();
header('Content-Type:application/json; charset=utf-8;');
include '../../config.php';
include '../../functions.php';
$data_array = array();

if(isset($_POST['id'])){

    $id = $_POST['id'];
    
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $phone_number = $_POST['phone_number'];
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $address = $_POST['address'];
  $title = $_POST['title'];
  $tpin = $_POST['tpin'];
  
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
}else if(!empty($email) && !filter_var($email,FILTER_VALIDATE_EMAIL)){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Enter correct email address';
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
        $sql0 = $db_9->prepare('UPDATE transcriber SET tpin =:tpin,first_name =:first_name,last_name =:last_name,phone_number =:phone_number,title =:title,email =:email,address =:address,branch =:branch, account_no =:account_no
                                    WHERE marking_centre =:marking_centre_code AND id =:id');
        $sql0->execute(array(
            ':id'=>$id,
            ':tpin'=>$tpin,
            ':first_name'=>$first_name,
            ':last_name'=>$last_name,
            ':phone_number'=>$phone_number,
            ':title'=>$title,
            ':email'=>$email,
            ':address'=>$address,
            ':branch'=>$branch,
            ':account_no'=>$account_number,
            ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
        if($sql0->rowCount() > 0){
            $data_array['status'] = '200';
            $data_array['response_msg'] = 'SUccessfully updated transcriber details';
         }else{
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Could not update transcriber. Try again';
        }
        
            
      

    }catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There wan an error updating details: '.$e->getMessage();
    }
}
}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'id parameter unrecognised';
}
echo json_encode($data_array);
?>