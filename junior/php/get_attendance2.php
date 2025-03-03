<?php

$attendance_sql= $db_9->prepare('SELECT id,name FROM attendance');
$attendance_sql->execute();

$attendance_sql->bindColumn('id',$attendance_id);
$attendance_sql->bindColumn('name',$attendance_name);
$attendance_sql->fetch(PDO::FETCH_BOUND);
?>