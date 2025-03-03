<?php
session_start();
header('Content-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if( (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'ADMIN') && !isset($_POST['marking_centre_code'])){
$sql= $db_ted->prepare('SELECT DISTINCT cg.group_code AS group_code, cg.group_name AS group_name FROM course_group cg
                                    INNER JOIN course c ON (cg.group_code = c.group_id)
                                    INNER JOIN marking_centre mc ON (c.course_code = mc.course)
                                    WHERE mc.centre_code =:marking_centre_code
                                    AND mc.session =:session_year
                                    ');
$sql->execute(array(
        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
        ':session_year'=>$_SESSION['session_year']
));
$i=0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['group_code'] = $row['group_code'];
        $data_array[$i]['group_name'] = $row['group_name'];
        $i++;
}
}else{
        if(isset($_POST['marking_centre_code'])){
                $marking_centre_code = $_POST['marking_centre_code'];
                $sql= $db_ted->prepare('SELECT DISTINCT cg.group_code AS group_code, cg.group_name AS group_name FROM course_group cg
                                    INNER JOIN course c ON (cg.group_code = c.group_id)
                                    INNER JOIN marking_centre mc ON (c.course_code = mc.course)
                                    WHERE mc.centre_code =:marking_centre_code
                                    ');
                $sql->execute(array(
                        ':marking_centre_code'=>$marking_centre_code
                       
                ));
                $i=0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        $data_array[$i]['group_code'] = $row['group_code'];
                        $data_array[$i]['group_name'] = $row['group_name'];
                        $i++;
                }
        }
}
echo json_encode($data_array);
?>