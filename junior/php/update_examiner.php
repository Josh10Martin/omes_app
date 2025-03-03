<?php
session_start();
header('Content-Type:application/json; charset=utf-8;');
include '../../config.php';
include '../../functions.php';
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
  
//   $tpin = $_POST['tpin'];
  $belt_number = $role == 4 || $role == 5 ? 0 : $_POST['belt_no'];
  $attendance = $_POST['attendance'];
  $no_of_days = $_POST['no_of_days'];
  $subject = $_POST['subject'];
  $paper = $_POST['paper'];
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
}else if(this_examiner_role_id($db_9,$subject,$paper,$role,$_SESSION['marking_centre_code'],$_SESSION['province_code']) == '5'){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There is a Chief Examiner already registered';
}else if($belt_number == 0 && ($role != 4 && $role != 5)){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Belt 0 is meant for Chief Examiners and Deputy Chief Examiners';

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
}else if(this_examiner_role_id($db_9,$subject,$paper,$role,$_SESSION['marking_centre_code'],$_SESSION['province_code']) == '5'){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There is a Chief Examiner already registered';
}else if(team_leader_exists($db_9,$subject,$paper,$role,$belt_number,$_SESSION['marking_centre_code'],$_SESSION['province_code']) == 'true'){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There is a Team Leader in belt '.$belt_number;
}else if(checker_exists($db_9,$subject,$paper,$role,$belt_number,$_SESSION['marking_centre_code'],$_SESSION['province_code']) == 'true'){
$data_array['status'] = '400';
$data_array['response_msg'] = 'There is a Checker in belt '.$belt_number;

}else{
    try{
        $sql0 = $db_9->prepare('DELETE FROM examiner WHERE nrc =:nrc');
        $sql0->execute(array(
            ':nrc'=>$nrc
        ));
        if($sql0->rowCount() > 0){
            $sql = $db_9->prepare('INSERT IGNORE INTO examiner (nrc,tpin,first_name,last_name,phone_number,email,address,title,role,belt_no,attendance,no_of_days,marking_centre,province,subject_code,paper_no,branch,account_no,session)
            VALUES (:nrc,:tpin,:first_name,:last_name,:phone,:email,:address,:title,:role,:belt_no,:attendance,:no_of_days,:marking_centre,:province_code,:subject_code,:paper_no,:branch,:account_no,:session)');
        $sql->execute(array(
        ':nrc'=>$nrc,
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
        ':marking_centre'=>$_SESSION['marking_centre_code'],
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
        ':nrc'=>$nrc,
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
        ':marking_centre'=>$_SESSION['marking_centre_code'],
        ':province_code'=>$_SESSION['province_code'],
        ':subject_code'=>$subject,
        ':paper_no'=>$paper_no,
        ':branch'=>$branch,
        ':account_no'=>$account_number,
        ':session'=>$_SESSION['session_id']
        ));
        if($sql2->rowCount() > 0){
        $data_array['status'] = '200';
        $data_array['response_msg'] = 'Details successfully updated and paper maintenance applied';

        }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was a problem applying paper maintenance to examiner';

        }
        }else{
        $data_array['status'] = '200';
        $data_array['response_msg'] = 'details successfully updated';

        }


        }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Could not add '.$role.'. Please try again';

        }
        }else{
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Could not remove examiner for preparation to insert updated data';
        }
        // $sql = $db_9->prepare('UPDATE examiner SET tpin =:tpin,first_name =:first_name,last_name =:last_name,phone_number =:phone,email =:email, address =:address,
        //                         title =:title,role =:role, belt_no =:belt_no, attendance =:attendance, no_of_days =:no_of_days, 
        //                         bank =:bank, branch =:branch, account_no =:account_no WHERE nrc =:nrc');
        // $sql->execute(array(
        //   ':tpin'=>$tpin,
        //   ':first_name'=>$first_name,
        //   ':last_name'=>$last_name,
        //   ':phone'=>$phone_number,
        //   ':email'=>$email,
        //   ':address'=>$address,
        //   ':title'=>$title,
        //   ':role'=>$role,
        //   ':belt_no'=>$belt_number,
        //   ':attendance'=>$attendance,
        //   ':no_of_days'=>$no_of_days,
        // //   ':subject_code'=>$subject,
        // //   ':paper_no'=>$paper,
        //   ':bank'=>$bank,
        //   ':branch'=>$branch,
        //   ':account_no'=>$account_number,
        //   ':nrc'=>$nrc
        // ));
        // if($sql->rowCount() > 0){
            // $paper_no = $paper == 1 ? 2 : 1;
            // if(subject_more_than_1_paper($db_9,$subject) == 'true' && current_no_of_paperss($db_9,$nrc,$subject) ==  1){
            //     $sql2 = $db_9->prepare('CALL paper_maintenance(:nrc,:tpin,:first_name,:last_name,:phone,:email,:address,:title,:role,:belt_no,:attendance,:no_of_days,:marking_centre,:province_code,:subject_code,:paper_no,:bank,:branch,:account_no,:session)');
            //     $sql2->execute(array(
            //       ':nrc'=>$nrc,
            //         ':tpin'=>$tpin,
            //         ':first_name'=>$first_name,
            //         ':last_name'=>$last_name,
            //         ':phone'=>$phone_number,
            //         ':email'=>$email,
            //         ':address'=>$address,
            //         ':title'=>$title,
            //         ':role'=>$role,
            //         ':belt_no'=>$belt_number,
            //         ':attendance'=>$attendance,
            //         ':no_of_days'=>$no_of_days,
            //         ':marking_centre'=>$_SESSION['marking_centre_code'],
            //         ':province_code'=>$_SESSION['province_code'],
            //         ':subject_code'=>$subject,
            //         ':paper_no'=>$paper_no,
            //         ':bank'=>$bank,
            //         ':branch'=>$branch,
            //         ':account_no'=>$account_number,
            //         ':session'=>$_SESSION['session_id']
            //     ));
            //     if($sql2->rowCount() > 0){
            //         $data_array['status'] = '200';
            //         $data_array['response_msg'] = 'Examiner details successfully updated and paper maintenance applied';
            //       }else{
            //         $data_array['status'] = '400';
            //         $data_array['response_msg'] = 'There was a problem applying paper maintenance after update';
            //       }
            // }else if(subject_more_than_1_paper($db_9,$subject) == 'false' && current_no_of_paperss($db_9,$nrc,$subject) >  1){
            //     $sql2 = $db_9->prepare('CALL remove_row_from_examiner(:nrc)');
            //     $sql2->execute(array(
            //         ':nrc'=>$nrc
            //     ));
            //     if($sql2->rowCount() > 0){
            //         $sql3 = $db_9->prepare('CALL make_paper_1(:nrc)');
            //         $sql3->execute(array(
            //             ':nrc'=>$nrc
            //         ));
            //         $data_array['status'] = '200';
            //         $data_array['response_msg'] = 'Examiner details successfully updated and paper maintenance removed';
            //     }else{
            //         $data_array['status'] = '400';
            //         $data_array['response_msg'] = 'There was a problem removing paper maintenance for examiner';
            //     }
            
            // }else{
                
            //     $data_array['status'] = '200';
            //     $data_array['response_msg'] = 'Examiner details successfully updated';
            // }
        //     $data_array['status'] = '200';
        //     $data_array['response_msg'] = 'Examiner details successfully updated';
        // }else{
        //     $data_array['status'] = '400';
        //     $data_array['response_msg'] = 'Could not update details';
        // }
            
    //    if(isset($_SESSION['nrc'])){
    //     unset($_SESSION['nrc']);
    //    }

    }catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There wan an error updating details: '.$e->getMessage();
    }
}
}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'nrc parameter unrecognised';
}
echo json_encode($data_array);
?>