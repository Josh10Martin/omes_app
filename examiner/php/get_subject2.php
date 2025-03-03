<?php

$subject_sql= $db_9->prepare('SELECT subject_code,subject_name FROM subjects');
$subject_sql->execute();

$subject_sql->bindColumn('subject_code',$subject_code);
$subject_sql->bindColumn('subject_name',$subject_name);
$subject_sql->fetch(PDO::FETCH_BOUND);
?>