<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();
try{
$sql = $db_12_gce->prepare('UPDATE marks m
                        INNER JOIN (SELECT subject,paper,centre_code FROM marking_centre) mc
                        ON (m.subject_code = mc.subject)
                        SET m.marking_centre = mc.centre_code
                        WHERE m.subject_code = mc.subject
                        AND m.paper_no = mc.paper
                        AND m.marking_centre = "none"');
                
$sql->execute();
$data_array['status'] = '200';
// $data_array['response_msg'] = 'Subject(s) successfully aligned to marking centre';
$data_array['response_msg'] = 'Marksheet Loaded. If there were any duplicates in the file, they were discarded';
remove_subject_paper_from_marksheet_not_belong($db_12_gce);

}catch(PDOExcetion $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
}
echo json_encode($data_array);
?>