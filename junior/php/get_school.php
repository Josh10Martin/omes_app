<?php
session_start();
header('Content-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['centre_code'])){
        $centre_code = $_POST['centre_code'];

        $sql = $db_9->prepare('SELECT centre_code, centre_name FROM school WHERE centre_code =:centre_code AND centre_type =:session_type AND province =:province_code');
        $sql->execute(array(
                ':centre_code'=>$centre_code,
                ':session_type'=>$_SESSION['session_type'],
                ':province_code'=>$_SESSION['province_code']
        ));
        if($sql->rowCount() > 0){
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $data_array['status'] = '200';
                $data_array['response_msg'] = $row['centre_code'].' - '.$row['centre_name'];
               
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = '[Unable to find centre. Proceed to submit]';
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Parameter error';
}
echo json_encode($data_array);
?>