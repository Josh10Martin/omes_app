<?php
if(!isset($_SESSION['user_type']) && !isset($_SESSION['first_name']) && !isset($_SESSION['last_name'])){
    $user_type = '[UNKNOWN]';
    $session_type = '[UNKNOWN]';
}else{
    $user_type = $_SESSION['user_type'] == 'DEO' ? 'DATA ENTRY OPERATOR' : $_SESSION['user_type'];
    $session_type = $_SESSION['session_type'] == 'I' ? 'school certificate' : 'general certificate of education';

?>


<div class="header">
			<div class="header-left">
				<a href="index.php" class="logo">
					<img src="../assets/img/logo.jpg" class="rounded-circle" width="35" height="35" alt=""> <span>Marks Entry</span>
				</a>
			</div>
			<a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
            <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
            <h5 style="color:white; text-transform:uppercase; text-align:center; position:absolute;top:30%;left:50%; transform:translate(-50%,-50%);">session: <?php echo isset($_SESSION['session_name']) ? $_SESSION['session_year'].' '.$session_type.' '.$_SESSION['session_name'] : 'No Set Session'; ?></h5>
            <h6 style="color:white; text-transform:uppercase; text-align:center; position:absolute;top:70%;left:50%; transform:translate(-50%,-50%);"> <?php echo $_SESSION['user_type'] == 'ECZ' ? '' : (isset($_SESSION['marking_centre']) ? 'marking centre: '.$_SESSION['marking_centre'] : ''); ?></h6>
           
            
            
            <ul class="nav user-menu float-right">
              
             
                <li class="nav-item dropdown has-arrow">
                    <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                        <div class="d-flex flex-column p-0 m-0">
                            <div class="p-0 m-0 text-center" style="font-size:smaller;"><span class="status online"></span> Logged in as</div> 
                            <div class="p-0 m-0 text-center" style="font-size:small;"><?php echo $_SESSION['first_name'],' ',$_SESSION['last_name']; ?> [<?php echo $user_type; ?>]</div>
                        </div>
                        <!-- <span class="user-img">
                            <small>Loged in as</small>
							<span class="status online"></span>
						</span>
						<span>Admin</span> -->
                    </a>
					<div class="dropdown-menu">
						<!-- <a class="dropdown-item" href="profile.html">My Profile</a>
						<a class="dropdown-item" href="edit-profile.html">Edit Profile</a> -->
						<a class="dropdown-item" href="settings.php">Settings</a>
						<a class="dropdown-item" href="../index.php">Logout</a>
					</div>
                </li>
            </ul>
            <div class="dropdown mobile-user-menu float-right">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- <a class="dropdown-item" href="profile.html">My Profile</a>
                    <a class="dropdown-item" href="edit-profile.html">Edit Profile</a> -->
                    <a class="dropdown-item" href="settings.php">Settings</a>
                    <a class="dropdown-item" href="../index.php">Logout</a>
                </div>
            </div>
        </div>
  <?php
}

?>