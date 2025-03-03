<?php
header('Content-Type:application/json ; charset=utf-8');
session_start();
include '../../config.php';
$data_array = array();

$_POST = json_decode(file_get_contents('php://input'), JSON_OBJECT_AS_ARRAY);


if(isset($_POST['examiner_number'])){
    $examiner_number = $_POST['examiner_number'];
    $nrc = $_POST['nrc'];
    $tpin = $_POST['tpin'];
    $province = $_POST['province'];
    $district = $_POST['district'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
  
    $role = $_POST['role'];
    $bank = $_POST['bank'];
    $branch = $_POST['branch'];
    $sortcode = $_POST['sortcode'];
    $account_no = $_POST['account_no'];
    $subject_code = $_POST['subject_code'];
    $paper_no = $_POST['paper_number'];
    $no_of_days = $_POST['no_of_days'];
    $session = trim(strtoupper($_POST['session_name']));
    $session_id = substr($session,0,4);
    $marking_centre = md5($_POST['marking_centre_name']);
    
    $belt_no = $role == 'CHIEF EXAMINER' || $role == 'DEPUTY CHIEF EXAMINER' ? 0 : NULL;
    
    try{
        $sql = $db_12_gce->prepare('INSERT IGNORE INTO examiner (examiner_number,nrc,tpin,first_name,last_name,phone_number,email,address,district,province,gender,role,belt_no,no_of_days,marking_centre,subject_code,paper_no,bank,branch,sortcode,account_no,session)
                                VALUES (:examiner_number,:nrc,:tpin,:first_name,:last_name,:phone,:email,:address,:district,:province,:gender,:role,:belt_no,:no_of_days,:marking_centre,:subject_code,:paper_no,:bank,:branch,:sortcode,:account_no,:session)
                                ON DUPLICATE KEY UPDATE
                               
                                first_name = VALUES(first_name),
                                last_name = VALUES(last_name),
                                phone_number = VALUES(phone_number),
                                email = VALUES(email),
                                address = VALUES(address),
                                district = VALUES(district),
                                province = VALUES(province),
                                gender = VALUES(gender),
                                role = VALUES(role),
                                belt_no = VALUES(belt_no),
                                no_of_days = VALUES(no_of_days),
                                marking_centre = VALUES(marking_centre),
                                bank = VALUES(bank),
                                branch = VALUES(branch),
                                sortcode = VALUES(sortcode),
                                account_no = VALUES(account_no),
                                session = VALUES(session)
                                ');
        $sql->execute(array(
            ':nrc'=>$nrc,
                ':examiner_number'=>$examiner_number,
                ':tpin'=>$tpin,
                ':first_name'=>$first_name,
                ':last_name'=>$last_name,
                ':phone'=>$phone_number,
                ':email'=>$email,
                ':address'=>$address,
                ':district'=>$district,
                ':province'=>$province,
                ':gender'=>$gender,
                ':role'=>$role,
                ':belt_no'=>$belt_no,
                ':no_of_days'=>$no_of_days,
                ':marking_centre'=>$marking_centre,
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
                ':bank'=>$bank,
                ':branch'=>$branch,
                ':sortcode'=>$sortcode,
                ':account_no'=>$account_no,
                ':session'=>$session_id
        ));
        
        if($sql->rowCount() > 0){

            $data_array['status'] = '200';
            $data_array['response_msg'] = 'examiner details successfully added';
        
        }else{
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Could not add examiner(s). Please try again';
           
        }
    }catch(PSOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
    }
}

echo json_encode($data_array);
?>