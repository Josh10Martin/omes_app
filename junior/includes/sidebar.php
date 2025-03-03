<?php
if(!isset($_SESSION['user_type']) && !isset($_SESSION['first_name']) && !isset($_SESSION['last_name'])){
    $user_type = '[UNKNOWN]';
}else{
    $user_type = $_SESSION['user_type'] == 'DEO' ? 'DATA ENTRY OPERATOR' : $_SESSION['user_type'];

?>

<div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title">Main</li>
                        <li class="active">
                            <a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                            
                        </li>



                        <?php
                          if($_SESSION['user_type']  == 'SESO' || $_SESSION['user_type']  == 'ECZ'|| $_SESSION['user_type']  == 'ADMIN'){
                            ?>
                        <li class="submenu">
                            <a href="javascript:void(0)"><i class="fa fa-user-circle"></i> <span>Profile</span><span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                            <li><a href="change_user_password.php"> Change Password</a></li>
								<!-- <li><a href="javascript:void(0)"> Other</a></li> -->
							</ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0)"><i class="fa fa-user-circle"></i> <span>Users</span><span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                            <?php
                          if($_SESSION['user_type']  == 'SESO'){
                            ?>
                                <li><a href="admins.php"> ADMIN</a></li>
                            <?php
                           }
                           if($_SESSION['user_type']  == 'ADMIN'){
                            ?>
                                <li><a href="deo_users.php"> DEO</a></li>
                            <?php
                           }
                           
                          if($_SESSION['user_type']  == 'ECZ'){
                            ?>
								<li><a href="sessos.php"> Seso and ECZ</a></li>
								<li><a href="admins_deo.php"> Admin and DEO's</a></li>
                            <?php
                          }
                            ?>
								<!-- <li><a href="javascript:void(0)"> Other</a></li> -->
							</ul>
                        </li>
                        <?php
                          }
                          ?>


<?php
                                if($_SESSION['user_type']  == 'ADMIN' || $_SESSION['user_type'] == 'DEO'){
                            ?>
						<li class="submenu">
                            <a href="examiners.php"><i class="fa fa-id-card"></i> <span>Examiners</span><span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                            
                            <li><a href="examiners.php"> Examiners</a></li>
                            <li><a href="transcribers.php"> Transcribers</a></li>
							 	<!-- <li><a href="belt_examiners.php"> Belt Examiners</a></li>
							 	<li><a href="belted_examiners.php"> Belted Examiners</a></li> -->
							</ul>
                        </li>

                        <?php
                                }
                           
                        if($_SESSION['user_type']  == 'DEO'){
                        ?>
                        <li class="submenu">
                            <a href="examiners.php"><i class="fa fa-list-alt"></i> <span>Marks Entry</span><span class="menu-arrow"></span></a>
                            <ul style="display: none;">
								<li><a href="marks_entry_by_center.php"> By Center</a></li>
								<li><a href="marks_entry_by_improvised.php"> Improvised</a></li>
                               
							</ul>
                        </li>
                        <?php
                        }
                        ?>
                           <?php
                           
                           if($_SESSION['user_type']  == 'SESO'){
                             ?>
                         <li class="submenu">
                             <a href="javascript:void(0)"><i class="fa fa-university"></i> <span>Marking Centres</span><span class="menu-arrow"></span></a>
                             <ul style="display: none;">
                                 <li><a href="marking-centers.php">Marking Centres List</a></li>
                                 <li><a href="unapportioned.php">Unapportioned Examination Ccentres <?php if($_SESSION['session_type'] == 'I'){echo '/ Subjects';} ?></a></li>
                                 <li><a href="<?php if($_SESSION['session_type'] == 'E'){echo 'alter-marksheet-external.php';}else{echo 'alter-marksheet-internal.php';} ?>">Alter marksheet</a></li>
                                 <!-- <li><a href="subject_apportionment_internal.php">Marking Centre Internal</a></li> -->
                                 <!-- <li><a href="marking-center-apportionment.php"> Marking Apportionments</a></li> -->
                                 <!-- <li><a href="javascript:void(0)"> Other</a></li> -->
                             </ul>
                         </li>
                         <?php
                           }
                                if($_SESSION['user_type']  == 'ADMIN' || $_SESSION['user_type']  == 'SESO' || $_SESSION['user_type']  == 'DEO'){
                                    if($_SESSION['user_type']  == 'ADMIN'){
                            ?>
                         <li>
                            <a href="apportionments.php"><i class="fa fa-cubes"></i> <span>Apportionments</span></a>
                        </li>
                        <?php } ?>
                        <li>
                            <a href="search.php"><i class="fa fa-search"></i> <span>Search Marksheet</span></a>
                        </li>
                        <?php
                                }
                        ?>
                        <li>
                            <!-- <a href="Marksheets.php"><i class="fa fa-calendar"></i> <span>Marksheets</span></a> -->
                        </li>
                       
                        <?php
                          
    
                      if($_SESSION['user_type']  == 'ECZ'){
                             ?>
                        <li class="submenu">
                            <a href="javascript:void(0)"><i class="fa fa-flag" aria-hidden="true"></i> <span>Logs</span><span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="marksheet_logs.php">Marksheet Logs</a></li>
								<!-- <li><a href="subject_apportionment_internal.php">Marking Centre Internal</a></li> -->
                                <!-- <li><a href="marking-center-apportionment.php"> Marking Apportionments</a></li> -->
								<!-- <li><a href="javascript:void(0)"> Other</a></li> -->
							</ul>
                        </li>
                       
                        <li class="submenu">
                        <a href="settings.html"><i class="fa fa-cog"></i> <span>Settings</span><span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="datasetup.php">Data Setup</a></li>
                                <!-- <li><a href="settings.php">Other Settings</a></li> -->
                               
                            </ul>
                        </li>
                        <?php
                           }
                           if( $_SESSION['user_type']  == 'ADMIN' || $_SESSION['user_type']  == 'DEO' || $_SESSION['user_type']  == 'ECZ'){
                        ?>

                        <!-- REPORTS -->
                        <li class="submenu">
                            <a href="examiners.php"><i class="fa fa-pie-chart"></i></i> <span>Reports</span><span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="marks_reports.php"> All Reports</a></li>
							</ul>
                        </li>
                        <?php
                           }
                            ?>
                        <!-- <li>Pages</li> -->
                        <li>
                            <a href="../php/logout.php"><i class="fa fbes"></i> <span>Log out</span></a>
                        </li>
                           
                        <!--ECZ-->
                    

                    </ul>
                </div>
            </div>
        </div>

    <?php
}
    ?>