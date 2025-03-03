<?php
// ob_start('ob_gzhandler');
// session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
try{
$sql = $db_12_gce->prepare('SELECT m.centre_code AS centre_code,m.exam_no AS exam_no, m.first_name AS first_name, m.last_name AS last_name,
                            m.subject_code AS subject_code, m.paper_no AS paper_no,m.mark AS mark,m.status AS status,m.sen AS sen,
                            m.improvised_mark AS improvised_mark, m.entered_by AS entered_by, m.date_entered AS date_entered,
                            m.marking_centre AS marking_centre,pa.max_questions AS max_questions
                            FROM marks m INNER JOIN paper pa ON (m.subject_code = pa.subject_code)
                            WHERE m.paper_no = pa.paper_no
                            AND pa.max_questions <> 0
                            AND m.exam_no IS NOT NULL
                            AND m.valid = 0 ');
$sql->execute();

$i= 0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
    for($y = 1;$y <=$row['max_questions']; $y++){
        $data_array[] = [
            'centre_code' => $row['centre_code'] ?? '',
            'exam_no' => $row['exam_no'] ?? '',
            'first_name' => $row['first_name'] ?? '',
            'last_name' => $row['last_name'] ?? '',
            'subject_code' => $row['subject_code'] ?? '',
            'paper_no' => $row['paper_no'] ?? '',
            'question' => $y,
            'mark' => $row['mark'] ?? '',
            'status' => $row['status'] ?? '',
            'sen' => $row['sen'] ?? '',
            'improvised_mark' => $row['improvised_mark'] ?? '',
            'entered_by' => $row['entered_by'] ?? '',
            'date_entered' => $row['date_entered'] ?? '',
            'marking_centre' => $row['marking_centre'] ?? '',
        ];
    }
    $i++;
}

}catch(PDOException $e){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There was a probllem: '.$e->getMessage();
}
echo json_encode($data_array);
?>