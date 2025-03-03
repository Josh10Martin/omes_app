<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['search'])){
        $search = $_POST['search'];
        if($_SESSION['user_type'] == 'ECZ'){
        $sql = $db_12_gce->prepare('SELECT m.centre_code AS centre_code,m.exam_no AS exam_no,m.first_name AS first_name,m.last_name AS last_name,m.belt_no AS belt_no,
                                        m.mark AS mark,m.status AS status, CASE WHEN m.sen = 1 THEN "YES" WHEN m.sen = 0 THEN "NO" ELSE "UNKNOWN" END AS sen,
                                        CASE WHEN m.improvised_mark = 0 THEN "NO" ELSE "YES" END AS improvised_mark,
                                        m.subject_code AS subject_code,m.paper_no AS paper_no,m.entered_by AS entered_by,m.date_entered AS date_entered, ce.name AS marking_centre
                                        FROM marks m LEFT OUTER JOIN centre ce ON (m.marking_centre = ce.centre_code)
                                        WHERE (m.centre_code =:search) OR (m.exam_no =:search)');
        $sql->execute(array(
                ':search'=>$search
        ));
        if($sql->rowCount() >0){
                $data_array['status'] = '200';
                $i =0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
                        $data_array[$i]['exam_no'] = $row['exam_no'] ?? '';
                        $data_array[$i]['first_name'] = $row['first_name'] ?? '';
                        $data_array[$i]['last_name'] = $row['last_name'] ?? '';
                        $data_array[$i]['mark'] = $row['mark'] ?? '';
                        $data_array[$i]['belt_no'] = $row['belt_no'] == 0 ? 'N/A' : $row['belt_no'];
                        $data_array[$i]['sen'] = $row['sen'] ?? '';
                        $data_array[$i]['improvised_mark'] = $row['improvised_mark'] ?? '';
                        $data_array[$i]['status'] = $row['status'] ?? '';
                        $data_array[$i]['subject_code'] = $row['subject_code'] ?? '';
                        $data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
                        $data_array[$i]['entered_by'] = $row['entered_by'] ?? '';
                        $data_array[$i]['date_entered'] = $row['date_entered'] ?? '';
                        $data_array[$i]['marking_centre'] = $row['marking_centre'] ?? '';
                        $i++;
                }
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'No Record Found';
        }
}else{
        $sql = $db_12_gce->prepare('SELECT m.centre_code AS centre_code,m.exam_no AS exam_no,m.first_name AS first_name,m.last_name AS last_name,m.belt_no AS belt_no,
                                        m.mark AS mark,m.status AS status, CASE WHEN m.sen = 1 THEN "YES" WHEN m.sen = 0 THEN "NO" ELSE "UNKNOWN" END AS sen,
                                        CASE WHEN m.improvised_mark = 0 THEN "NO" ELSE "YES" END AS improvised_mark,
                                        m.subject_code AS subject_code,m.paper_no AS paper_no,m.entered_by AS entered_by,m.date_entered AS date_entered, ce.name AS marking_centre
                                        FROM marks m LEFT OUTER JOIN centre ce ON (m.marking_centre = ce.centre_code)
                                        WHERE (m.centre_code =:search) OR (m.exam_no =:search)
                                        AND m.marking_centre =:marking_centre_code');
        $sql->execute(array(
                ':search'=>$search,
                ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
        if($sql->rowCount() >0){
                $data_array['status'] = '200';
                $i =0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
                        $data_array[$i]['exam_no'] = $row['exam_no'] ?? '';
                        $data_array[$i]['first_name'] = $row['first_name'] ?? '';
                        $data_array[$i]['last_name'] = $row['last_name'] ?? '';
                        $data_array[$i]['mark'] = $row['mark'] ?? '';
                        $data_array[$i]['belt_no'] = $row['belt_no'] == 0 ? 'N/A' : $row['belt_no'];
                        $data_array[$i]['sen'] = $row['sen'] ?? '';
                        $data_array[$i]['improvised_mark'] = $row['improvised_mark'] ?? '';
                        $data_array[$i]['status'] = $row['status'] ?? '';
                        $data_array[$i]['subject_code'] = $row['subject_code'] ?? '';
                        $data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
                        $data_array[$i]['entered_by'] = $row['entered_by'] ?? '';
                        $data_array[$i]['date_entered'] = $row['date_entered'] ?? '';
                        $data_array[$i]['marking_centre'] = $row['marking_centre'] ?? '';
                        $i++;
                }
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'No Record Found';
        }
}
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Search parameter not set';
}
echo json_encode($data_array);
?>