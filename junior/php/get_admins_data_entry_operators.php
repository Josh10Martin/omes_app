<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql = $db_9->prepare('SELECT u.username AS username,u.first_name AS first_name,u.last_name AS last_name,u.email AS email,ce.name AS marking_centre, p.p_name AS province,u.phone AS phone_number,
                        CASE WHEN u.activation_status = "0" THEN "NOT ACTIVE" ELSE "ACTIVE" END AS activation_status, u.user_type AS role
                        FROM users u INNER JOIN province p ON (u.province = p.p_code)
                        INNER JOIN centre ce on (p.p_code = ce.province)
                        WHERE u.marking_centre = ce.centre_code 
                        AND u.user_type IN ("DEO", "ADMIN")
                        AND ce.centre_type =:session_type
                        ');
$sql->execute(array(
        ':session_type'=>$_SESSION['session_type']
));
if($sql ->rowCount() > 0){
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['username'] = $row['username'];
                $data_array[$i]['first_name'] = $row['first_name'];
                $data_array[$i]['last_name'] = $row['last_name'];
                $data_array[$i]['email'] = $row['email'];
                $data_array[$i]['phone_number'] = $row['phone_number'];
                $data_array[$i]['marking_centre'] = $row['marking_centre'];
                $data_array[$i]['province'] = $row['province'];
                $data_array[$i]['activation_status'] = $row['activation_status'];
                $data_array[$i]['role'] = $row['role'];
                $i++;
        }
}else{
        $data_array['status'] = '400';
}
echo json_encode($data_array);
?>