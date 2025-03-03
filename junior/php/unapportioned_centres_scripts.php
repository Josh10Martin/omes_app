<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
include '../../config.php';
$data_array = array();

if($_SESSION['session_type'] == 'E'){

    $sql = $db_9->prepare('SELECT GROUP_CONCAT(DISTINCT sc.centre_code," - ",sc.centre_name SEPARATOR " ,") AS exam_centre, GROUP_CONCAT(DISTINCT d.d_code," - ",d.d_name SEPARATOR" ,") AS district
                            FROM marks m INNER JOIN school sc ON (m.centre_code = sc.centre_code)
                            LEFT OUTER JOIN district d ON (sc.district = d.d_code)
                            WHERE m.province = "00"
                            AND m.centre_code IN (SELECT centre_code FROM school where province =:province_code)
                            AND sc.province =:province_code
                            AND sc.centre_type = :session_type
                            GROUP BY sc.centre_code, d.d_code
                            ORDER BY sc.centre_code ASC');
    $sql->execute(array(
        ':province_code'=>$_SESSION['province_code'],
        ':session_type'=>$_SESSION['session_type']
    ));
    if($sql->rowCount() > 0){
        $i =0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
            $data_array[$i]['exam_centre'] = $row['exam_centre'] ?? '';
            $data_array[$i]['district'] = $row['district'] ?? '';
            $i++;
        }
    }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'All examination centres are allocated';
    }
}else{
    $sql = $db_9->prepare('SELECT GROUP_CONCAT(DISTINCT sc.centre_code," - ",sc.centre_name SEPARATOR " ,") AS exam_centre, GROUP_CONCAT(DISTINCT d.d_code," - ",d.d_name SEPARATOR" ,") AS district,GROUP_CONCAT(DISTINCT su.subject_code," - ",su.subject_name SEPARATOR ", ") AS subject
                        FROM school sc LEFT OUTER JOIN district d ON (sc.district = d.d_code)
                        LEFT OUTER JOIN marks m ON (sc.centre_code = m.centre_code)
                        LEFT OUTER JOIN subjects su ON (m.subject_code = su.subject_code)
                        WHERE m.province = "00"
                        AND m.centre_code IN (SELECT centre_code FROM school where province =:province_code)
                        AND sc.province =:province_code
                        AND sc.centre_type =:session_type
                        GROUP BY sc.centre_code, d.d_code
                        ORDER BY sc.centre_code ASC');
    $sql->execute(array(
        ':province_code'=>$_SESSION['province_code'],
        ':session_type'=>$_SESSION['session_type']
    ));
    if($sql->rowCount() > 0){
        $i =0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
            $data_array[$i]['exam_centre'] = $row['exam_centre'] ?? '';
            $data_array[$i]['district'] = $row['district'] ?? '';
            $data_array[$i]['subject'] = $row['subject'] ?? '';
            $i++;
        }
    }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'All examination centres with subjects allocated';
    }
}
echo json_encode($data_array);
?>