<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php';

if($_SESSION['user_type'] == 'ECZ' || $_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO'){

  ?>

<body>
  <div class="main-wrapper">

    <?php include 'includes/navbar.php'?>

    <?php include 'includes/sidebar.php'?>
    <!-- <div id="preloader-div" class="d-none" style="height: 100%;width:100%; left:0;top:0; position:absolute; background-color: #414040b9;z-index:10000" >
      <img src="../images/loading.gif" alt="Loading..." class="d-block ml-auto mr-auto " style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
      <p class="text-center " style="position: absolute; top: 60%; left: 50%; transform: translateX(-50%); color: white; font-weight: bold;font-size:large;">Uploading <span class="centre_type"></span> Center(s) from OCRS. Please wait...</p>
    </div> -->

    <div class="page-wrapper">

      <!-- Preloader -->



      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <h4 class="page-title"><i class="fa fa-pie-chart blue-ecz" aria-hidden="true"></i> REPORTS</h4>
          </div>
          <!-- <?php
              //  echo $_SESSION['marking_centre_code'];
                ?>  -->
        </div>

        <?php
if($_SESSION['user_type'] == 'ADMIN'){
          ?>
        <div class="row px-3">
          <div class="col-md-6 ">
            <h5 class="blue-ecz"><i class="fa fa-th-large" aria-hidden="true"></i> CENTRES REPORT:</h5>
          </div>

        </div>

        <div class="row px-5">
          <div class="col-md-6">
            <a href="javascript.:void(0)" data-toggle="modal" data-target="#centers_in_belt_modal">
              <div> CENTRES IN A BELT </div>
            </a>
          </div>
          <!-- <div class="col-md-6">
                               <a href="javascript:void(0)" data-toggle="modal" data-target="#change-session-modal"><div>change active session</div></a> 
                        </div> -->
        </div>
        <?php
                    }
                ?>
        <hr>

        <!-- Payments Reports -->
        <?php
               if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO' || $_SESSION['user_type'] == 'ECZ'){
               ?>
        <h5 class="blue-ecz px-3"><i class="fa fa-credit-card" aria-hidden="true"></i> PAYMENT CLAIMS:</h5>
        <div class="row px-5">

          <?php
                  if($_SESSION['user_type'] == 'ECZ'){
                  ?>


          <div class="col-md-12">
            <div class="row justify-content-center ">
              <div class="col-md-4">
                <a href="shedule.php?examiner=examiner" target="_blank" class="btn btn-white">
                  <div> Examiners Payment Schedule</div>
                </a>
              </div>
              <div class="col-md-4 ">
                <a href="shedule.php?examiner=deo" target="_blank" class="btn btn-white">
                  <div> DEO Payment Schedule</div>
                  <!-- /paymentschedule/DEO.php -->
                </a>
              </div>
              <div class="col-md-4 ">
                <a href="shedule.php?examiner=sad" target="_blank" class="btn btn-white">
                  <div>System Admins Payment Schedule</div>
                </a>
              </div>

            </div>
          </div>
          <?php
              }
                if($_SESSION['user_type'] == 'ADMIN'){
                ?>
          <!-- <div class="col-md-6">
                              <a href="javascript:void(0)" data-toggle="modal" data-target="#daily_allow_claim_modal"><div>Examiners Daily Allowance</div></a>  
                        </div> -->
          <div class="col-md-4">
            <a href="javascript:void(0)" data-toggle="modal" data-target="#examiners_claim_modal">
              <!-- <div> Examiners Payment Schedule</div> -->
            </a>
          </div>
          <!-- <div class="col-md-6">
                               <a href="javascript:void(0)" data-toggle="modal" data-target="#deputy_claim_modal"><div>Chief Examiners Claim</div></a> 
                        </div> -->

          <div class="col-md-4">
            <a href="javascript:void(0)" data-toggle="modal" data-target="#chief_deputy_claim_modal">
              <!-- <div> Chief / Deputy Chief Examiners Claim</div> -->
            </a>
          </div>
          <div class="col-md-4">
            <a href="javascript:void(0)" data-toggle="modal" data-target="#transport_lunch">
              <div> Transport and Lunch</div>
            </a>
          </div>

          <div class="col-md-4">
            <a href="#" data-toggle="modal" data-target="#system_admin_modal">
              <div> Systems Admin (Statistics)</div>
            </a>
          </div>
          <div class="col-md-4">
            <a href="reports/systems_admin_lunch_transport.php" target="_blank">
              <div> Systems Admin Lunch and Transport</div>
            </a>
          </div>
          <div class="col-md-4">
            <a href="reports/transcribers.php" target="_blank">
              <!-- <div> Braille Transcribers</div> -->
            </a>
          </div>

          



          <!-- <a href="reports/data_entry_claim_question.php" target="_blank"><div> Data Entry Officer Claims</div></a>  -->
        </div>

        <div class="col-md-6">
          <a href="#" id="submit_system_admin_claim" class="btn btn-white"><i class="fa fa-check"
              aria-hidden="true"></i> Submit Claim (Yours)</a>
              
              <a href="submitted_system_admin_claim.php" target="_blank" class="btn btn-white"><i class="fa fa-check"
                aria-hidden="true"></i> Submitted Claim</a>

          <div class="dataclaim1"></div>
          <div class="dataclaim2"></div>
          <div class="claim_loading"></div>


        </div>
        <div class="col-md-6">

          

          <?php
                    }
                  if($_SESSION['user_type'] == 'DEO'){
                  ?>
          <div class="col-md-4">
            <a href="#" data-toggle="modal" data-target="#data_entry_modal">
              <div> Data Entry Officer Statistics (Yours)</div>
            </a>
          </div>
          <div class="col-md-4">
            <a href="reports/data_entry_lunch_transport.php" target="_blank">
              <div> Data Entry Lunch and Transport</div>
            </a>
          </div>

        


        </div>

        <div class="col-md-6">
          <a href="#" id="submit_data_entry_claim" class="btn btn-white"><i class="fa fa-check" aria-hidden="true"></i>
            Submit Claim</a>
            <a href="submitted_data_entry_claim.php" target ="_blank" class="btn btn-white"><i class="fa fa-check" aria-hidden="true"></i>
            Submitted Claim</a>
          <div class="dataclaim0"></div>
          <!-- <div class="dataclaim1"></div> -->
          <div class="dataclaim2"></div>
          <div class="claim_loading"></div>

        </div>
        <div class="col-md-6"></div>

          <!-- Data Entry claim modal -->
  <div class="modal fade" id="data_entry_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
          <form action="#" target="_blank" method="post" style="width:100%;">
            <div class="modal-content">
              <div class="modal-header bg-success p-1 d-flex justify-content-center">
                <div class="modal-title h4 text-white text-center " id="exampleModalLongTitle">Data Entry Statistics (Yours)</div>
              </div>
              <div class="modal-body">
               
                <div class="script_count">Nnumber of scripts entered: <span class="script_no_entered"></span></div>
                <div class="rate">Rate: K<span class="data_entry_rate"></span></div>
                <div class="gross">Gross: K<span class="gross_pay"></span></div>
                <div class="wht">Tax (15%): K<span class="wht"></span></div>
                <div class="net">Net: K<span class="net_pay"></span></div>
              </div>
              <div class="modal-footer">
                <span class="text-small text-center">above information will be used for payment when claim is submitted / re-submitted</span>
                </div>
              
            </div>
  
          </form>
          </div>
        </div>

        <?php
                  }
                  ?>
      </div>
      <?php
               }
               ?>
      <hr>

      <!--Marks  -->
      <?php
              if($_SESSION['user_type'] == 'DEO' || $_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'ECZ'){
                ?>
      <h5 class="blue-ecz px-3"><i class="fa fa-table" aria-hidden="true"></i> MARKS / SCRIPTS REPORTS:</h5>
      <div class="row px-5">
        <div class="col-md-6">
          <a href="javascript:void(0)" data-toggle="modal" data-target="#script-movement">
            <div> Script Movement Report</div>
          </a>
        </div>
      </div>

      <div class="row px-5">
        <?php
                if($_SESSION['user_type'] == 'DEO' || $_SESSION['user_type'] == 'ADMIN'){
                  if($_SESSION['user_type'] == 'DEO'){
                ?>
        <div class="col-md-6">
          <a href="javascript:void(0)" data-toggle="modal" data-target="#transcription_checklist_modal">
            <div> Transcription Checklist</div>
          </a>
        </div>


        <div class="col-md-6">
          <a href="javascript:void(0)" data-toggle="modal" data-target="#improvised_marks_modal">
            <div> Improvised Marks</div>
          </a>
        </div>
        <?php
                  }
                        
                        if($_SESSION['user_type'] == 'ADMIN' ){
                        ?>
        <div class="col-md-6">
          <a href="javascript:void(0)" data-toggle="modal" data-target="#frequency_distribution_by_paper">
            <div> Frequency Distribution</div>
          </a>
        </div>
        <?php
                        }
                    ?>
        <div class="col-md-6">
          <a href="missing-marks.php">
            <div> Missing Marks</div>
          </a>
        </div>
        <?php

                      }
                        ?>

      </div>
      <?php
              }
                ?>
      <hr>

      <!-- Examiners Reports -->
      <?php
                if($_SESSION['user_type'] == 'ADMIN'){
                ?>
      <h5 class="blue-ecz px-3"><i class="fa fa-users" aria-hidden="true"></i> EXAMINER REPORTS</h5>
      <div class="row px-5">
        <div class="col-md-6">
          <a href="javascript:void(0)" data-toggle="modal" data-target="#examiners_in_belt">
            <div>Examiners in a belt</div>
          </a>
        </div>
        <div class="col-md-6">
          <a href="javascript:void(0)" data-toggle="modal" data-target="#examiner_attendance">
            <div> Examiner Attendance</div>
          </a>
        </div>

      </div>
      <?php
                }
                    ?>
      <hr>

    </div>
  </div>

  <div class="sidebar-overlay" data-reff=""></div>
  </div>




  <!-- Modals -->
  <!-- Button trigger modal -->


  <!-- Centers in belt Modal -->
  <?php
if($_SESSION['user_type'] == 'ADMIN'){
          ?>
  <div class="modal fade" id="centers_in_belt_modal" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <form action="reports/centers_in_belt.php" target="_blank" method="post" style="width:100%;">
        <div class="modal-content">
          <div class="modal-header bg-success p-1 d-flex justify-content-center">
            <div class="modal-title h4 text-white text-center " id="exampleModalLongTitle">Centres in a Belt Report
            </div>
          </div>
          <div class="modal-body">
            <div class="row">

              <div class="col-md-6">
                <label for="subject">Subject</label>
                <select name="subject" class="select" id="subject" required>
                  <option value="" selected> Select subject</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="paper">paper</label>
                <select name="paper" class="select" id="paper" required>
                  <option value="" selected> Select Paper</option>
                </select>
              </div>

            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="belt">Belt No.</label>
                <select name="app_belt_no" class="select" id="belt" required>
                  <option value="" selected> Select Belt No.</option>
                </select>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download" aria-hidden="true"></i>
              GENERATE</button>
          </div>
        </div>

      </form>
    </div>
  </div>
  <?php
}
?>
  <!-- Daily allowance claim -->
  <?php
if($_SESSION['user_type'] == 'ADMIN'){
          ?>

  <div class="modal fade" id="daily_allow_claim_modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <form action="reports/daily_allowance_claim.php" target="_blank" method="post" style="width:100%;">
        <div class="modal-content">
          <div class="modal-header bg-success p-1 d-flex justify-content-center">
            <div class="modal-title h4 text-white text-center " id="exampleModalLongTitle">Examiners Daily Allowance
            </div>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-md-6">
                <label for="subject">Subject</label>
                <select name="subject" class="select" id="subject" required>
                </select>
              </div>
              <div class="col-md-6">
                <label for="paper">Paper</label>
                <select name="paper" class="select" id="paper" required>
                  <option value="" selected> Select Paper No</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="belt">Belt No.</label>
                <select name="belt_no" class="select" id="belt" required>
                  <option value="" selected> Select Belt No.</option>
                </select>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download" aria-hidden="true"></i>
              GENERATE</button>
          </div>
        </div>

      </form>
    </div>
  </div>
  <?php
}
if($_SESSION['user_type'] == 'ADMIN'){
          ?>
  <!-- Examiner claim -->
  <div class="modal fade" id="examiners_claim_modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <!-- <form action="reports/examiners_claim_report.php" target="_blank" method="post" style="width:100%;"> -->
      <form action="examiner_claim.php" target="_blank" method="post" style="width:100%;">
        <div class="modal-content">
          <div class="modal-header bg-success p-1 d-flex justify-content-center">
            <div class="modal-title h4 text-white text-center " id="exampleModalLongTitle">Examiner Payment Claim (statistics)
              Schedule</div>
          </div>
          <div class="modal-body">
            <div class="row">

              <div class="col-md-6">
                <label for="subject">Subject </label>
                <select name="subject" class="select" id="subject" required>
                </select>
              </div>
              <div class="col-md-6">
                <label for="paper">Paper </label>
                <select name="paper" class="select" id="paper" required>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <label for="belt">Belt No.</label>
              <select name="app_belt_no" class="select" id="belt" required>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download" aria-hidden="true"></i>
              GENERATE</button>
          </div>
        </div>

    </div>

  </div>


  </form>
  </div>
  </div>


  <?php }

if($_SESSION['user_type'] == 'ADMIN'){
  ?>

  <!-- System Admin claim modal -->
  <div class="modal fade" id="system_admin_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
          <form action="#" target="_blank" method="post" style="width:100%;">
            <div class="modal-content">
              <div class="modal-header bg-success p-1 d-flex justify-content-center">
                <div class="modal-title h4 text-white text-center " id="exampleModalLongTitle">System Admin Statistics (Yours)</div>
              </div>
              <div class="modal-body">
               
                <div class="script_count">Highest nnumber of scripts entered: <span class="highest_script_count"></span></div>
                <div class="subject_paper">Subject: <span class="subject_paper"></span></div>
                <div class="belt">Belt No: <span class="belt_no"></span></div>
                <div class="no_of_examiners">No. of Examiners (Team leaders and examiners) <span class="no_of_examiners"></span></div>
                <div class="rate">Rate: K<span class="rate"></span></div>
                <div class="gross">Gross: K<span class="gross"></span></div>
                <div class="wht">Tax (15%): K<span class="wht"></span></div>
                <div class="net">Net: K<span class="net"></span></div>
              </div>
              <div class="modal-footer">
                <span class="text-small text-center">above information will be used for payment when claim is submitted / re-submitted</span>
                </div>
              
            </div>
  
          </form>
          </div>
        </div>

  <!-- deputy_claim claim -->
  <div class="modal fade" id="chief_deputy_claim_modal" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <!-- <form action="reports/deputy_chief_claim.php" target="_blank" method="post" id="frequecy_form" -->
      <form action="deputy_chief_claim.php" target="_blank" method="post" id="frequecy_form"
        style="width:100%;">
        <div class="modal-content">
          <div class="modal-header bg-success p-1 d-flex justify-content-center">
            <div class="modal-title h4 text-white text-center " id="exampleModalLongTitle">Chief / Deputy CHief
              Examiners Claim</div>
          </div>
          <div class="modal-body">


            <div class="row">
              <div class="col-md-6">
                <p>Subject
                  <select name="subject" class="select" id="subject" required>
                    <option value="" selected> Select Subject</option>
                    <option value="0">sub 1</option>
                  </select>
                </p>
              </div>

              <div class="col-md-6 " id="by_paper_opt">
                <p>Paper
                  <select name="paper" class="select" id="paper" required>
                    <option value="" selected> Select Papert</option>
                    <option value="0">paper 1</option>
                  </select>
                </p>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download" aria-hidden="true"></i>
              GENERATE</button>
          </div>
        </div>

      </form>
    </div>
  </div>

  <!-- Chief_examiners_claim claim -->
  <div class="modal fade" id="deputy_claim_modal" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <form action="reports/chief_claim.php" target="_blank" method="post" id="frequecy_form" style="width:100%;">
        <div class="modal-content">
          <div class="modal-header bg-success p-1 d-flex justify-content-center">
            <div class="modal-title h4 text-white text-center " id="exampleModalLongTitle">Chief / Deputy Chief Examiner
              Claim</div>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-md-6">
                <p>Subject
                  <select name="subject" class="select" id="subject" required>
                    <option value="" selected> Select Subject</option>
                    <option value="0">sub 1</option>
                  </select>
                </p>
              </div>

              <div class="col-md-6 " id="by_paper_opt">
                <p>Paper
                  <select name="paper" class="select" id="paper" required>
                    <option value="" selected> Select Papert</option>
                    <option value="0">paper 1</option>
                  </select>
                </p>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download" aria-hidden="true"></i>
              GENERATE</button>
          </div>
        </div>

      </form>
    </div>
  </div>



  <?php }

if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO'){
  ?>



  <?php }

if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO'){
  ?>
  <!-- Improvised marks maoda -->
  <div class="modal fade" id="improvised_marks_modal" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <form action="reports/improvised_marks.php" target="_blank" method="post" style="width:100%;">
        <div class="modal-content">
          <div class="modal-header bg-success p-1 d-flex justify-content-center">
            <div class="modal-title h4 text-white text-center " id="exampleModalLongTitle">Improvised Marks Report</div>
          </div>
          <div class="modal-body">
            <div class="row">
              <!-- <div class="col-md-6">
            <p>Marking Center Code
            <select name="marking-center" class="select" id="marking-center" required>
              <option value="" selected> Select Marking Center</option>
              <option value="0">MARKING CENTER 1</option>
            </select>
            </p>
          </div> -->
              <div class="col-md-12">
                <p> Centre Code
                  <select name="centre_improvised" class="select" id="mcenter" required>
                  </select>
                </p>
              </div>
              <!-- <div class="col-md-3">
            <p>End Center
            <select name="end_center" class="select" id="end_center" required>
              <option value="" selected> Select End</option>
              <option value="0">end 1</option>
            </select>
            </p>
          </div> -->
            </div>
            <div class="row">
              <div class="col-md-6">
                <p>Subject
                  <select name="subject" class="select" id="subject" required>
                  </select>
                </p>
              </div>

              <div class="col-md-6">
                <p>Paper
                  <select name="paper" class="select" id="Paper" required>
                  </select>
                </p>
              </div>
            </div>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download" aria-hidden="true"></i>
              GENERATE</button>
          </div>
        </div>

      </form>
    </div>
  </div>


  <?php }
if($_SESSION['user_type'] == 'ADMIN'){
  ?>
  <!-- Frequency Distribution -->
  <div class="modal fade" id="frequency_distribution_by_paper" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <form action="reports/frequency_distribution_by_paper.php" target="_blank" method="post" id="frequecy_form"
        style="width:100%;">
        <div class="modal-content">
          <div class="modal-header bg-success p-1 d-flex justify-content-center">
            <div class="modal-title h4 text-white text-center " id="exampleModalLongTitle">Frequency Distribution</div>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-check form-check-inline p-2">
                  <input class="form-check-input" type="radio" name="frequency_type" id="by_paper" value="paper"
                    checked>
                  <label class="form-check-label font-weight-bold" for="inlineRadio1">By Paper</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-check form-check-inline p-2">
                  <input class="form-check-input" type="radio" name="frequency_type" id="by_sybject" value="subject">
                  <label class="form-check-label font-weight-bold" for="inlineRadio2">By Subject</label>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <p>Subject
                  <select name="subject" class="select" id="subject" required>
                    <option value="" selected> Select Subject</option>
                    <option value="0">sub 1</option>
                  </select>
                </p>
              </div>

              <div class="col-md-6 " id="by_paper_opt">
                <p>Paper
                  <select name="paper" class="select" id="paper" required>
                    <option value="" selected> Select Paper</option>
                    <option value="0">paper 1</option>
                  </select>
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <p>Centre Type
                  <select name="centre_type" class="select" id="center_type" required>
                  </select>
                </p>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download" aria-hidden="true"></i>
              GENERATE</button>
          </div>
        </div>

      </form>
    </div>
  </div>


  <?php }
if($_SESSION['user_type'] == 'ADMIN'){
  ?>
  <!-- Examiners in belt -->
  <div class="modal fade" id="examiners_in_belt" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <form action="reports/examiners_in_belt.php" target="_blank" method="post" style="width:100%;">
        <div class="modal-content">
          <div class="modal-header bg-success p-1 d-flex justify-content-center">
            <div class="modal-title h4 text-white text-center " id="exampleModalLongTitle">Examiners In Belt</div>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-md-6">
                <p>Subject
                  <select name="subject" class="select" id="Subject" required>
                  </select>
                </p>
              </div>

              <div class="col-md-6">
                <p>Paper
                  <select name="paper" class="select" id="paper" required>
                    <option value="" selected> Select Paper</option>
                  </select>
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <p>Belt
                  <select name="belt_no" class="select" id="belt_no" required>
                  </select>
                </p>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download" aria-hidden="true"></i>
              GENERATE</button>
          </div>
        </div>

      </form>
    </div>
  </div>


  <?php }
if($_SESSION['user_type'] == 'ADMIN'){
  ?>
  <!-- examiner_attendance -->
  <div class="modal fade" id="examiner_attendance" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <form action="reports/attendance_register.php" target="_blank" method="post" style="width:100%;">
        <div class="modal-content">
          <div class="modal-header bg-success p-1 d-flex justify-content-center">
            <div class="modal-title h4 text-white text-center " id="exampleModalLongTitle">Examiner Attendance</div>
          </div>
          <div class="modal-body">
            <div class="row">
              <!-- <div class="col-md-6">
            <p>Marking Center
            <select name="Center" class="select" id="Center" required>
              <option value="" selected> Select Center</option>
              <option value="0">Center 1</option>
            </select>
            </p>
          </div> -->

            </div>

            <div class="row">
              <div class="col-md-6">
                <p>Subject
                  <select name="subject" class="select" id="subject" required>
                  </select>
                </p>
              </div>

              <div class="col-md-6">
                <p>Paper
                  <select name="paper" class="select" id="paper" required>
                  </select>
                </p>
              </div>
            </div>
            <div class="row ">
              <div class="col-md-6">
                <p>Belt
                  <select name="belt_no" class="select" id="belt_no" required>
                    <!-- <option value="" selected> Select Belt</option> -->
                    <!-- <option value="all" selected>All</option> -->
                  </select>
                </p>
              </div>
              <div class="col-md-6">
                <p>Attendance
                  <select name="attendance" class="select" id="Attendance" required>
                  </select>
                </p>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download" aria-hidden="true"></i>
              GENERATE</button>
          </div>
        </div>

      </form>
    </div>
  </div>
  
<!-- examiner attendance end -->

  <!-- transport and lunch -->
  <div class="modal fade" id="transport_lunch" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <form action="reports/transport_lunch.php" target="_blank" method="post" style="width:100%;">
        <div class="modal-content">
          <div class="modal-header bg-success p-1 d-flex justify-content-center">
            <div class="modal-title h4 text-white text-center " id="exampleModalLongTitle">Transport and Lunch</div>
          </div>
          <div class="modal-body">
            <div class="row">
              <!-- <div class="col-md-6">
            <p>Marking Center
            <select name="Center" class="select" id="Center" required>
              <option value="" selected> Select Center</option>
              <option value="0">Center 1</option>
            </select>
            </p>
          </div> -->

            </div>

            <div class="row">
              <div class="col-md-6">
                <p>Subject
                  <select name="subject" class="select" id="subject" required>
                  </select>
                </p>
              </div>

              <div class="col-md-6">
                <p>Paper
                  <select name="paper" class="select" id="paper" required>
                  </select>
                </p>
              </div>
            </div>
            <div class="row ">
              <div class="col-md-6">
                <p>Belt
                  <select name="belt_no" class="select" id="belt_no" required>
                    <!-- <option value="" selected> Select Belt</option> -->
                    <!-- <option value="all" selected>All</option> -->
                  </select>
                </p>
              </div>
              
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download" aria-hidden="true"></i>
              GENERATE</button>
          </div>
        </div>

      </form>
    </div>
  </div>

<!-- transport and lunch end -->

  <?php }

if($_SESSION['user_type'] == 'DEO'){
  ?>
  <!-- Transcription Checklist -->
  <div class="modal fade" id="transcription_checklist_modal" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <form action="reports/transcription_checklist.php" target="_blank" method="post" style="width:100%;">
        <div class="modal-content">
          <div class="modal-header bg-success p-1 d-flex justify-content-center">
            <div class="modal-title h4 text-white text-center " id="exampleModalLongTitle">Marks Report</div>
          </div>
          <div class="modal-body">
            <div class="row ">

              <div class="col-md-12">
                <p>Centre
                  <select name="centre_code" class="select" id="Center" required>
                    <option value="" selected>Select Centre</option>
                  </select>
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <p>Subject
                  <select name="subject" class="select" id="subject" required>
                  </select>
                </p>
              </div>

              <div class="col-md-6">
                <p>Paper
                  <select name="paper" class="select" id="paper" required>
                  </select>
                </p>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download" aria-hidden="true"></i>
              GENERATE</button>
          </div>
        </div>

      </form>
    </div>
  </div>


  <?php }

if($_SESSION['user_type'] == 'ECZ' || $_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO'){
  ?>
  <!-- Transcription Checklist -->
  <div class="modal fade" id="script-movement" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <?php
    if($_SESSION['session_type'] == 'I'){
    ?>
      <form action="reports/script_movement_report.php" target="_blank" method="post" style="width:100%;">
        <?php
    }else{
      ?>
        <form action="reports/script_movement_report_external.php" target="_blank" method="post" style="width:100%;">
          <?php
    }
    ?>
          <div class="modal-content">
            <div class="modal-header bg-success p-1 d-flex justify-content-center">
              <div class="modal-title h4 text-white text-center " id="exampleModalLongTitle">Script Movement Report
              </div>
            </div>
            <div class="modal-body">
              <div class="row ">

                <div class="col-md-12">
                  <p>Province
                    <select name="province" class="select" required>
                      <!-- <option value="" selected>Select Province</option> -->
                    </select>
                  </p>
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download" aria-hidden="true"></i>
                GENERATE</button>
            </div>
          </div>

        </form>
    </div>
  </div>


  <?php }
if($_SESSION['user_type'] == 'DEO'){
  ?>
  <!-- Transcription Checklist -->
  <!-- <div class="modal fade" id="data_entry_claim_modal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
  <form action="reports/transcription_checklist.php" target="_blank" method="post" style="width:100%;">
    <div class="modal-content">
      <div class="modal-header bg-success p-1 d-flex justify-content-center">
        <div class="modal-title h4 text-white text-center " id="exampleModalLongTitle">Data Entry Officer Claims</div>
      </div>
      <div class="modal-body">
        <div class="row ">

          <div class="col-md-12">
            <p>Center
            <select name="centre_code" class="select" id="Center" required>
              <option value="" selected>Select Centre</option>
            </select>
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <p>Subject
            <select name="subject" class="select" id="subject" required>
            </select>
            </p>
          </div>

          <div class="col-md-6">
            <p>Paper
            <select name="paper" class="select" id="paper" required>
            </select>
            </p>
          </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download" aria-hidden="true"></i> GENERATE</button>
      </div>
    </div>

  </form>
  </div>
</div> -->


  <?php }




include 'includes/scripts.php'; ?>

</body>
<script>
  $(document).ready(function () {

    $('input[type=radio][name=frequency_type]').change(function () {
      if (this.value == 'paper') {
        //console.log("Clicked Paper")
        $('#by_paper_opt').removeClass('d-none')
      }
      else if (this.value == 'subject') {
        // console.log("Clicked Subject")
        $('#by_paper_opt').addClass('d-none')
      }
    });
    $('.dialog').dialog({
      title: 'REQUEST RESPONSE',
      width: '450',
      height: '150',
      modal: true,
      draggable: false,
      resizable: false,
      appendTo: '#missing_mark_modal',
      closeOnEscape: false,
      autoOpen: false,
      create: function (e) {
        $(e.target).parent().css({
          'position': 'fixed'
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
          click: function () {
            $(this).dialog('close');
          }
        }
      ]
    });

    $('.dataclaim0').dialog({
      title: 'REQUEST RESPONSE',
      width: '450',
      height: '150',
      modal: true,
      draggable: false,
      resizable: false,
      // appendTo: '#missing_mark_modal',
      closeOnEscape: false,
      autoOpen: false,
      create: function (e) {
        $(e.target).parent().css({
          'position': 'fixed'
        });

      },
      buttons: [
        {
          text: 'NO',
          click: function () {
            $(this).dialog('close');
          }
        },
        {
          text: 'YES',
          click: function () {
            submit_data_entry_claim();
            $(this).dialog('close');
          }
        }
      ]
    });


    $('.dataclaim1').dialog({
      title: 'REQUEST RESPONSE',
      width: '450',
      height: '150',
      modal: true,
      draggable: false,
      resizable: false,
      // appendTo: '#missing_mark_modal',
      closeOnEscape: false,
      autoOpen: false,
      create: function (e) {
        $(e.target).parent().css({
          'position': 'fixed'
        });

      },
      buttons: [
        {
          text: 'NO',
          click: function () {
            $(this).dialog('close');
          }
        },
        {
          text: 'YES',
          click: function () {
            submit_system_admin_claim();
            $(this).dialog('close');
          }
        }
      ]
    });

    $('.dataclaim2').dialog({
      title: 'REQUEST RESPONSE',
      width: '450',
      height: '150',
      modal: true,
      draggable: false,
      resizable: false,
      // appendTo: '#missing_mark_modal',
      closeOnEscape: false,
      autoOpen: false,
      create: function (e) {
        $(e.target).parent().css({
          'position': 'fixed'
        });

      },
      buttons: [
        // {
        //     text: 'NO',
        //     click: function(){
        //       $(this).dialog('close');
        //     }
        // },
        {
          text: 'OK',
          click: function () {
            $(this).dialog('close');
          }
        }
      ]
    });

    get_subjects();
    get_paper();
    // get_schools();
    get_centre_type();
    get_attendance();
    get_schools_improvised();
    get_schools_in_marking_centre();
    get_province();
    system_admin_claim();
    system_admin_statistics();
    data_entry_claim();
    data_entry_statistics();

    function get_province() {
      $.ajax({
        url: 'php/get_province.php',
        method: 'POST',
        dataType: 'json',
        success: function (data) {
          $('select[name=province]').append(
            '<option value="" selected disabled>Select province</option>'
          );

          $.each(data, function () {
            $('select[name=province]').append(
              '<option value="' + this["province_code"] + ':' + this["province"] + '">' + this["province"] + '</option>'
            );
          });
          $('select[name=province]').select2({
            data: data
          });
        }
      });
    }
    function get_subjects() {
      $.ajax({
        url: 'php/get_subject.php',
        method: 'POST',
        dataType: 'json',
        success: function (data) {
          $('select[name=subject] option').remove();
          $('select[name=subject]').append(
            '<option selected disabled>Select Subject</option>'
          );
          $.each(data, function () {
            $('select[name=subject]').append(
              '<option value="' + this["subject_code"] + '">' + this["subject_code"] + ' - ' + this["subject_name"] + '</option>'
            );
          });
          $('select[name=subject]').select2({
            data: data
          });
        }
      });
    }

    function get_paper() {
      $('select[name=subject]').change(function () {
        var subject_code = $(this).val();
        $.ajax({
          url: 'php/get_paper.php',
          method: 'POST',
          data: { subject_code: subject_code },
          dataType: 'json',
          success: function (data) {
            $('select[name=paper] option').remove();
            $('select[name=paper]').append(
              '<option value="" selected disabled>Select Paper Number</option>'
            );
            $.each(data, function () {
              $('select[name=paper]').append(
                '<option value="' + this["paper_no"] + '">' + this["paper_no"] + '</option>'
              );
            });
          }
        });
        get_apportioned_belts(subject_code);
        get_belt(subject_code);
      });
    }
    function get_apportioned_belts(subject_code) {
      $('select[name=paper]').change(function () {
        var paper = $(this).val();
        $.ajax({
          url: 'php/get_apportioned_belts.php',
          method: 'POST',
          data: { subject_code: subject_code, paper: paper },
          dataType: 'json',
          success: function (data) {
            $('select[name=app_belt_no] option').remove();
            if (data.status == '200') {

              $.each(data, function () {
                $('select[name=app_belt_no]').append(
                  '<option value="' + this["belt_no"] + '">' + this["belt_no"] + '</option>'
                );
              });

              $('select[name=app_belt_no] option[value=undefined]').remove();
            }
          }
        });
      });
    }
    function get_belt(subject_code) {
      $('select[name=paper]').change(function () {
        var paper = $(this).val();
        $.ajax({
          url: 'php/get_belt.php',
          method: 'POST',
          data: { subject_code: subject_code, paper: paper },
          dataType: 'json',
          success: function (data) {
            $('select[name=belt_no] option').remove();
            if (data.status == '200') {
              $('select[name=belt_no]').append(
                  '<option value="all">ALL</option>'
                );
              $.each(data, function () {
                $('select[name=belt_no]').append(
                  '<option value="' + this["belt_no"] + '">' + this["belt_no"] + '</option>'
                );
              });

              $('select[name=belt_no] option[value=undefined]').remove();
            }
          }
        });
      });
    }
    function get_schools_in_marking_centre() {
      $.ajax({
        url: 'php/get_schools_in_marking_centre.php',
        method: 'POST',
        dataType: 'json',
        success: function (data) {
          $('select[name=start_centre] option').remove();
          $('select[name=end_centre] option').remove();

          $('select[name=start_centre]').append(
            '<option value="" selected >Select start centre</option>'
          );
          $('select[name=end_centre]').append(
            '<option value="" selected disabled>Select end centre</option>'
          );
          $.each(data, function () {
            $('select[name=start_centre]').append(
              '<option value="' + this["centre_code"] + '">' + this["centre_code"] + ' - ' + this["centre_name"] + '</option>'
            );
            $('select[name=end_centre]').append(
              '<option value="' + this["centre_code"] + '">' + this["centre_code"] + ' - ' + this["centre_name"] + '</option>'
            );
            $('select[name=centre_code]').append(
              '<option value="' + this["centre_code"] + '">' + this["centre_code"] + ' - ' + this["centre_name"] + '</option>'
            );
          });
          $('select[name=start_centre]').select2({
            data: data
          });
          $('select[name=end_centre]').select2({
            data: data
          });
          $('select[name=centre_code]').select2({
            data: data
          });
          $('select[name=start_centre] option[value=undefined]').remove();
          $('select[name=end_centre] option[value=undefined]').remove();
          $('select[name=centre_code] option[value=undefined]').remove();


        }
      });

    }

    // function get_schools(){
    //   $.ajax({
    //     url: 'php/get_schools.php',
    //     method: 'POST',
    //     dataType: 'json',
    //     success: function(data){
    //       $('select[name=start_centre] option').remove();
    //       $('select[name=end_centre] option').remove();

    //       $('select[name=start_centre]').append(
    //           '<option value="" selected disabled>Select start centre</option>'
    //         );
    //         $('select[name=end_centre]').append(
    //           '<option value="" selected disabled>Select end centre</option>'
    //         );
    //       $.each(data,function(){
    //         $('select[name=start_centre]').append(
    //           '<option value="'+this["centre_code"]+'">'+this["centre_code"]+' - '+this["centre_name"]+'</option>'
    //         );
    //         $('select[name=end_centre]').append(
    //           '<option value="'+this["centre_code"]+'">'+this["centre_code"]+' - '+this["centre_name"]+'</option>'
    //         );
    //         $('select[name=centre_code]').append(
    //           '<option value="'+this["centre_code"]+'">'+this["centre_code"]+' - '+this["centre_name"]+'</option>'
    //         );
    //       });
    //       $('select[name=start_centre]').select2({
    //         data:data
    //       });
    //       $('select[name=end_centre]').select2({
    //         data:data
    //       });
    //       $('select[name=centre_code]').select2({
    //         data:data
    //       });
    //       $('select[name=start_centre] option[value=undefined]').remove();
    //       $('select[name=end_centre] option[value=undefined]').remove();
    //       $('select[name=centre_code] option[value=undefined]').remove();


    //     }
    //   });

    // }

    function get_centre_type() {
      $.ajax({
        url: 'php/get_centre_type.php',
        method: 'POST',
        dataType: 'json',
        success: function (data) {
          $('select[name=centre_type] option').remove();
          $.each(data, function () {
            $('select[name=centre_type]').append(
              '<option value="' + this["centre_type"] + '">' + this["centre_type_name"] + '</option>'
            );
          });
          $('select[name=centre_type] option[value=undefined]').remove();
        }
      });
    }
    function get_attendance() {
      $.ajax({
        url: 'php/get_attendance.php',
        method: 'POST',
        dataType: 'json',
        success: function (data) {
          $('select[name=attendance]').append(
            '<option selected disabled>Select Attendance</option>'
          );
          $.each(data, function () {
            $('select[name=attendance]').append(
              '<option value="' + this["id"] + '">' + this["name"] + '</option>'
            );
          });
          $('select[name=attendance] option[value=undefined]').remove();
        }
      });
    }

    function get_schools_improvised() {
      $.ajax({
        url: 'php/get_schools_improvised_marks.php',
        method: 'POST',
        dataType: 'json',
        success: function (data) {
          $('select[name=centre_improvised]').append(
            '<option selected disabled>Select Centre</option>'
          );
          $.each(data, function () {
            $('select[name=centre_improvised]').append(
              '<option value="' + this["centre_code"] + '">' + this["centre_name"] + '</option>'
            );
          });
          $('select[name=centre_improvised]').select2({
            data: data
          });
          $('select[name=centre_improvised] option[value=undefined]').remove();
        }
      });
    }

    function system_admin_claim() {
      $('#submit_system_admin_claim').click(function () {
        $('.dataclaim1').text('Submit your System Administrator claim?').dialog('open');
      });
    }

    function submit_system_admin_claim() {
      $.ajax({
        url: 'php/submit_system_admin_claim.php',
        method: 'POST',
        dataType: 'json',
        beforeSend: function () {
          $('.claim_loading').html('../images/loading.gif');
        },
        success: function (data) {
          if (data.status == '200') {
            $('.dataclaim2').text(data.response_msg).dialog('open');
            $('.claim_loading').html('');
          } else {
            $('.dataclaim2').text(data.response_msg).dialog('open');
            $('.claim_loading').html('');
          }
        }
      });
    }
    function system_admin_statistics(){
      $.ajax({
        url: 'php/system_admin_statistics.php',
        method: 'POST',
        dataType: 'json',
        success:function(data){
          $('span.highest_script_count').text(data.highest_script_count);
          $('span.subject_paper').text(data.subject_paper);
          $('span.belt_no').text(data.belt_no);
          $('span.no_of_examiners').text(data.no_of_examiners);
          $('span.rate').text(data.rate);
          $('span.gross').text(data.gross);
          $('span.wht').text(data.wht);
          $('span.net').text(data.net);
        }
      });
    }

    function data_entry_claim() {
      $('#submit_data_entry_claim').click(function () {
        $('.dataclaim0').text('Submit your Data Entry claim?').dialog('open');
      });
    }

    function submit_data_entry_claim() {
      $.ajax({
        url: 'php/submit_data_entry_claim.php',
        method: 'POST',
        dataType: 'json',
        beforeSend: function () {
          $('.claim_loading').html('../images/loading.gif');
        },
        success: function (data) {
          if (data.status == '200') {
            $('.dataclaim2').text(data.response_msg).dialog('open');
            $('.claim_loading').html('');
          } else {
            $('.dataclaim2').text(data.response_msg).dialog('open');
            $('.claim_loading').html('');
          }
        }
      });
    }

    function data_entry_statistics(){
      $.ajax({
        url: 'php/data_entry_statistics.php',
        method: 'POST',
        dataType: 'json',
        success:function(data){
          $('span.script_no_entered').text(data.script_no_entered);
          
          $('span.data_entry_rate').text(data.data_entry_rate);
          $('span.gross_pay').text(data.gross_pay);
          $('span.wht').text(data.wht);
          $('span.net_pay').text(data.net_pay);
        }
      });
    }
    
  });
</script>
<?php
}else{
  header('location: ../');
}
?>


</html>