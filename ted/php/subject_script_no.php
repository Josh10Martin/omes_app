<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
$no_of_scripts = '';
$subject_code = '';
if($_SESSION['user_type'] == 'ECZ'){
    $sql = $db_ted->prepare('SELECT SUM(a.script_no) AS no_of_scripts,co.course_code AS course_code
                            FROM apportionment a LEFT OUTER JOIN course co ON (a.course = co.course_code)
                            GROUP BY co.course_code
                            ORDER BY course_code');
    $sql->execute();
 
    $i =0;
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['no_of_scripts'] =  $row['no_of_scripts'] ?? '0';
        $data_array[$i]['course_code'] = $row['course_code'] ?? '';
        $i++;
      
    }
   
}else{
    $sql = $db_ted->prepare('SELECT SUM(a.script_no) AS no_of_scripts,co.course_code AS course_code
    FROM apportionment a LEFT OUTER JOIN course co ON (a.course = co.course_code)
   
    WHERE marking_centre =:marking_centre_code
    GROUP BY co.course_code
    ORDER BY course_code');
$sql->execute(array(
    ':marking_centre_code'=>$_SESSION['marking_centre_code']
));
$row = $sql->fetch(PDO::FETCH_ASSOC);
$i =0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
    $data_array[$i]['no_of_scripts'] =  $row['no_of_scripts'] ?? '0';
    $data_array[$i]['course_code'] = $row['course_code'] ?? '';
    $i++;
    
}

}
echo json_encode($data_array);
?>