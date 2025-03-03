<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();

if(isset($_FILES['myFile']['name'])){
    $path = $_FILES['myFile']['tmp_name'];
    
    function getUploadCount($db, $file) {
        global $data_array;
        try {
            $sql = $db->prepare('LOAD DATA LOCAL INFILE :path INTO TABLE marks_temp
                                CHARACTER SET latin1
                                FIELDS TERMINATED BY ","
                                OPTIONALLY ENCLOSED BY \'"\' 
                                ESCAPED BY \'"\' 
                                LINES TERMINATED BY "\r\n"
                                (centre_code, exam_no, first_name, last_name, subject_code, paper_no, mark, status, sen)');
            $sql->execute(array(':path' => $file));
            return $sql->rowCount();
        } catch (PDOException $e) {
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'There was a loading error: ' . $e->getMessage();
            echo json_encode($data_array);
            exit();
        }
    }
////////////////////////////////////

    function getRowcount($db){
        $sql = $db->prepare('SELECT COUNT(*) AS no_of_rows FROM marks');
        $sql->execute();
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $no_of_rows = $row['no_of_rows'] ?? '0';
        return $no_of_rows; 
        
    }
    function insertIntoMarks($db, $uploadedRows) {
        global $data_array;
        try {
            $initialCount = getRowcount($db);
            $sql = $db->prepare('INSERT IGNORE INTO marks
                                SELECT * FROM marks_temp');
            $sql->execute();
            $finalCount = getRowcount($db);

            $successfulRows = $finalCount - $initialCount;
            $rejectedRows = $uploadedRows - $successfulRows;

            if ($successfulRows == 0) {
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'No new rows have been inserted';
            } else {
                $data_array['status'] = '200';
                $data_array['inserted_rows'] = $successfulRows;
                $data_array['rejected_rows'] = $rejectedRows;
                $_SESSION['inserted_rows'] = $successfulRows;
                $_SESSION['rejected_rows'] = $rejectedRows;
                append_0($db);
            }
        } catch (PDOException $e) {
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'There was an error: ' . $e->getMessage();
        }
    }


    $uploadedRows = getUploadCount($db_9, $path);
    insertIntoMarks($db_9, $uploadedRows);

}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'File name not set. Reload and try again';
}
echo json_encode($data_array);
?>