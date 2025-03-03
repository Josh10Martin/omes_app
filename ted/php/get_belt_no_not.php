<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['belt_no']) && isset($_POST['group_code'])){
    $belt_no = $_POST['belt_no'];
    $group_code = $_POST['group_code'];

    $sql = $db_ted->prepare('SELECT DISTINCT belt_no from group_apportion WHERE group_code =:group_code
                            AND belt_no <>:belt_no AND marking_centre =:marking_centre_code AND session =:session');
    $sql->execute(array(
        ':belt_no'=>$belt_no,
        ':group_code'=>$group_code,
        ':session'=>$_SESSION['session_year'],
        ':marking_centre_code'=>$_SESSION['marking_centre_code']
    ));
    if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $i =0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
            $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
            $i++;
        }
    }
}
echo json_encode($data_array);
?>