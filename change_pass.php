<?php
session_start();
if(!isset($_SESSION['username'])){
  header('location: index.php');
}
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
            <h5>Password requirement</h5>
            <div class="row justify-content-left">
             
              <ul>
                <li> At least one lowercase letter</li>
                <li> At least one uppercase letter</li>
                <li>At least one digit</li>
                <li>At least one special character (@$!%*?&)</li>
                <li>Minimum length of 8 characters</li>

              </ul>
            </div>
          </div>
            <p class="lead text-center ">Change Password </p>
          <div class="row justify-content-center">
            <div class="account-box">
            <div class="dialog"></div>
            <div class="dialog1"></div>
                        <form action="#" id="form-change_password" autocomplete="off">
                          
                      
                                                    
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                              </div>
                              <input type="password" required class="form-control" id="password" name="password" placeholder="Current Password" >
                              <span id="toggleEye" class="fa fa-eye" style="z-index: 5;position:absolute; cursor:pointer; top:50%; transform:scale(1.2) translateY(-50%);right:0;"></span>
                            </div>
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                              </div>
                              <input type="password" required class="form-control" id="password1" name="password1" placeholder="New Password" >
                              
                            </div>
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                              </div>
                              <input type="hidden" name="username" value="<?php echo $_SESSION['username'] ?>">
                              <input type="password" required class="form-control" id="password2" name="password2" placeholder="Re-Type New Password" >
                            
                            </div>

                            
                        
                        
                            <div class="form-group">
                              <button type="submit" class="btn btn-primary btn-block">Change password</button>
                              <div class="load"></div>
                          </div>
                          <!-- <div class="form-group text-right">
                            <a href="forgot-password.php">Forgot your password?</a>
                        </div> -->
                            
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
                  location.href="index.php";
                    $(this).dialog('close');
                }
            }
        ]
    });
  $('.dialog1').dialog({
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

    $('#form-change_password').submit(function(e){
      e.preventDefault();

      $.ajax({
        url: 'php/change_password.php',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        beforeSend: function(){
          $('button[type=submit]').attr('disabled',true);
          $('.load').html('<img src="images/loading.gif" style="transform:scale(.7) translateY(-100%) translateX(-50%);left:50%;position:absolute;"/>');
        },
        success(data){
          if(data.status == '200'){
            $('button[type=submit]').attr('disabled',false);
            $('.load').html('');
            $('.dialog').text(data.response_msg+' You need to login with new password').dialog('open');
          }else{
            $('button[type=submit]').attr('disabled',false);
            $('.load').html('');
            $('.dialog1').text(data.response_msg).dialog('open');
          }
        }
      });

    });
    });

</script>
</html>