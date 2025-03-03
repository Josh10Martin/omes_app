<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if($_SESSION['session_type'] == 'E'){
if(isset($_POST['subject_code']) && isset($_POST['paper']) && isset($_POST['belt_no'])){
        $subject_code = $_POST['subject_code'];
        $paper = $_POST['paper'];
        $belt_no = $_POST['belt_no'];
        ///start
        if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO'){
        $sql = $db_9->prepare('SELECT DISTINCT e.nrc AS nrc,e.id AS id,e.first_name AS first_name,e.last_name AS last_name,e.phone_number AS phone,e.branch AS branch_id,su.subject_name AS subject_name,
        pa.paper_no AS paper_no,e.belt_no AS belt_no,po.name AS role
        FROM marking_centre mc INNER JOIN subjects su ON (mc.subject = su.subject_code)
        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
        INNER JOIN examiner e ON (pa.paper_no = e.paper_no)
        INNER JOIN position po ON (e.role = po.id)
        WHERE e.subject_code = su.subject_code
        AND e.province = mc.province
        AND e.marking_centre = mc.centre_code
        AND e.subject_code = mc.subject
        AND e.paper_no = mc.paper
        AND e.belt_no =:belt_no
        AND mc.province =:province_code
        AND mc.centre_code =:marking_centre_code
        AND mc.subject =:subject_code
        AND mc.paper =:paper
        ORDER BY nrc ASC');
$sql->execute(array(
':province_code'=>$_SESSION['province_code'],
':marking_centre_code'=>$_SESSION['marking_centre_code'],
':subject_code'=>$subject_code,
':paper'=>$paper,
':belt_no'=>$belt_no
));
if($sql->rowCount() > 0){
$data_array['status'] = '200';
$i=0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
$data_array[$i]['nrc'] = $row['nrc'] ?? '';
$data_array[$i]['id'] = $row['id'] ?? '';
$data_array[$i]['first_name'] = $row['first_name'] ?? '';
$data_array[$i]['last_name'] = $row['last_name'] ?? '';
$data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
$data_array[$i]['phone'] = $row['phone'] ?? '';
$data_array[$i]['branch_id'] = $row['branch_id'] ?? '';
$data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
$data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
$data_array[$i]['role'] = $row['role'] ?? '';
$i++;
}
}else{
$data_array['status'] = '400';
}
        }else{
                $sql = $db_9->prepare('SELECT DISTINCT e.nrc AS nrc,e.id AS id,e.first_name AS first_name,e.last_name AS last_name,e.phone_number AS phone,e.branch AS branch_id,su.subject_name AS subject_name,
        pa.paper_no AS paper_no,e.belt_no AS belt_no,po.name AS role
        FROM marking_centre mc INNER JOIN subjects su ON (mc.subject = su.subject_code)
        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
        INNER JOIN examiner e ON (pa.paper_no = e.paper_no)
        INNER JOIN position po ON (e.role = po.id)
        WHERE e.subject_code = su.subject_code
        AND  e.province = mc.province
        AND e.marking_centre = mc.centre_code
        AND e.subject_code = mc.subject
        AND e.paper_no = mc.paper
        AND e.belt_no =:belt_no
        AND mc.subject =:subject_code
        AND mc.paper =:paper
        ORDER BY nrc ASC');
$sql->execute(array(
':subject_code'=>$subject_code,
':paper'=>$paper,
':belt_no'=>$belt_no
));
if($sql->rowCount() > 0){
$data_array['status'] = '200';
$i=0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
$data_array[$i]['nrc'] = $row['nrc'] ?? '';
$data_array[$i]['id'] = $row['id'] ?? '';
$data_array[$i]['first_name'] = $row['first_name'] ?? '';
$data_array[$i]['last_name'] = $row['last_name'] ?? '';
$data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
$data_array[$i]['phone'] = $row['phone'] ?? '';
$data_array[$i]['branch_id'] = $row['branch_id'] ?? '';
$data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
$data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
$data_array[$i]['role'] = $row['role'] ?? '';
$i++;
}
}else{
$data_array['status'] = '400';
}
 }
///end
}else if(isset($_POST['subject_code']) && isset($_POST['paper'])){
        $subject_code = $_POST['subject_code'];
        $paper = $_POST['paper'];
        //start
        if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO'){
        $sql = $db_9->prepare('SELECT DISTINCT e.nrc AS nrc,e.id AS id,e.first_name AS first_name,e.last_name AS last_name,e.phone_number AS phone,e.branch AS branch_id,su.subject_name AS subject_name,
        pa.paper_no AS paper_no,e.belt_no AS belt_no,po.name AS role
        FROM marking_centre mc INNER JOIN subjects su ON (mc.subject = su.subject_code)
        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
        INNER JOIN examiner e ON (pa.paper_no = e.paper_no)
        INNER JOIN position po ON (e.role = po.id)
        WHERE e.subject_code = su.subject_code
        AND e.province = mc.province
        AND e.marking_centre = mc.centre_code
        AND e.subject_code = mc.subject
        AND e.paper_no = mc.paper
        AND mc.province =:province_code
        AND mc.centre_code =:marking_centre_code
        AND mc.subject =:subject_code
        AND mc.paper =:paper
        ORDER BY nrc ASC');
$sql->execute(array(
':province_code'=>$_SESSION['province_code'],
':marking_centre_code'=>$_SESSION['marking_centre_code'],
':subject_code'=>$subject_code,
':paper'=>$paper
));
if($sql->rowCount() > 0){
$data_array['status'] = '200';
$i=0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
$data_array[$i]['nrc'] = $row['nrc'] ?? '';
$data_array[$i]['id'] = $row['id'] ?? '';
$data_array[$i]['first_name'] = $row['first_name'] ?? '';
$data_array[$i]['last_name'] = $row['last_name'] ?? '';
$data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
$data_array[$i]['phone'] = $row['phone'] ?? '';
$data_array[$i]['branch_id'] = $row['branch_id'] ?? '';
$data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
$data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
$data_array[$i]['role'] = $row['role'] ?? '';
$i++;
}
}else{
$data_array['status'] = '400';
}
        }else{
                $sql = $db_9->prepare('SELECT DISTINCT e.nrc AS nrc,e.id AS id,e.first_name AS first_name,e.last_name AS last_name,e.phone_number AS phone,e.branch AS branch_id,su.subject_name AS subject_name,
        pa.paper_no AS paper_no,e.belt_no AS belt_no,po.name AS role
        FROM marking_centre mc INNER JOIN subjects su ON (mc.subject = su.subject_code)
        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
        INNER JOIN examiner e ON (pa.paper_no = e.paper_no)
        INNER JOIN position po ON (e.role = po.id)
        WHERE e.subject_code = su.subject_code
        AND e.province = mc.province
        AND e.marking_centre = mc.centre_code
        AND e.subject_code = mc.subject
        AND e.paper_no = mc.paper
        AND mc.subject =:subject_code
        AND mc.paper =:paper
        ORDER BY nrc ASC');
$sql->execute(array(
':subject_code'=>$subject_code,
':paper'=>$paper
));
if($sql->rowCount() > 0){
$data_array['status'] = '200';
$i=0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
$data_array[$i]['nrc'] = $row['nrc'] ?? '';
$data_array[$i]['id'] = $row['id'] ?? '';
$data_array[$i]['first_name'] = $row['first_name'] ?? '';
$data_array[$i]['last_name'] = $row['last_name'] ?? '';
$data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
$data_array[$i]['phone'] = $row['phone'] ?? '';
$data_array[$i]['branch_id'] = $row['branch_id'] ?? '';
$data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
$data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
$data_array[$i]['role'] = $row['role'] ?? '';
$i++;
}
}else{
$data_array['status'] = '400';
}
        }
//end
}else{
        ///start
        if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO'){
$sql = $db_9->prepare('SELECT DISTINCT e.nrc AS nrc,e.id AS id,e.first_name AS first_name,e.last_name AS last_name,e.phone_number AS phone,e.branch AS branch_id,su.subject_name AS subject_name,
                        pa.paper_no AS paper_no,e.belt_no AS belt_no,po.name AS role
                        FROM marking_centre mc INNER JOIN subjects su ON (mc.subject = su.subject_code)
                        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                        INNER JOIN examiner e ON (pa.paper_no = e.paper_no)
                        INNER JOIN position po ON (e.role = po.id)
                        WHERE e.subject_code = su.subject_code
                        AND e.subject_code = mc.subject
                        AND e.province = mc.province
                        AND e.marking_centre = mc.centre_code
                        AND mc.province =:province_code
                        AND mc.centre_code =:marking_centre_code
                        ORDER BY nrc ASC');
$sql->execute(array(
        ':province_code'=>$_SESSION['province_code'],
        ':marking_centre_code'=>$_SESSION['marking_centre_code']
));
if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['nrc'] = $row['nrc'] ?? '';
                $data_array[$i]['id'] = $row['id'] ?? '';
                $data_array[$i]['first_name'] = $row['first_name'] ?? '';
                $data_array[$i]['last_name'] = $row['last_name'] ?? '';
                $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
                $data_array[$i]['phone'] = $row['phone'] ?? '';
                $data_array[$i]['branch_id'] = $row['branch_id'] ?? '';
                $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
                $data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
                $data_array[$i]['role'] = $row['role'] ?? '';
                $i++;
        }
}else{
        $data_array['status'] = '400';
}
        }else{
                $sql = $db_9->prepare('SELECT DISTINCT e.nrc AS nrc,e.id AS id,e.first_name AS first_name,e.last_name AS last_name,e.phone_number AS phone,e.branch AS branch_id,su.subject_name AS subject_name,
                        pa.paper_no AS paper_no,e.belt_no AS belt_no,po.name AS role
                        FROM marking_centre mc INNER JOIN subjects su ON (mc.subject = su.subject_code)
                        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                        INNER JOIN examiner e ON (pa.paper_no = e.paper_no)
                        INNER JOIN position po ON (e.role = po.id)
                        WHERE e.subject_code = su.subject_code
                        AND e.subject_code = mc.subject
                        AND e.province = mc.province
                        AND e.marking_centre = mc.centre_code
                        ORDER BY nrc ASC');
$sql->execute();
if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['nrc'] = $row['nrc'] ?? '';
                $data_array[$i]['id'] = $row['id'] ?? '';
                $data_array[$i]['first_name'] = $row['first_name'] ?? '';
                $data_array[$i]['last_name'] = $row['last_name'] ?? '';
                $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
                $data_array[$i]['phone'] = $row['phone'] ?? '';
                $data_array[$i]['branch_id'] = $row['branch_id'] ?? '';
                $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
                $data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
                $data_array[$i]['role'] = $row['role'] ?? '';
                $i++;
        }
}else{
        $data_array['status'] = '400';
}
        }
///end
}

}else{
        if(isset($_POST['subject_code']) && isset($_POST['paper']) && isset($_POST['belt_no'])){
                $subject_code = $_POST['subject_code'];
                $paper = $_POST['paper'];
                $belt_no = $_POST['belt_no'];
                ///start
                if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO'){
                $sql = $db_9->prepare('SELECT DISTINCT e.nrc AS nrc,e.id AS id,e.first_name AS first_name,e.last_name AS last_name,e.phone_number AS phone,e.branch AS branch_id,su.subject_name AS subject_name,
                pa.paper_no AS paper_no,e.belt_no AS belt_no,po.name AS role
                FROM paper pa INNER JOIN subjects su ON (pa.subject_code = su.subject_code)
                INNER JOIN examiner e ON (su.subject_code = e.subject_code)
                INNER JOIN position po ON (e.role = po.id)
                WHERE pa.paper_no = e.paper_no
                AND e.province = :province_code
                AND e.marking_centre =:marking_centre_code
                AND e.subject_code =:subject_code
                AND e.belt_no =:belt_no
                AND e.paper_no =:paper
                ORDER BY nrc ASC');
        $sql->execute(array(
        ':province_code'=>$_SESSION['province_code'],
        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
        ':subject_code'=>$subject_code,
        ':paper'=>$paper,
        ':belt_no'=>$belt_no
        ));
        if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['nrc'] = $row['nrc'] ?? '';
        $data_array[$i]['id'] = $row['id'] ?? '';
        $data_array[$i]['first_name'] = $row['first_name'] ?? '';
        $data_array[$i]['last_name'] = $row['last_name'] ?? '';
        $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
        $data_array[$i]['phone'] = $row['branch_id'] ?? '';
        $data_array[$i]['branch_id'] = $row['branch_id'] ?? '';
        $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
        $data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
        $data_array[$i]['role'] = $row['role'] ?? '';
        $i++;
        }
        }else{
        $data_array['status'] = '400';
        }
                }else{
                        $sql = $db_9->prepare('SELECT DISTINCT e.nrc AS nrc,e.id AS id,e.first_name AS first_name,e.last_name AS last_name,e.phone_number AS phone,e.branch AS branch_id,su.subject_name AS subject_name,
                pa.paper_no AS paper_no,e.belt_no AS belt_no,po.name AS role
                FROM paper pa INNER JOIN subjects su ON (pa.subject_code = su.subject_code)
                INNER JOIN examiner e ON (su.subject_code = e.subject_code)
                INNER JOIN position po ON (e.role = po.id)
                WHERE pa.paper_no = e.paper_no
                AND e.province = mp.province
                AND e.marking_centre = mp.marking_centre
                AND e.subject_code = mp.subject_code
                AND e.belt_no =:belt_no
                AND mp.subject_code =:subject_code
                AND e.paper_no =:paper
                ORDER BY nrc ASC');
        $sql->execute(array(
        ':subject_code'=>$subject_code,
        ':paper'=>$paper,
        ':belt_no'=>$belt_no
        ));
        if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['nrc'] = $row['nrc'] ?? '';
        $data_array[$i]['id'] = $row['id'] ?? '';
        $data_array[$i]['first_name'] = $row['first_name'] ?? '';
        $data_array[$i]['last_name'] = $row['last_name'] ?? '';
        $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
        $data_array[$i]['phone'] = $row['phone'] ?? '';
        $data_array[$i]['branch_id'] = $row['branch_id'] ?? '';
        $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
        $data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
        $data_array[$i]['role'] = $row['role'] ?? '';
        $i++;
        }
        }else{
        $data_array['status'] = '400';
        }
         }
        ///end
        }else if(isset($_POST['subject_code']) && isset($_POST['paper'])){
                $subject_code = $_POST['subject_code'];
                $paper = $_POST['paper'];
                //start
                if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO'){
                $sql = $db_9->prepare('SELECT DISTINCT e.nrc AS nrc,e.id AS id,e.first_name AS first_name,e.last_name AS last_name,e.phone_number AS phone,e.branch AS branch_id,su.subject_name AS subject_name,
                pa.paper_no AS paper_no,e.belt_no AS belt_no,po.name AS role
                FROM paper pa INNER JOIN subjects su ON (pa.subject_code = su.subject_code)
                INNER JOIN examiner e ON (su.subject_code = e.subject_code)
                INNER JOIN position po ON (e.role = po.id)
                WHERE pa.paper_no = e.paper_no
                AND e.province =:province_code
                AND e.marking_centre =:marking_centre_code
                AND e.subject_code =:subject_code
                AND e.paper_no =:paper
                ORDER BY nrc ASC');
        $sql->execute(array(
        ':province_code'=>$_SESSION['province_code'],
        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
        ':subject_code'=>$subject_code,
        ':paper'=>$paper
        ));
        if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['nrc'] = $row['nrc'] ?? '';
        $data_array[$i]['id'] = $row['id'] ?? '';
        $data_array[$i]['first_name'] = $row['first_name'] ?? '';
        $data_array[$i]['last_name'] = $row['last_name'] ?? '';
        $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
        $data_array[$i]['phone'] = $row['phone'] ?? '';
        $data_array[$i]['branch_id'] = $row['branch_id'] ?? '';
        $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
        $data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
        $data_array[$i]['role'] = $row['role'] ?? '';
        $i++;
        }
        }else{
        $data_array['status'] = '400';
        }
                }else{
                        $sql = $db_9->prepare('SELECT DISTINCT e.nrc AS nrc,e.id AS id,e.first_name AS first_name,e.last_name AS last_name,e.phone_number AS phone,e.branch AS branch_id,su.subject_name AS subject_name,
                pa.paper_no AS paper_no,e.belt_no AS belt_no,po.name AS role
                FROM paper pa INNER JOIN subjects su ON (pa.subject_code = su.subject_code)
                INNER JOIN examiner e ON (su.subject_code = e.subject_code)
                INNER JOIN position po ON (e.role = po.id)
                WHERE pa.paper_no = e.paper_no
                AND e.province =:province_code
                AND e.marking_centre =:marking_centre_code
                AND e.subject_code =:subject_code
                AND e.paper_no =:paper
                ORDER BY nrc ASC');
        $sql->execute(array(
        ':subject_code'=>$subject_code,
        ':paper'=>$paper,
        ':province_code'=>$_SESSION['province_code'],
        ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
        if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['nrc'] = $row['nrc'] ?? '';
        $data_array[$i]['id'] = $row['id'] ?? '';
        $data_array[$i]['first_name'] = $row['first_name'] ?? '';
        $data_array[$i]['last_name'] = $row['last_name'] ?? '';
        $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
        $data_array[$i]['phone'] = $row['phone'] ?? '';
        $data_array[$i]['branch_id'] = $row['branch_id'] ?? '';
        $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
        $data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
        $data_array[$i]['role'] = $row['role'] ?? '';
        $i++;
        }
        }else{
        $data_array['status'] = '400';
        }
                }
        //end
        }else{
                ///start
                if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO'){
        $sql = $db_9->prepare('SELECT DISTINCT e.nrc AS nrc,e.id AS id,e.first_name AS first_name,e.last_name AS last_name,e.phone_number AS phone,e.branch AS branch_id,su.subject_name AS subject_name,
                                pa.paper_no AS paper_no,e.belt_no AS belt_no,po.name AS role
                                FROM paper pa INNER JOIN subjects su ON (pa.subject_code = su.subject_code)
                                INNER JOIN examiner e ON (su.subject_code = e.subject_code)
                                 INNER JOIN position po ON (e.role = po.id)
                                 WHERE pa.paper_no = e.paper_no
                                AND e.province =:province_code
                                AND e.marking_centre =:marking_centre_code
                                ORDER BY nrc ASC');
        $sql->execute(array(
                ':province_code'=>$_SESSION['province_code'],
                ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                $i=0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        $data_array[$i]['nrc'] = $row['nrc'] ?? '';
                        $data_array[$i]['id'] = $row['id'] ?? '';
                        $data_array[$i]['first_name'] = $row['first_name'] ?? '';
                        $data_array[$i]['last_name'] = $row['last_name'] ?? '';
                        $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
                        $data_array[$i]['phone'] = $row['phone'] ?? '';
                        $data_array[$i]['branch_id'] = $row['branch_id'] ?? '';
                        $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
                        $data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
                        $data_array[$i]['role'] = $row['role'] ?? '';
                        $i++;
                }
        }else{
                $data_array['status'] = '400';
        }
                }else{
                        $sql = $db_9->prepare('SELECT DISTINCT e.nrc AS nrc,e.id AS id,e.first_name AS first_name,e.last_name AS last_name,e.phone_number AS phone,e.branch AS branch_id,su.subject_name AS subject_name,
                                pa.paper_no AS paper_no,e.belt_no AS belt_no,po.name AS role
                                FROM paper pa INNER JOIN subjects su ON (pa.subject_code = su.subject_code)
                                INNER JOIN examiner e ON (su.subject_code = e.subject_code)
                                 INNER JOIN position po ON (e.role = po.id)
                                 WHERE pa.paper_no = e.paper_no
                                AND e.province =:province_code
                                AND e.marking_centre =:marking_centre_code
                                ORDER BY nrc ASC');
        $sql->execute(array(
                ':province_code'=>$_SESSION['province_code'],
                ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                $i=0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        $data_array[$i]['nrc'] = $row['nrc'] ?? '';
                        $data_array[$i]['id'] = $row['id'] ?? '';
                        $data_array[$i]['first_name'] = $row['first_name'] ?? '';
                        $data_array[$i]['last_name'] = $row['last_name'] ?? '';
                        $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
                        $data_array[$i]['phone'] = $row['phone'] ?? '';
                        $data_array[$i]['branch_id'] = $row['branch_id'] ?? '';
                        $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
                        $data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
                        $data_array[$i]['role'] = $row['role'] ?? '';
                        $i++;
                }
        }else{
                $data_array['status'] = '400';
        }
                }
        ///end
        }
}
echo json_encode($data_array);
?>