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
            <p class="lead text-center ">EMIS Login </p>
          <div class="row justify-content-center">
            <div class="account-box">
                        <form action="index.php" class="form-signin">
                           
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">@</span>
                              </div>
                              <input type="text" required class="form-control" placeholder="username" >
                            </div>
                                                    
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">@</span>
                              </div>
                              <input type="password" required class="form-control" placeholder="Password" >
                            </div>

                            
                            <div class="form-group">
                              <button type="submit" class="btn btn-primary btn-block">Login</button>
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

</html>