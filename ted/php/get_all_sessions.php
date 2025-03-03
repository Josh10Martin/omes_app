<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql = $db_ted->prepare('SELECT id,name,year,level FROM session ');
$sql->execute();
if($sql->rowCount() > 0){
        $i = 0;
    while($row = $sql->fetch(PDO:: FETCH_ASSOC)){
        $data_array[$i]['year'] = $row['year'] ?? '';
        $data_array[$i]['description'] = $row['name'] ?? '';
        $i++;
    }
    
    
}else{
    $data_array['status'] = '400';
}
echo json_encode($data_array);
?>