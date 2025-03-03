<?php

session_start();

?>


<!DOCTYPE html>
<html lang="en">



<?php include "includes/header.php";

if($_SESSION["user_type"]  == "ADMIN" || $_SESSION['user_type'] == 'DEO'){

    include "../config.php";
    include "../functions.php";
    include "php/get_bank2.php";
    include "php/get_branch2.php";
    if(isset($_GET["id"])){
        
        $id = $_GET["id"];
      //   $nrc = $_GET["nrc"] ?? $_SESSION["nrc"];

        $sql = $db_9->prepare("SELECT DISTINCT tr.nrc AS nrc,tr.id AS id,tr.tpin,tr.first_name AS first_name,tr.last_name AS last_name,tr.phone_number AS phone,tr.address AS address,
        tr.email AS email, tr.title AS transcriber_title, b.id AS transcriber_bank,tr.branch AS transcriber_branch,
        tr.account_no AS account_no
        FROM transcriber tr INNER JOIN bankbranch br ON (tr.branch = br.id)
        INNER JOIN bank b ON (br.bank_id = b.id)
         WHERE tr.id =:id");
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
$sql->bindColumn("transcriber_title",$transcriber_title);
$sql->bindColumn("transcriber_bank",$transcriber_bank);
$sql->bindColumn("transcriber_branch",$transcriber_branch);
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
<form action="" method="post" class="my-auto mx-auto" id="update_transcriber">
  <div class="text-center h4">Update Transcriber</div>
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
                        <p>NRC Number:<input disabled required type="text" id="nrc" placeholder="Nrc..." class="form-control" name="nrc_number" value="<?php echo $nrc; ?>" maxlength="11"></p>
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
                                <option value="MR" <?php echo $transcriber_title == "MR" ? "selected": ""; ?>>MR</option>
                                <option value="MRS" <?php echo $transcriber_title == "MRS" ? "selected": ""; ?>>MRS</option>
                                <option value="MS" <?php echo $transcriber_title == "MS" ? "selected": ""; ?>>MS</option>
                                <option value="DR" <?php echo $transcriber_title == "DR" ? "selected": ""; ?>>DR</option>
                                <option value="PROFF" <?php echo $transcriber_title == "PROFF" ? "selected": ""; ?>>PROFF</option>
                                <option value="HON" <?php echo $transcriber_title == "HON" ? "selected": ""; ?>>HON</option>
                                <option value="PR" <?php echo $transcriber_title == "PR" ? "selected": ""; ?>>PR</option>
                            </select>
                        </p>
                    </div>
                    
                    
                </div>
                <div class="row">
               
            
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
                                    <option value="<?php echo $bank_id; ?>" <?php echo $bank_id == $transcriber_bank ? "selected" : ""; ?>><?php echo $bank_name; ?></option>
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
                                 <option value="<?php echo $branch_id; ?>" <?php echo $branch_id == $transcriber_branch ? "selected" : ""; ?>><?php echo $branch_name; ?></option>
                                 <?php
                                }while($branch_sql->fetch(PDO::FETCH_BOUND));
                                 ?>
                                </select>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>ACCOUNT NUMBER:<input required type="text" maxlength="13"  placeholder="13 digit account number" class="form-control" name="account_no" value="<?php echo $account_no; ?>"></p>
                        </div>
                        <div class="col-md-6">
                        <p>T-PIN:<input type="text" id="t-pin" required placeholder="10 digit t-pin" class="form-control" name="tpin" value="<?php echo $tpin; ?>" maxlength="10"></p>
                    </div>
                        
                    </div>
                    
                   
                
            </div>

            <div class="col-md-6">
               
                <div class="row">
                  
                   
                </div>
            </div>
            
        </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
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
                    // location.href="examiners.php";
                    location.href="transcribers.php";
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

    $('#update_transcriber').submit(function(e){
        e.preventDefault();
        $.ajax({
        url: 'php/update_transcriber.php',
        method: 'POST',
        data: $(this).serialize(),
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
</script>

<?php 
    }else{
        header("location: transcribers.php");
    }
}else{
    header("location: ../");
}
?>
</html>