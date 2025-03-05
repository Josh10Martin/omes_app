<?php
session_start();

if(isset($_GET['marking_centre_code']) && isset($_GET['marking_centre_name'])){
    $marking_centre_code = $_GET['marking_centre_code'];
    $marking_centre_name = $_GET['marking_centre_name'];

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
                <h4 class="page-title">CENTRE APPORTIONMENT</h4>
            </div>
           
        </div>

        <div class="row px-2">
            <div class="col-sm-6">
                <h4 class="h4">Province: <?php echo $_SESSION['province_name']; ?></h4>
            </div>
            <div class="col-sm-6">
                <div class="h4">Marking Centre : <span class="h4"> <?php echo $marking_centre_name; ?></span> </div> 
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
            <form id="apportion_subjects">
            <div class="row p-2 bg-white">
                <div class="col-md-4">
                    <!--  -->
                    <p class="text-center">DISTRICTS</p>
                    <span class="row px-2 justify-content-between">
                        <input type="text" class="form-control col-md-6 " placeholder="Search district" id="search_input_district">
                        <div class="col-4 p-0">Select All <input type="checkbox" name="" id="select_all_districts"> </div>
                    </span>
                    
                    <div class="tableFixHead table-hover bg-white p-1">
                        <table class="table_districts mb-0 ">
                            <tbody>
                              

                            </tbody>
                        </table>

                        </div>
                       
                </div>

               
                
                
                <div class="col-md-4 bg-light">
                <!--  -->
                  <div>
                    
                   <p class="text-center">SUBJECTS</p>
                   <span class="row px-2 justify-content-between">
                        <input type="text" class="form-control col-md-6" placeholder="Search Subject" id="search_input_subject">
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
                <!--  -->
                <div class="col-md-4">
                    <!--  -->
                    <p class="text-center">CENTRES</p>
                    <span class="row px-2 justify-content-between">
                        <div class="col-8"><input type="text" class="form-control" placeholder="Search centre" id="search_input_centre"></div>
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
                       <input type="hidden" name="marking_centre_code" value="<?php echo $marking_centre_code; ?>">
                        <div class="col-12 pt-2 ">
                            <button type ="submit" class="btn btn-primary d-block mx-auto">Submit</button>
                            <div class="load"></div>
                        </div>
                </div>
                <!--  -->
            </div>
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
    subject_apportionment();
    get_centres_per_district();
    get_all_subjects();
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
                    // location.reload();
                    $(this).dialog('close');
                }
            }
        ]
    });
   
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
            // get_centres_per_district(district);
        });
            // get_centres_per_subjects(district);
        }else{
            location.reload();
        }
        
     
    });

    $("#select_all_subjects").click(function () {
    $('.subject-check').prop('checked', this.checked);

    setTimeout(function () { // Ensure checkboxes are updated before reading values
        var subject_code = [];

        $('input:checkbox[name=subject_code]:checked').each(function () {
            subject_code.push($(this).val());
        });

        console.log("Calling get_centres_per_district with:", subject_code);
        get_centres_per_district(subject_code);
    }, 10);

});

$(document).on('change', 'input:checkbox[name=subject_code]', function () {
    var subject_code = [];

    $('input:checkbox[name=subject_code]:checked').each(function () {
        subject_code.push($(this).val());
    });

    console.log("Individual checkbox clicked:", subject_code);
    get_centres_per_district(subject_code);
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
            // district_and_subject_choice();

        }else{
            $('table.table_districts tbody td').text('NO Districts Available');
        }
        }
    });
  }

function district_and_subject_choice(){
$('input[type=checkbox][name=district]').change(function(){
    
   //alert('hi');
    var district =[];
    var subject_code =[];
    if($('input:checkbox[name=district]').is(':checked') && $('input:checkbox[name=subject_code]').is(':checked')){
       
        $('input:checkbox[name=district]:checked').each(function(){
            district.push($(this).val());
        });
        $('input:checkbox[name=subject_code]:checked').each(function(){
            subject_code.push($(this).val());
        });
        
        // get_centres_per_district(district,subject_code);
    }
       
    });
}
//   function get_subjects_school(){
    
//     var marking_centre_code = $('input[type=hidden][name=marking_centre_code]').val();
//     $.ajax({
//         url:'php/get_subjects_school.php',
//         method: 'POST',
//         data: {marking_centre_code:marking_centre_code},
//         dataType: 'json',
//         success: function(data){
//             $('table.table_subject tbody tr').remove();
//             if(data.status == '400'){
//                 $('table.table_subject tbody').append('<tr class = "null">'+
//                     '<td>No subjects available</td>'+
//                 '<tr>');
//             }else{
//             $.each(data,function(){
//                 $('table.table_subject tbody').append('<tr class="'+this["subject_code"]+'">'+
//                     '<td>'+
//                         '<div class="d-flex justify-content-left align-items-center mb-2">'+
//                         '<span class="px-2"><input style="cursor:pointer;" type="checkbox" class="form-check subject-check" name="subject_schools" id="'+this["subject_code"]+'" value="'+this["subject_code"]+'"></span>'+
//                             '<label style="cursor:pointer;" for="'+this["subject_code"]+'" class="text-center border-bottom border-primary">'+this["subject_code"]+' - '+this["subject_name"]+'</label>'+
                            
//                         '</div>'+
//                     '</td>'+
//                 '</tr>');
//             });
//             $('table.table_subject tbody tr.undefined').remove();
//         }
//     }
//     });
//   }

//   function get_centres_per_subjects(district){
//     $('input[type=checkbox][name=subject_schools]').change(function(){
//         // $('input:checkbox[name=subject_schools]').not(this).prop('checked', false);
//         var subject_code = [];
//         if($('input:checkbox[name=subject_schools]').is(':checked')){
          
//         $('input:checkbox[name=subject_schools]:checked').each(function(){
           
//             subject_code.push($(this).val());
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
//                    // console.log("data!!")
//                 }
//                 $('table.table_centre tbody tr.null').remove();
//                     $('table.table_centre tbody tr').remove();
                    
//                     $.each(data,function(){
//                         $('table.table_centre tbody').append('<tr class="'+this["centre_code"]+'">'+
//                         '<td>'+
//                             '<div class="d-flex justify-content-left align-items-left mb-2">'+
//                             '<span class="px-2"><input style="cursor:pointer;" type="checkbox" class="form-check centre-check" name="centre" id="'+this["centre_code"]+'" value="'+this["centre_code"]+'"></span>'+
//                                 '<label for="'+this["centre_code"]+'" class="text-center border-bottom border-primary" style="cursor:pointer;">'+this["centre_code"]+' - '+this["centre_name"]+'</label>'+
                                
//                             '</div>'+
//                         '</td>'+
//                         '</tr>');
                        
//                     });
//                     $('table.table_centre tbody tr.undefined').remove();
//             }
//         });
//     }
//     });

    
//   }
function get_all_subjects(){
    
    $.ajax({
        url:'php/get_all_subjects.php',
        method: 'POST',
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
                        '<span class="px-2"><input style="cursor:pointer;" type="checkbox" class="form-check subject-check" name="subject_code" id="'+this["subject_code"]+'" value="'+this["subject_code"]+'"></span>'+
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

  function get_centres_per_district(subject_code = []) {
    var district = [];

    // If subject codes are passed manually, do not re-collect them
    if (subject_code.length === 0) {
        subject_code = [];
        $('input:checkbox[name=subject_code]:checked').each(function () {
            subject_code.push($(this).val());
        });
    }

    // Collect selected districts
    $('input:checkbox[name=district]:checked').each(function () {
        district.push($(this).val());
    });

    // Debugging output
    console.log("Districts:", district);
    console.log("Subject Codes:", subject_code);

    $.ajax({
        url: 'php/get_centres_per_subjects_per_district.php',
        method: 'POST',
        data: { district: district, subject_code: subject_code },
        dataType: 'json',
        success: function (data) {
            if (data) {
                $("#select_all_div").removeClass('d-none');
                console.log("Data received from server!", data);
            }

            $('table.table_centre tbody tr.null').remove();
            $('table.table_centre tbody tr').remove();

            $.each(data, function () {
                $('table.table_centre tbody').append('<tr class="' + this["centre_code"] + '">' +
                    '<td>' +
                    '<div class="d-flex justify-content-center align-items-center mb-2">' +
                    '<label for="' + this["centre_code"] + '" class="text-center border-bottom border-primary" style="cursor:pointer;">' + this["centre_code"] + ' - ' + this["centre_name"] + '</label>' +
                    '<span class="px-2"><input style="cursor:pointer;" type="checkbox" class="form-check centre-check" name="centre" id="' + this["centre_code"] + '" value="' + this["centre_code"] + '"></span>' +
                    '</div>' +
                    '</td>' +
                    '</tr>');
            });

            $('table.table_centre tbody tr.undefined').remove();
        }
    });
}


function subject_apportionment(){
    $('#apportion_subjects').submit(function(e){
        e.preventDefault();
        var marking_centre_code = $('input[type=hidden][name=marking_centre_code]').val(),
            centre_code =[],
            subject_code =[];
        if($('input[type=checkbox][name=centre]:checked').length > 0 && $('input[type=checkbox][name=subject_code]:checked').length > 0){
                $('input[type=checkbox][name=centre]:checked').each(function(){
                centre_code.push($(this).val());
            });
                $('input[type=checkbox][name=subject_code]:checked').each(function(){
                subject_code.push($(this).val());
            });
            $.ajax({
                url: 'php/submit_subject_apportionment.php',
                method: 'POST',
                data: {marking_centre_code:marking_centre_code,centre_code:centre_code, subject_code:subject_code},
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
                        $('button[type=submit]').attr('disabled',false);
                        $('.load').html('');
                        $.each(data,function(){
                            // $('table.table_centre tbody input[type=checkbox]:checked').closest('tr').remove();
                            // $('table.table_subject tbody input[type=checkbox]:checked').closest('tr').remove();
                            // location.reload();
                    });
                    $('.dialog').text(data.response_msg).dialog('open');
                    if(data.remind == 'true'){
                        $('.dialog').text(data.message).dialog('open');
                    }
                    }
                }
            });
        }else{
            $('.dialog1').text('You need to choose the examination centre and subjects').dialog('open');
        }
    });
}
});

 
</script>

<?php
}else{
    header('location: ../');
}
}else{
    header('marking-centres.php');
}

?>
</html>