<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../functions.php';
include '../../config.php';
$data_array = array();

if(isset($_POST['username'])){
    $username = $_POST['username'];
    $first_name = strtoupper($_POST['first_name']);
    $last_name = strtoupper($_POST['last_name']);
    $nrc = $_POST['nrc'];
    $phone = $_POST['phone'];
    $tpin = $_POST['tpin'];
    // $bank = $_POST['bank'];
    $branch = $_POST['branch'];
    $account_no = $_POST['account_no'];
    if($bank == 3 && strlen($account_no) != 10){
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Enter 10 digit bank account number for ABSA';
    
    }else if($bank == 16 && strlen($account_no) != 11){
          $data_array['status'] = '400';
          $data_array['response_msg'] = 'Enter 11 digit bank account number for FIRST NATIONAL BANK (FNB)';
    }else if(($bank != 16 && $bank != 3) && strlen($account_no) != 13){
          $data_array['status'] = '400';
          $data_array['response_msg'] = 'Enter 13 digit bank account number';
    }else{
        $sql = $db_9->prepare('UPDATE users SET first_name =:first_name,last_name =:last_name, nrc =:nrc,tpin =:tpin,phone =:phone, branch =:branch, account_no =:account_no WHERE username =:username');
        $sql->execute(array(
            ':nrc'=>$nrc,
            ':tpin'=>$tpin,
            ':phone'=>$phone,
            ':branch'=>$branch,
            ':account_no'=>$account_no,
            ':first_name'=>$first_name,
            ':last_name'=>$last_name,
            ':username'=>$username,
        ));
        if($sql->rowCount() > 0){
            $data_array['status'] = '200';
            $data_array['response_msg'] = 'Data successfully updated';
        }else{
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Could not update information. Try again';
        }
    }


}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Tne username parameter not set';
}
echo json_encode($data_array);
?>