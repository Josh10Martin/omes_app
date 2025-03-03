<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();
if((isset($_POST['checker']) && !empty($_POST['checker'])) && (isset($_POST['sad'])) && !empty($_POST['sad'])){
        $checker = $_POST['checker'];
        $sad = $_POST['sad'];

        $sql = $db_ted->prepare('UPDATE marking_rates SET checker =:checker,sys_admin =:sad');
        $sql->execute(array(
                ':checker'=>$checker,
                ':sad'=>$sad
        ));
        $data_array['status'] = '200';
        $data_array['checker'] = $checker;
        $data_array['sad'] = $sad;
}else{
        if(isset($_POST['cch']) && isset($_POST['dcch'])){
                $cch = $_POST['cch'];
                $dcch = $_POST['dcch'];

                $sql = $db_ted->prepare('UPDATE centre_chairperson_rate SET centre_chairperson =:cch, deputy_c_person =:dcch');
                $sql->execute(array(
                        ':cch'=>$cch,
                        ':dcch'=>$dcch
                ));
                $data_array['status'] = '200';
                $data_array['cch'] = $cch;
                $data_array['dcch'] = $dcch;
        }
}
echo json_encode($data_array);
?>