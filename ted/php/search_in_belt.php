<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['centre']) && isset($_POST['subject']) ){
    $subject_code = explode(':',$_POST['subject'])[0];
    $centre_code = $_POST['centre'];

    $sql = $db_ted->prepare('SELECT sc.centre_code AS centre_code,sc.centre_name AS centre_name, a.belt_no AS belt_no, a.script_no AS script_no, a.username AS created_by
                                FROM school sc INNER JOIN apportionment a ON (sc.centre_code = a.school)
                                WHERE a.subject =:subject_code
                                AND a.school =:centre_code
                                AND a.session =:session_year
                                AND a.marking_centre =:marking_centre_code
    ');
    $sql->execute(array(
        ':subject_code'=>$subject_code,
        ':centre_code'=>$centre_code,
        ':session_year'=>$_SESSION['session_year'],
        ':marking_centre_code'=>$_SESSION['marking_centre_code']
    ));
    if($sql->rowCount() > 0){

        $i = 0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
            $data_array[$i]['centre_name'] = $row['centre_name'] ?? '';
            $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
            $data_array[$i]['script_no'] = $row['script_no'] ?? '';
            $data_array[$i]['created_by'] = $row['created_by'] ?? '';
             $i++;
        }
    }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'No college was found';
    }
}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Not all parameters are set';
}
echo json_encode($data_array);
?>