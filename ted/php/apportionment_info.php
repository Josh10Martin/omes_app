<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['group_code']) && isset($_POST['subject_code']) && isset($_POST['centre_code']) && isset($_POST['belt_no']) && isset($_POST['no_of_scripts'])){
$group_code = $_POST['group_code'];
$subject_code = $_POST['subject_code'];
$centre_code = $_POST['centre_code'];
$no_of_scripts = $_POST['no_of_scripts'];
$belt_no = $_POST['belt_no'];

$sql = $db_ted->prepare('SELECT cg.group_name AS group_name, su.subject_name AS subject_name,sc.centre_name AS centre_name, a.script_no AS no_of_scripts, a.belt_no AS belt_no
                        FROM school sc INNER JOIN apportionment a ON (sc.centre_code = a.school)
                        INNER JOIN subjects su ON (a.subject = su.subject_code)
                        INNER JOIN course co ON (su.course_id = co.course_code)
                        INNER JOIN course_group cg ON (co.group_id = cg.group_code)
                        WHERE a.group_code =:group_code
                        AND a.subject =:subject_code
                        AND a.school =:centre_code
                        AND a.script_no =:no_of_scripts
                        AND a.belt_no =:belt_no
                        AND a.session =:session
                        AND a.marking_centre =:marking_centre_code
                        ');
$sql->execute(array(
      ':subject_code'=>$subject_code,
      ':group_code'=>$group_code,
      ':no_of_scripts'=>$no_of_scripts,
      ':belt_no'=>$belt_no,
      ':centre_code'=>$centre_code,
      ':session'=>$_SESSION['session_year'],
      ':marking_centre_code'=>$_SESSION['marking_centre_code']
));
if($sql->rowCount() > 0){
      
      $row = $sql->fetch(PDO::FETCH_ASSOC);

            $data_array['group_name'] = $row['group_name'] ?? '';
            $data_array['subject_name'] = $row['subject_name'] ?? '';
            $data_array['centre_name'] = $row['centre_name'] ?? '';
            $data_array['no_of_scripts'] = $row['no_of_scripts'] ?? '';
            $data_array['belt_no'] = $row['belt_no'] ?? '';

           
      
}else{
      $data_array['status'] = '400';
}

}else{
      $data_array['status'] = '400';
      $data_array['response_msg'] = 'Parameters not set';
}
echo json_encode($data_array);
?>