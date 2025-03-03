<?php
header('Content-Type:application/json ; charset=utf-8');
session_start();
include '../../config.php';
$data_array = array();


    $centre_type = $_SESSION['session_type'];

    $json_data = 'https://omes.exams-council.org.zm/g9/api/g9_centres.php?centre_type='.$centre_type;
    $schools = file_get_contents($json_data);
    $centres = json_decode($schools, JSON_OBJECT_AS_ARRAY);
    if($centre_type == 'E'){
try{
    $i =0;
    foreach($centres as $row){
        if(isset($row['centre_code'])){
        $centre_code = $row['centre_code'] ?? ''; 
        $centre_name = $row['centre_name'] ?? '';
        $centre_type = $row['centre_type'] ?? '';
        $province = $row['province_code'] ?? '';
        $district = $row['district_code'] ?? '';
        $sql = $db_9->prepare('INSERT IGNORE INTO school (centre_code,centre_name,centre_type,province,district)VALUES(:centre_code,:centre_name,:centre_type,:province,:district)');
        $sql->execute(array(
            ':centre_code'=>$centre_code,
            ':centre_name'=>$centre_name,
            ':centre_type'=>$centre_type,
            ':province'=>$province,
            ':district'=>$district,
        ));
        $i++;
    }
    }
    $centre_type = $centre_type == 'I' ? 'Grade 9 Internal' : 'Grade 9 External';
    $data_array['status'] = '200';
    $data_array['response_msg'] = $i.' '.$centre_type.' centre(s) successfully imported from OCRS';
   
}catch(PDOException $e){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
}
    }else{
        try{
            $i =0;
            foreach($centres as $row){
                if(isset($row['centre_code'])){
                $centre_code = $row['centre_code'] ?? ''; 
                $centre_name = $row['centre_name'] ?? '';
                $centre_type = $row['centre_type'] ?? '';
                $subject_code = $row['subject_code'] ?? '';
                $province = $row['province_code'] ?? '';
                $district = $row['district_code'] ?? '';
                $sql = $db_9->prepare('REPLACE INTO school (centre_code,centre_name,centre_type,province,district)VALUES(:centre_code,:centre_name,:centre_type,:province,:district)');
                $sql->execute(array(
                    ':centre_code'=>$centre_code,
                    ':centre_name'=>$centre_name,
                    ':centre_type'=>$centre_type,
                    ':province'=>$province,
                    ':district'=>$district,
                ));
                $i++;
                $count = $sql->rowCount();
            if($count > 0){
                $sql2 = $db_9->prepare('INSERT IGNORE INTO school_subject(centre_code,subject_code) VALUES(:centre_code,:subject_code)');
                $sql2->execute(array(
                    ':centre_code'=>$centre_code,
                    ':subject_code'=>$subject_code
                ));

            }
            }
            
            }
            $centre_type = $centre_type == 'I' ? 'Grade 9 Internal' : 'Grade 9 External';
            $data_array['status'] = '200';
            $data_array['response_msg'] = $centre_type.' centre(s) successfully imported from OCRS';
           
        }catch(PDOException $e){
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
        }
    }
echo json_encode($data_array);
?>