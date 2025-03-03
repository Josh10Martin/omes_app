<?php

session_start();

?>


<!DOCTYPE html>
<html lang="en">



<?php include "includes/header.php";

if($_SESSION["user_type"]  == "ADMIN"){

    include "../config.php";
    include "../functions.php";
    include "php/get_bank2.php";
    include "php/get_role2.php";
    include "php/get_attendance2.php";
    include "php/get_branch2.php";
    include "php/get_bank2.php";
    include "php/get_subject2.php";
    if(isset($_GET["id"])){
        
        $id = $_GET["id"];

        $sql = $db_ted->prepare("SELECT DISTINCT nrc AS nrc,id AS id,tpin,first_name AS first_name,last_name AS last_name,phone_number AS phone,address AS address,
        email AS email,belt_no AS belt_no,role AS examiner_role,attendance AS examiner_attendance, title AS examiner_title, bank AS examiner_bank,branch AS examiner_branch,
        subject_code AS examiner_subject_code, paper_no AS examiner_paper_no, no_of_days, account_no
        FROM examiner WHERE id =:id");
$sql->execute(array(
":id"=>$id
));
$sql->bindColumn("nrc",$nrc);
$sql->bindColumn("id",$id);
$sql->bindColumn("first_name",$first_name);
$sql->bindColumn("last_name",$last_name);
$sql->bindColumn("phone",$phone);
$sql->bindColumn("address",$address);
$sql->bindColumn("email",$email);
$sql->bindColumn("belt_no",$belt_no);
$sql->bindColumn("examiner_role",$examiner_role);
$sql->bindColumn("examiner_attendance",$examiner_attendance);
$sql->bindColumn("examiner_title",$examiner_title);
$sql->bindColumn("examiner_bank",$examiner_bank);
$sql->bindColumn("examiner_branch",$examiner_branch);
$sql->bindColumn("examiner_subject_code",$examiner_subject_code);
$sql->bindColumn("examiner_paper_no",$examiner_paper_no);
$sql->bindColumn("no_of_days",$no_of_days);
$sql->bindColumn("account_no",$account_no);
$sql->bindColumn("tpin",$tpin);
$sql->fetch(PDO::FETCH_BOUND);
    
?>
<body>
<div class="main-wrapper">

    <?php include "includes/navbar.php"?>     

    <?php include "includes/sidebar.php"?>

    <div class="page-wrapper">
            <div class="content p-4">
                <div class="dialog1"></div>
                <div class="dialog2"></div>
                <div class="dialog3"></div>
                <?php  echo $_SESSION['session_id']; ?>
<form action="" method="post" class="my-auto mx-auto" id="update_examiner">
  <div class="text-center h4">Update Examiner</div>
  <div class="blue-ecz">PERSONAL DETAILS:</div> 
        <div class="row">
            <div class="col-md-6 ">
                <div class="row">
                    <div class="col-md-6">
                        <p>Other Name(s):<input required type="text" placeholder="Other name (s)..." class="form-control" name="first_name" value="<?php echo $first_name; ?>" oninput="this.value = this.value.toUpperCase()"></p>
                    </div>
                    <div class="col-md-6">
                        <p>Last Name:<input required type="text" placeholder="Last name.." class="form-control" name="last_name" value="<?php  echo $last_name;?>" oninput="this.value = this.value.toUpperCase()"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p>NRC Number:<input required disabled type="text" id="nrc" placeholder="Nrc..." class="form-control" name="nrc_number" value="<?php echo $nrc; ?>" maxlength="11"></p>
                    </div>
                    <div class="col-md-6">
                        <p>Phone Number:<input required type="text" id="phone" maxlength="10" placeholder="phone number..." class="form-control" name="phone_number" value="<?php  echo $phone;?>"></p>
                    </div>
                    <div class="col-md-6">
                        <p>Email:<input required type="email" placeholder="email..." class="form-control" name="email" value="<?php  echo $email; ?>"oninput="this.value = this.valutoLowerCase()"></p>
                    </div>
                    <div class="col-md-6">
                        <p>Address:<textarea required rows="2" cols="6" class="form-control" placeholder="Enter Address" name="address" oninput="this.value = this.valutoUpperCase()"><?php  echo $address; ?></textarea></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="row">
                    <div class="col-md-6">
                        <p>Title:
                            <select class="select" name="title" required>
                                <option disabled>Select Title</option>
                                <option value="MR" <?php echo $examiner_title == "MR" ? "selected": ""; ?>>MR</option>
                                <option value="MRS" <?php echo $examiner_title == "MRS" ? "selected": ""; ?>>MRS</option>
                                <option value="MS" <?php echo $examiner_title == "MS" ? "selected": ""; ?>>MS</option>
                                <option value="DR" <?php echo $examiner_title == "DR" ? "selected": ""; ?>>DR</option>
                                <option value="PROFF" <?php echo $examiner_title == "PROFF" ? "selected": ""; ?>>PROFF</option>
                                <option value="HON" <?php echo $examiner_title == "HON" ? "selected": ""; ?>>HON</option>
                                <option value="PR" <?php echo $examiner_title == "PR" ? "selected": ""; ?>>PR</option>
                            </select>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p>Role:
                            <select class="select" name="role" required>
                                <?php 
                                do{
                                ?>
                             <option value="<?php echo $role_id; ?>" <?php echo $role_id == $examiner_role ? "selected" : ""; ?>><?php echo $role_name; ?></option>
                             <?php }while($role_sql->fetch(PDO::FETCH_BOUND)); ?>
                            </select>
                                <?php
                                if($role_id == user_id($db_ted)){
                                    ?>
                                    <a href="#" class="reset_pass" data-id="<?php echo $id; ?>">reset password</a>
                                    <?php
                                }
                                ?>
                        </p>
                    </div>
                    
                </div>
                <div class="row">
                <div class="col-md-3">
                        <p>N0. of days:<input required type="number" placeholder="number of dasys" class="form-control" name="no_of_days" value="<?php echo $no_of_days; ?>"></p>
                    </div>
                    <div class="col-md-3">
                        <p>Belt Number:<input required type="text" id="belt" placeholder="belt number..." class="form-control" name="belt_no" value="<?php echo $belt_no; ?>"></p>
                    </div>
                    <div class="col-md-6">
                        <p>Attendance:
                            <select class="select" name="attendance" required>
                                <?php
                                do{
                                ?>
                            <option value="<?php echo $attendance_id; ?>" <?php echo $attendance_id == $examiner_attendance ? "selected" : ""; ?>><?php echo $attendance_name; ?></option>
                            <?php
                                }while($attendance_sql->fetch(PDO::FETCH_BOUND));
                            ?>
                            </select>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>Marking Centre:<input required type="text"  placeholder="Marking center..." class="form-control" name="marking_centre_name" value="<?php echo $_SESSION['marking_centre']; ?>" disabled></p>
                       
                    </div>
                </div>
                
                
            </div>
          
        </div>



        <div class="row">
        <div class="col-md-6">
                <div class="blue-ecz">
                    BANK DETAILS:
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p>BANK:
                                <select required class="select" name="bank" style="width:100%;">
                                <?php
                                do{
                                ?>
                                    <option value="<?php echo $bank_id; ?>" <?php echo $bank_id == $examiner_bank ? "selected" : ""; ?>><?php echo $bank_name; ?></option>
                                    <?php }while($bank_sql->fetch(PDO::FETCH_BOUND)); ?>
                                </select>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <p>BRANCH:
                                <select required class="select" name="branch" style="width:100%;">
                                <?php
                                do{
                                ?>
                                 <option value="<?php echo $branch_id; ?>" <?php echo $branch_id == $examiner_branch ? "selected" : ""; ?>><?php echo $branch_name; ?></option>
                                 <?php
                                }while($branch_sql->fetch(PDO::FETCH_BOUND));
                                 ?>
                                </select>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>ACCOUNT NUMBER:<input required type="text" maxlength="15"  placeholder="account number" class="form-control" name="account_no" value="<?php echo $account_no; ?>"></p>
                        </div>
                        <div class="col-md-6">
                        <p>T-PIN:<input type="text" id="t-pin" required placeholder="10 digit t-pin" class="form-control" name="tpin" value="<?php echo $tpin; ?>" maxlength="10"></p>
                    </div>
                        
                    </div>
                    
                   
                
            </div>

            <div class="col-md-6">
                <div class="blue-ecz">
                    SUBJECT DETAILS:
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>SUBJECT:
                            <select class="select" name="subject" required>
                                <?php
                                do{
                                ?>
                                <option value="<?php echo $subject_code; ?>" <?php echo $subject_code == $examiner_subject_code ? "selected" : "" ?>><?php echo $subject_name; ?></option>
                                    <?php } while($subject_sql->fetch(PDO::FETCH_BOUND)); ?>
                            </select>
                        </p>
                    </div>
                    <div class="col-md-12">
                        <p>PAPER:
                            <select class="select" name="paper" required>
                         <option value="1">1</option>
                            </select>
                        </p>
                    </div>
                </div>
            </div>
            
        </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="nrc" value="<?php echo $nrc; ?>">
<div class="row justify-content-center">
    <img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;"/>
    <button type="submit" id="save" class="btn btn-primary float-right">Submit</button>
</div>
        

  </form>

	<?php include "includes/scripts.php"; ?>

</body>
<script>
$(document).ready(function(){
    $('#phone').mask('0000000000');
    $('#nrc').mask('000000/00/0');
    $('#t-pin').mask('0000000000');
    $('#belt').mask('000');
    
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
                    location.href="examiners.php";
                    $(this).dialog('close');
                }
            }
        ]
    });

    $('.dialog2').dialog({
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
    $('.dialog3').dialog({
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
            {
                text: 'NO',
                click: function(){
                    $(this).dialog('close');
                }
            },
            {
                text: 'YES',
                click: function(){
                    var id = $('.dialog3').data('id');
                    reset_password(id);
                    $(this).dialog('close');
                }
            }
        ]
    });

    $('#update_examiner').submit(function(e){
        e.preventDefault();
        $.ajax({
        url: 'php/update_examiner.php',
        method: 'POST',
        data: $('#update_examiner').serialize(),
        dataType: 'json',
        beforeSend: function(){
            $('button[id=save]').attr('disabled',true).addClass('bg_att');
            $('img.loading').css('display','block');
        },
        success:function(data){
            if(data.status == '200'){
                $('.dialog1').text(data.response_msg).dialog('open');
                $('button[id=save]').attr('disabled',false).removeClass('bg_att').text('Submit');
                $('img.loading').css('display','none');
            }else{
                $('.dialog2').text(data.response_msg).dialog('open');
                $('button[id=save]').attr('disabled',false).removeClass('bg_att').text('Submit');
                $('img.loading').css('display','none');
            }
        }
    });
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
    function reset_deo_password(){
        $('a.reset_pass').click(function(){
            var id = $(this).data('id');
            $('.dialog3').text('Reset Data Eentr Operators password?').data('id',id).dialog('open');
        });
    }
    function reset_password(id){
        $.ajax({
            url: 'php/reset_deo_password.php',
            method: 'POST',
            data: {id:id},
            dataType: 'json',
            success: function(data){
                if(data.status == '200'){
                    $('.dialog1').text(data.response_msg).dialog('open');
                }else{
                    $('.dialog2').text(data.response_msg).dialog('open');
                }
            }
        });
    }
});
</script>

<?php 
    }else{
        header("location: examiners.php");
    }
}else{
    header("location: ../");
}
?>
</html>