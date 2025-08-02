<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">



<?php
include 'includes/header.php';

if ($_SESSION['user_type']  == 'ADMIN') {

   



?>

        <body>
            <style>
                .table>tbody>tr.active {
                    background-color: rgba(29, 157, 117, 0.26);
                    border: 1px solid #1d9d74;
                }

                .tableFixHead {
                    overflow: auto;
                    max-height: 20rem;
                }

                .tableFixHead thead th {
                    position: sticky;
                    top: 0;
                    z-index: 1;
                    background-color: #1d9d74;
                }
                    input[type="checkbox"] {
                        cursor: pointer;
                        }
            </style>
            <div class="main-wrapper">

                <?php include 'includes/navbar.php' ?>

                <?php include 'includes/sidebar.php' ?>

                <div class="page-wrapper">
                    <div class="content">

                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title "> Centres and scripts</h4>
                            </div>

                        </div>
                        <div class="row d-flex justify-content-center ">
                        
                        <form class="w-100 bg-white p-3 m-3 rounded" method="post" id="search_apportionment">
                            <div class="row d-flex justify-content-center">
                               <div class="form-group col-md-6">
                                    <label>Subject:</label>
                                    <select class="select" name="subject" required>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Paper:</label>
                                    <select class="select" required name="paper" required>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Belt No.:</label>
                                    <select class="select"  name="apportioned_belt" id="belt_no">
                                       
                                       
                                    </select>
                                </div>
                               
                               
                            </div>
                             <div class="d-flex justify-content-center">
                                <span class=" mx-auto mb-2">
                                    <button id="getApportionment" type="submit" class="btn btn-primary mx-auto"><i class="fa fa-search" aria-hidden="true"></i> Search </button>
                                </span>
                             </div>
                           
                                
                        </form>
                    </div>
                     <div class="row d-none" id="apportionment_results">
                        <div class="col-md-12">
                            <span class="text-success h4"> <span class="cubject_code"></span> - SUBJECT: <span class="subject_name"></span>:  PAPER: <span class="paper_no"></span> BELT: <span class="belt_no"></span></span>
                        </div>
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <div class="dialog"></div>
                                <div class="dialog1"></div>
                                <table class="table table-border table-striped custom-table mb-0 beltTable">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Center Name </th>
                                            <th>NO. Scripts</th>
                                            <th class="text-right">SEN</th>
                                            <th>Person Responsible </th>
                                            <!-- <th>Centres</th> -->
                                            
                                            <th class="text-right">
                                                <div class="mb-3">
                                                    <label for="exampleSelect" class="form-label">Move Script(s)</label>
                                                    <select class="form-select" id="exampleSelect" name="belt_no_not">
                                                       
                                                    </select>
                                                    <button class="btm btm-primary" id="move_scripts">Move Script(s)</button>
                                                    </div>
                                        
                                        </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                      


                        <?php include 'includes/notifications.php' ?>
                    </div>
                </div>

                <div class="sidebar-overlay" data-reff=""></div>
            </div>


            <?php include 'includes/scripts.php' ?>
           

        </body>
        <script>
            $(document).ready(function() {
              get_subjects();
              get_paper();
            //   get_belts();
              get_apportionments();
              move_scripts();

               

                $('.dialog').dialog({
                    title: 'REQUEST RESPONSE',
                    width: '450',
                    height: '150',
                    modal: true,
                    draggable: false,
                    resizable: false,
                    closeOnEscape: false,
                    // appendTo: '#add_scripts',
                    autoOpen: false,
                    create: function(e) {
                        $(e.target).parent().css({
                            'position': 'fixed'
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
                            text: 'OK',
                            click: function() {
                                $(this).dialog('close');
                                
                            }
                        }
                    ]
                });

               function get_subjects() {
                $.ajax({
                    url: 'php/get_subject.php',
                    method: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        $('select[name=subject]').append(
                            '<option value="" selected>Select Subject</option>'
                        );
                        $.each(data, function() {
                            $('select[name=subject]').append(
                                '<option value="' + this["subject_code"] + ':'+this["subject_name"]+'">' + this["subject_code"] + ' - ' + this["subject_name"] + '</option>'
                            );
                        });
                        $('select[name=subject]').select2({
                            data: data
                        });
                    }
                });
            }
             function get_paper() {
                $('select[name=subject]').change(function() {
                    var subject = $(this).val().split(':'),
                        subject_code = subject[0],
                        subject_name = subject[1];
                    if (subject_code != '') {
                        $.ajax({
                            url: 'php/get_paper.php',
                            method: 'POST',
                            data: {
                                subject_code: subject_code
                            },
                            dataType: 'json',
                            success: function(data) {
                                $('select[name=paper] option').remove();
                                $('select[name=paper]').append(
                                    '<option value="" selected>Select Paper Number</option>'
                                );
                                $.each(data, function() {
                                    $('select[name=paper]').append(
                                        '<option value="' + this["paper_no"] + '">' + this["paper_no"] + '</option>'
                                    );
                                });
                                get_apportioned_belts(subject_code);
                            }
                        });
                    } else {
                        $('select[name=paper] option[value=""]').change();
                    }
                });
            }

            function get_apportioned_belts(subject_code) {
                $('select[name=paper]').change(function(){
                    var paper_no = $(this).val();
                
                $.ajax({
                    url: 'php/get_apportioned_belts.php',
                    method: 'POST',
                    data: {subject_code:subject_code,paper:paper_no},
                    dataType: 'json',
                    success: function(data) {
                        $('select[name=apportioned_belt] option').remove();
                        $('select[name=apportioned_belt]').append(
                            '<option value="" selected disabled>Select Belt</option>'
                        );

                      
                        $.each(data, function() {
                            $('select[name=apportioned_belt]').append(
                                '<option value="' + this["belt_no"] + '">BELT ' + this["belt_no"] + '</option>'
                            );
                        });
                    }
                });
                });
            }

             function get_apportionments() {
                     $('#search_apportionment').submit(function(e) {
                    e.preventDefault();
                         var subject_code = $('select[name=subject]').val(),
                         paper_no = $('select[name=paper]').val(),
                         belt_no = $('select[name=apportioned_belt]').val();

                          $.ajax({
                        url: 'php/get_apportionments.php',
                        method: 'POST',
                        data: {
                            subject_code: subject_code,
                            paper_no: paper_no,
                            belt_no: belt_no
                        },
                        dataType: 'json',
                        success: function(data) {
                            //   $('#search_apportionment').addClass('d-none');
                         $('#apportionment_results').removeClass('d-none');

                         $('span.cubject_code').text(data[0].subject_code);
                         $('span.subject_name').text(data[0].subject_name);
                         $('span.paper_no').text(data[0].paper_no);
                         $('span.belt_no').text(data[0].belt_no);

                            belt_no_not(data[0].subject_code, data[0].paper_no,data[0].belt_no);
                            
                                $.each(data, function() {
                                    var sen_value = this["sen"] == 'NO' ? 0 : 1;
                                    $('.table.beltTable tbody').append('<tr>' +
                                     
                                         '<td>' + this["centre_code"] + '</td>' +
                                        '<td>' + this["centre_name"] + '</td>' +
                                        '<td>' + this["script_no"] + '</td>' +
                                        '<td>' + this["sen"] + '</td>' +
                                        '<td>' + this["user"] + '</td>' +
                                        '<td class="text-center" style="width: 150px;">' +
                                        '<form class="move_scripts" > ' +
                                           '<div class="form-check">' +
                                               ' <input class="form-check-input cursor-pointer" name="id_group" type="checkbox" value="'+this["id"]+'" >' +
                                               
                                               ' </div>' +
                                           
                                            ' </form> '+
                                        '</td>' +
                                        
                                       
                                        '</tr>');
                                });
                             

                                // clickable_td();


                            
                        }
                    });
                });
                   
                       
                   
                }

                function belt_no_not(subject_code,paper_no,belt_no) {
                   
                    $.ajax({
                        url: 'php/get_belt_no_not.php',
                        method: 'POST',
                        data: {
                            current_belt: belt_no,
                            subject_code: subject_code,
                            paper_no: paper_no
                        },
                        dataType: 'json',
                        success: function(data) {
                            $('select[name=belt_no_not] option').remove();
                          
                                $('select[name=belt_no_not]').append(
                                    '<option value="" selected disabled>Choose belt</option>'
                                );
                                $.each(data, function() {
                                    $('select[name=belt_no_not]').append(
                                        '<option value="' + this["belt_no"] + '">BELT ' + this["belt_no"] + '</option>'
                                    );
                                });
                              
                            
                        }


                    });
                }

                function move_scripts(){
                   $(document).on('click','button#move_scripts', function(){
                     if ($('input:checkbox[name=id_group]:checked').length > 0) {
                            var id = [],
                                selected_belt = $('select[name=belt_no_not]').val();
                            $('input:checkbox[name=id_group]:checked').each(function() {
                                id.push($(this).val());
                            });
                   
                    $.ajax({
                        url: 'php/move_scripts.php',
                        method: 'POST',
                        data: {id:id, selected_belt:selected_belt},
                        dataType: 'json',
                        success:function(data){
                            $('.dialog').text(data.response_msg).dialog('open');	
                            if(data.status == '200'){
                               $.each(data.id_group, function(idex, group_id){
                               $('input[type="checkbox"][value="' + group_id + '"]').closest('tr').remove();
                               });
                            }else{}
                        }
                    });
                }else{
                     $('.dialog').text('Choose scripts to move').dialog('open');
                }
                   });
                }

            });
        </script>
<?php 
} else {
    header('location:../');
}
?>

</html>