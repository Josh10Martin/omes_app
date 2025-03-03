<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'ECZ'){
$sql = $db_ted->prepare('SELECT centre_code, name
                        FROM centre WHERE session =:session
                        ORDER BY centre_code ASC');
$sql->execute(array(
        ':session'=>$_SESSION['session_year']
));
if($sql->rowCount() > 0){
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['centre_code'] = $row['centre_code'];
                $data_array[$i]['centre_name'] = $row['name'];
                $i++;
        }
}else{
        $data_array['status'] = '400';
}
}else if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'ADMIN'){
        $sql = $db_ted->prepare('SELECT centre_code, name
                        FROM centre WHERE session =:session
                        AND centre_code =:marking_centre_code
                        ORDER BY centre_code ASC');
$sql->execute(array(
        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
        ':session'=>$_SESSION['session_year']
));
if($sql->rowCount() > 0){
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['centre_code'] = $row['centre_code'];
                $data_array[$i]['centre_name'] = $row['name'];
                $i++;
        }
}else{
        $data_array['status'] = '400';
}
}else{
        $sql = $db_ted->prepare('SELECT centre_code, name
        FROM centre
        ORDER BY centre_code ASC');
$sql->execute();
if($sql->rowCount() > 0){
$i=0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
$data_array[$i]['centre_code'] = $row['centre_code'];
$data_array[$i]['centre_name'] = $row['name'];
$i++;
}
}else{
$data_array['status'] = '400';
}
}
echo json_encode($data_array);
?>