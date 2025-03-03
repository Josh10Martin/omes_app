<?php
header('Content-Type:application/json; charset=utf-8;');
session_start();
include '../../config.php';
$data_array = array();

// if(isset($_POST['examiner_number']) && isset($_POST['nrc']) && isset($_POST['tpin']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['phone_number']) && isset($_POST['email']) && isset($_POST['address']) && isset($_POST['title']) && isset($_POST['role']) && isset($_POST['no_of_days']) && isset($_POST['marking_centre_code']) && isset($_POST['subject_code']) && isset($_POST['paper_number']) && isset($_POST['bank']) && isset($_POST['branch']) && isset($_POST['sortcode']) && isset($_POST['account_no'])){
    $_POST = json_decode(file_get_contents('php://input'),JSON_OBJECT_AS_ARRAY);
   
    $examiner_number = trim(strtoupper($_POST['examiner_number']));
    $nrc = $_POST['nrc'];
    $tpin = $_POST['tpin'];
    $first_name = trim(strtoupper($_POST['first_name']));
    $last_name = trim(strtoupper($_POST['last_name']));
    $email = $_POST['email'];
    $address = trim(strtoupper($_POST['address']));
    $district = trim(strtoupper($_POST['district']));
    $province = trim(strtoupper($_POST['province']));
    $phone_number = trim($_POST['phone_number']);
    $gender = trim(strtoupper($_POST['gender']));
    $role = trim(strtoupper($_POST['role']));
    //$belt_no = $role == 'CHIEF EXAMINER' || $role == 'DEPUTY CHIEF EXAMINER' ? 0 : $belt_no;
    $no_of_days = trim($_POST['no_of_days']);
    $marking_centre = md5(trim(strtoupper($_POST['marking_centre_name'])));
    $subject_code = trim($_POST['subject_code']);
    $paper_no = trim($_POST['paper_number']);
    $bank = $_POST['bank'];
    $branch = $_POST['branch'];
    $sortcode = $_POST['sortcode'];
    $account_no = $_POST['account_no'];
   
    try{
        $sql = $db_12_gce->prepare('UPDATE examiner SET nrc =:nrc, tpin =:tpin,first_name =:first_name,last_name =:last_name,phone_number =:phone,email =:email, address =:address,
                                district =:district,province =:province,gender =:gender,role =:role,no_of_days =:no_of_days,marking_centre =:marking_centre, subject_code =:subject_code, paper_no =:paper_no,
                                bank =:bank, branch =:branch,sortcode=:sortcode, account_no =:account_no WHERE examiner_number =:examiner_number');
        $sql->execute(array(
          ':tpin'=>$tpin,
          ':nrc'=>$nrc,
          ':first_name'=>$first_name,
          ':last_name'=>$last_name,
          ':phone'=>$phone_number,
          ':email'=>$email,
          ':address'=>$address,
          ':district'=>$district,
          ':province'=>$province,
          ':gender'=>$gender,
          ':role'=>$role,
          //':belt_no'=>$belt_no,
          ':no_of_days'=>$no_of_days,
          ':subject_code'=>$subject_code,
          ':marking_centre'=>$marking_centre,
          ':paper_no'=>$paper_no,
          ':bank'=>$bank,
          ':branch'=>$branch,
          ':account_no'=>$account_no,
          ':sortcode'=>$sortcode,
          ':examiner_number'=>$examiner_number
        ));
   
        if($sql->rowCount() > 0){
            $data_array['status'] = '200';
            $data_array['response_msg'] = 'Examiner details successfully updated';
        }else{
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Could not find examiner details. Try again';
        }

    }catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There wan an error updating details: '.$e->getMessage();
    }
       
// }else{
//     $data_array['status'] = '400';
//     $data_array['response_msg'] = 'Not all parameters set for update';
// }
echo json_encode($data_array);
?>