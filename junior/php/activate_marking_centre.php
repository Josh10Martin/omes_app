<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
include '../../config.php';
$data_array = array();

if(isset($_POST['centre_code'])){
        $centre_code = $_POST['centre_code'];
try{
        $sql = $db_9->prepare('INSERT IGNORE INTO marking_centre
                                SELECT "",:province_code,subject_code,paper_no, :centre_code FROM paper');
        $sql->execute(array(
                ':province_code'=>$_SESSION['province_code'],
                ':centre_code'=>$centre_code
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'There was a problem activating centre. Please try again';
        }
}catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'An error occured: '.$e->getMessage();
}
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Marking centre could not be set';
}
echo json_encode($data_array);
?>