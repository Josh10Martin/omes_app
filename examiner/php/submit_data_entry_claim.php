<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
header("Access-Control-Allow-Origin: *"); 
include '../../config.php';
$data_array = array();
$rate_value = 100/85;
$tax = 15/100;
if(isset($_SESSION['user_type'])){
        try{
                $sql = $db_12_gce->prepare('CALL insert_data_entry_claim(?,?,?,?,?,?,?,?) ');
               $sql->execute([
                        $_SESSION['username'],     // p_examiner_number
                        $rate_value,               // p_rate_value
                        $tax,                      // p_tax
                        $_SESSION['marking_centre_code'],  // p_marking_centre_code
                        $_SESSION['marking_centre'],       // p_marking_centre_name
                        $_SESSION['session_year'], // p_session_year
                        $_SESSION['session_name'], // p_session_name
                        $_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'] // p_username
                ]);
                if($sql->rowCount() > 0){
                        $data_array['status'] = '200';
                        $data_array['response_msg'] = 'Successfully submitted your claim';
                }else{
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'There was a problem submitting your claim';
                }
        }catch(PDOException $e){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'User type not set';
}
echo json_encode($data_array);
?>