<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['group_code']) && isset($_POST['belt_no']) && isset($_POST['group_apportion_id'])){
      
        $group_code = $_POST['group_code'];
        $belt_no = $_POST['belt_no'];
        $group_apportion_id = $_POST['group_apportion_id'];
        

        $sql = $db_ted->prepare('SELECT a.id AS id, cg.group_code AS group_code,s.subject_code AS subject_code,s.subject_name AS subject_name, a.belt_no AS belt_no,a.school AS centre_code, a.script_no AS script_no
                        FROM apportionment a INNER JOIN subjects s ON (a.subject = s.subject_code)
                        INNER JOIN course co ON (s.course_id = co.course_code)
                        INNER JOIN course_group cg ON (co.group_id = cg.group_code)
                        WHERE a.group_code =:group_code 
                        AND a.belt_no =:belt_no
                        AND a.marking_centre =:marking_centre_code
                        AND a.group_apportion_id =:group_apportion_id
                        AND a.session =:session
                        ORDER BY a.date_apportioned DESC');
        $sql->execute(array(
                ':group_code'=>$group_code,
                ':belt_no'=>$belt_no,
                ':group_apportion_id'=>$group_apportion_id,
                ':marking_centre_code'=>$_SESSION['marking_centre_code'],
                ':session'=>$_SESSION['session_year']
        ));
        if($sql->rowCount() > 0){
                $i=0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        $data_array[$i]['id'] = $row['id'] ?? '';
                        $data_array[$i]['group_code'] = $row['group_code'] ?? '';
                        $data_array[$i]['subject_code'] = $row['subject_code'] ?? '';
                        $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
                        $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
                        $data_array[$i]['script_no'] = $row['script_no'] ?? '';
                        $i++;
                }
        }else{
                $data_array['status'] = '400';
        }
}
echo json_encode($data_array);

?>