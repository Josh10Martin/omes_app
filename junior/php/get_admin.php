<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if($_SESSION['user_type'] == 'SESO'){
$sql = $db_9->prepare('SELECT u.username AS username,u.first_name AS first_name,u.last_name AS last_name,u.email AS email,p.p_name AS province,
                        CASE WHEN u.activation_status = "0" THEN "NOT ACTIVE" ELSE "ACTIVE" END AS activation_status,c.name AS marking_centre_name,
                        CASE WHEN u.user_type = "ADMIN" THEN "SYSTEMS ADMINISTRATOR" WHEN u.user_type = "DEO" THEN "DATA ENTRY OPERATOR" ELSE "" END AS user_type
                        FROM province p INNER JOIN users u ON (p.p_code = u.province)
                        INNER JOIN centre c ON (u.marking_centre = c.centre_code)
                        WHERE u.user_type = "ADMIN"
                        AND u.province = :province_code');
$sql->execute(array(
        ':province_code'=>$_SESSION['province_code']
));
if($sql ->rowCount() > 0){
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['username'] = $row['username'];
                $data_array[$i]['first_name'] = $row['first_name'];
                $data_array[$i]['last_name'] = $row['last_name'];
                $data_array[$i]['email'] = $row['email'];
                $data_array[$i]['user_type'] = $row['user_type'];
                $data_array[$i]['province'] = $row['province'];
                $data_array[$i]['activation_status'] = $row['activation_status'];
                $data_array[$i]['marking_centre_name'] = $row['marking_centre_name'];
                $i++;
        }
}else{
        $data_array['status'] = '400';
}
}else{
        $sql = $db_9->prepare('SELECT u.username AS username,u.first_name AS first_name,u.last_name AS last_name,u.email AS email,p.p_name AS province,
                        CASE WHEN u.activation_status = "0" THEN "NOT ACTIVE" ELSE "ACTIVE" END AS activation_status,c.name AS marking_centre_name,
                        CASE WHEN u.user_type = "ADMIN" THEN "SYSTEMS ADMINISTRATOR" WHEN u.user_type = "DEO" THEN "DATA ENTRY OPERATOR" ELSE "" END AS user_type
                        FROM province p INNER JOIN users u ON (p.p_code = u.province)
                        INNER JOIN centre c ON (u.marking_centre = c.centre_code)
                        WHERE u.user_type = "DEO"
                        AND u.marking_centre =:marking_centre_code
                        AND u.province = :province_code');
$sql->execute(array(
        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
        ':province_code'=>$_SESSION['province_code']
));
if($sql ->rowCount() > 0){
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['username'] = $row['username'];
                $data_array[$i]['first_name'] = $row['first_name'];
                $data_array[$i]['last_name'] = $row['last_name'];
                $data_array[$i]['email'] = $row['email'];
                $data_array[$i]['user_type'] = $row['user_type'];
                $data_array[$i]['province'] = $row['province'];
                $data_array[$i]['activation_status'] = $row['activation_status'];
                $data_array[$i]['marking_centre_name'] = $row['marking_centre_name'];
                $i++;
        }
}else{
        $data_array['status'] = '400';
}
}
echo json_encode($data_array);
?>