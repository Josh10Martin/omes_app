<?php
header('Content-Type:application/json ; charset=utf-8');
session_start();
include '../../config.php';
$data_array = array();

if(isset($_SESSION['session_type'])){
    $session_type = $_SESSION['session_type'];

    $json_data = 'https://omes.exams-council.org.zm/g12/api/g12_gce_centres.php?centre_type='.$session_type;
    $schools = file_get_contents($json_data);
    $centres = json_decode($schools, JSON_OBJECT_AS_ARRAY);
    $i = 0;
try{
    foreach($centres as $row){
        if(isset($row['centre_code'])){
        $centre_code = $row['centre_code']; 
        $centre_name = $row['centre_name'];
        $centre_type = $row['centre_type'];
        $sql = $db_12_gce->prepare('INSERT IGNORE INTO school (centre_code,centre_name,centre_type)VALUES(:centre_code,:centre_name,:centre_type)');
        $sql->execute(array(
            ':centre_code'=>$centre_code,
            ':centre_name'=>$centre_name,
            ':centre_type'=>$centre_type
        ));
        $i++;
    }
    }

    if($sql->rowCount() > 0){
        $centre_type = $centre_type == 'I' ? 'Grade 12' : 'G.C.E';
        $data_array['status'] = '200';
        $data_array['response_msg'] = $i.' '.$centre_type.' centre(s) successfully imported from OCRS';
    }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was a problem importing centre(s) from OCRS';
    }
}catch(PDOException $e){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
}
}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Centre type parameter not set';
}
echo json_encode($data_array);
?>