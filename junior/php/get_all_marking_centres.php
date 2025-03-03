<?php
header("Access-Control-Allow-Origin: *"); 
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'ECZ'){
$sql = $db_9->prepare('SELECT ce.centre_code AS centre_code, ce.name AS centre_name,p.p_name AS province_name, CASE WHEN ce.centre_type ="E" THEN "GRADE 9 EXTERNAL" WHEN ce.centre_type = "I" THEN "GRADE 9 INTERNAL" ELSE "[UNKNOWN]" END AS centre_type
                        FROM centre ce INNER JOIN province p ON (ce.province = p.p_code)
                        ORDER BY ce.centre_code ASC');
$sql->execute();
if($sql->rowCount() > 0){
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['centre_code'] = $row['centre_code'];
                $data_array[$i]['centre_name'] = $row['centre_name'];
                $data_array[$i]['province_name'] = $row['province_name'];
                $data_array[$i]['centre_type'] = $row['centre_type'];
                $i++;
        }
}else{
        $data_array['status'] = '400';
}
}else if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'ADMIN'){
        $sql = $db_9->prepare('SELECT ce.centre_code AS centre_code, ce.name AS centre_name,p.p_name AS province_name, CASE WHEN ce.centre_type ="E" THEN "GRADE 9 EXTERNAL" WHEN ce.centre_type = "I" THEN "GRADE 9 INTERNAL" ELSE "[UNKNOWN]" END AS centre_type
        FROM centre ce INNER JOIN province p ON (ce.province = p.p_code)
        WHERE ce.centre_code =:marking_centre_code
        AND ce.centre_type =:centre_type
        ORDER BY ce.centre_code ASC');
        $sql->execute(array(
                ':marking_centre_code'=>$_SESSION['marking_centre_code'],
                ':centre_type'=>$_SESSION['session_type']
        ));
        if($sql->rowCount() > 0){
     
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['centre_code'] = $row['centre_code'];
        $data_array[$i]['centre_name'] = $row['centre_name'];
        $data_array[$i]['province_name'] = $row['province_name'];
        $data_array[$i]['centre_type'] = $row['centre_type'];
        $i++;
}
        }
}else{
        $sql = $db_9->prepare('SELECT ce.centre_code AS centre_code, ce.name AS centre_name,p.p_name AS province_name, CASE WHEN ce.centre_type ="E" THEN "GRADE 9 EXTERNAL" WHEN ce.centre_type = "I" THEN "GRADE 9 INTERNAL" ELSE "[UNKNOWN]" END AS centre_type
                        FROM centre ce INNER JOIN province p ON (ce.province = p.p_code)
                        ORDER BY ce.centre_code ASC');
$sql->execute();
if($sql->rowCount() > 0){ 
   
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['centre_code'] = $row['centre_code'];
                $data_array[$i]['centre_name'] = $row['centre_name'];
                $i++;
        }
}else{
        $data_array['status'] = '400';
}
}
echo json_encode($data_array);
?>