<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'ADMIN'){


if(isset($_POST['course_group'])){
        $course_group = $_POST['course_group'];

        $sql = $db_ted->prepare('SELECT DISTINCT belt_no FROM group_apportion WHERE group_code =:course_group 
                                AND session =:session
                                AND marking_centre =:marking_centre_code
                                ORDER BY belt_no ASC');
        $sql->execute(array(
                ':course_group'=>$course_group,
                ':session'=>$_SESSION['session_year'],
                ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                $i=0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
                        $i++;
                }
        }
}
}else{
        if(isset($_POST['course_group'])){
                $course_group = $_POST['course_group'];
                $marking_centre_code = isset($_POST['marking_centre_code']) ? $_POST['marking_centre_code'] : '';
        
                $sql = $db_ted->prepare('SELECT DISTINCT belt_no FROM group_apportion WHERE group_code =:course_group 
                                         AND marking_centre =:marking_centre_code
                                        ORDER BY belt_no ASC');
                $sql->execute(array(
                        ':course_group'=>$course_group,
                        ':marking_centre_code'=>$marking_centre_code
                ));
                if($sql->rowCount() > 0){
                        $data_array['status'] = '200';
                        $i=0;
                        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                                $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
                                $i++;
                        }
                }
        }
}
echo json_encode($data_array);