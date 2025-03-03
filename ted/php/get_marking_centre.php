<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql =$db_ted->prepare('SELECT c.centre_code AS marking_centre_code, c.name AS marking_centre_name
                        FROM centre c INNER JOIN marking_centre mc ON (c.centre_code = mc.centre_code)
                        INNER JOIN users u ON (mc.centre_code = u.marking_centre)
                        WHERE c.centre_code = u.marking_centre
                        AND mc.centre_code = u.marking_centre
                        AND mc.centre_code =:marking_centre_code
                        ');
$sql->execute(array(
    ':marking_centre_code'=>$_SESSION['marking_centre_code']
));
if($sql->rowCount() > 0){
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    $data_array['status'] = '200';
    $data_array['marking_centre_code'] = $row['marking_centre_code'] ?? '';
    $data_array['marking_centre_name'] = $row['marking_centre_name'] ?? '';

}else{
    $data_array['status'] = '400';
}
echo json_encode($data_array);
?>