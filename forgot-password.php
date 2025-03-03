<?php


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
            <p class="lead text-center ">Forgot Password? </p>
          <div class="row justify-content-center">
            <div class="account-box">
            <div class="dialog"></div>
                        <form action="#" id="form-forgot-password" autocomplete="off">
                          
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                              </div>
                              <input type="email" required class="form-control" placeholder="email address" name="email" autofocus>
                            </div>
                                                    
                         

                        
                            <div class="form-group">
                              <button type="submit" class="btn btn-primary btn-block">Submit</button>
                              <div class="load"></div>
                              <div class="feedback"></div>
                          </div>
                         
                          <div class="form-group text-left">
                            <a href="index.php">Login
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
                        location.reload();
                    $(this).dialog('close');
                }
            }
        ]
    });

   $('#form-forgot-password').submit(function(e){

        e.preventDefault();
        $.ajax({
                url: 'php/forgot-password.php',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function(){
                        $('button[type=submit]').attr('disabled',true);
                        $('.load').html('<img src="images/loading.gif" style="transform:scale(.7) translateY(-100%) translateX(-50%);left:50%;position:absolute;"/>');
                },
                success:function(data){
                        
                        if(data.status == '200'){
                                send_reset_email(data.email,data.first_name,data.last_name,data.username);
                        }else{
                                $('button[type=submit]').attr('disabled',false);
                                $('.load').html('');
                                $('.dialog').text(data.response_msg).dialog('open');
                        }
                }
        });
   });

function send_reset_email(email,first_name,last_name,username){
        $.ajax({
                // url: 'php/send_reset_email.php',
                url: 'https://verify.exams-council.org.zm/orvs/send_reset_email.php',
                method: 'POST',
                data: {email:email,first_name:first_name,last_name:last_name,username:username},
                dataType: 'json',
                eforeSend: function(){
                        $('.feedback').text('Sending email. Please wait...');
                },
                success: function(data){
                        $('.feedback').text('');
                        $('button[type=submit]').attr('disabled',false);
                        $('.load').html('');
                        if(data,status == '200'){
                                $('#form-forgot-password').trigger('reset');
                                $('input[type=email]').val('');
                                $('.dialog').text(data.response_msg).dialog('open');
                        }else{
                                $('.dialog').text(data.response_msg).dialog('open');
                        }
                }

        });
}
    
  

});

</script>
</html>