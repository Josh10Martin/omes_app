<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php';
     include '../config.php';
     include '../functions.php';
if($usertype  == 'SESO'){
    ?>

<body>
    <style>
        .tableFixHead          { overflow: auto; max-height: 20rem; }
        .tableFixHead thead th { position: sticky; top: 0; z-index: 1; background-color: #1d9d74;}
        .table td, .table th {
            border-top: 0px;
            padding: 0px;
        }
    </style>
<div class="main-wrapper">

    <?php include 'includes/navbar.php'?>     
    <?php include 'includes/sidebar.php'?>
<div class="page-wrapper">
    <div class="content">
        <div class="row justify-content-between px-2">
            <div class="col-sm-6">
            <h4 class="page-title">ALTER MARKSHEET</h4>
            </div>
           
        </div>

        <div class="row px-2">
            <div class="col-sm-6">
                <h4 class="h4">Province: <?php echo $_SESSION['province_name']; ?></h4>
            </div>
            <div class="col-sm-6">
            </div>
            <!-- <div class="col-sm-6">
                <h4 class="page-title">PROVINCE: <?php echo $_SESSION['province_name']; ?></h4>
            </div> -->
        </div>

       
        <div class="border border-primary">
            <div class="dialog"></div>
            <div class="dialog1"></div>
            <div class="dialog2"></div>
            <div class="dialog3"></div>
            <div class="dialog4"></div>
            <form id="alter_marksheet">
            <div class="row p-2 bg-white">
                <div class="col-md-3">
                    <!--  -->
                    <p class="text-center">DISTRICTS</p>
                    <span class="row px-2 justify-content-between">
                        <input type="text" class="form-control col-md-12 " placeholder="Search district" id="search_input_district">
                        <div class="col-4 p-0">Select All <input type="checkbox" name="" id="select_all_districts"> </div>
                    </span>
                    
                    <div class="tableFixHead table-hover bg-white p-1">
                        <table class="table_districts mb-0 ">
                            <tbody>
                              

                            </tbody>
                        </table>

                        </div>
                       
                </div>

               
                <div class="col-md-3 bg-light">
                <!--  -->
                  <div>
                    
                   <p class="text-center">SUBJECTS</p>
                    <span class="row px-2 justify-content-between">
                        <input type="text" class="form-control col-md-12" placeholder="Search Subject" id="search_input_subject">
                        <div class="col-4 p-0" >Select All <input type="checkbox" name="" id="select_all_subjects"> </div>
                    </span>

                  
                    <div class="tableFixHead table-hover p-1">
                        <table class="table_subject mb-0" id="beltTable">
                            <tbody>
                                

                            </tbody>
                        </table>

                        </div>
                  </div>
                  <!--  -->
                </div>
                <div class="col-md-3">
                    <!--  -->
                    <p class="text-center">CENTRES</p>
                    <span class="row px-2 justify-content-between">
                        <input type="text" class="form-control col-md-12" placeholder="Search centre" id="search_input_centre">
                        <div class="col-4 p-0 d-none" id="select_all_div">
                            Select All <input type="checkbox" name="" id="select_all"> 
                        </div>

                    </span>
                    
                    <div class="tableFixHead table-hover bg-white p-1">
                        <table class="table_centre mb-0 " id="beltTable">
                            <tbody>
                              

                            </tbody>
                        </table>

                        </div>
                      
                </div>
                <div class="col-md-3">
                <div class="form-group">
                                <label>MARKING CENTRE:</label>
                                <select class="select" name="marking_centre">
                                    
                                </select>
                            </div> 
                       <div class="col-12 pt-2 ">
                            <button type ="submit" class="btn btn-primary d-block mx-auto">Submit</button>
                            <div class="load"></div>
                        </div>
                </div>
                <!--  -->
            </div>
    </form>
        </div>


    <?php include 'includes/notifications.php' ?>
    </div> <!--End  content-->
</div> <!--End page wrapper-->
<!--Modal-->


<div class="sidebar-overlay" data-reff=""></div>
</div>	
<?php include 'includes/scripts.php' ?>

</body>
<script>
   $(document).ready(function(){
    get_districts();
    get_subjects_school();
    // subject_apportionment();
    // get_subjects_school();
    get_marking_centres();
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
                    location.reload();
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
                  alter_marksheet(storedSubjectCodes);
                  $(this).dialog('close');
                }
            },
            {
                text: 'NO',
                click: function(){
                    location.reload();
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
        autoOpen: false,
        create: function(e){
            $(e.target).parent().css({
                'position':'fixed'
            }); 
            
        },
        buttons: [
            {
                text: 'OK',
                click: function(){
                 location.reload();
                  $(this).dialog('close');
                }
            }
            // {
            //     text: 'NO',
            //     click: function(){
            //         location.reload();
            //         $(this).dialog('close');
            //     }
            // }
        ]
    });
    function get_marking_centres(){
        $.ajax({
        url: 'php/get_marking_centres.php',
        method: 'POST',
        dadaType: 'json',
         success:function(data){
            $('select[name=marking_centre] option').remove();
            $('select[name=marking_centre]').append(
                    '<option value="" selected disabled required>Select marking centre to transfer..</option>'
                );
            $.each(data,function(){
                $('select[name=marking_centre]').append(
                    '<option value="'+this["centre_code"]+':'+this["centre_name"]+'">'+this["centre_code"]+' - '+this["centre_name"]+'</option>'
                );
            });
        
            $('select[name=marking_centre]').select2({
              data:data
            });
        }
    });
    }
    // $("#type_centre_opt").prop('disabled', true);
    // $('.form-check-input').click(function(){
    // if ($("#select_centre").is(':checked')){
    //     $('#select_centre_opt').prop('disabled',false);
    //     $("#type_centre_opt").prop('disabled', true);
    //     console.log("Select!!!!!!")
    // }else{
    //    // $('#type_centre_opt').attr()
    //     $('#select_centre_opt').prop('disabled','disabled');
    //     $("#type_centre_opt").prop('disabled', false);
    //     console.log("Type!!!!!!")
    // }
    // });

    $("#select_all_districts").click(function(){
        if($("#select_all_districts").is(':checked')){
            $('.district-check').not(this).prop('checked', this.checked);
            var district = [];
            $('input:checkbox[name=district]:checked').each(function(){
            district.push($(this).val());
        });
            get_centres_per_subjects(district);
        }else{
            location.reload();
        }
        
     
    });
    $("#select_all_subjects").click(function(){
        $('.subject-check').not(this).prop('checked', this.checked);
        var subject_code = [];
        $('input:checkbox[name=subject_schools]:checked').each(function(){
           
           subject_code.push($(this).val());
        //    subject_code.splice($.inArray('undefined',subject_code),1);
           // alert($(this).val());
       });
       get_centres_per_subjects2(subject_code);

    });
    $("#select_all").click(function(){
        $('.centre-check').not(this).prop('checked', this.checked);
    });

$(document).on('keyup', '#search_input_centre', function() {
    var value = $(this).val().toLowerCase();
    $(".table_centre tr").filter(function() {
        var text = $(this).find("label").text().toLowerCase();
        
        var isVisible = text.indexOf(value) > -1;
        $(this).toggle(isVisible);
    });
});
$(document).on('keyup', '#search_input_district', function() {
    var value = $(this).val().toLowerCase();
    $(".table_districts tr").filter(function() {
        var text = $(this).find("label").text().toLowerCase();
        //console.log('TXT:',text)
        var isVisible = text.indexOf(value) > -1;
        $(this).toggle(isVisible);
    });
});
$(document).on('keyup', '#search_input_subject', function() {
    var value = $(this).val().toLowerCase();
    $(".table_subject tr").filter(function() {
        var text = $(this).find("label").text().toLowerCase();
        var isVisible = text.indexOf(value) > -1;
        $(this).toggle(isVisible);
    });
});
  function get_districts(){
    $.ajax({
        url: 'php/get_districts.php',
        method: 'POST',
        dataType: 'json',
        success: function(data){
            if(data.status == '200'){
                $('table.table_districts tbody tr.undefined').remove();
            $.each(data,function(){
                $('table.table_districts tbody').append('<tr class="'+this["district_code"]+'">'+
                '<td>'+
                    '<div class="d-flex justify-content-left align-items-center ml-2 mb-2">'+
                    '<span class="px-2"><input style="cursor:pointer;" type="checkbox" id="'+this["district_code"]+'" class="form-check district-check" name="district" value="'+this["district_code"]+'"></span>'+
                        '<label for="'+this["district_code"]+'" style="cursor:pointer;" class="text-center border-bottom border-primary">'+this["district_name"]+'</label>'+
                       
                    '</div>'+
                '</td>'+
            '</tr>');

            });
            $('table.table_districts tbody tr.undefined').remove();
            district_choice();

        }else{
            $('table.table_districts tbody td').text('NO Districts Available');
        }
        }
    });
  }
function district_choice(){
$('input[type=checkbox][name=district]').change(function(){
    
   // alert('hi');
    var district =[];
    if($('input:checkbox[name=district]').is(':checked')){
       
        $('input:checkbox[name=district]:checked').each(function(){
            district.push($(this).val());
        });
        get_centres_per_subjects(district);
    }
       
    });
}
  function get_subjects_school(){
    
    var marking_centre_code = $('input[type=hidden][name=marking_centre_code]').val();
    $.ajax({
        url:'php/get_subjects_school.php',
        method: 'POST',
        data: {marking_centre_code:marking_centre_code},
        dataType: 'json',
        success: function(data){
            $('table.table_subject tbody tr').remove();
            if(data.status == '400'){
                $('table.table_subject tbody').append('<tr class = "null">'+
                    '<td>No subjects available</td>'+
                '<tr>');
            }else{
            $.each(data,function(){
                $('table.table_subject tbody').append('<tr class="'+this["subject_code"]+'">'+
                    '<td>'+
                        '<div class="d-flex justify-content-left align-items-center mb-2">'+
                        '<span class="px-2"><input style="cursor:pointer;" type="checkbox" class="form-check subject-check" name="subject_schools" id="'+this["subject_code"]+'" value="'+this["subject_code"]+'"></span>'+
                            '<label style="cursor:pointer;" for="'+this["subject_code"]+'" class="text-center border-bottom border-primary">'+this["subject_code"]+' - '+this["subject_name"]+'</label>'+
                            
                        '</div>'+
                    '</td>'+
                '</tr>');
            });
            $('table.table_subject tbody tr.undefined').remove();
        }
    }
    });
  }
  function get_centres_per_subjects(district){
    $('input[type=checkbox][name=subject_schools]').change(function(){
        // $('input:checkbox[name=subject_schools]').not(this).prop('checked', false);
        var subject_code = [];
        if($('input:checkbox[name=subject_schools]').is(':checked')){
          
        $('input:checkbox[name=subject_schools]:checked').each(function(){
           
            subject_code.push($(this).val());
            // alert($(this).val());
        });
        $.ajax({
            url: 'php/get_centres_in_subjects_in_district.php',
            method: 'POST',
            data:{district:district,subject_code:subject_code},
            dataType: 'json',
            success:function(data){

                if (data){
                    $("#select_all_div").removeClass('d-none')
                   // console.log("data!!")
                }
                $('table.table_centre tbody tr.null').remove();
                    $('table.table_centre tbody tr').remove();
                    
                    $.each(data,function(){
                        $('table.table_centre tbody').append('<tr class="'+this["centre_code"]+'">'+
                        '<td>'+
                            '<div class="d-flex justify-content-left align-items-left mb-2">'+
                            '<span class="px-2"><input style="cursor:pointer;" type="checkbox" class="form-check centre-check" name="centre" id="'+this["centre_code"]+'" value="'+this["centre_code"]+'"></span>'+
                                '<label for="'+this["centre_code"]+'" class="text-center border-bottom border-primary" style="cursor:pointer;">'+this["centre_code"]+' - '+this["centre_name"]+'</label>'+
                                
                            '</div>'+
                        '</td>'+
                        '</tr>');
                        
                    });
                    $('table.table_centre tbody tr.undefined').remove();
                    alter(subject_code);
            }
        });
    }
    });

    
  }
//   function get_centres_per_subjects2(subject_code){
    
//         // alert('hi');
//         // $('input:checkbox[name=subject_schools]').not(this).prop('checked', false);
//         var district = [];
//         if($('input:checkbox[name=district]').is(':checked')){
           
//         $('input:checkbox[name=district]:checked').not(':checked[value=undefined]').each(function(){
           
//             district.push($(this).val());
//             // district.filter(function(e){
//             //     return e != 'undefined';
//             // })
               
            
//             // district.splice($.inArray('undefined',district), 1);
//             // alert($(this).val());
//         });
//         $.ajax({
//             url: 'php/get_centres_per_subjects.php',
//             method: 'POST',
//             data:{district:district,subject_code:subject_code},
//             dataType: 'json',
//             success:function(data){

//                 if (data){
//                     $("#select_all_div").removeClass('d-none')
//                     console.log("data!!")
//                 }
//                 $('table.table_centre tbody tr.null').remove();
//                     $('table.table_centre tbody tr').remove();
                    
//                     $.each(data,function(){
//                         $('table.table_centre tbody').append('<tr class="'+this["centre_code"]+'">'+
//                         '<td>'+
//                             '<div class="d-flex justify-content-center align-items-center mb-2">'+
//                                 '<label for="'+this["centre_code"]+'" class="text-center border-bottom border-primary" style="cursor:pointer;">'+this["centre_code"]+' - '+this["centre_name"]+'</label>'+
//                                 '<span class="px-2"><input style="cursor:pointer;" type="checkbox" class="form-check centre-check" name="centre" id="'+this["centre_code"]+'" value="'+this["centre_code"]+'"></span>'+
//                             '</div>'+
//                         '</td>'+
//                         '</tr>');
                        
//                     });
//                     $('table.table_centre tbody tr.undefined').remove();
//             }
//         });
//     }
  
//   }
var storedSubjectCodes = [];

function alter(subject_code){

    storedSubjectCodes = subject_code;
    $('#alter_marksheet').submit(function(e){
        e.preventDefault();
        $.each(subject_code,function(){

        });
        $('.dialog2').text('Are you sure you want to alter marksheet? Any entered marks on the affected examination centre(s) will be nullified. Continue?').dialog('open');

    });
}
function alter_marksheet(subject_code){
   
   var marking_centre = $('select[name=marking_centre]').val().split(':');
   var marking_centre_code = marking_centre[0]
   if(marking_centre != ''){
       var centre_code =[];
   if($('input[type=checkbox][name=centre]:checked').length > 0){
           $('input[type=checkbox][name=centre]:checked').each(function(){
           centre_code.push($(this).val());
       });
       $.ajax({
           url: 'php/alter_marksheet.php',
           method: 'POST',
           data: {marking_centre_code:marking_centre_code,centre_code:centre_code,subject_code:subject_code},
           dataType: 'json',
           beforeSend:function(){
               $('button[type=submit]').attr('disabled',true);
               $('.load').html('<img src="images/loading.gif" style="transform:scale(.7) translateY(-100%) translateX(-50%);left:50%;position:absolute;"/>');
           },
           success:function(data){
               if(data.status == '400'){
                   $('button[type=submit]').attr('disabled',false);
                   $('.load').html('');
                   $('.dialog').text(data.response_msg).dialog('open');
               }else{
                   script_movement();
                   if (data[0].username) {

                      $.each(data,function(){
                       delete_deo_from_payshedule(this['username']);
                       <?php if($_SESSION['session_type'] == 'E'){ ?>
                       send_deo_email(this["first_name"],this["last_name"],this["centre_code"],this["centre_name"],this["email"]);
                      <?php }else{ ?>
                        send_deo_email(this["first_name"],this["last_name"],this["centre_code"],this["centre_name"],this["email"],this["subject_name"]);
                        <?php } ?>
                      });
                       
                   }else{
                       $('#alter_marksheet').trigger('reset');
                   }
                   $('button[type=submit]').attr('disabled',false);
                   $('.load').html('');
                   $.each(data,function(){
                       // $('table.table_centre tbody input[type=checkbox]:checked').closest('tr').remove();
                       // $('table.table_subject tbody input[type=checkbox]:checked').closest('tr').remove();
                       // location.reload();
               });
               // $('.dialog').text(data.response_msg).dialog('open');
              
               }
           }
       });
   }else{
       $('.dialog1').text('You need to choose the examination centre(s)').dialog('open');
   }
}else{
   $('.dialog1').text('You need to choose the marking centre to transfer to').dialog('open');
}
}
function script_movement(){
    $.ajax({
        url: 'php/script_movement.php',
        dataType: 'json',
        method: 'POST',
        success(data){
           if(data.status == '200'){
           console.log(data.response_msg);
           $('.dialog3').text(data.response_msg).dialog('open');
           }else{
            $('.dialog3').text(data.response_msg).dialog('open');
            console.log(data.response_msg);
           }
        }
    });
}
function delete_deo_from_payshedule(username){
    $.ajax({
        url: 'php/delete_deo_from_payshedule.php',
        dataType: 'json',
        method: 'POST',
        data: {username:username},
        success(data){
           if(data.status == '200'){
           console.log(data);
           }else{
            console.log(data.status);
           }
        }
    });
}
function send_deo_email(first_name,last_name,centre_code,centre_name,email,subject_name = null){
    if(subject_name === null){
        $.ajax({
        // url: 'php/send_deo_alert_email.php',
        url: 'https://verify.exams-council.org.zm/orvs/send_deo_alert_email.php',
        dataType: 'json',
        method: 'POST',
        data: {first_name:first_name,last_name:last_name,centre_code:centre_code,centre_name:centre_name,email:email},
        success(data){
           if(data.status == '200'){
            $('dialog1').text('Marksheet successfully altered and script movement updated').dialog('open');
            $('#alter_marksheet').trigger('reset');
           }else{
            $('dialog1').text(data.response_msg).dialog('open');
           }
        }
    });
    }else{
        $.ajax({
        // url: 'php/send_deo_alert_email.php',
        url: 'https://verify.exams-council.org.zm/orvs/send_deo_alert_email.php',
        dataType: 'json',
        method: 'POST',
        data: {first_name:first_name,last_name:last_name,centre_code:centre_code,centre_name:centre_name,email:email,subject_name:subject_name},
        success(data){
           if(data.status == '200'){
            $('dialog1').text('Marksheet successfully altered and script movement updated').dialog('open');
            $('#alter_marksheet').trigger('reset');
           }else{
            $('dialog1').text(data.response_msg).dialog('open');
           }
        }
    });
    }
}
});

 
</script>

<?php
}else{
    header('location: ../');
}


?>
</html>