<?php
include '../../config.php';
include '../../functions.php';
$data_array = array();



$sql = $db_12_gce->prepare('SELECT exam_no,subject_code,paper_no,mark,status FROM marks WHERE status <> "L" AND (exam_no,subject_code,paper_no) IN
                    (SELECT exam_no,subject_code,paper_no FROM sen_exam_no WHERE date_time = (
                        SELECT MAX(date_time) FROM sen_exam_no 
                        WHERE exam_no IN (SELECT exam_no FROM marks WHERE status <> "L")
                    ))');
$sql->execute();

if (isset($_POST['check_only'])) {
    echo $sql->rowCount() > 0 ? 'has_data' : 'no_data';
    exit;
}

if ($sql->rowCount() > 0) {
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);

    // CSV headers
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="exam_no_not_exist.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['exam_no', 'subject_code', 'paper_no', 'mark','status']);
    foreach ($results as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
} else {
    http_response_code(204);
    exit;
}

if(isset($_SESSION['date_time'])){
        unset($_SESSION['date_time']);
        // unset($_SESSION['status']);
}
?>