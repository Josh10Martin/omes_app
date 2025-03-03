<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
 if(isset($_POST['course_group']) && isset($_POST['belt_no'])){
        $course_group = $_POST['course_group'];
        $belt_no = $_POST['belt_no'];

        $sql = $db_ted->prepare('SELECT DISTINCT ex.examiner_number AS examiner_number,ex.nrc AS nrc,ex.id AS id,ex.first_name AS first_name,ex.last_name AS last_name,ex.belt_no AS belt_no,
        ex.email AS email
        FROM examiner ex INNER JOIN marking_centre mc ON (ex.marking_centre = mc.centre_code)
        INNER JOIN course c ON (mc.course = c.course_code)
        INNER JOIN course_group cg ON (c.group_id = cg.group_code)
       
        WHERE ex.marking_centre = mc.centre_code
        AND ex.session = mc.session
        AND ex.attendance = 1
        AND ex.marking_centre =:marking_centre_code
        AND ex.belt_no IS NOT NULL
        AND ex.course_code = mc.course
        AND ex.session =:session_year
        AND cg.group_code =:group_code
        AND ex.belt_no =:belt_no');
$sql->execute(array(
':session_year'=>$_SESSION['session_year'],
':marking_centre_code'=>$_SESSION['marking_centre_code'],
':group_code'=>$course_group,
':belt_no'=>$belt_no
));
if($sql->rowCount() > 0){
$data_array['status'] = '200';
$i=0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
$data_array[$i]['examiner_number'] = $row['examiner_number'] ?? '';
$data_array[$i]['nrc'] = $row['nrc'] ?? '';
$data_array[$i]['id'] = $row['id'] ?? '';
$data_array[$i]['first_name'] = $row['first_name'] ?? '';
$data_array[$i]['last_name'] = $row['last_name'] ?? '';
$data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
$data_array[$i]['email'] = $row['email'] ?? '';
$i++;
}
}else{
$data_array['status'] = '400';
}
}
echo json_encode($data_array);
?>