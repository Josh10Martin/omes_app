<?php

$bank_sql= $db_9->prepare('SELECT id,name FROM bank');
$bank_sql->execute();

$bank_sql->bindColumn('id',$bank_id);
$bank_sql->bindColumn('name',$bank_name);
$bank_sql->fetch(PDO::FETCH_BOUND);
?>