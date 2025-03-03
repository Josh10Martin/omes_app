<!DOCTYPE html>
<html lang="en">


<!-- login23:11-->
<?php include 'includes/header.php'?>
<link rel="stylesheet" href="../assets/css/login.css">

<body>
    <div class="main-wrapper account-wrapper">
        <div class="account-page">
          <div class="header-login">
            <div class="row justify-content-center">
              <div class="col-auto">
                <img class="logo ml-auto mr-auto" src="../assets/img/eczlogo_tr.png" alt="Log">
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
                              <input type="text" required class="form-control" placeholder="username" name="username" autofocus>
                            </div>
                                                    
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                              </div>
                              <input type="password" required class="form-control" name="password" placeholder="Password" >
                            </div>

                            <label for="">SELECT LEVEL:</label>
                            <div class="input-group mb-3">
                              
                              <select name="level" id="" class="form-control" required>
                                <option value="" selected>choose level</option>
                                <option value="9">G9 INTERNAL / EXTERNAL</option>
                                <option value="12">G12 / GCE</option>

                              </select>
                            </div>

                            
                            <div class="form-group">
                              <button type="submit" class="btn btn-primary btn-block">Login</button>
                              <div class="load"></div>
                          </div>
                          <div class="form-group text-right">
                            <a href="forgot-password.php">Forgot your password?</a>
                        </div>
                            
                        </form>
                    </div>
          </div>
        </div>
<div class="footer light p-1 border-top border-primary" >
  <footer>
    <p class="text-center">
      <span class="text-center">Copyright &copy; <script>document.write(new Date().getFullYear())</script> Examinations Council of Zambia</span>  <span>emis-web v.1</span> 
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

    $('.form-signin').submit(function(e){
      e.preventDefault();
      $.ajax({
        url: 'php/login.php',
        method: 'POST',
        data: $('.form-signin').serialize(),
        dataType: 'json',
        beforeSend: function(){
          $('button[type=submit]').attr('disabled',true);
          $('.load').html('<img src="../images/loading.gif" style="transform:scale(.7) translateY(-100%) translateX(-50%);left:50%;position:absolute;"/>');
        },
        success:function(data){
          if(data.status == '200'){
            location.href="./";
          }else{
            $('.dialog').text(data.response_msg).dialog('open');
            $('button[type=submit]').attr('disabled',false);
            $('.load').html('');
          }
        }
      });
     });

});
</script>
</html>