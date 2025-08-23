<?php
session_start();
include '../../config.php';

if (isset($_POST['subject']) && isset($_POST['paper']) && isset($_POST['attendance']) && isset($_POST['belt_no'])) {
    $subject_code = $_POST['subject'];
    $paper_no = $_POST['paper'];
    $attendance = $_POST['attendance'];
    $belt_no = $_POST['belt_no'];

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="attendance_register.csv"');

    // Open PHP output stream as "file"
    $output = fopen('php://output', 'w');

    // Add CSV headers
    fputcsv($output, ['Examiner Number', 'NRC', 'first Name','last name', 'No. of Days', 'Attendance', 'Subject Code', 'Subject Name', 'Paper No', 'Role','belt number', 'Account No', 'Bank', 'Branch']);

    if ($belt_no == 'all') {
        $sql = $db_12_gce->prepare('
            SELECT ex.examiner_number AS examiner_number,ex.nrc AS nrc, ex.first_name AS first_name,ex.last_name AS last_name, ex.no_of_days AS no_of_days,
                   CASE WHEN ex.attendance = 1 THEN "PRESENT" ELSE "NOT PRESENT" END AS attendance,
                   su.subject_code AS subject_code, su.subject_name AS subject_name,  pa.paper_no, ex.role AS role,
                   ex.belt_no AS belt_no,ex.account_no AS account_no, ex.bank AS bank, ex.branch AS branch
            FROM examiner ex
            INNER JOIN subjects su ON ex.subject_code = su.subject_code
            INNER JOIN paper pa ON su.subject_code = pa.subject_code
            WHERE ex.paper_no = pa.paper_no
              AND ex.subject_code = :subject_code
              AND ex.paper_no = :paper_no
              AND ex.attendance = :attendance
              AND ex.marking_centre = :marking_centre_code
        ');

        $sql->execute([
            ':subject_code' => $subject_code,
            ':paper_no' => $paper_no,
            ':attendance' => $attendance,
            ':marking_centre_code' => $_SESSION['marking_centre_code']
        ]);
    } else {
        $sql = $db_12_gce->prepare('
            SELECT ex.examiner_number AS examiner_number,ex.nrc AS nrc, ex.first_name, AS first_name,ex.last_name AS last_name, ex.no_of_days AS no_of_days,
                   CASE WHEN ex.attendance = 1 THEN "PRESENT" ELSE "NOT PRESENT" END AS attendance,
                   su.subject_code AS subject_code, su.subject_name AS subject_name,  pa.paper_no, ex.role AS role,
                   ex.belt_no AS belt_no, ex.account_no AS account_no, ex.bank AS bank, ex.branch AS branch
            FROM examiner ex
            INNER JOIN subjects su ON ex.subject_code = su.subject_code
            INNER JOIN paper pa ON su.subject_code = pa.subject_code
            WHERE ex.paper_no = pa.paper_no
              AND ex.subject_code = :subject_code
              AND ex.paper_no = :paper_no
              AND ex.attendance = :attendance
              AND ex.belt_no = :belt_no
              AND ex.marking_centre = :marking_centre_code
        ');

        $sql->execute([
            ':subject_code' => $subject_code,
            ':paper_no' => $paper_no,
            ':attendance' => $attendance,
            ':belt_no' => $belt_no,
            ':marking_centre_code' => $_SESSION['marking_centre_code']
        ]);
    }

    // Fetch rows and output as CSV
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $row);
    }

    fclose($output);
    exit();
}
?>
