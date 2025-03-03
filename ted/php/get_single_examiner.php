<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['id'])){
        $id = $_POST['id'];

        $sql = $db_9->prepare('SELECT DISTINCT e.nrc AS nrc,e.id AS id,e.first_name AS first_name,e.last_name AS last_name,e.phone_number AS phone,e.address AS address,
                        e.email AS email,e.belt_no AS belt_no,e.role AS role_id,po.name AS role, e.title AS title,e.attendance AS attendance,e.no_of_days AS no_of_days,
                        e.subject_code AS subject_code,e.paper_no AS paper_no,
                        e.bank AS bank, e.branch AS branch, e.account_no AS account_no
                        FROM marking_centre mc INNER JOIN examiner e ON (mc.centre_code = e.marking_centre)
                        INNER JOIN position po ON (po.id = e.role)
                        WHERE e.id =:id');
$sql->execute(array(
        ':id'=>$id
));
        $data_array['status'] = '200';
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $data_array['nrc'] = $row['nrc'] ?? '';
        $data_array['id'] = $row['id'] ?? '';
        $data_array['first_name'] = $row['first_name'] ?? '';
        $data_array['last_name'] = $row['last_name'] ?? '';
        $data_array['belt_no'] = $row['belt_no'] ?? '';
        $data_array['phone'] = $row['phone'] ?? '';
        $data_array['address'] = $row['address'] ?? '';
        $data_array['email'] = $row['email'] ?? '';
        $data_array['role_id'] = $row['role_id'] ?? '';
        $data_array['role'] = $row['role'] ?? '';
        $data_array['title'] = $row['title'] ?? '';
        $data_array['attendance'] = $row['attendance'] ?? '';
        $data_array['no_of_days'] = $row['no_of_days'] ?? '';
        $data_array['subject_code'] = $row['subject_code'] ?? '';
        $data_array['paper_no'] = $row['paper_no'] ?? '';
        $data_array['bank'] = $row['bank'] ?? '';
        $data_array['branch'] = $row['branch'] ?? '';
        $data_array['account_no'] = $row['account_no'] ?? '';
      
        

}

echo json_encode($data_array);
?>