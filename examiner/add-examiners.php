<?php

session_start();

// include '../functions.php';
// include '../config.php';
// if(isset($_POST['first_name'])){

//   $first_name = $_POST['first_name'] ?? '';
//   $last_name = $_POST['last_name'] ?? '';
//   $nrc_number = $_POST['nrc_number'] ?? '';
//   $phone_number = $_POST['phone_number'] ?? '';
//   $email = $_POST['email'] ?? '';
//   $address = $_POST['address'] ?? '';
//   $title = $_POST['title'] ?? '';
//   $role = $_POST['role'] ?? '';
//   $tpin = $_POST['tpin'] ?? '';
//   $belt_number = $_POST['belt_number'] ?? '';
//   $attendance = $_POST['attendance'] ?? '';
//   $no_of_days = $_POST['no_of_days'] ?? '';
//   $marking_center = $_POST['marking_center'] ?? '';
//   $subject = $_POST['subject'] ?? '';
//   $paper = $_POST['paper'] ?? '';
//   $bank = $_POST['bank'] ?? '';
//   $branch = $_POST['branch'] ?? '';
//   $account_number = $_POST['account_number'] ?? '';
//   $session = '1';

//   if(!preg_match('/^[a-zA-Z \']+$/', $first_name) || !preg_match('/^[a-zA-Z \']+$/',$last_name)){
         
//           $message = '<p sryle="width:100%;height:100%;background-color:red;color:white;">Enter correct names</p>';
//   }else if(!preg_match('/^([1-9]{7}\/[1-9]{2}\/[1-9]{1})$/',$nrc_number)){
          
//           $message = '<p sryle="width:100%;height:100%;background-color:red;color:white;">Enter the NRC number in the format 000000/00/0 and continue</p>';
//   }else if(!preg_match('/^[1*9]{10}$/',$tpin)){

//           $message = '<p sryle="width:100%;height:100%;background-color:red;color:white;">Enter 10 digit tpin number</p>';
//   }else if(!preg_match('/^[0-9]{10}$/',$phone_number)){
         
//           $message = '<p sryle="width:100%;height:100%;background-color:red;color:white;">Enter 10 digit phone number</p>';
//   }else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
         
//           $message = '<p sryle="width:100%;height:100%;background-color:red;color:white;">Please enter an email address</p>';
//   }else if(nrc_exists($db_9,$nrc_number) == 'true'){
         
//           $message = '<p sryle="width:100%;height:100%;background-color:red;color:white;">NRC number '.$nrc_number.' is already in use</p>';
//   }else if(email_exists($db_9,$email) == 'true'){
         
//           $message = '<p sryle="width:100%;height:100%;background-color:red;color:white;">The email '.$email.' is already in use</p>';
//   }else if(tpin_exists($db_9,$tpin) == 'true'){
         
//           $message = '<p sryle="width:100%;height:100%;background-color:red;color:white;">The tpin '.$tpin.' is already in use.</p>';
//   }else if(!preg_match('/^[0-9]{13}$/',$account_number)){
         
//           $message = '<p sryle="width:100%;height:100%;background-color:red;color:white;">Enter 13 digit account number</p>';
//   }else{
//           try{
//   $sql = $db_9->prepare('INSERT INTO examiner (nrc,tpin,first_name,last_name,phone_number,email,address,title,role,belt_no,attendance,no_of_days,marking_centre,subject_code,paper_no,bank,branch,account_no,session)
//                           VALUES (:nrc,:tpin,:first_name,:last_name,:phone,:email,:address,:title,:role,:belt_no,:attendance,:no_of_days,:marking_centre,:subject_code,:paper_no,:bank,:branch,:account_no,:session)');
//   $sql->execute(array(
//           ':nrc'=>$nrc_number,
//           ':tpin'=>$tpin,
//           ':first_name'=>$first_name,
//           ':last_name'=>$last_name,
//           ':phone'=>$phone_number,
//           ':email'=>$email,
//           ':address'=>$address,
//           ':title'=>$title,
//           ':role'=>$role,
//           ':belt_no'=>$belt_number,
//           ':attendance'=>$attendance,
//           ':no_of_days'=>$no_of_days,
//           ':marking_centre'=>$marking_center,
//           ':subject_code'=>$subject,
//           ':paper_no'=>$paper,
//           ':bank'=>$bank,
//           ':branch'=>$branch,
//           ':account_no'=>$account_number,
//           ':session'=>$session
//   ));
//   if($sql->rowCount() > 0){

//           $message ='<p sryle="width:100%;height:100%;background-color:green;color:white;">'.$role.' details successfully added</p>';
//   }else{
         
//           $message = '<p sryle="width:100%;height:100%;background-color:red;color:white;">Could not add '.$role.'. Please try again </p>';
//   }

// }catch(PDOEXCEPTION $e){
 
//   $error = 'There was an error: '.$e->getMesage();
// }

//   }
// }

?>

<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php';

if($_SESSION['user_type'] == 'ADMIN'){

  ?>

<body>

    <style>
        * {
          box-sizing: border-box;
        }
        
        button {
          background-color: #04AA6D;
          color: #ffffff;
          border: none;
          padding: 5px 10px;
          font-size: 15px;
          font-family: Raleway;
          cursor: pointer;
        }
        
        button:hover {
          opacity: 0.8;
        }
        
        .form-control {
         height: calc(1.25rem + 2px);
        }
        .select{
            height: calc(1.25rem + 2px);
        }
        .title{
            color:#7a75b5;
        }
        </style>
<div class="main-wrapper">

    <?php include 'includes/navbar.php'?>     

    <?php include 'includes/sidebar.php'?>

    <div class="page-wrapper">
      
            <div class="content p-3">
            <?php if(isset($message)){
              echo '<script>
              $("div.message").text(',$message,').slideDown(400);
              setTimeout(function() {
                $("div.message").slideUp(400);
            }, 3000);
              </script>';
            }
            
            ?>
            <div class="message" style="z-index:10;position:absolute; width:100%; height:10px;font-size:17px;text-align:center;top:20%;left:43%;">
           
          </div>
            <div class="dialog"></div>
            <div class="dialog1"></div>
            <div class="dialog2"></div>
            <div class="id"></div>
  <form action="" method="" class="my-auto mx-auto" id="add_examiner">
  <div class="text-center h4">New Examiner</div>
  <div class="title">PERSONAL DETAILS:</div> 
        <div class="row">
            <div class="col-md-6 ">
                <div class="row">
                    <div class="col-md-6">
                        <p>Other Name(s):<input required type="text" placeholder="Other name (s)..." class="form-control" name="first_name" oninput="this.value = this.value.toUpperCase()"></p>
                    </div>
                    <div class="col-md-6">
                        <p>Last Name:<input required type="text" placeholder="Last name..." class="form-control" name="last_name" oninput="this.value = this.value.toUpperCase()"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p>NRC Number:<input required type="text" placeholder="Nrc..." class="form-control" name="nrc_number" maxlength="11"></p>
                    </div>
                    <div class="col-md-6">
                        <p>Phone Number:<input required type="text" maxlength="10" placeholder="phone number..." class="form-control" name="phone_number"></p>
                    </div>
                    <div class="col-md-6">
                        <p>Email:<input required type="email" placeholder="email..." class="form-control" name="email"oninput="this.value = this.value.toLowerCase()"></p>
                    </div>
                    <div class="col-md-6">
                        <p>Address:<textarea required rows="2" cols="6" class="form-control" placeholder="Enter Address" name="address" oninput="this.value = this.value.toUpperCase()"></textarea></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="row">
                    <div class="col-md-6">
                        <p>Title:
                            <select class="select" name="title" required>
                                <option selected disabled>Select Title</option>
                                <option value="MR">MR</option>
                                <option value="MRS">MRS</option>
                                <option value="MISS">MSS</option>
                                <option value="DR">DR</option>
                                <option value="PROFF">PROFF</option>
                                <option value="HON">HON</option>
                                <option value="PR">PR</option>
                            </select>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p>Role:
                            <select class="select" name="role" required>
                             
                            </select>
                        </p>
                    </div>
                    
                </div>
                <div class="row">
                <div class="col-md-3">
                        <p>N0. of days:<input required type="number" placeholder="number of dasys" class="form-control" name="no_of_days"></p>
                    </div>
                    <div class="col-md-3">
                        <p>Belt Number:<input required type="text" placeholder="belt number..." class="form-control" name="belt_number"></p>
                    </div>
                    <div class="col-md-6">
                        <p>Attendance:
                            <select class="select" name="attendance" required>
                            </select>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>Marking Center:<input required type="text"  placeholder="Marking center..." class="form-control" name="marking_centre_name" oninput="this.value = this.value.toUpperCase()" readonly></p>
                        <input type="hidden" name="marking_centre">
                    </div>
                </div>
                
                
            </div>
          
        </div>



        <div class="row">
        <div class="col-md-6">
                <div class="title">
                    BANK DETAILS:
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p>BANK:
                                <select required class="select" name="bank" style="width:100%;">
                                    
                                </select>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <p>BRANCH:
                                <select required class="select" name="branch" style="width:100%;">
                                 
                                </select>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>ACCOUNT NUMBER:<input required type="text" maxlength="13"  placeholder="13 digit account number" class="form-control" name="account_number"></p>
                        </div>
                        <div class="col-md-6">
                        <p>T-PIN:<input type="text" required placeholder="10 digit t-pin" class="form-control" name="tpin" maxlength="10"></p>
                    </div>
                        
                    </div>
                    
                   
                
            </div>

            <div class="col-md-6">
                <div class="title">
                    SUBJECT DETAILS:
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>SUBJECT:
                            <select class="select" name="subject" required>
                                
                            </select>
                        </p>
                    </div>
                    <div class="col-md-12">
                        <p>PAPER:
                            <select class="select" name="paper" required>
                         
                            </select>
                        </p>
                    </div>
                </div>
            </div>
            
        </div>

<div class="row justify-content-center">
<img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;"/>
    <button type="submit" id="save" class="btn btn-primary float-right">Submit</button>
</div>
        

  </form>

                <?php include 'includes/notifications.php' ?>
            </div>
    </div>

            <div class="sidebar-overlay" data-reff=""></div>
</div>

	
<?php include 'includes/scripts.php' ?>

<script>


    $(document).ready(function(){
      add_examiner();
      $('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
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
      $('.id').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        autoOpen: false,
        create: function(e){
            $(e.target).parent().css({
                'position':'fixed'
            }); 
            
        },
        buttons: [
            {
                text: 'YES',
                click: function(){
                  var id = $('.id').data('id');
                   delete_examiner(id);
                   $(this).dialog('close');
                }
            },
            {
                text: 'NO',
                click: function(){
                    $(this).dialog('close');
                }
            }
        ]
    });
    $('input[type=text][name=first_name]').attr('autofocus',true);
      $('input[type=text][name=nrc_number]').keyup(function(){
        
        var nrc = $(this).val();
        if(nrc.length == 6 ){
          var str = nrc+'/';
          $(this).val(str);
        }
        if(nrc.length == 9){
          var str = nrc+'/';
          $(this).val(str);
        }
     
        
      });
      
      $.ajax({
        url: 'php/get_marking_centre.php',
        method: 'POST',
        dataType: 'json',
        success:function(data){
          if(data.status == '200'){
            $('input[type=text][name=marking_centre_name]').val(''+data.marking_centre_name);
            $('input[type=hidden][name=marking_centre]').val(''+data.marking_centre_code);
          }else{
            $('input[type=text][name=marking_centre_name]').val('[MARKING CENTRE NOT SET]');
            $('input[type=hidden][name=marking_centre]').val('error');
          }
        }
      });
        $.ajax({
                url: 'php/get_roles.php',
                mrthod: 'POST',
                dataType: 'json',
                success:function(data){
                  $('select[name=role]').append(
                                        '<option value=" : "selected disabled>Select Role</option>'
                                );
                        $.each(data,function(){
                                $('select[name=role]').append(
                                        '<option value="'+this["id"]+':'+this["name"]+'">'+this["name"]+'</option>'
                                );
                        });
                }
        });
        $('select[name=role]').change(function(){
          var data = $(this).val(),
          arr = data.split(':');
          if(arr[0] == '4' || arr[0] =='5'){
            $('input[type=text][name=belt_number]').val('0').attr('readonly',true);
          }else{
            $('input[type=text][name=belt_number]').val('').attr('readonly',false);
          }
        })

        $.ajax({
          url: 'php/get_attendance.php',
          method: 'POST',
          dataType: 'json',
          success:function(data){
            $('select[name=attendance]').append(
              '<option selected disabled>Select Attendance</option>'
            );
            $.each(data,function(){
              $('select[name=attendance]').append(
                '<option value="'+this["id"]+'">'+this["name"]+'</option>'
              );
            });
          }
        });

        $.ajax({
          url: 'php/get_subject.php',
          method: 'POST',
          dataType: 'json',
          success:function(data){
            $('select[name=subject] option').remove();
              $('select[name=subject]').append(
                '<option selected disabled>Select Subject</option>'
              );
              $.each(data,function(){
                $('select[name=subject]').append(
                '<option value="'+this["subject_code"]+'">'+this["subject_code"]+' - '+this["subject_name"]+'</option>'
              );
              });
              $('select[name=subject]').select2({
                data:data
              });
          }
        });

        $('select[name=subject]').change(function(){
          var subject_code = $(this).val();
          $.ajax({
            url: 'php/get_paper.php',
            method: 'POST',
            data:{subject_code:subject_code},
            dataType: 'json',
            success:function(data){
              $('select[name=paper] option').remove();
              $('select[name=paper]').append(
                '<option value="" selected disabled>Select Paper Number</option>'
              );
              $.each(data,function(){
                $('select[name=paper]').append(
                '<option value="'+this["paper_no"]+'">'+this["paper_no"]+'</option>'
              );
              });
            }
          });
        });


        $.ajax({
          url: 'php/get_bank.php',
          method: 'POST',
          dataType: 'json',
          success: function(data){
      
            $('select[name=bank]').append(
                '<option value="" selected disabled>Select Bank</option>'
              );
              $.each(data,function(){
                $('select[name=bank]').append(
                '<option value="'+this["id"]+'" >'+this["name"]+'</option>'
              );
              });
              $('select[name=bank]').select2({
              data:data
            });
          }
        });
      
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
      }); 
      function add_examiner(){
        $('#add_examiner').submit(function(e){
                e.preventDefault();
                // var first_name = $('input[type=text][name=first_name]').val(),
                //  last_name = $('input[type=text][name=last_name]').val(),
                //  nrc_number = $('input[type=text][name=nrc_number]').val(),
                //  tpin = $('input[type=text][name=tpin]').val(),
                //  phone_number = $('input[type=text][name=phone_number]').val(),
                //  email = $('input[type=text][name=email]').val(),
                //  account_number = $('input[type=text][name=account_number]').val(),
                //  name_regex = /^[a-zA-Z \']+$/,
                //  tpin_redex = /^[1*9]{10}$/,
                //  phone_regex = /^[0-9]{10}$/,
                //  email_regex = /\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\b./,
                //  nrc_regex = /^([1-9]{7}) \/ ([1-9]{2}) \/ ([1-1]{1})$/,
                //  account_no_regex = /^[0-9]{13}$/;
                
                //  if(!name_regex.test(first_name) || !name_regex.test(last_name)){
                //         $('.dioalog').text('Please enter correct name or surname').dialog('open');
                       
                //  }else if(!nrc_regex.test(nrc_number)){
                //         $('.dioalog').text('Please enter NRC in the format 00000/00/0').dialog('open');
                       
                //  }else if(!tpin_redex.test(tpin)){
                //         $('.dioalog').text('Please enter 10 digit TPIN').dialog('open');
                       
                //  }else if(!phone_regex.test(phone_number)){
                //         $('.dioalog').text('Please enter 10 digit phone number').dialog('open');
                       
                //  }else if(!email_regex.test(email)){
                //         $('.dioalog').text('Please eter correct email address').dialog('open');
                       
                //  }else if(!account_no_regex.test(account_number)){
                //   $('.dioalog').text('Please enter 13 digit account number').dialog('open');
                //   }else{
                $.ajax({
                        url: 'php/add-examiners.php',
                        method: 'POST',
                        data: $('#add_examiner').serialize(),
                        dataType: 'json',
                        beforeSend:function(){
                          $('button[id=save]').attr('disabled',true).addClass('bg_att');
                          $('img.loading').css('display','block');
                        },
                        success:function(data){
                          
                                if(data.status == '200'){
                                        $('.dialog1').text(data.response_msg).dialog('open');
                                       
                                        $('button[id=save]').attr('disabled',false).text('Submit');
                                        $('#add_examiner').trigger('reset');
                                        $('img.loading').css('display','none');
                                        $('input[type=text][name=first_name]').attr('autofocus',true);
                                }else{
                                  if(data.status == '401'){
                                      var id = data.id;
                                      $('.id').text(data.mexxage+' Delete to continue registration?').data('id',id).dialog('open');
                                    }else{
                                  $('button[id=save]').attr('disabled',false).text('Submit');
                                  $('img.loading').css('display','none');
                                  $('.dialog').text(data.response_msg).dialog('open');
                                }
                        }
                });

        // }
        });
      }
      function delete_examiner(id){
        $.ajax({
          url: 'php/delete_examiner.php',
          method: 'POST',
          data: {id:id},
          dataType: 'json',
          success: function(data){
            if(data.status == '400'){
              $('.dialog').text(data.response_msg).dialog('open');
            }else{
              $('.dialog').text(data.response_msg).dialog('open');
			}
		}
	});
}

    </script>

</body>

<?php
}else{
  header('location: ../');
}
?>


</html>