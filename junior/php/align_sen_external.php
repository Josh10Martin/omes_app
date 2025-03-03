<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

    if($_SESSION['user_type'] == 'ECZ'){
        try{
$sql = $db_9->prepare('UPDATE marks m
                    INNER JOIN (SELECT marking_centre,centre_code,sen,province
                     FROM marking_centre_centres) mcc
                    ON (m.centre_code = mcc.centre_code)
                    SET m.marking_centre = mcc.marking_centre,m.province = mcc.province
                    WHERE m.centre_code = mcc.centre_code
                    AND m.centre_code IN (SELECT centre_code FROM school WHERE province = mcc.province)
                    AND m.sen = mcc.sen
                    AND m.sen = 1
                    AND m.marking_centre = "none"
                    AND m.province = "00"
                    ');
$sql->execute();
$data_array['status'] = '200';
$data_array['response_msg'] = 'Successfully aligned sen candidates';
}catch(PDOException $e){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There was an error aligning sen candidates: '.$e->getMessage();
}
    }else{
        try{
        $sql = $db_9->prepare('UPDATE marks m
                    INNER JOIN SELECT marking_centre,centre_code,sen,province
                     FROM marking_centre_centres) mcc
                    ON (m.centre_code = mcc.centre_code)
                    SET m.marking_centre = mcc.marking_centre, m.province = mcc.province
                    WHERE m.centre_code = mcc.centre_code
                    AND m.sen = mcc.sen
                    AND m.sen = 1
                    AND m.marking_centre = "none"
                    AND m.province = "00"
                    AND mcc.province =:province_code
                    AND m.centre_code IN (SELECT centre_code FROM school WHERE province =:province_code)
                    ');
$sql->execute(array(
    ':province_code'=>$_SESSION['province_code']
));
$data_array['status'] = '200';
$data_array['response_msg'] = 'Successfully aligned sen';
}catch(PDOException $e){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There was an error aligning sen candidates: '.$e->getMessage();
}
    }

echo json_encode($data_array);
?>