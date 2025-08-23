<?php
session_start();
header('Content-Type: application/json;charset=utf-8');
include '../../functions.php';
include '../../config.php';
$data_array = array();
try{
        $sql = $db_12_gce->prepare('UPDATE examiner ex
                                INNER JOIN (SELECT examiner_number, subject_code,paper_no,belt_no, uploaded_by,date_uploaded,marking_centre FROM belted_examiners) be
                                ON (ex.examiner_number = be.examiner_number)
                                SET ex.belt_no = be.belt_no
                                WHERE ex.subject_code = be.subject_code
                                AND ex.paper_no = be.paper_no
                                AND ex.marking_centre = be.marking_centre
                                AND be.marking_centre = :marking_centre_code
                                AND be.uploaded_by =:username
                                AND be.date_uploaded = (SELECT MAX(date_uploaded) FROM belted_examiners WHERE uploaded_ny =:username AND marking_centre =:marking_centre_code)
                                AND (be.belt_no <> 0 AND be.belt_no <> "")
                                AND ex.role NOT IN ("CHIEF EXAMINER","DEPUTY CHIEF EXAMINER","DATA ENTRY OFFICER")
        
        ');
        $sql->execute(array(
                ':username'=>$_SESSION['username'],
                ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
        $data_array['status'] = '200';
        $data_array['response_msg'] = 'Succesfully belted examiner(s). Kindly confirm the examiners';
}catch(PDOEXception $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Error: '.$e->getMessage();
}
if(isset($_SESSION['date_time'])){
        unset($_SESSION['date_time']);
}
echo json_encode($data_array);
?>