<?php

$branch_sql= $db_9->prepare('SELECT id,name,bank_id FROM bankbranch');
$branch_sql->execute();

$branch_sql->bindColumn('id',$branch_id);
$branch_sql->bindColumn('name',$branch_name);
$branch_sql->bindColumn('bank_id',$bank_id);
$branch_sql->fetch(PDO::FETCH_BOUND);
?>