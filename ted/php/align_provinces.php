<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
try{
$sql = $db_9->prepare('UPDATE marks m
                        INNER JOIN (SELECT centre_code,province FROM school) s
                        ON (m.centre_code = s.centre_code)
                        SET m.province = s.province
                        WHERE m.centre_code = s.centre_code
                        AND m.province IS NULL');
                
$sql->execute();
$data_array['status'] = '200';
}catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Could not align provinces in marksheet: '.$e->getMessage();
}
echo json_encode($data_array);
?>