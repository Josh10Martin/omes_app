<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['course_group'])){
        $course_group = $_POST['course_group'];

        $sql = $db_ted->prepare('SELECT DISTINCT ex.belt_no AS belt_no FROM examiner ex INNER JOIN course c ON (ex.course_code = c.course_code)
                                INNER JOIN course_group cg ON (c.group_id = cg.group_code)
                                WHERE ex.belt_no IS NOT NULL
                                AND ex.session =:session
                                AND cg.group_code =:course_group
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
echo json_encode($data_array);