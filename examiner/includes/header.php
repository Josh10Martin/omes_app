<?php

if(!isset($_SESSION['user_type'])){
  $_SESSION['user_type'] = '[UNKNOWN]';
}
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/icon.ico">
    <title>Online Marks Entry System</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <!-- <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> -->
    <title>Reports - Centers_in_belt</title>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> -->

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <!-- <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css"> -->
    <link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-toggle.min.css">

    <link rel="stylesheet" type="text/css" href="../assets/css/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/jquery-ui.structure.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/jquery-ui.theme.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet"> -->
    <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js" integrity="sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY=" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <style>
      .ui-dialog .ui-dialog-buttonpane{
        height: 50px;
        padding: 0 50%;
      }
      .ui-dialog .ui-dialog-buttonpane .ui-dialog-buttonset{
        position:absolute;
        /* left:50%;
        transform: translateX(-50%); */
        

      }
      .ui-dialog .ui-dialog-buttonpane button{
        left:50%;
        transform: translateX(-100%);
       
      }
      .ui-dialog .ui-dialog-content{
        height:auto !important;
        text-align:center;
      }
      .ui-dialog .ui-dialog-titlebar{
        text-align:center;
      }
      .ui-dialog .ui-dialog-titlebar-close{
        display:none;
      }
      .bg_att{
        background-color: yellow;
      }
    </style>
</head>