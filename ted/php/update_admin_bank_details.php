<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();
if(isset($_POST['bank'])){
        $bank = $_POST['bank'];
        $branch = $_POST['branch'];
        $account_no = $_POST['account_no'];
        $nrc = $_POST['nrc'];
        $tpin = $_POST['tpin'];
        $phone = $_POST['phone'];
        if(nrc_exists($db_ted,$nrc) == 'true'){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'The NRC number '.$nrc.' is already in use';
        }else if($bank == 3 && strlen($account_no) != 10){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Enter 10 digit bank account number for ABSA';
      }else if($bank == 11 && strlen($account_no) != 15){
              $data_array['status'] = '400';
              $data_array['response_msg'] = 'Enter 15 digit bank account number for INVESTRUST';
      }else if($bank == 16 && strlen($account_no) != 11){
              $data_array['status'] = '400';
              $data_array['response_msg'] = 'Enter 11 digit bank account number for FIRST NATIONAL BANK (FNB)';
      }else if(($bank != 16 && $bank != 11 && $bank != 3) && strlen($account_no) != 13){
              $data_array['status'] = '400';
              $data_array['response_msg'] = 'Enter 13 digit bank account number';
        }else{
        $sql = $db_ted->prepare('UPDATE users SET nrc =:nrc,tpin =:tpin,phone =:phone, bank =:bank,branch =:branch,account_no =:account_no WHERE username =:username AND user_type = "ADMIN"');
        $sql->execute(array(
                ':bank'=>$bank,
                ':branch'=>$branch,
                ':account_no'=>$account_no,
                ':nrc'=>$nrc,
                ':tpin'=>$tpin,
                ':phone'=>$phone,
                ':username'=>$_SESSION['username']
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                $data_array['response_msg'] = 'Successfully updated bank details';
        }else{
                $data_array['status'] = '400';
                 $data_array['response_msg'] = 'There was a problem updating bank details';
        }
}
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'bank parameter not set';
}
echo json_encode($data_array);
?>