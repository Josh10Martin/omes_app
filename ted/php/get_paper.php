<?php
header('Content-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['subject_code'])){
        $subject_code = $_POST['subject_code'];

        $sql = $db_ted->prepare('SELECT subject_code,paper_no FROM paper WHERE subject_code =:subject_code');
        $sql->execute(array(
                ':subject_code'=>$subject_code
        ));
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['subject_code'] = $row['subject_code'];
                $data_array[$i]['paper_no'] = $row['paper_no'];
                $i++;
        }
}
echo json_encode($data_array);
?>