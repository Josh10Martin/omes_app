
<?php
session_start();
include '../config.php';
include '../functions.php';



          
?>
<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php';

if($_SESSION['user_type'] == 'DEO' || $_SESSION['user_type'] == 'ADMIN'){

  include "php/get_branch2.php";
    include "php/get_bank2.php";
$sql = $db_9->prepare('SELECT u.nrc AS nrc, u.tpin AS tpin, u.first_name AS first_name,u.last_name AS last_name,
                      u.phone AS phone, b.id AS user_bank_id, u.branch AS user_branch_id,b.name AS bank,br.name AS branch,
                      p.p_name AS province,ce.name AS marking_centre,u.email AS email, u.account_no AS account_no
                      FROM province p INNER JOIN centre ce ON (p.p_code = ce.province)
                      INNER JOIN users u ON (ce.centre_code = u.marking_centre)
                      INNER JOIN bankbranch br ON (u.branch = br.id)
                      INNER JOIN bank b ON (br.bank_id = b.id)
                     
                      WHERE p.p_code = ce.province
                      AND u.username =:username');
$sql->execute(array(
  ':username'=>$_SESSION['username']
));
$sql->bindColumn('nrc',$nrc);
$sql->bindColumn('tpin',$tpin);
$sql->bindColumn('first_name',$first_name);
$sql->bindColumn('last_name',$last_name);
$sql->bindColumn('phone',$phone);
$sql->bindColumn('user_bank_id',$user_bank_id);
$sql->bindColumn('user_branch_id',$user_branch_id);
$sql->bindColumn('province',$province);
$sql->bindColumn('marking_centre',$marking_centre);
$sql->bindColumn('email',$email);
$sql->bindColumn('account_no',$account_no);
$sql->fetch(PDO::FETCH_BOUND);

    ?>

<body>
<div class="main-wrapper">

    <?php include 'includes/navbar.php'?>     

    <?php include 'includes/sidebar.php'?>

    <div class="page-wrapper">
        <div class="content">
            <div class="row justify-content-between px-2">
                <div class="col-xs-6">
                    <h4 class="page-title"> Update Personal Details</h4>
                </div>
            </div>
            <div class="bg-light">
              <div class="dialog"></div>
              <div class="dialog1"></div>
                <form action="" method="post" id ="update_details">
                    
                    <div class="row p-2">
                        <div class="col-md-4">
                            <div class="form-group row p-2">
                                <label for="inputPassword" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9 p-0">
                                  <input type="text" value="<?php echo $_SESSION['username']; ?>" class="form-control" readonly> 
                                </div>
                              </div>
                              <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">

                              <div class="form-group row p-2">
                                <label for="inputPassword" class="col-sm-3 col-form-label">First Name</label>
                                <div class="col-sm-9 p-0">
                                  <input type="text" class="form-control" name="first_name" value="<?php echo $first_name; ?>"> 
                                </div>
                              </div>

                              <div class="form-group row p-2">
                                <label for="inputPassword" class="col-sm-3 col-form-label">Last Name</label>
                                <div class="col-sm-9 p-0">
                                  <input type="text" class="form-control" name="last_name" value="<?php echo $last_name; ?>"> 
                                </div>
                              </div>

                              <div class="form-group row p-2">
                                <label for="inputPassword" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9 p-0">
                                  <input type="email" class="form-control"  value ="<?php echo $email; ?>" readonly> 
                                </div>
                              </div>

                             
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row p-2">
                                <label for="nrc" class="col-sm-3 col-form-label">NRC</label>
                                <div class="col-sm-9 p-0 ">
                                  <input maxlength ="11" type="text" class="form-control" name="nrc" value="<?php echo $nrc; ?>"> 
                                </div>
                              </div>

                              <div class="form-group row p-2">
                                <label for="phone" class="col-sm-3 col-form-label">Phone Number</label>
                                <div class="col-sm-9 p-0">
                                  <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>"> 
                                </div>
                              </div>

                              <div class="form-group row p-2">
                                <label for="province" class="col-sm-3 col-form-label">Province</label>
                                <div class="col-sm-9 p-0">
                                    <select name="province" id="" class="select">
                                      <option><?php echo $province; ?></option>
                                    </select>
                                  <!-- <input type="text" class="form-control" name="branch" >  -->
                                </div>
                              </div>

                              <div class="form-group row p-2">
                                <label for="marking-centre" class="col-sm-3 col-form-label">Marking Centre</label>
                                <div class="col-sm-9 p-0">
                                    <select name="marking-centre" id="" class="select">
                                      <option><?php echo $marking_centre; ?></option>
                                    </select>
                                </div>
                              </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row p-2">
                                <label for="t-pin" class="col-sm-3 col-form-label">T-PIN</label>
                                <div class="col-sm-9 p-0">
                                  <input maxlength = "10" type="text" class="form-control" name="tpin" value ="<?php echo $tpin; ?>"> 
                                </div>
                              </div>

                              <div class="form-group row p-2">
                                <label for="bank" class="col-sm-3 col-form-label">Bank</label>
                                <div class="col-sm-9 p-0">
                                    <select name="bank" id="" class="select" required>
                                        <?php do{ ?>
                                          <option value ="<?php echo $bank_id; ?>" <?php echo $bank_id == $user_bank_id ? 'selected' : ''; ?>><?php echo $bank_name; ?></option>
                                          <?php } while($bank_sql->fetch(PDO::FETCH_BOUND));  ?>
                                    </select>
                                  <!-- <input type="text" class="form-control" name="bank" >  -->
                                </div>
                              </div>

                              <div class="form-group row p-2">
                                <label for="branch" class="col-sm-3 col-form-label">Branch</label>
                                <div class="col-sm-9 p-0">
                                    <select name="branch" id="" class="select">
                                      <?php do{ ?>
                                      <option value="<?php echo $branch_id; ?>" <?php echo $branch_id == $user_branch_id ? 'selected' : ''; ?>><?php echo $branch_name; ?></option>
                                    <?php } while ($branch_sql->fetch(PDO::FETCH_BOUND)); ?>
                                      </select>
                                  <!-- <input type="text" class="form-control" name="branch" >  -->
                                </div>
                              </div>

                              <div class="form-group row p-2">
                                <label for="inputPassword" class="col-sm-3 col-form-label">Account Number</label>
                                <div class="col-sm-9 p-0">
                                  <input type="text" class="form-control" name="account_no" value="<?php echo $account_no; ?>"> 
                                </div>
                              </div>

                        </div>
                    </div>
                    <div class="row ">
                    <img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;"/>
                            <button type="submit" class="btn btn-primary mx-auto">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="sidebar-overlay" data-reff=""></div>
</div>


	
<?php include 'includes/scripts.php' ?>

</body>
<script>
$(document).ready(function(){
  // get_branch();
  update_details();
    $('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        // appendTo: '#add-marking-center',
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
    $('.dialog1').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        // appendTo: '#add-marking-center',
        autoOpen: false,
        create: function(e){
            $(e.target).parent().css({
                'position':'fixed'
            }); 
            
        },
        buttons: [
            // {
            //     text: 'NO',
            //     click: function(){
            //         $(this).dialog('close');
            //     }
            // },
            {
                text: 'OK ',
                click: function(){
                    history.back();
                    $(this).dialog('close');
                }
            }
        ]
    });
    // $('select[name=bank]').select2({});
    // $('select[name=branch]').select2({});

  //  function get_branch(){
  //   var bank_id = $('select[name=bank]').val();
  //         $.ajax({
  //           url: 'php/get_branch.php',
  //           method: 'POST',
  //           data:{bank_id:bank_id},
  //           dataType: 'json',
  //           success:function(data){
  //             $('select[name=branch] option').remove();
  //             $.each(data,function(){
  //               $('select[name=branch]').append(
  //               '<option value="'+this["id"]+'">'+this["name"]+'</option>'
  //             );
  //             });
  //             $('select[name=branch]').select2({
  //             data:data
  //           });
  //           }
  //         });
  //  }
       


    $('select[name=bank]').change(function(){
          var bank_id = $(this).val();
          $.ajax({
            url: 'php/get_branch.php',
            method: 'POST',
            data:{bank_id:bank_id},
            dataType: 'json',
            success:function(data){
              $('select[name=branch] option').remove();
              $('select[name=branch]').append(
                '<option value="" selected disabled>Select Branch</option>'
              );
              $.each(data,function(){
                $('select[name=branch]').append(
                '<option value="'+this["id"]+'">'+this["name"]+'</option>'
              );
              });
              $('select[name=branch]').select2({
              data:data
            });
            }
          });
        });

function update_details(){
  $('#update_details').submit(function(e){
    e.preventDefault();
    $.ajax({
      url: 'php/edit_details.php',
      method: 'POST',
      data: $('#update_details').serialize(),
      dataType: 'json',
      beforeSend: function(){
				$('button[type=submit]').attr('disabled',true).addClass('bg_att');
        $('img.loading').css('display','block');
			},
      success:function(data){
        if(data.status == '400'){
          $('.dialog').text(data.response_msg).dialog('open');
          $('button[type=submit]').attr('disabled',false).removeClass('bg_att');
          $('img.loading').css('display','none');
        }else{
          $('.dialog1').text(data.response_msg).dialog('open');
          $('button[type=submit]').attr('disabled',false).removeClass('bg_att');
          $('img.loading').css('display','none');
        }
      }

    });
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