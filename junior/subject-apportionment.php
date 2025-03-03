<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php';
if($_SESSION['user_type']  == 'SESO'){
    if(isset($_GET['marking_centre_code']) && isset($_GET['marking_centre_name'])){
        $marking_centre_code = $_GET['marking_centre_code'];
        $marking_centre_name = $_GET['marking_centre_name'];
    
    ?>


<body>
    <style>
       
        .table>tbody>tr.active{
            background-color: rgba(29, 157, 117, 0.26);
            border:1px solid #1d9d74;
        }
        .tableFixHead          { overflow: auto; max-height: 30rem; }
        .tableFixHead thead th { position: sticky; top: 0; z-index: 1; background-color: #1d9d74;}
       
    </style>
<div class="main-wrapper">

    <?php include 'includes/navbar.php'?>     

    <?php include 'includes/sidebar.php'?>

    <div class="page-wrapper">
            <div class="content">

                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h4 class="page-title">ADD / REMOVE SUBJECTS</h4>
                    </div>
                    <div class="col-md-6">
                        <h4 class="page-title">MARKING CENTRE NAME: <?php echo $marking_centre_name; ?></h4>
                        <form action="">
                            <input type="hidden" name="marking_centre_code" value="<?php echo $marking_centre_code; ?>">
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center pb-2">
                            <div class="com-md-3 ">
                              <span class="font-weight-bold"> ACTION:</span> 
                            </div>
                            <div class="col-md-9">
                                <select name="optiom-selection" id="action" class="select">
                                    <option value="add" selected>ADD SUBJECTS</option>
                                    <option value="remove" >REMOVE SUBJECTS</option>
                                </select>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5 border pt-2 border-primary rounded">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <input type="text" id="search" placeholder="Search" class="form-control col-5">
                            <p class="h4 text-success text-center col-7" id="box-title"> SUBJECTS NOT ADDED</p> 
                        </div>
                        <div class=" card mb-1 ">
                            <div class="tableFixHead">
                                <div class="dialog"></div>
                                <div class="dialog1"></div>
                                <div class="dialog2"></div>
                                <div class="dialog3"></div>
                                <div class="dialog4"></div>
                               
                                <table class="table" id="not-added">
                                    <thead>
                                        <th>CODE</th>
                                        <th>SUBJECT NAME</th>
                                        <!-- <th>PAPER</th> -->
                                        <th class="text-center">Check All <input type="checkbox" name="" id="check-all"> </th>
                                    </thead>
                                    <tbody>
                                       

                                    </tbody>
                                </table>
                            </div>
                         
                        </div>

                    </div>
                    <div class="col-md-2 align-items-center">
                        <div class="d-flex h-100">
                            <div class=" justify-content-between align-self-center mx-auto">
                                <div> <button class="btn btn-info btn-sm my-2" id="add-btn"><i class="fa fa-plus" aria-hidden="true"></i>  ADD <i class="fa fa-angle-double-right" aria-hidden="true"></i></button> </div>
                                <div><button class="btn btn-primary btn-sm my-2" id="remove-btn"><i class="fa fa-angle-double-left" aria-hidden="true"></i> REMOVE <i class="fa fa-minus" aria-hidden="true"></i></button></div>

                              </div>
                        </div>
                    </div>
                    <div class="col-md-5 border border-info  rounded">
                        <div class="d-flex justify-content-between align-items-center my-2">
                        <input type="text" id="search" placeholder="Search" class="form-control col-5">
                            <p class="h4 text-info text-center col-7 " id="box-title"> SUBJECTS ADDED</p> 
                        </div>
                       
                        <div class=" card mb-1 ">
                            <div class="tableFixHead">
                                <table class="table" id="added">
                                    <thead>
                                        <th>CODE</th>
                                        <th>SUBJECT NAME</th>
                                        <!-- <th>PAPER</th> -->
                                        <th>Check All <input type="checkbox" name="" id="check-all-added"> </th>
                                    </thead>
                                    <tbody>
                                       



                                    </tbody>
                                </table>
                            </div>
                         
                        </div>

                    </div>
                </div>
                    
               
              
                <?php include 'includes/notifications.php' ?>
            </div>
    </div>

            <div class="sidebar-overlay" data-reff=""></div>
</div>

	
<?php include 'includes/scripts.php' ?>
<script>
    $(document).ready(function(){



     subjects_in_marking_centre();
        subjects_not_in_marking_centre();
        add_subject_to_marking_centre();
        remove_subject_to_marking_centre();
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
        $('#remove-btn').addClass('d-none');
        hideCheckboxes('#added')
        showCheckboxes('#not-added')
       

            // switch action
    var action=$('#action').find(":selected").val();
    //console.log("SELECTED: ",action)
    $('#action').change(function(){
        var action=$('#action').find(":selected").val();
        if (action == 'add'){
            console.log("SELECTED: ",action)
            $('#add-btn').removeClass('d-none')
            $('#remove-btn').addClass('d-none')
            hideCheckboxes('#added')
            showCheckboxes('#not-added')
        }
        else if (action == 'remove'){
            console.log("SELECTED: ",action);
            $('#add-btn').addClass('d-none')
            $('#remove-btn').removeClass('d-none')
            hideCheckboxes('#not-added')
            showCheckboxes('#added')
           
        } 
    });
    function subjects_not_in_marking_centre(){
        var marking_centre_code = $('input[type=hidden][name=marking_centre_code]').val();
        $.ajax({
            url: 'php/get_subjects_not_in_marking_centre.php',
            method: 'POST',
            data: {marking_centre_code:marking_centre_code},
            dataType: 'json',
            success: function(data){
                $('table.table#not-added tbody tr').remove();
                if(data.status == '200'){
                    $.each(data,function(){
                        $('table.table#not-added tbody').append('<tr class="'+this["subject_code"]+'">'+
                            '<td>'+this["subject_code"]+'</td>'+
                            '<td>'+this["subject_name"]+'</td>'+
                            // '<td>'+this["paper_no"]+'</td>'+
                            '<td><input type="checkbox" class="form-check" name="subject['+this["subject_code"]+']" id="'+this["subject_code"]+'" value="'+this["subject_code"]+'"></td>'+
                        '</tr>');
                    });
                    $('table.table#not-added tbody tr.undefined').remove();
                }
            }
        });
    }
    function add_subject_to_marking_centre(){
        $('#add-btn').click(function(){
            if($('input[type=checkbox]:checked').length > 0){
                var marking_centre_code = $('input[type=hidden][name=marking_centre_code]').val(),
                    subject_code =[];
                $('input[type=checkbox]:checked').each(function(){
                           
                        subject_code.push($(this).val());
                });
                $.ajax({
                    url: 'php/add_subject_to_marking_centre.php',
                    method: 'POST',
                    data: {marking_centre_code:marking_centre_code,subject_code:subject_code},
                    dataType: 'json',
                    success: function(data){
                        if(data.status == '400'){
                            $('.dialog').text(data.response_msg).dialog('open');
                        }else{
                            $.each(data,function(){
                                $('table.table#not-added tbody input[type=checkbox]:checked').closest('tr').remove();
                                // $('table.table#not-added tbody tr.'+this["subject_code"]+'.'+this["paper_no"]+'').remove();
                                $('table.table#added tbody').append('<tr class="'+this["subject_code"]+'">'+
                                '<td>'+this["subject_code"]+'</td>'+
                                '<td>'+this["subject_name"]+'</td>'+
                                // '<td>'+this["paper_no"]+'</td>'+
                                '<td><input type="checkbox" class="form-check" name="subject_code['+this["subject_code"]+']" id="'+this["subject_code"]+'" value="'+this["subject_code"]+'"></td>'+
                                '</tr>');
                            });
                            hideCheckboxes('#added')
                            $('table.table#added tbody tr.undefined').remove();
                           
                        }
                    }
                });
            }else{
                $('.dialog').text('Choose the subject(s) you need to assign').dialog('open');
            }
        });
    }

    function subjects_in_marking_centre(){
        var marking_centre_code = $('input[type=hidden][name=marking_centre_code]').val();
        $.ajax({
            url: 'php/get_subjects_in_marking_centre.php',
            method: 'POST',
            data: {marking_centre_code:marking_centre_code},
            dataType: 'json',
            success: function(data){
                $('table.table#added tbody tr').remove();
                if(data.status == '200'){
                    $.each(data,function(){
                        $('table.table#added tbody').append('<tr class="'+this["subject_code"]+'">'+
                            '<td>'+this["subject_code"]+'</td>'+
                            '<td>'+this["subject_name"]+'</td>'+
                            // '<td>'+this["paper_no"]+'</td>'+
                            '<td><input type="checkbox" class="form-check" name="subject_code['+this["subject_code"]+']" id="'+this["subject_code"]+'" value="'+this["subject_code"]+'"></td>'+
                        '</tr>');
                    });
                    hideCheckboxes('#added')
                    $('table.table#added tbody tr.undefined').remove();
                }
            }
        });
    }
    function remove_subject_to_marking_centre(){
        $('#remove-btn').click(function(){
            if($('input[type=checkbox]:checked').length > 0){
                var marking_centre_code = $('input[type=hidden][name=marking_centre_code]').val(),
                    subject_code =[];
                    paper_no =[];
                $('input[type=checkbox]:checked').each(function(){
                    
                        subject_code.push($(this).val());
                });
                $.ajax({
                    url: 'php/remove_subject_from_marking_centre.php',
                    method: 'POST',
                    data: {marking_centre_code:marking_centre_code,subject_code:subject_code},
                    dataType: 'json',
                    success: function(data){
                        if(data.status == '400'){
                            $('.dialog').text(data.response_msg).dialog('open');
                        }else{
                            $.each(data,function(){
                                $('table.table#added tbody input[type=checkbox]:checked').closest('tr').remove();
                                // $('table.table#added tbody tr.'+this["subject_code"]+'.'+this["paper_no"]+'').remove();
                                $('table.table#not-added tbody').append('<tr class="'+this["subject_code"]+'">'+
                                '<td>'+this["subject_code"]+'</td>'+
                                '<td>'+this["subject_name"]+'</td>'+
                                // '<td>'+this["paper_no"]+'</td>'+
                                '<td><input type="checkbox" class="form-check" name="subject_code['+this["subject_code"]+']" id="'+this["subject_code"]+'" value="'+this["subject_code"]+'"></td>'+
                                '</tr>');
                            });
                            hideCheckboxes('#not-added');
                            $('table.table#not-added tbody tr.undefined').remove();
                           
                        }
                    }
                });
            }else{
                $('.dialog').text('Choose the subject(s) you need to remove').dialog('open');
            }
        });
    }

    /// Function to hide checkboxes in the specified table
    function hideCheckboxes(tableId) {
        $(tableId).find('input[type="checkbox"]').addClass('d-none');
    }

    // Function to show checkboxes in the specified table
    function showCheckboxes(tableId) {
      $(tableId).find('input[type="checkbox"]').removeClass('d-none');
    }

    //Check all
    $('#check-all-added').click(function(){
        $('#added').find('input[type="checkbox"]').not(this).prop('checked', this.checked);
    })
    $("#check-all").click(function(){
    $('#not-added').find('input[type="checkbox"]').not(this).prop('checked', this.checked);
    });

    })
</script>

</body>

<?php 
    }else{
        header('location: marking-centers.php');
    }
}else{
    header('location: ../');
}
?>

</html>