<?php
// ob_start('ob_gzhandler');
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['subject_code']) && isset($_POST['paper_no'])){
$subject_code = $_POST['subject_code'];
$paper_no = $_POST['paper_no'];

try{
$sql = $db_12_gce->prepare('SELECT su.subject_code AS subject_code, su.subject_name AS subject_name, pa.id AS id, pa.paper_no AS paper_no,
                            pa.max_questions AS max_questions
                            FROM subjects su INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                            WHERE pa.max_questions <> 0 
                            AND pa.subject_code =:subject_code
                            AND pa.paper_no = :paper_no');
$sql->execute(array(
        ':subject_code'=>$subject_code,
        ':paper_no'=>$paper_no,
));

$i= 0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
    for($y = 1;$y <=$row['max_questions']; $y++){
        $data_array[] = [
        
            'id' => $row['id'] ?? '',
            'subject_code' => $row['subject_code'] ?? '',
            'paper_no' => $row['paper_no'] ?? '',
            'question' => $y,
            
        ];
    }
    $i++;
}

}catch(PDOException $e){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There was a probllem: '.$e->getMessage();
}
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Subject and paper parameter not set';
}
echo json_encode($data_array);
?>