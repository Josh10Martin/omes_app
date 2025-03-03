<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
try{
$sql = $db_ted->prepare('UPDATE marks m
                        INNER JOIN (SELECT marking_centre,centre_code,province FROM marking_centre_centres) mcc
                        ON (m.centre_code = mcc.centre_code)
                        SET m.marking_centre = mcc.marking_centre, m.province = mcc.province
                        WHERE m.centre_code = mcc.centre_code
                        AND m.marking_centre IS NULL');
                
$sql->execute();

        $data_array['status'] = '200';
}catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Could not align centres in marksheet: '.$e->getMessage();
}
echo json_encode($data_array);
?>