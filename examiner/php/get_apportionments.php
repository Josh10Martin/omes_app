<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['subject_code']) && isset($_POST['paper']) && isset($_POST['belt_no']) && isset($_POST['group_id'])){
        $subject_code = $_POST['subject_code'];
        $paper = $_POST['paper'];
        $belt_no = $_POST['belt_no'];
        $group_id = $_POST['group_id'];

        $sql = $db_12_gce->prepare('SELECT s.subject_name AS subject_name, pa.paper_no AS paper,CASE WHEN a.sen = 1 THEN "YES" ELSE "NO" END AS sen, a.id AS id, a.belt_no AS belt_no,a.school AS centre_no, a.script_no AS script_no, a.username AS user
                        FROM apportionment a INNER JOIN subjects s ON (a.subject = s.subject_code)
                        INNER JOIN paper pa ON (s.subject_code = pa.subject_code)
                        WHERE a.subject =:subject_code
                        AND pa.paper_no = a.paper 
                        AND a.paper =:paper 
                        AND a.belt_no =:belt_no
                        AND a.marking_centre =:marking_centre_code
                        AND a.group_id =:group_id
                        -- AND a.username =:username
                        ORDER BY a.date_apportioned DESC');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':paper'=>$paper,
                ':belt_no'=>$belt_no,
                ':group_id'=>$group_id,
                // ':username'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
                ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                $i=0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        $data_array[$i]['id'] = $row['id'] ?? '';
                        $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
                        $data_array[$i]['paper'] = $row['paper'] ?? '';
                        $data_array[$i]['sen'] = $row['sen'] ?? '';
                        $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
                        $data_array[$i]['user'] = $row['user'] ?? '';
                        $data_array[$i]['centre_code'] = $row['centre_no'] ?? '';
                        $data_array[$i]['script_no'] = $row['script_no'] ?? '';
                        $i++;
                }
        }else{
                $data_array['status'] = '400';
        }
}
echo json_encode($data_array);

?>