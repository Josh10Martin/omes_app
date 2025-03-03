<?php
header('Content-Type:application/json ; charset=utf-8');
header("Access-Control-Allow-Origin: *"); 
session_start();
include '../../../config.php';
$data_array = array(); 

$data = json_decode(file_get_contents('https://ems.exams-council.org.zm:8080/api/ted/examiners/'), JSON_OBJECT_AS_ARRAY);

foreach($data as $key => $row){
if(isset($row['ExaminerCode'])){
    $examiner_number = $row['ExaminerCode'] ?? '';
    $nrc = $row['nrc'] ?? '';
    $tpin = $row['t_pin'] ?? '';
    $province = $row['province'] ?? '';
    $district = $row['district'] ?? '';
    $station = $row['station'] ?? '';
    $first_name = $row['first_name'] ?? '';
    $last_name = $row['last_name'] ?? '';
    $email = $row['email'] ?? '';
    $phone_number = $row['phone'] ?? '';
    $address = $row['address'] ?? '';
    $gender = $row['gender'] ?? '';
    $dob = $row['D_O_B'] ?? '';
  
    $role = $row['role'] ?? '';
    $job_title = $row['job_title'] ?? '';
    $bank = $row['bank'] ?? '';
    $branch = $row['branch'] ?? '';
    $sortcode = $row['sort_code'] ?? '';
    $account_no = $row['account'] ?? '';
    $course_code  = $row['course_code'] ?? '';
    $session = trim(strtoupper($row['session_name']));
    $session_id = substr($session,0,4);
    $marking_centre = md5($row['marking_centre']);
    
    
    try{
        $sql = $db_ted->prepare('INSERT INTO examiner (examiner_number,nrc,tpin,first_name,last_name,phone_number,email,address,station,district,province,gender,dob,role,job_title,marking_centre,course_code ,bank,branch,sortcode,account_no,session)
                                VALUES (:examiner_number,:nrc,:tpin,:first_name,:last_name,:phone,:email,:address,:station,:district,:province,:gender,:dob,:role,:job_title,:marking_centre,:course_code ,:bank,:branch,:sortcode,:account_no,:session)
                                ON DUPLICATE KEY UPDATE
                               
                                first_name = VALUES(first_name),
                                last_name = VALUES(last_name),
                                phone_number = VALUES(phone_number),
                                email = VALUES(email),
                                address = VALUES(address),
                                district = VALUES(district),
                                station = VALUES(station),
                                province = VALUES(province),
                                gender = VALUES(gender),
                                dob = VALUES(dob),
                                role = VALUES(role),
                                job_title = VALUES(job_title),
                                course_code = VALUES(course_code),
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
                ':station'=>$station,
                ':province'=>$province,
                ':gender'=>$gender,
                ':dob'=>$dob,
                ':job_title'=>$job_title,
                ':role'=>$role,
                ':course_code'=>$course_code ,
                ':bank'=>$bank,
                ':branch'=>$branch,
                ':marking_centre'=>$marking_centre,
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
}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Examiner code not set';
}
}
echo json_encode($data_array);
?>