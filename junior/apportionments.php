<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php' ?>

<?php
if ($_SESSION['user_type']  == 'ADMIN') {
?>

    <body>
        <div class="main-wrapper">

            <?php include 'includes/navbar.php' ?>

            <?php include 'includes/sidebar.php' ?>

            <div class="page-wrapper">
                <div class="content">

                    <div class="row">
                        <div class="col-sm-4 col-3">
                            <h4 class="page-title">Belt Creation</h4>
                        </div>
                        <div class="col-sm-4 col-4 text-right m-b-20">
                            <div class="transcriber1"></div>
                            <div class="transcriber2"></div>
                            <a href="#" id="transcriber_claim" class="btn btn-white"><i class="fa fa-check" aria-hidden="true"></i> Submit Transcriber Claim(s)</a>
                            <a href="#" id="sendexaminerclaim" class="btn btn-white"><i class="fa fa-check" aria-hidden="true"></i> Submit Examiner Claims</a>
                            <a href="submitted_examiners_claim.php" class="btn btn-white"><i class="fa fa-check" aria-hidden="true"></i> Submitted Claims</a>

                            <div class="export_load"style="position:fixed;backgr
                            ound-color:black; width:100%;height:100%;left:0;top:0;z-index:999999; display:none">
                          <img src="../images/loading.gif" style="position:absolute;left:50%;top:50%; transform: translate(-50%,-50%);" alt="">  
                          <h5 class="feedback" style="color:white;position:absolute;left:50%;top:70%; transform: translate(-50%,-50%);">loading</h5>                  
                        </div>

                        </div>
                        <div class="col-sm-4 col-9 text-right m-b-20">
                            <a href="#" data-toggle="modal" data-target="#addApportionment" class="btn btn-white"><i class="fa fa-plus"></i> Add</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <?php
                                // echo $_SESSION['username'].'</br />'.
                                // $_SESSION['marking_centre_code']
                                ?>
                                <table class="table table-border table-striped custom-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Belt</th>
                                            <th>Subject </th>
                                            <th>Paper </th>
                                            <th>Centers</th>
                                            <th>NO. Scripts</th>
                                            <th class="text-right">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Add Apportionment modal -->
                <div class="modal fade" id="addApportionment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header p-2 bg-success ">
                                <div class="modal-title h4 text-white text-center " id="exampleModalLongTitle">New Apportionment</div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="dialog"></div>
                                <div class="dialog1"></div>
                                <div class="dialog2"></div>
                                <div class="dialog3"></div>
                                <form action="#" method="post" id="belt_subject">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Belt:</label>
                                                <input type="number" name="belt_no" id="belt-input" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Subject:</label>
                                                <select class="select" name="subject" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Paper:</label>
                                                <select class="select" name="paper" required>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" name="marking_centre_code" value="<?php echo $_SESSION['marking_centre_code']; ?>">
                                        <input type="hidden" name="province_code" value="<?php echo $_SESSION['province_code']; ?>">
                                    </div>
                                    <div class="modal-footer">
                                        <button id="button_close" type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
                                        <img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;" />
                                        <button id="save" type="submit" class="btn btn-primary float-right">Save</button>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Add Apportionment modal -->
                <div class="modal fade" id="confirmApportionment" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header p-2 bg-success">
                                <div class="modal-title text-white h5 text-center">Confirm Apportionment</div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- <div class="dialog"></div>
                        <div class="dialog1"></div>
                        <div class="dialog2"></div>
                        <div class="dialog3"></div> -->

                                <div class="dialog4"></div>
                                <div class="dialog5"></div>
                                <div class="dialog6"></div>
                                <div class="dialog7"></div>
                                <form action="" method="" id="confirm">
                                    <div class="row">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Subject:</label>
                                                <select class="select" name="subject" required>
                                                    <!-- <option>Select Subject</option>
                                        <option value="1">Enlish Language</option>
                                        <option value="2">Mathermatics</option>
                                        <option value="3">Science</option> -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Paper:</label>
                                                <select class="select" name="paper" required>
                                                    <!-- <option>Select State</option>
                                        <option value="1">Paper 1</option>
                                        <option value="2">Paper 2</option> -->
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" name="marking_centre_code" value="<?php echo $_SESSION['marking_centre_code']; ?>">
                                    </div>
                                    <div class="modal-footer">
                                        <button id="button_close" type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
                                        <img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;" />
                                        <button id="save" type="submit" class="btn btn-primary float-right">Save</button>
                                    </div>

                                </form>
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


    </body>
    <script>
        $(document).ready(function() {
            get_subjects();
            get_paper();
            belt_subject();
            get_belted_subjects();
            confirm_apportionments();
            transcriber();
           

            $('.dialog').dialog({
                title: 'REQUEST RESPONSE',
                width: '450',
                height: '150',
                modal: true,
                draggable: false,
                resizable: false,
                closeOnEscape: false,
                appendTo: '#belt_subject',
                autoOpen: false,
                create: function(e) {
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
                        click: function() {
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
                appendTo: '#belt_subject',
                autoOpen: false,
                create: function(e) {
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
                        click: function() {
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
                // appendTo: '#belt_subject',
                autoOpen: false,
                create: function(e) {
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
                        click: function() {
                            var id = $(this).data('id');
                            delete_group_apportion(id);
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
                // appendTo: '#belt_subject',
                autoOpen: false,
                create: function(e) {
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
                        click: function() {

                            $(this).dialog('close');
                        }
                    }
                ]
            });

            $('.dialog4').dialog({
                title: 'REQUEST RESPONSE',
                width: '450',
                height: '150',
                modal: true,
                draggable: false,
                resizable: false,
                closeOnEscape: false,
                // appendTo: '#confirmApportionment',
                autoOpen: false,
                create: function(e) {
                    $(e.target).parent().css({
                        'position': 'fixed'
                    });

                },
                buttons: [{
                        text: 'NO',
                        click: function() {
                            $(this).dialog('close');
                        }
                    },
                    {
                        text: 'YES',
                        click: function() {
                            submit_claim();
                            $(this).dialog('close');
                        }
                    }
                ]
            });
           

            $('.dialog5').dialog({
                title: 'REQUEST RESPONSE',
                width: '450',
                height: '150',
                modal: true,
                draggable: false,
                resizable: false,
                closeOnEscape: false,
                // appendTo: '#confirmApportionment',
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

            $('.transcriber1').dialog({
                title: 'REQUEST RESPONSE',
                width: '450',
                height: '150',
                modal: true,
                draggable: false,
                resizable: false,
                closeOnEscape: false,
                // appendTo: '#confirmApportionment',
                autoOpen: false,
                create: function(e) {
                    $(e.target).parent().css({
                        'position': 'fixed'
                    });

                },
                buttons: [
                    {
                        text: 'YES',
                        click: function(){
                            $(this).dialog('close');
                            submit_transcriber_claim();
                        }
                    },
                    {
                        text: 'NO',
                        click: function() {
                            $(this).dialog('close');
                        }
                    }
                ]
            });
            $('.transcriber2').dialog({
                title: 'REQUEST RESPONSE',
                width: '450',
                height: '150',
                modal: true,
                draggable: false,
                resizable: false,
                closeOnEscape: false,
                // appendTo: '#confirmApportionment',
                autoOpen: false,
                create: function(e) {
                    $(e.target).parent().css({
                        'position': 'fixed'
                    });

                },
                buttons: [
                    // {
                    //     text: 'YES',
                    //     click: function(){
                    //         $(this).dialog('close');
                    //         submit_transcriber_claim();
                    //     }
                    // },
                    {
                        text: 'OK',
                        click: function() {
                            location.reload();
                            $(this).dialog('close');
                        }
                    }
                ]
            });

            $("#belt-input").mask('000');

            function transcriber(){
                $('#transcriber_claim').click(function(){
                    $('.transcriber1').text('SUbmit transcriber claim?').dialog('open');
                });
            }
            function submit_transcriber_claim(){
                $.ajax({
                    url: 'php/submit_transcriber_claim.php',
                    method: 'POST',
                    dataType: 'json',
                    success: function(data){
                        $('.transcriber2').text(data.response_msg).dialog('open');
                    }
                });
            }

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
                                '<option value="' + this["subject_code"] + ':' + this["subject_name"] + '">' + this["subject_code"] + ' - ' + this["subject_name"] + '</option>'
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
                            }
                        });
                    } else {
                        $('select[name=paper] option[value=""]').change();
                    }
                });
            }

            function belt_subject() {
                $('#belt_subject').submit(function(e) {
                    e.preventDefault();
                    var belt_no = $('input[type=number][name=belt_no]').val(),
                        marking_centre_code = $('input[type=hidden][name=marking_centre_code]').val(),
                        province_code = $('input[type=hidden][name=province_code]').val(),
                        subject = $('select[name=subject]').val().split(':'),
                        subject_code = subject[0],
                        subject_name = subject[1],
                        paper = $('select[name=paper]').val(),
                        id = +province_code + '_' + marking_centre_code.replace("-", "_") + '_' + subject_code + '_' + paper + '_' + belt_no;
                    $.ajax({
                        url: 'php/apportionment_group.php',
                        method: 'POST',
                        data: {
                            belt_no: belt_no,
                            subject: subject_code,
                            paper: paper,
                            id: id
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            $('button[id=button_close]').attr('disabled', true);
                            $('button[id=save]').attr('disabled', true);
                            $('button[id=save]').addClass('bg_att');
                            $('img.loading').css('display', 'block');
                        },
                        success: function(data) {
                            if (data.status == '400') {
                                if (data.try == 'true') {
                                    $('.dialog1').text(data.response_msg).dialog('open');
                                } else {
                                    $('.dialog').text(data.response_msg).dialog('open');
                                }

                                $('button[id=save]').removeClass('bg_att');
                                $('img.loading').css('display', 'none');
                                $('button').attr('disabled', false);
                            } else {
                                $('table.table tbody tr.null').remove();
                                $('table.table tbody').prepend('<tr class="' + data.id + '">' +
                                    '<td>' + belt_no + '</td>' +
                                    '<td>' + subject_name + '</td>' +
                                    '<td>' + paper + '</td>' +
                                    '<td>0</td>' +
                                    '<td>0</td>' +
                                    '<td class="text-right">' +
                                    '<div class="dropdown dropdown-action">' +
                                    '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item table-icon" href="belts.php?belt_no=' + belt_no + '&subject_code=' + subject_code + '&subject_name=' + encodeURIComponent(subject_name) + '&paper_no=' + paper + '&id=' + data.id + '"><i class="fa fa-pencil m-r-5" style="color:blue"></i> Edit</a>' +
                                    '<a data-id="' + data.id + '" class="dropdown-item delete_group_apportion" href="#" data-toggle="modal" data-target="#delete_examiner"><i class="fa fa-trash-o m-r-5" style="color:lightcoral"></i> Delete</a>' +
                                    '</div>' +
                                    '</div>' +
                                    '</td>' +
                                    '</tr>');
                                click_delete();
                                $('button[id=save]').removeClass('bg_att');
                                $('img.loading').css('display', 'none');
                                $('button').attr('disabled', false);
                                $('#belt_subject').trigger('reset');
                                $('select[name=subject] option[value=""]').change();



                            }
                        }
                    });
                });
            }

            function get_belted_subjects() {
                $.ajax({
                    url: 'php/belted_subjects.php',
                    method: 'POST',
                    dataTyle: 'json',
                    success: function(data) {
                        if (data.status == '400') {
                            $('table.table tbody').append('<tr class="null">' +
                                '<td colspan="6">There are no apportionments listed</td>' +
                                '</tr>');
                        } else {
                            $.each(data, function() {
                                $('table.table tbody').append('<tr class="' + this["id"] + '">' +
                                    '<td>' + this["belt_no"] + '</td>' +
                                    '<td>' + this["subject_name"] + '</td>' +
                                    '<td>' + this["paper"] + '</td>' +
                                    '<td>' + this["no_of_centres"] + '</td>' +
                                    '<td>' + this["no_of_scripts"] + '</td>' +
                                    '<td class="text-right">' +
                                    '<div class="dropdown dropdown-action">' +
                                    '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item table-icon" href="belts.php?belt_no=' + this["belt_no"] + '&subject_code=' + this["subject_code"] + '&subject_name=' + encodeURIComponent(this["subject_name"]) + '&paper_no=' + this["paper"] + '&id=' + this["id"] + '"><i class="fa fa-pencil m-r-5" style="color:blue"></i> Edit</a>' +
                                    '<a data-id="' + this["id"] + '" class="dropdown-item delete_group_apportion" href="#" data-toggle="modal" data-target="#delete_examiner"><i class="fa fa-trash-o m-r-5" style="color:lightcoral"></i> Delete</a>' +
                                    '</div>' +
                                    '</div>' +
                                    '</td>' +
                                    '</tr>');
                            });
                            click_delete();
                            $('table.table tbody td').each(function() {
                                var currentTd = $(this).html();
                                if (currentTd == 'undefined') {
                                    $(this).parent('tr.undefined').remove();
                                }
                            });
                        }
                    }
                });
            }

           

            function confirm_apportionments(){
                $('#sendexaminerclaim').click(function(){
                   
                    $('.dialog4').text('Are you sure you want to submit claims?').dialog('open');
                });
            }

            function submit_claim() {
                $.ajax({
                    url: 'php/submit_claims.php',
                    method: 'POST',
                    data: $('#confirm').serialize(),
                    dataType: 'json',
                    beforeSend: function() {
                        // $('button[id=button_close]').attr('disabled', true);
                        // $('button[id=save]').attr('disabled', true);
                        // $('button[id=save]').addClass('bg_att');
                        // $('img.loading').css('display', 'block');

                        $('.export_load').css('display','block');
                        $('.feedback').text('Submitting all Examiners claims. Please wait..');
                    },
                    success: function(data) {
                        $('.export_load').css('display','none');
                        $('.feedback').text('');
                        if (data.status == '200') {
                            // $('button[id=button_close]').attr('disabled', false);
                            // $('button[id=save]').attr('disabled', false);
                            // $('button[id=save]').removeClass('bg_att');
                            // $('img.loading').css('display', 'none');
                            $('.dialog5').text(data.response_msg).dialog('open');
                        } else {
                            // $('button[id=button_close]').attr('disabled', false);
                            // $('button[id=save]').attr('disabled', false);
                            // $('button[id=save]').removeClass('bg_att');
                            // $('img.loading').css('display', 'none');
                            $('.dialog5').text(data.response_msg).dialog('open');
                        }
                    }

                });
            }

            function click_delete() {
                $('a.delete_group_apportion').click(function() {

                    var id = $(this).data('id');
                    $('.dialog2').text('Are you sure you want to delete belt ? All belted scripts will be gone').data('id', id).dialog('open')
                });
            }

            function delete_group_apportion(id) {
                $.ajax({
                    url: 'php/delete_group_apportionment.php',
                    method: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == '200') {
                            $('table.table tbody tr.' + id).remove();
                        } else {
                            $('.dialog').text(data.response_msg).dialog('open');
                        }
                    }

                });
            }
        });
    </script>

<?php
} else {
    header('location: ../');
}
?>

</html>