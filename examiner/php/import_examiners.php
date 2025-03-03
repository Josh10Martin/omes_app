<?php
header('Content-Type:application/json ; charset=utf-8');
session_start();
include '../../config.php';
$data_array = array();


    $json_data = 'https://ems.exams-council.org.zm:8080/api/examiners/';
    $examiners = file_get_contents($json_data);
    $people = json_decode($examiners, JSON_OBJECT_AS_ARRAY);
    $i = 0;
try{
    foreach($people as $key=> $row){
        if(isset($row['examiner_number'])){
        $examiner_number = $row['examiner_number'] ?? ''; 
        $nrc = $row['nrc'] ?? '';
        $tpin = $row['tpin'] ?? '';
        $first_name = $row['first_name'] ?? '';
        $last_name = $row['last_name'] ?? '';
        $phone_number = $row['phone_number'] ?? '';
        $email  = $row['email'] ?? '';
        $address  = $row['address'] ?? '';
        $gender  = $row['gender'] ?? '';
        $role = $row['role'] ?? '';
        $no_of_days   = $row['no_of_days'] ?? '';
        $marking_centre_code  = md5($row['marking_centre_name'] ?? '');
        $subject_code = $row['subject_code'] ?? '';
        $paper_no  = $row['paper_number'];
        $bank = $row['bank'] ?? '';
        $branch = $row['branch'] ?? '';
        $sortcode = $row['sortcode'] ?? '';
        $account_no = $row['account_no'] ?? '';
        $session = $row['session_id'] ?? '';
        
        $sql = $db_12_gce->prepare('INSERT IGNORE INTO examiner (examiner_number,nrc,tpin,first_name,last_name,phone_number,email,address,gender,role,no_of_days,marking_centre,subject_code,paper_no,bank,branch,sortcode,account_no,session)VALUES(:examiner_number,:nrc,:tpin,:first_name,:last_name,:phone_number,:email,:address,:gender,:role,:no_of_days,:marking_centre,:subject_code,:paper_no,:bank,:branch,:sortcode,:account_no,:session)');
        $sql->execute(array(
            ':examiner_number'=>$examiner_number,
            ':nrc'=>$nrc,
            ':tpin'=>$tpin,
            ':first_name'=>$first_name,
            ':last_name'=>$last_name,
            ':phone_number'=>$phone_number,
            ':email'=>$email,
            ':address'=>$address,
            ':gender'=>$gender,
            ':marking_centre'=>$marking_centre_code,
            ':role'=>$role,
            ':no_of_days'=>$no_of_days,
            ':subject_code'=>$subject_code,
            ':paper_no'=>$paper_no,
            ':bank'=>$bank,
            ':branch'=>$branch,
            ':sortcode'=>$sortcode,
            ':account_no'=>$account_no,
            ':session'=>$session
        ));
        $i++;
    }
    }

//     if($sql->rowCount() > 0){
//         $centre_type = $centre_type == 'I' ? 'Grade 12' : 'G.C.E';
//         $data_array['status'] = '200';
//         $data_array['response_msg'] = $i.' '.$centre_type.' examiner(s) successfully imported from OCRS';
//     }else{
//         $data_array['status'] = '400';
//         $data_array['response_msg'] = 'There was a problem importing examiner(s) from OCRS';
//     }
}catch(PDOException $e){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
}

echo json_encode($data_array);
?>