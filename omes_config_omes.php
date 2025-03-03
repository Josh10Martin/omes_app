<?php
$db_9 = new PDO('mysql:host=localhost;dbname=omes_9','root','1m0n%Mysql%',array(
        PDO::MYSQL_ATTR_LOCAL_INFILE => true,
));
$db_9->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db_12_gce = new PDO('mysql:host=localhost;dbname=omes_12_gce','root','1m0n%Mysql%',array(
        PDO::MYSQL_ATTR_LOCAL_INFILE => true,
));
$db_12_gce->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db_ted = new PDO('mysql:host=localhost;dbname=omes_ted','root','1m0n%Mysql%',array(
        PDO::MYSQL_ATTR_LOCAL_INFILE => true,
));
$db_ted->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>