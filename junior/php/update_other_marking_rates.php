<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();
if((isset($_POST['checker']) && !empty($_POST['checker'])) && (isset($_POST['sad'])) && !empty($_POST['transcriber'] && isset($_POST['lunch']) && isset($_POST['transport']))){
        $checker = $_POST['checker'];
        $sad = $_POST['sad'];
        $transcriber = $_POST['transcriber'];
        $transport = $_POST['transport'];
        $lunch = $_POST['lunch'];

        $sql = $db_9->prepare('UPDATE marking_rates SET checker =:checker,sys_admin =:sad, transcriber =:transcriber');
        $sql->execute(array(
                ':checker'=>$checker,
                ':sad'=>$sad,
                ':transcriber'=>$transcriber
        ));

        $sql1 = $db_9->prepare('INSERT INTO lun_trans (lunch, transport) VALUES (:lunch,:transport)
        ON DUPLICATE KEY UPDATE
        lunch = VALUES(lunch),
        transport = VALUES(transport)
        ');
        $sql1->execute(array(
        ':lunch'=>$lunch,
        ':transport'=>$transport
        ));
        $data_array['status'] = '200';
        $data_array['checker'] = $checker;
        $data_array['sad'] = $sad;
        $data_array['lunch'] = $lunch;
        $data_array['transport'] = $transport;
}
echo json_encode($data_array);
?>