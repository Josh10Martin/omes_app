<?php
session_start();
// header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();
try{
$sql = $db_12_gce->prepare('UPDATE marks m
                        INNER JOIN (SELECT sen, subject,paper,centre_code FROM marking_centre) mc
                        ON (m.subject_code = mc.subject)
                        SET m.marking_centre = mc.centre_code
                        WHERE m.subject_code = mc.subject
                        AND m.paper_no = mc.paper
                        AND (m.exam_no,m.subject_code,paper_no)  IN (SELECT exam_no,subject_code,paper_no FROM sen_exam_no WHERE date_time = (SELECT MAX(date_time) FROM sen_exam_no))
                        AND m.status = "L"
                        AND mc.sen = 1

                        ');
                
$sql->execute();

$data_array['status'] = '200';
// $data_array['response_msg'] = 'Subject(s) successfully aligned to marking centre';
$data_array['response_msg'] = 'SEN / Other marksheet prepared . If there were any duplicates in the file, they were discarded and all exam numbers in the uploaded file that are in the marksheet will be reset';
// get_exam_no_not_exist($db_12_gce);


if(isset($_SESSION['date_time'])){
        unset($_SESSION['date_time']);
        // unset($_SESSION['status']);
}


}catch(PDOExcetion $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error aligning sen subjects: '.$e->getMessage();
}
echo json_encode($data_array);
?>