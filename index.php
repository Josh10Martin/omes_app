<?php
include 'config.php';

$sql = $db_9->prepare('SELECT id,name,year,level,type FROM session');
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);
$sess_id = $row['id'] ?? '';
$session_name = $row['name'] ?? '';
$session_year = $row['year'] ?? '';
$session_level = $row['level'] ?? '';
$type = $row['type'] ?? '';

$sql2 = $db_12_gce->prepare('SELECT id,name,year,level,type FROM session');
$sql2->execute();
$row2 = $sql2->fetch(PDO::FETCH_ASSOC);
$sess_id_12_gce = $row2['id'] ?? '';
$session_name_12_gce = $row2['name'] ?? '';
$session_year_12_gce = $row2['year'] ?? '';
$session_level_12_gce = $row2['level'] ?? '';
$type_12_gce = $row2['type'] ?? '';

$sql3 = $db_ted->prepare('SELECT id,name,year,level FROM session');
$sql3->execute();
$row3 = $sql3->fetch(PDO::FETCH_ASSOC);
$sess_id_db_ted = $row3['id'] ?? '';
$session_name_db_ted = $row3['name'] ?? '';
$session_year_db_ted = $row3['year'] ?? '';
$session_level_db_ted = $row3['level'] ?? '';


?>


<!DOCTYPE html>
<html lang="en">


<!-- login23:11-->
<?php include 'includes/header.php'?>
<link rel="stylesheet" href="assets/css/login.css">

<body>
    <div class="main-wrapper account-wrapper">
        <div class="account-page">
          <div class="header-login">
            <div class="row justify-content-center">
              <div class="col-auto">
                <img class="logo ml-auto mr-auto" src="assets/img/eczlogo_tr.png" alt="Log">
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-auto"><h3 class="lead text-center text-primary">Examinations Council of Zambia</h3></div> 
            </div>
          </div>
            <p class="lead text-center ">OMES Login </p>
          <div class="row justify-content-center">
            <div class="account-box">
            <div class="dialog"></div>
                        <form action="#" class="form-signin" autocomplete="off">
                          
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                              </div>
                              <input type="text" required class="form-control" placeholder="Username" name="username" autofocus>
                            </div>
                                                    
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                              </div>
                              <input type="password" required class="form-control" id="password" name="password" placeholder="Password" >
                              <span id="toggleEye" class="fa fa-eye" style="z-index: 5;position:absolute; cursor:pointer; top:50%; transform:scale(1.2) translateY(-50%);right:0;"></span>
                            </div>

                            <!-- <label for="">SELECT LEVEL:</label> -->
                            <div class="input-group mb-3">
                              
                              <select name="level" id="" class="form-control" required>
                                <option value="" selected>SELECT LEVEL</option>
                                <option value="9">G9 INTERNAL / EXTERNAL</option>
                                <option value="12">G12 / GCE</option>
                                <option value="ted">TEACHER EDUCATION</option>

                              </select>
                            </div>
                          <input type="hidden" name="sess_id" value="<?php echo $sess_id; ?>">
                          <input type="hidden" name="session_name" value="<?php echo $session_name; ?>">
                          <input type="hidden" name="session_year" value="<?php echo $session_year; ?>">
                          <input type="hidden" name="session_level" value="<?php echo $session_level; ?>">
                          <input type="hidden" name="session_type" value="<?php echo $type; ?>">

                          <input type="hidden" name="sess_id_12_gce" value="<?php echo $sess_id_12_gce; ?>">
                          <input type="hidden" name="session_name_12_gce" value="<?php echo $session_name_12_gce; ?>">
                          <input type="hidden" name="session_year_12_gce" value="<?php echo $session_year_12_gce; ?>">
                          <input type="hidden" name="session_level_12_gce" value="<?php echo $session_level_12_gce; ?>">
                          <input type="hidden" name="session_type_12_gce" value="<?php echo $type_12_gce; ?>">

                          <input type="hidden" name="sess_id_db_ted" value="<?php echo $sess_id_db_ted; ?>">
                          <input type="hidden" name="session_name_db_ted" value="<?php echo $session_name_db_ted; ?>">
                          <input type="hidden" name="session_year_db_ted" value="<?php echo $session_year_db_ted; ?>">
                          <input type="hidden" name="session_level_db_ted" value="<?php echo $session_level_db_ted; ?>">
                          
                            
                            <div class="form-group">
                              <button type="submit" class="btn btn-primary btn-block">Login</button>
                              <div class="load"></div>
                          </div>
                          <!-- <p>Forgot password? click <a href="forgot_password.php">here</a></p> -->
                          <div class="form-group text-right">
                            <a href="forgot-password.php">Forgot your password?</a> (Grade 9 only)
                        </div>
                            
                        </form>
                    </div>
          </div>
        </div>
<div class="footer light p-1 border-top border-primary" >
  <footer>
    <p class="text-center">
      <span class="text-center">Copyright &copy; <script>document.write(new Date().getFullYear())</script> Examinations Council of Zambia</span>  <span>OMES v.1</span> 
    </p>
  </footer>
</div>
        
       
    </div>
    <?php include 'includes/scripts.php' ?>

</body>
<script type="text/javascript">
$(document).ready(function(){
  $('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        // appendTo: '#add-admin',
        autoOpen: false,
        create: function(e){
            $(e.target).parent().css({
                'position':'fixed'
            }); 
            
        },
        buttons: [
            // {
            //     text: 'login',
            //     click: function(){
            //         location.href="/orvs";
            //     }
            // },
            {
                text: 'OK',
                click: function(){
                    $(this).dialog('close');
                }
            }
        ]
    });

    $('#toggleEye').click(function(){
      var fieldType = $('input[type=password]').attr('type');
      if(fieldType === 'password'){
        $('#password').attr('type','text');
        $("#toggleEye").removeClass('fa-eye').addClass('fa-eye-slash');

      }else{
        $('#password').attr('type','password');
        $("#toggleEye").removeClass('fa-eye-slash').addClass('fa-eye');
      }
    });

    $('.form-signin').submit(function(e){
      e.preventDefault();
      var level = $('select[name=level]').val();
      if(level == '9'){
      $.ajax({
        url: 'php/login.php',
        method: 'POST',
        data: $('.form-signin').serialize(),
        dataType: 'json',
        beforeSend: function(){
          $('button[type=submit]').attr('disabled',true);
          $('.load').html('<img src="images/loading.gif" style="transform:scale(.7) translateY(-100%) translateX(-50%);left:50%;position:absolute;"/>');
        },
        success:function(data){
          if(data.status == '200'){
            
              
              if(data.first_login == 'true'){
                location.href="change_pass.php";
              }else{
                location.href="junior/";
              }
              
           
            
          }else{
            $('.dialog').text(data.response_msg).dialog('open');
            $('button[type=submit]').attr('disabled',false);
            $('.load').html('');
          }
        }
      });
    }else if(level == '12'){
        var username = $('input[type=text][name=username]').val(),
            password = $('input[id=password][name=password]').val(),
            session_id = $('input[type=hidden][name=sess_id_12_gce]').val(),
            session_name = $('input[type=hidden][name=session_name_12_gce]').val(),
            session_type = $('input[type=hidden][name=session_type_12_gce]').val(),
            session_year = $('input[type=hidden][name=session_year_12_gce]').val(),
            session_level = $('input[type=hidden][name=session_level_12_gce]').val();
        $.ajax({
        // url: 'http://localhost:8000/api/auth-user/api-ems/',
        url: 'https://ems.exams-council.org.zm:8080/api/auth-user/api-ems/',
        //  url: 'http://192.9.200.124:8000/api/auth-user/api-ems/',
          method: 'POST',
          dataType: 'json',
          data: {username:username,password:password},
          beforeSend: function(){
          $('button[type=submit]').attr('disabled',true);
          $('.load').html('<img src="images/loading.gif" style="transform:scale(.7) translateY(-100%) translateX(-50%);left:50%;position:absolute;"/>');
        },
        success:function(data){
          if(data.status == '400'){
            $('.dialog').html('<span class="font-weight:900;"> Message from EMS: </span>'+data.message).dialog('open');
            $('button[type=submit]').attr('disabled',false);
            $('.load').html('');
          }else{
            console.log("data",data)
            start_session(data.username,data.first_name,data.last_name,data.user_type,data.marking_centre_name,data.subject_code,data.subject_name,data.paper_number,session_id,session_name,session_level,session_type,session_year);
          }
        }
        });
      }else{
        var username = $('input[type=text][name=username]').val(),
            password = $('input[id=password][name=password]').val(),
            session_id = $('input[type=hidden][name=sess_id_db_ted]').val(),
            session_name = $('input[type=hidden][name=session_name_db_ted]').val(),
           
            session_year = $('input[type=hidden][name=session_year_db_ted]').val(),
            session_level = $('input[type=hidden][name=session_level_db_ted]').val();
        $.ajax({
        // url: 'http://localhost:8000/api/auth-user/api-ems/',
        url: 'https://ems.exams-council.org.zm:8080/api/ted/auth/user/',
        //  url: 'http://192.9.200.124:8000/api/auth-user/api-ems/',
          method: 'POST',
          dataType: 'json',
          data: {username:username,password:password},
          beforeSend: function(){
          $('button[type=submit]').attr('disabled',true);
          $('.load').html('<img src="images/loading.gif" style="transform:scale(.7) translateY(-100%) translateX(-50%);left:50%;position:absolute;"/>');
        },
        success:function(data){
          if(data.status == '400'){
            $('.dialog').html('<span class="font-weight:900;"> Message from EMS (TED): </span>'+data.message).dialog('open');
            $('button[type=submit]').attr('disabled',false);
            $('.load').html('');
          }else{
            console.log("data",data)
            start_session(data.username,data.first_name,data.last_name,data.user_type,data.marking_centre_name,data.subject_code,data.subject_name,data.paper_number,session_id,session_name,session_level,session_year);
          }
        }
        });
      }
    });
    
    function start_session(username,first_name,last_name,user_type,marking_centre_name,subject_code,subject_name,paper_number,session_id,session_name,session_level,session_type = null,session_year){

  if(session_level != 'TED'){
      $.ajax({
    url: 'php/g12_gce_start_session.php',
    method: 'POST',
    dataType: 'json',
    data: {username:username,first_name:first_name,last_name:last_name,user_type:user_type,marking_centre_name:marking_centre_name,subject_code:subject_code,subject_name:subject_name,paper_number:paper_number,session_id:session_id,session_name:session_name,session_level:session_level,session_type:session_type,session_year:session_year},
    success: function(data){
      if(data.status == '200'){
        location.href="examiner/";
      }else{
        $('.dialog').text(data.response_msg).dialog('open');
            $('button[type=submit]').attr('disabled',false);
            $('.load').html('');
      }
    }
  });
}else{
  $.ajax({
    url: 'php/ted_start_session.php',
    method: 'POST',
    dataType: 'json',
    data: {username:username,first_name:first_name,last_name:last_name,user_type:user_type,marking_centre_name:marking_centre_name,subject_code:subject_code,subject_name:subject_name,paper_number:paper_number,session_id:session_id,session_name:session_name,session_level:session_level,session_year:session_year},
    success: function(data){
      if(data.status == '200'){
        location.href="ted/";
      }else{
        $('.dialog').text(data.response_msg).dialog('open');
            $('button[type=submit]').attr('disabled',false);
            $('.load').html('');
      }
    }
  });
}
} 

});

</script>
</html>