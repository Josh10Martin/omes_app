<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
try{
$sql = $db_ted->prepare('UPDATE marks m
                        INNER JOIN (SELECT centre_code,course, session FROM marking_centre) mc
                        ON m.session = mc.session
                        SET m.marking_centre = mc.centre_code
                        WHERE m.session = mc.session 
                        AND m.session =:session
                        AND m.marking_centre ="none" ');
                
$sql->execute(array(
        ':session'=>$_SESSION['session_year']
));
$data_array['status'] = '200';
$data_array['response_msg'] = 'Marksheet successfully loaded';
}catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'SUccessfully uploaded marksheet';
}
echo json_encode($data_array);
?>