<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
try{
$sql = $db_9->prepare('UPDATE marks m
                        INNER JOIN (SELECT centre_code,province,subject FROM marking_centre) mc
                        ON (m.province = mc.province)
                        SET m.marking_centre = mc.centre_code
                        WHERE m.province = mc.province
                        AND m.subject_code = mc.subject
                        AND m.marking_centre IS NULL');
                
$sql->execute();
$data_array['status'] = '200';
}catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Could not align subjects in marksheet: '.$e->getMessage();
}
echo json_encode($data_array);
?>