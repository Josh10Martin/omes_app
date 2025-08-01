<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['subject_code']) && isset($_POST['paper_no']) && isset($_POST['belt_no'])){
        $subject_code = explode(':', $_POST['subject_code'])[0];
        $paper = $_POST['paper_no'];
        $belt_no = $_POST['belt_no'];

        $sql = $db_12_gce->prepare('SELECT su.subject_code AS subject_code, su.subject_name AS subject_name, pa.paper_no AS paper,CASE WHEN a.sen = 1 THEN "YES" ELSE "NO" END AS sen, a.belt_no AS belt_no,s.centre_code AS centre_code, s.centre_name AS centre_name, a.script_no AS script_no, a.username AS user
                        FROM apportionment a INNER JOIN school s ON (a.school = s.centre_code)
                        INNER JOIN subjects su ON (a.subject = su.subject_code)
                        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                        WHERE a.subject =:subject_code
                        AND pa.paper_no = a.paper 
                        AND a.paper =:paper 
                        AND a.belt_no =:belt_no
                        AND a.marking_centre =:marking_centre_code
                        -- AND a.username =:username
                        ORDER BY a.date_apportioned DESC');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':paper'=>$paper,
                ':belt_no'=>$belt_no,
                // ':username'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
                ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
        if($sql->rowCount() > 0){
              
                $i=0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        $data_array[$i]['subject_code'] = $row['subject_code'] ?? '';
                        $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
                        $data_array[$i]['paper_no'] = $row['paper'] ?? '';
                        $data_array[$i]['sen'] = $row['sen'] ?? '';
                        $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
                        $data_array[$i]['user'] = $row['user'] ?? '';
                        $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
                        $data_array[$i]['centre_name'] = $row['centre_name'] ?? '';
                        $data_array[$i]['script_no'] = $row['script_no'] ?? '';
                        $i++;
                }
        }else{
                $data_array['status'] = '400';
        }
}
echo json_encode($data_array);

?>