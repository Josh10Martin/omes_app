<?php
include '../../config.php';
$date_time = date("d_m_Y_H_:_m_:_s");
$filename = 'audit_logs as of '.$date_time.'.csv';
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename='.$filename);
    header('Content-Type: application/csv ');

    $file = fopen('php://output', 'w');
    $fields = array('CENTRE CODE','EXAM NUMBER','SUBJECT CODE','PAPER NUMBER','OLD MARK','OLD STATUS','NEW MARK','NEW STATUS','SEN','IMPROVISED MARK','ACTIONED BY','ACTION','DATE ACTIONED','MARKING_CENTRE');
    fputcsv($file, $fields);
    if(isset($_POST['subject'])){
        $subject_code = $_POST['subject'];

        if($subject_code == 'all'){
            $sql = $db_12_gce->prepare('SELECT CONCAT(sc.centre_code," - ",sc.centre_name) AS centre_code,m.exam_no AS exam_no, CONCAT(su.subject_code," - ",su.subject_name) AS subject_code,pa.paper_no AS paper_no,m.old_mark AS old_mark,m.old_status AS old_status,m.new_mark AS new_mark,m.status AS new_status,
                                    CASE WHEN m.sen =1 THEN "YES" ELSE "NO" END AS sen, CASE WHEN m.improvised_mark =1 THEN "YES" ELSE "NO" END AS improvised_mark,
                                    m.entered_by AS entered_by,m.action AS action,m.date_entered AS date_entered,ce.name AS marking_centre
                                        FROM centre ce INNER JOIN school sc ON (ce.centre_type = sc.centre_type)
                                        INNER JOIN marks_audit_trail m ON (sc.centre_code = m.centre_code)
                                        INNER JOIN subjects su ON (m.subject_code = su.subject_code)
                                        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                                        WHERE ce.centre_code = m.marking_centre
                                        AND m.paper_no = pa.paper_no
                                        ORDER BY m.date_entered DESC');
    $sql->execute();
    $result = $sql->fetchAll();
    foreach($result as $row){
        $data = array();
        $data[] = $row['centre_code'];
        $data[] = $row['exam_no'];
        $data[] = $row['subject_code'];
        $data[] = $row['paper_no'];
        $data[] = $row['old_mark'];
        $data[] = $row['old_status'];
        $data[] = $row['new_mark'];
        $data[] = $row['new_status'];
        $data[] = $row['sen'];
        $data[] = $row['improvised_mark'];
        $data[] = $row['entered_by'];
        $data[] = $row['action'];
        $data[] = $row['date_entered'];
        $data[] = $row['marking_centre'];

        fputcsv($file, $data);
        
    }
    fclose($file);
    exit;
        }else{
            $paper_no = isset($_POST['paper']) ? $_POST['paper'] : '';
            $sql = $db_12_gce->prepare('SELECT CONCAT(sc.centre_code," - ",sc.centre_name) AS centre_code,m.exam_no AS exam_no, CONCAT(su.subject_code," - ",su.subject_name) AS subject_code,pa.paper_no AS paper_no,m.old_mark AS old_mark,m.old_status AS old_status,m.new_mark AS new_mark,m.status AS new_status,
                                    CASE WHEN m.sen =1 THEN "YES" ELSE "NO" END AS sen, CASE WHEN m.improvised_mark= 1 THEN "YES" ELSE "NO" END AS improvised_mark,
                                    m.entered_by AS entered_by,m.action AS action,m.date_entered AS date_entered,ce.name AS marking_centre
                                        FROM centre ce INNER JOIN school sc ON (ce.centre_type = sc.centre_type)
                                        INNER JOIN marks_audit_trail m ON (sc.centre_code = m.centre_code)
                                        INNER JOIN subjects su ON (m.subject_code = su.subject_code)
                                        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                                        WHERE ce.centre_code = m.marking_centre
                                        AND m.paper_no = pa.paper_no
                                        AND m.subject_code =:subject_code
                                        AND m.paper_no =:paper_no
                                        ORDER BY m.date_entered DESC');
    $sql->execute(array(
        ':subject_code'=>$subject_code,
        ':paper_no'=>$paper_no
    ));
    $result = $sql->fetchAll();
    foreach($result as $row){
        $data = array();
        $data[] = $row['centre_code'];
        $data[] = $row['exam_no'];
        $data[] = $row['subject_code'];
        $data[] = $row['paper_no'];
        $data[] = $row['old_mark'];
        $data[] = $row['old_status'];
        $data[] = $row['new_mark'];
        $data[] = $row['new_status'];
        $data[] = $row['sen'];
        $data[] = $row['improvised_mark'];
        $data[] = $row['entered_by'];
        $data[] = $row['action'];
        $data[] = $row['date_entered'];
        $data[] = $row['marking_centre'];

        fputcsv($file, $data);
        
    }
    fclose($file);
    exit;
        }


    }

    
?>