<?php
include '../../config.php';
$date_time = date("d_m_Y_H_:_m_:_s");
$filename = 'audit_logs as of '.$date_time.'.csv';
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename='.$filename);
    header('Content-Type: application/csv ');

    $file = fopen('php://output', 'w');
    $fields = array('CENTRE CODE','EXAM NUMBER','SUBJECT CODE','PAPER NUMBER','OLD MARK','OLD STATUS','NEW MARK','NEW STATUS','SEN','IMPROVISED MARK','ACTIONED BY','ACTION','DATE ACTIONED','MARKING_CENTRE','PROVINCE');
    fputcsv($file, $fields);
    if(isset($_POST['province'])){
        $province_code = explode(':',$_POST['province'])[0];
        $marking_centre_code = isset($_POST['marking_centre']) ? $_POST['marking_centre'] : '';
        $centre_code = isset($_POST['centre_code']) ? $_POST['centre_code'] : '';
        $subject_code = isset($_POST['subject']) ? $_POST['subject'] : '';
        $paper_no = isset($_POST['paper']) ? $_POST['paper'] : '';
        global $sql;
        if($province_code == 'all'){
            $sql = $db_9->prepare('SELECT CONCAT(sc.centre_code," - ",sc.centre_name) AS centre_code,m.exam_no AS exam_no, CONCAT(su.subject_code," - ",su.subject_name) AS subject_code,pa.paper_no AS paper_no,m.old_mark AS old_mark,m.old_status AS old_status,m.new_mark AS new_mark,m.status AS new_status,
                                    CASE WHEN m.sen =1 THEN "YES" ELSE "NO" END AS sen, CASE WHEN m.improvised_mark =1 THEN "YES" ELSE "NO" END AS improvised_mark,
                                    m.entered_by AS entered_by,m.action AS action,m.date_entered AS date_entered,ce.name AS marking_centre,p.p_name AS province
                                        FROM province p INNER JOIN centre ce ON (p.p_code = ce.province)
                                        INNER JOIN school sc ON (ce.centre_type = sc.centre_type)
                                        INNER JOIN marks_audit_trail m ON (sc.centre_code = m.centre_code)
                                        INNER JOIN subjects su ON (m.subject_code = su.subject_code)
                                        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                                        WHERE ce.centre_code = m.marking_centre
                                        AND p.p_code = sc.province
                                        AND p.p_code = m.province
                                        AND m.paper_no = pa.paper_no
                                        AND m.subject_code = pa.subject_code
                                        AND ce.centre_code = m.marking_centre
                                        AND sc.province = ce.province
                                        AND m.province = sc.province
                                        AND m.province = ce.province
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
        $data[] = $row['province'];

        fputcsv($file, $data);
        
    }
    fclose($file);
    exit;
        

    }else{
        if($marking_centre_code == 'all'){
            $sql = $db_9->prepare('SELECT CONCAT(sc.centre_code," - ",sc.centre_name) AS centre_code,m.exam_no AS exam_no, CONCAT(su.subject_code," - ",su.subject_name) AS subject_code,pa.paper_no AS paper_no,m.old_mark AS old_mark,m.old_status AS old_status,m.new_mark AS new_mark,m.status AS new_status,
                                    CASE WHEN m.sen =1 THEN "YES" ELSE "NO" END AS sen, CASE WHEN m.improvised_mark =1 THEN "YES" ELSE "NO" END AS improvised_mark,
                                    m.entered_by AS entered_by,m.action AS action,m.date_entered AS date_entered,ce.name AS marking_centre,p.p_name AS province
                                        FROM province p INNER JOIN centre ce ON (p.p_code = ce.province)
                                        INNER JOIN school sc ON (ce.centre_type = sc.centre_type)
                                        INNER JOIN marks_audit_trail m ON (sc.centre_code = m.centre_code)
                                        INNER JOIN subjects su ON (m.subject_code = su.subject_code)
                                        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                                        WHERE ce.centre_code = m.marking_centre
                                        AND p.p_code = sc.province
                                        AND p.p_code = m.province
                                        AND m.paper_no = pa.paper_no
                                        AND m.subject_code = pa.subject_code
                                        AND ce.centre_code = m.marking_centre
                                        AND sc.province = ce.province
                                        AND m.province = sc.province
                                        AND m.province = ce.province
                                        AND p.p_code =:province_code
                                        ORDER BY m.date_entered DESC');
    $sql->execute(array(
        ':province_code'=>$province_code
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
        $data[] = $row['province'];

        fputcsv($file, $data);
        
    }
    fclose($file);
    exit;
            
        }else{
            if($centre_code == 'all'){
            $sql = $db_9->prepare('SELECT CONCAT(sc.centre_code," - ",sc.centre_name) AS centre_code,m.exam_no AS exam_no, CONCAT(su.subject_code," - ",su.subject_name) AS subject_code,pa.paper_no AS paper_no,m.old_mark AS old_mark,m.old_status AS old_status,m.new_mark AS new_mark,m.status AS new_status,
                                    CASE WHEN m.sen =1 THEN "YES" ELSE "NO" END AS sen, CASE WHEN m.improvised_mark =1 THEN "YES" ELSE "NO" END AS improvised_mark,
                                    m.entered_by AS entered_by,m.action AS action,m.date_entered AS date_entered,ce.name AS marking_centre,p.p_name AS province
                                        FROM province p INNER JOIN centre ce ON (p.p_code = ce.province)
                                        INNER JOIN school sc ON (ce.centre_type = sc.centre_type)
                                        INNER JOIN marks_audit_trail m ON (sc.centre_code = m.centre_code)
                                        INNER JOIN subjects su ON (m.subject_code = su.subject_code)
                                        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                                        WHERE ce.centre_code = m.marking_centre
                                        AND p.p_code = sc.province
                                        AND p.p_code = m.province
                                        AND m.paper_no = pa.paper_no
                                        AND m.subject_code = pa.subject_code
                                        AND ce.centre_code = m.marking_centre
                                        AND sc.province = ce.province
                                        AND m.province = sc.province
                                        AND m.province = ce.province
                                        AND p.p_code =:province_code
                                        AND ce.centre_code =:marking_centre_code
                                        ORDER BY m.date_entered DESC');
    $sql->execute(array(
        ':province_code'=>$province_code,
        ':marking_centre_code'=>$marking_centre_code
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
        $data[] = $row['province'];

        fputcsv($file, $data);
        
    }
    fclose($file);
    exit;
        }else{
            if($subject_code == 'all'){
                $sql = $db_9->prepare('SELECT CONCAT(sc.centre_code," - ",sc.centre_name) AS centre_code,m.exam_no AS exam_no, CONCAT(su.subject_code," - ",su.subject_name) AS subject_code,pa.paper_no AS paper_no,m.old_mark AS old_mark,m.old_status AS old_status,m.new_mark AS new_mark,m.status AS new_status,
                                    CASE WHEN m.sen =1 THEN "YES" ELSE "NO" END AS sen, CASE WHEN m.improvised_mark =1 THEN "YES" ELSE "NO" END AS improvised_mark,
                                    m.entered_by AS entered_by,m.action AS action,m.date_entered AS date_entered,ce.name AS marking_centre,p.p_name AS province
                                        FROM province p INNER JOIN centre ce ON (p.p_code = ce.province)
                                        INNER JOIN school sc ON (ce.centre_type = sc.centre_type)
                                        INNER JOIN marks_audit_trail m ON (sc.centre_code = m.centre_code)
                                        INNER JOIN subjects su ON (m.subject_code = su.subject_code)
                                        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                                        WHERE ce.centre_code = m.marking_centre
                                        AND p.p_code = sc.province
                                        AND p.p_code = m.province
                                        AND m.paper_no = pa.paper_no
                                        AND m.subject_code = pa.subject_code
                                        AND ce.centre_code = m.marking_centre
                                        AND sc.province = ce.province
                                        AND m.province = sc.province
                                        AND m.province = ce.province
                                        AND p.p_code =:province_code
                                        AND ce.centre_code =:marking_centre_code
                                        AND sc.centre_code =:centre_code
                                        ORDER BY m.date_entered DESC');
    $sql->execute(array(
        ':province_code'=>$province_code,
        ':marking_centre_code'=>$marking_centre_code,
        ':centre_code'=>$centre_code
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
        $data[] = $row['province'];

        fputcsv($file, $data);
        
    }
    fclose($file);
    exit;
            }else{
                if($paper_no == 'all'){
                    $sql = $db_9->prepare('SELECT CONCAT(sc.centre_code," - ",sc.centre_name) AS centre_code,m.exam_no AS exam_no, CONCAT(su.subject_code," - ",su.subject_name) AS subject_code,pa.paper_no AS paper_no,m.old_mark AS old_mark,m.old_status AS old_status,m.new_mark AS new_mark,m.status AS new_status,
                                    CASE WHEN m.sen =1 THEN "YES" ELSE "NO" END AS sen, CASE WHEN m.improvised_mark =1 THEN "YES" ELSE "NO" END AS improvised_mark,
                                    m.entered_by AS entered_by,m.action AS action,m.date_entered AS date_entered,ce.name AS marking_centre,p.p_name AS province
                                        FROM province p INNER JOIN centre ce ON (p.p_code = ce.province)
                                        INNER JOIN school sc ON (ce.centre_type = sc.centre_type)
                                        INNER JOIN marks_audit_trail m ON (sc.centre_code = m.centre_code)
                                        INNER JOIN subjects su ON (m.subject_code = su.subject_code)
                                        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                                        WHERE ce.centre_code = m.marking_centre
                                        AND p.p_code = sc.province
                                        AND p.p_code = m.province
                                        AND m.paper_no = pa.paper_no
                                        AND m.subject_code = pa.subject_code
                                        AND ce.centre_code = m.marking_centre
                                        AND sc.province = ce.province
                                        AND m.province = sc.province
                                        AND m.province = ce.province
                                        AND p.p_code =:province_code
                                        AND ce.centre_code =:marking_centre_code
                                        AND sc.centre_code =:centre_code
                                        AND su.subject_code =:subject_code
                                        ORDER BY m.date_entered DESC');
    $sql->execute(array(
        ':province_code'=>$province_code,
        ':marking_centre_code'=>$marking_centre_code,
        ':centre_code'=>$centre_code,
        ':subject_code'=>$subject_code
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
        $data[] = $row['province'];

        fputcsv($file, $data);
        
    }
    fclose($file);
    exit;
                }else{
                    
                    $sql = $db_9->prepare('SELECT CONCAT(sc.centre_code," - ",sc.centre_name) AS centre_code,m.exam_no AS exam_no, CONCAT(su.subject_code," - ",su.subject_name) AS subject_code,pa.paper_no AS paper_no,m.old_mark AS old_mark,m.old_status AS old_status,m.new_mark AS new_mark,m.status AS new_status,
                                    CASE WHEN m.sen =1 THEN "YES" ELSE "NO" END AS sen, CASE WHEN m.improvised_mark =1 THEN "YES" ELSE "NO" END AS improvised_mark,
                                    m.entered_by AS entered_by,m.action AS action,m.date_entered AS date_entered,ce.name AS marking_centre,p.p_name AS province
                                        FROM province p INNER JOIN centre ce ON (p.p_code = ce.province)
                                        INNER JOIN school sc ON (ce.centre_type = sc.centre_type)
                                        INNER JOIN marks_audit_trail m ON (sc.centre_code = m.centre_code)
                                        INNER JOIN subjects su ON (m.subject_code = su.subject_code)
                                        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                                        WHERE ce.centre_code = m.marking_centre
                                        AND p.p_code = sc.province
                                        AND p.p_code = m.province
                                        AND m.paper_no = pa.paper_no
                                        AND m.subject_code = pa.subject_code
                                        AND ce.centre_code = m.marking_centre
                                        AND sc.province = ce.province
                                        AND m.province = sc.province
                                        AND m.province = ce.province
                                        AND p.p_code =:province_code
                                        AND ce.centre_code =:marking_centre_code
                                        AND sc.centre_code =:centre_code
                                        AND su.subject_code =:subject_code
                                        AND pa.paper_no =:paper_no
                                        ORDER BY m.date_entered DESC');
    $sql->execute(array(
        ':province_code'=>$province_code,
        ':marking_centre_code'=>$marking_centre_code,
        ':centre_code'=>$centre_code,
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
        $data[] = $row['province'];

        fputcsv($file, $data);
        
    }
    fclose($file);
    exit;
                }
            }
        }
        }
    }
   

}
?>