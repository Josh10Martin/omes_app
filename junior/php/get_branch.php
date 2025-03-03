<?php
header('Content-Type:application/json; charset=utf-8;');
include '../../config.php';
$data_array = array();
if(isset($_POST['bank_id'])){
        $bank_id = $_POST['bank_id'];
        $sql= $db_9->prepare('SELECT id,name,sortcode FROM bankbranch WHERE bank_id =:bank_id');
        $sql->execute(array(
                ':bank_id'=>$bank_id
        ));

$row = $sql->fetch(PDO::FETCH_ASSOC);
$data_array[0]['id'] = $row['id'] ?? '';
$data_array[0]['name'] = $row['name']?? '';
$data_array[0]['sortcode'] = $row['sortcode']?? '';
$i=1;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['id'] = $row['id']?? '';
        $data_array[$i]['name'] = $row['name']?? '';
        $data_array[$i]['sortcode'] = $row['sortcode']?? '';
        $i++;
}
}
echo json_encode($data_array);
?>