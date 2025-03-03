<?php

$role_sql= $db_ted->prepare('SELECT id,name FROM position');
$role_sql->execute();

$role_sql->bindColumn('id',$role_id);
$role_sql->bindColumn('name',$role_name);
$role_sql->fetch(PDO::FETCH_BOUND);
?>