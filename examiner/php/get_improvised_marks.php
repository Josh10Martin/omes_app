<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
$username = $_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'];

if(isset($_SESSION['marking_centre_code']) && isset($_SESSION['username'])){
$sql = $db_12_gce->prepare('SELECT m.exam_no AS exam_no,m.centre_code AS centre_code, su.subject_name AS subject_name,
                        m.paper_no AS paper_no,m.mark AS mark,m.belt_no AS belt_no,CASE WHEN m.sen = 1 THEN "YES" ELSE "NO" END AS sen, m.date_entered AS date_entered,m.disable AS disable
                        FROM marks m INNER JOIN subjects su ON (m.subject_code = su.subject_code)
                        WHERE m.improvised_mark = 1
                        AND m.entered_by =:username
                        AND m.marking_centre =:marking_centre_code
                        ORDER BY date_entered DESC');
$sql->execute(array(
    ':username'=>$username,
    ':marking_centre_code'=>$_SESSION['marking_centre_code']
));
if($sql->rowCount() > 0){
    $data_array['status'] = '200';
    $i = 0;
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['exam_no'] = $row['exam_no'] ?? '';
        $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
        $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
        $data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
        $data_array[$i]['mark'] = $row['mark'] ?? '';
        $data_array[$i]['sen'] = $row['sen'] ?? '';
        $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
        $data_array[$i]['date_entered'] = $row['date_entered'] ?? '';
        $data_array[$i]['disable'] = $row['disable'] ?? '';
        $i++;
    }
}else{
    $data_array['status'] = '400';
}
}else{
    $data_array['marking_centrwe'] = $_SESSION['marking_centre_code'];

}
echo json_encode($data_array);
?>