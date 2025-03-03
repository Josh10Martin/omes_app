<?php
session_start();

if($_SESSION['user_type'] == 'DEO'){
    include '../config.php';
    include '../functions.php';
    if($_SESSION['session_level'] == 9){

    }else if($_SESSION['session_level'] == 'TED'){
        logout($db_ted,$_SESSION['username']);
    }else{
        logout($db_12_gce,$_SESSION['username']);
    }
   
}
$_SESSION = array();

if(isset($_COOKIE[session_name()])){
    setcookie('session_name', '',time()-42000,'/');
}
session_destroy();
header('location:../');
?>