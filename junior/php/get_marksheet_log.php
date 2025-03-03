<?php
// session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql = $db_9->prepare('SELECT centre_code, exam_no,subject_code,paper_no,marking_centre,province,
                        CASE WHEN marking_centre = "none" THEN "Check if centre type is correct for the uploaded centre (internal / external). Check if centre is imported from OCRS. Check if centre is in script movement report"
                        WHEN province = "00" THEN "Check if centre has been imported from OCRS"
                        ELSE "Contact administrator"
                        END AS comment
                         FROM marks WHERE marking_centre = "none" OR province = "00"
                        
                         ');
$sql->execute();
if($sql->rowCount() > 0){
    // $data_array['status'] = '200';
    $i =0;
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['centre_code'] = $row['centre_code'];
        $data_array[$i]['exam_no'] = $row['exam_no'];
        $data_array[$i]['subject_code'] = $row['subject_code'];
        $data_array[$i]['paper_no'] = $row['paper_no'];
        $data_array[$i]['marking_centre_code'] = $row['marking_centre'];
        $data_array[$i]['province'] = $row['province'];
        $data_array[$i]['comment'] = $row['comment'];
        $i++;
    }
}else{
        $data_array['status'] = '400';
}
echo json_encode($data_array);
?>