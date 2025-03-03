<?php
header('Content-Type:application/json ; charset=utf-8');
session_start();
include '../../config.php';
$data_array = array();

if(isset($_SESSION['session_year'])){

    $json_data = 'https://omes.exams-council.org.zmted/api/college.ph/p';
    $schools = file_get_contents($json_data);
    $centres = json_decode($schools, JSON_OBJECT_AS_ARRAY);
try{
    $i =0;
    foreach($centres as $row){
        if(isset($row['centre_code'])){
        $centre_code = $row['centre_code'] ?? ''; 
        $centre_name = $row['centre_name'] ?? '';
        $sql = $db_ted->prepare('INSERT IGNORE INTO school (centre_code,centre_name,session)VALUES(:centre_code,:centre_name,:session)
                                ON DUPLICATE KEY UPDATE
                                centre_name = VALUES(centre_name)
        ');
        $sql->execute(array(
            ':centre_code'=>$centre_code,
            ':centre_name'=>$centre_name,
            ':session'=>$_SESSION['session_year']
        ));
       
    }
    $i++;
    if($i == $sql->rowCount()){
        $data_array['status'] = '200';
        $data_array['response_msg'] ='Teacher Education college(s) successfully imported from OCRS';
    }
    
    }

 
}catch(PDOException $e){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
}
}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Session year not set';
}
echo json_encode($data_array);
?>