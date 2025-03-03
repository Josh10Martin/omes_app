<?php
header("Content-Type: application/json; charset=utf-8");
include '../../config.php';
$data_array = array();

if(isset($_POST['province_code'])){
    $province_code = $_POST['province_code'];
    $sql = $db_9->prepare('SELECT p.p_code AS province_code, p.p_name AS province_name, a.apportion_id AS apportion_id, a.marking_centre_name AS marking_centre, a.subject_name AS subjects,a.d_name AS districts, a.no_of_centres AS no_of_centres
                            FROM province p INNER JOIN apportionment_summary a ON (p.p_code = a.province)
                            WHERE a.province =:province');
    $sql->execute(array(
        ':province'=>$province_code
    ));
    if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $i =0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
            $data_array[$i]['province_code'] = $row['province_code'] ?? '';
            $data_array[$i]['apportion_id'] = $row['apportion_id'] ?? '';
            $data_array[$i]['province_name'] = $row['province_name'] ?? '';
            $data_array[$i]['marking_centre'] = $row['marking_centre'] ?? '';
            $data_array[$i]['subjects'] = $row['subjects'] ?? '';
            $data_array[$i]['districts'] = $row['districts'] ?? '';
            $data_array[$i]['no_of_centres'] = $row['no_of_centres'] ?? '';
            $i++;
        }
    }
}else{
    $data_array['status'] = '400';
}
echo json_encode($data_array);
?>