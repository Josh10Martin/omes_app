<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">



<?php
include 'includes/header.php';

if($_SESSION['user_type']  == 'ADMIN'){

if(isset($_GET['belt_no']) && isset($_GET['group_code']) && isset($_GET['group_name']) && isset($_GET['id'])){
     $belt_no =$_GET['belt_no'];
     $group_code =$_GET['group_code'];
     $group_name =$_GET['group_name'];
      $id =$_GET['id'];



?>

<body>
    <style>
       
        .table>tbody>tr.active{
            background-color: rgba(29, 157, 117, 0.26);
            border:1px solid #1d9d74;
        }
        .tableFixHead          { overflow: auto; max-height: 20rem; }
        .tableFixHead thead th { position: sticky; top: 0; z-index: 1; background-color: #1d9d74;}
       
    </style>
<div class="main-wrapper">

    <?php include 'includes/navbar.php'?>     

    <?php include 'includes/sidebar.php'?>

    <div class="page-wrapper">
            <div class="content">

            <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">Belt <?php echo $belt_no; ?> Centers and scripts</h4>
                    </div>
                    
                </div>
                <div class="row p-2">
                    
                    <div class="col-lg-6 border border-dark p-2">

                    <div class="row border-bottom py-2 mx-1">
                        <div class="col-md-6">
                            <div class="h4 text-success px-4" id="box-title"> Apportionment</div> 
                        </div>
                        <div class="col-md-6">
                        <div class="dialog_box"></div>
                         
                           
                                
                        </div>
                    </div>
                    <?php
                   // echo $_SESSION['session_type'];
                    ?>
                    <div class="dialog"></div>
                    <div class="dialog1"></div>
                    <div class="dialog2"></div>
                    <div class="dialog3"></div>
                    <div style="position:absolute;border: 1px solid green;padding: 10px;color:black;" class="infodiv bg-primary"></div>
                   
                    <form action="" method="post" id="add_scripts" autocomplete="off">
                    
                    <div class="row mt-1 pt-1">
                        <div class="col-xs-12 col-sm-6 col-md-12">
                            <div class="form-group">
                                <label>Group:</label>
                                <select class="select" name="group">
                                    <option value="<?php echo $group_code; ?>:<?php echo $group_name; ?>" selected><?php echo $group_code,' - ',$group_name; ?></option>
                                    <!-- <option value="1">Enlish Language</option>
                                    <option value="2">Mathermatics</option>
                                    <option value="3">Science</option> -->
                                </select>
                            </div>
                        </div>
                       
                    </div>
                  
                   
                    
                    <div class="row p-2 justify-content-around">
                        <div id="updatediv" class="d-none">
                            <!-- <span class="mr-auto ml-auto">
                                <button id="update" type="button" class="btn btn-info">UPDATE</button>
                            </span>
                            
                            <span class="mr-auto ml-auto ">
                                <button id="delete" type="button" class="btn btn-danger">DELETE</button>
                            </span>

                            <span class="mr-auto ml-auto ">
                                <!-- <button type="btn" class="btn bg-light border-secondary">CANCEL</button> -->
                                <!-- <span class="btn bg-light border-secondary" id="cancel">CANCEL</span> -->
                            </span> -->
                        </div>
                        <div id="savediv">
                            <!-- <span class="mr-auto ml-auto">
                            <img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;"/>

                                <button type="submit" class="btn btn-primary">SAVE</button>
                            </span> -->
                        </div>
                    </div>
                    <input type="hidden" name="belt_no" value="<?php echo $belt_no; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                </form>
                    </div>
                    <div class="col-lg-6 border border-dark p-2 tableC0ntent">
                        <div class="row mb-1 def-row">
                            <div class="col-md-6 search-col">
                                <input type="text" name="" id="search" placeholder="Search" class="form-control mb-1">
                            </div>
                            <div class="col-md-6 align-self-center">
                                <button class="btn btn-info btn-sm mb-1" id="move-btn"><i class="fa fa-arrows" aria-hidden="true"></i> Move Script(s)</button>
                            </div>
                        </div>
                        <div class="row mb-1 move-row d-none" id="id-move-row">
                            <div class="col-md-3 align-self-center">
                                <button class="btn btn-danger btn-sm mb-1" id="move-cancel-btn"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
                            </div>
                            <div class="col-md-6 to-belt-col">
                                <div class="d-flex">
                                  <div class="h5 px-3 pt-2">Move to </div>
                                  <div class="">
                                    <form action="" id="move_script">
                                    <select name="belt_no_not" required id="" class="select">
                                    </select>
                                  </div>
                                  <input type="hidden" name="group_code" value="<?php echo $group_code; ?>">
                                  <input type="hidden" name="belt_no" value="<?php echo $belt_no; ?>">
                                  <div>
                                
                                <input type="hidden" name="group_apportion_id" value="<?php echo $id; ?>">
                                <img src="../images/loading.gif" alt="Loading..." class="ml-auto mr-auto move_script_load" style="display: none; position: absolute; top: 50%; left: 50%; transform: translateX(50%);">
                                    <button type="submit" id="move" class="btn btn-sm btn-primary mx-2" ><i class="fa fa-arrows" aria-hidden="true"></i> Move</button>
                                  </div>
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                        
                    <div class="tableFixHead table-hover ">
									<table class="table mb-0" id="beltTable">
										<thead>
											<tr>
												<th>Group</th>
												<th>Subject</th>
												<th>Belt</th>
                                                <th>Center</th>
												<th>No. Scripts</th>
                                                <th class="move-check d-none"></th>
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
<script>
    // $(document).ready(function(){
        
    //      $('#number_of_scripts').mask('000000');

    //      var activeRow= $('#beltTable tr.active')
    //      $('#beltTable tr').click(function(){
    //          console.log("Clicked",$(this))
    //          console.log("Active row",activeRow)
    //         activeRow.removeClass('active');
    //         $(this).addClass('active');
    //         activeRow=$(this);

    //         $('#updatediv').removeClass('d-none');
    //         $('#savediv').addClass('d-none');
    //         var numberOfScrips = $(this).find("td").eq(4).html()
    //         var center = $(this).find("td").eq(3).html()
    //         // console.log("Cliked Scripts:",numberOfScrips)
    //         // console.log("Cliked Center:",center)
    //         $('#number_of_scripts').val(numberOfScrips);
    //         $('#ceter_number').val(center);
    //         $('#box-title').text('Update Apportionment');
    //      })

    //      $('#cancel').click(function(){
    //         $('#savediv').removeClass('d-none');
    //         $('#updatediv').addClass('d-none');
    //         $('#number_of_scripts').val("");
    //         $('#ceter_number').val("");
    //         $('#box-title').text('New Apportionment');
    //         activeRow.removeClass('active');
    //      })
    // })
</script>

</body>
<script>
$(document).ready(function(){
    $('#ceter_number').mask('000000');
    get_apportionments();
    update_apportionment();
    delete_apportion();
    get_schools_in_marking_centre();
    upload_apportionment();
    belt_no_not();
    // $('select[name=centre_code] option:first').attr('selected',true);
    $('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '#add_scripts',
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
        appendTo: '#add_scripts',
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
                    var id = $('.dialog1').data('id');
                    $(this).dialog('close');
                    delete_apportionment(id);
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
        appendTo: '#add_scripts',
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
        appendTo: '#add_scripts',
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
                    $(this).dialog('close');
                    update_scripts(id)
                   
                }
            }
        ]
    });
    $('select[name=centre_code]').change(function(){
        $('#number_of_scripts').focus();
    });
    $('#move-btn').click(function(){
        $('.def-row').addClass('d-none')
        $('.move-row').removeClass('d-none')
        $('.move-check').removeClass('d-none')
        //var activeRow= $('#beltTable tr.active');
        //console.log("OK GOT U!!",activeRow)
       
    });
    $('#move-cancel-btn').click(function(){
        $('.def-row').removeClass('d-none')
        $('.move-row').addClass('d-none')
        $('.move-check').addClass('d-none')
    })

    $('#formFileSm').change(function(){
        $('#file_path').text($(this).val());
    });

    if($('#text-check').is(':checked')) { 
        $('#text-check').attr("required","required");
        $('select[name="centre_code"]').removeAttr("required");
        $('select[name="centre_code"]').attr("disabled",true);
       // $('.form-group.check').addClass("d-none");
       <?php if(isset($_SESSION['school2'])){unset($_SESSION['school2']);} $_SESSION['school'] = 'text_check';?>
        //console.log("TEXT CHECK!!")
     }

    $('#text-check').click(function(){
        if($('#text-check').is(':checked')) { 
            $('input[type=text][name="centre_code"]').attr("required",true);
            $('input[type=text][name="centre_code"]').attr("disabled",false);
            $('select[name="centre_code"]').attr("disabled",true);
            $('select[name="centre_code"]').attr("required",false);
         }

    })
    if($('#select-check').is(':checked')) { 
        $('input[type=text][name="centre_code"]').attr("required",false);
        $('input[type=text][name="centre_code"]').attr("disabled",true);
        $('select[name="centre_code"]').attr("disabled",false);
        $('select[name="centre_code"]').attr("required",true);
        $('.school_name').text('');
        //console.log("TEXT CHECK!!")
     }
    $('#select-check').click(function(){
        if($('#select-check').is(':checked')) { 
            $('input[type=text][name="centre_code"]').attr("required",false);
            $('input[type=text][name="centre_code"]').attr("disabled",true);
            $('select[name="centre_code"]').attr("disabled",false);
            $('select[name="centre_code"]').attr("required",true);
            $('.school_name').text('');
         }

    })
    function upload_apportionment(){
        $('#upload_apportionment').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: 'php/upload_apportionment.php',
                method: 'POST',
                dataType: 'json',
                data: new FormData(this),
                processData:false,
                contentType:false,
                cache: false,
                beforeSend: function(){
                    $('button[submit=submit]#upload').attr('disabled',true).addClass('bg_att');
                    $('img.load_apportionment_file').css('display','block');
                },
                success: function(data){
                    if(data.status == '200'){
                        $('.dialog').text(data.response_msg).dialog('open');
                        $('button[submit=submit]#upload').attr('disabled',false).removeClass('bg_att');
                        $('img.load_apportionment_file').css('display','none');
                    }else{ 
                        $('button[submit=submit]#upload').attr('disabled',false).removeClass('bg_att');
                        $('img.load_apportionment_file').css('display','none');
                        $('.dialog').text(data.response_msg).dialog('open');
                    }
                }

            });
        });
    }
    function get_schools_in_marking_centre(){
		$.ajax({
                url: 'php/get_schools_in_marking_centre.php',
                method: 'POST',
                dataType: 'json',
                success: function(data){
                    
                    if(data.status == '200'){
						$('select[name=centre_code] option').remove();
						$('select[name=centre_code]').append(
							'<option value ="" selected select subject>Select centre</option>'
						);
						$.each(data,function(){
							$('select[name=centre_code]').append(
							'<option value ="'+this["centre_code"]+'">'+this["centre_code"]+' - '+this["centre_name"]+'</option>'
						);
						});
                        $('select[name=centre_code]').select2({
							data:data
						});
                    }
                }
            });
	 }
    


    $('input[type=text][name=centre_code]').keyup(function(){
        var centre_code = $(this).val();
        if(centre_code.length >= 4){
            $.ajax({
                url: 'php/get_school.php',
                method: 'POST',
                data: {centre_code:centre_code},
                dataType: 'json',
                beforeSend: function(){
                    $('.school_name').html('<img src="../images/loading.gif" style="transform:scale(.3);" />');
                },
                success: function(data){
                    
                    if(data.status == '200'){
                        $('.school_name').text(data.response_msg);
                    }else{
                        $('.school_name').text(data.response_msg);
                    }
                }
            });
        }else{
            $('.school_name').text('');
        }
    });
    function display_centre_name(school){
        $.ajax({
                url: 'php/get_school.php',
                method: 'POST',
                data: {centre_code:school},
                dataType: 'json',
                beforeSend: function(){
                    $('.school_name').html('<img src="../images/loading.gif" style="transform:scale(.3);" />');
                },
                success: function(data){
                    
                    if(data.status == '200'){
                        $('.school_name').text(data.response_msg);
                    }else{
                        $('.school_name').text('['+data.response_msg+']');
                    }
                }
            });
    }

    $("#add_scripts input , select , textarea").keypress(function(e){
    if(e.keyCode == 13){
        var enter_position = $(this).index();
        $("#add_scripts input , select , textarea").eq(enter_position+1).focus();
    }
});
    
    $('#add_scripts').submit(function(e){
        e.preventDefault();
        var centre_code = $('input[type=text][name=centre_code]').val() || $('select[name=centre_code]').val(),
            centre_code2 = $('select[name=centre_code]').val(),
            subject = $('select[name=subject]').val().split(':'),
            subject_code =subject[0],
            subject_name = subject[1],
            paper = $('select[name=paper]').val(),
            script_no = $('input[type=number][name=script_no]').val(),
            belt_no = $('input[type=hidden][name=belt_no]').val(),
            id = $('input[type=hidden][name=id]').val();
            $.ajax({
                url: 'php/apportionment.php',
                method: 'POST',
                data: {centre_code:centre_code,centre_code2:centre_code2,subject:subject_code,paper:paper,script_no:script_no,belt_no:belt_no,id:id},
                beforeSend:
                    function(){
                    $('buton[type=submit]').attr('disabled',true);
                    // $('img.loading').css('display','block');
                    $('.school_name').html('<img src="../images/loading.gif" style="transform:scale(.3);" />');
                    },
                success: function(data){
                    $('.school_name').html('');
                    if(data.status == '400'){
                        $('.dialog').text(data.response_msg).dialog('open');
                    }else{
                        $('table#beltTable tbody tr.null').remove();
                        $('table#beltTable tbody').prepend('<tr class="'+id+' '+centre_code+'">'+
                        '<td>'+subject_code+' - '+subject_name+'</td>'+
                        '<td>'+paper+'</td>'+
                        '<td>'+belt_no+'</td>'+
                        '<td>'+centre_code+'</td>'+
                        '<td>'+script_no+'</td>'+
                        
                        '</tr>');
                        $('buton[type=submit]').attr('disabled',false);
                        $('img.loading').css('display','none');
                        // $('#add_scripts').trigger('reset');
                        $('#ceter_number').val('').focus();
                        $('#number_of_scripts').val('');
                        $('input[type=text][name=centre_code]').focus();
                        // $('select[name=centre_code] option:first').attr('selected',selected);
                        // location.reload();
                        $('select[name=centre_code] option:first').attr('selected',true);
                            clickable_td();

                    }
                }
            });
    });
    function clickable_td(){
        var activeRow= $('#beltTable tr.active');
         $('#beltTable tbody tr').click(function(){
            // console.log("Clicked",$(this));
             //console.log("Active row",activeRow);
            
            if(!$('#id-move-row').hasClass('d-none')){
                console.log("MOVE ROW")

            }else{
            activeRow.removeClass('active');
            $(this).addClass('active');
            activeRow=$(this);
            $('input[type=text][name=centre_code]').attr('readonly',true);

            $('#updatediv').removeClass('d-none');
            $('#savediv').addClass('d-none');
            var numberOfScrips = $(this).find("td").eq(4).html();
            var center = $(this).find("td").eq(3).html();
            // console.log("Cliked Scripts:",numberOfScrips)
            //console.log("Cliked Center:",center)
            $('#number_of_scripts').val(numberOfScrips);
            $('#ceter_number').val(center);
            $('#box-title').text('Update Apportionment');
            display_centre_name(center);
            $('button#delete').attr('data-id',center);
            $('input[type=number][name=script_no]').attr('title','click on the desired button after update. Dont press the "ENTER" key')
            }
            
            

         });

         $('#cancel').click(function(){
            $('#savediv').removeClass('d-none');
            $('#updatediv').addClass('d-none');
            $('#number_of_scripts').val("");
            $('#ceter_number').val("");
            $('#box-title').text('New Apportionment');
            activeRow.removeClass('active');
            $('input[type=text][name=centre_code]').attr('readonly',false);
            $('.school_name').text('');
            $('input[type=number][name=script_no]').attr('title','');
         });
    }
    
 function get_apportionments(){
        var group = $('select[name=group]').val().split(':'),
        group_code =group[0],
        group_name = group[1],
            belt_no = $('input[type=hidden][name=belt_no]').val(),
            id = $('input[type=hidden][name=group_apportion_id]').val();
    $.ajax({
        url: 'php/get_apportionments.php',
        method: 'POST',
        data: {group_code:group_code,belt_no:belt_no,group_apportion_id:id},
        dataType: 'json',
        success: function(data){
          
            if(data.status == '400'){
                $('table#beltTable tbody').append('<tr class="null">'+
                '<td colspan="5">No apportionments done</td>'+
                '</tr>');
            }else{
                $.each(data,function(){
                    console.log(data)
                    $('table#beltTable tbody').append('<tr id="'+this["id"]+'" class="centre_apportion">'+
                        '<td>'+this["group_code"]+'</td>'+
                        '<td>'+this["subject_code"]+'</td>'+
                        '<td>'+this["belt_no"]+'</td>'+
                        '<td>'+this["centre_code"]+'</td>'+
                        '<td>'+this["script_no"]+'</td>'+
                        '<td>'+'<input type="checkbox" name="apportioned_centre_subject" style="cursor:pointer;" value="'+this["id"]+'" class="move-check d-none">'+'</td>'+
                        
                        '</tr>');
                });
                get_info();
                $('table#beltTable tbody td').each(function(){
                    var currentTd = $(this).html();
                     if(currentTd == 'undefined'){
                        $(this).parent('tr.undefined').remove();
                     }
                });

                clickable_td();


            }
        }
    });
 }
 
 function get_info(){

    $('tr.centre_apportion').hover(function(){
        var group_code = $(this).find("td").eq(0).html(),
        subject_code = $(this).find("td").eq(1).html(),
        belt_no = $(this).find("td").eq(2).html(),
        no_of_scripts = $(this).find("td").eq(4).html(),
        centre_code = $(this).find("td").eq(3).html();

      

        $.ajax({
            url: 'php/apportionment_info.php',
            method: 'POST',
            data:{centre_code:centre_code,group_code:group_code,subject_code:subject_code,belt_no:belt_no,no_of_scripts:no_of_scripts},
            dataType: 'json',
            success:function(data){
                if(data.status != '400'){
                
                    $('.infodiv').css({'display':'block', 'font-weight': '900'}).html('GROUP NAME: '+data.group_name+'<br /> CENTRE NAME: '+data.centre_name+'<br />SUBJECT NAME: '+data.subject_name+'<br />Belt NO. '+data.belt_no+'<br /> NO. OF SCRIPTS: '+data.no_of_scripts);

                }
            }
        });
    }, function(){
    // Hide .infodiv when hover ends
    $('.infodiv').css('display', 'none');
    
    }).mousemove(function(e){
        $('.infodiv').css({
            top: "100px",
            zIndex: 100, 
            
        });
    });
    
 }

 function update_apportionment(){
    $('button#update').click(function(){
        var centre_code = $('input[type=text][name=centre_code]').val(),
        script_no = $('input[type=number][name=script_no]').val(),
        subject = $('select[name=subject]').val().split(':'),
        subject_code =subject[0],
        subject_name = subject[1],
        paper = $('select[name=paper]').val(),
        belt_no = $('input[type=hidden][name=belt_no]').val(),
        id = $('input[type=hidden][name=id]').val();
        $.ajax({
            url: 'php/update_apportionment.php',
            method: 'POST',
            data: {school:centre_code,script_no:script_no,subject_code:subject_code,paper:paper,belt_no:belt_no,group_id:id},
            dataType: 'json',
            success(data){
                if(data.status == '400'){
                    $('.dialog').text(data.response_msg).dialog('open');
                }else{
                    $('table#beltTable tbody tr.'+centre_code).find("td").eq(4).html(data.script_no);
                }
            }

        });
    });
 }
 $('select[name=belt_no_not]').change(function(){
    var selected_belt = $(this).val();
    move_script(selected_belt);
 });

 function move_script(selected_belt){
    $('#move_script').submit(function(e){
        e.preventDefault();
        if($('input:checkbox[name=apportioned_centre_subject]:checked').length > 0){
            var id =[];
            $('input:checkbox[name=apportioned_centre_subject]:checked').each(function(){
                id.push($(this).val());
            });
            $.ajax({
                url: 'php/move_scripts.php',
                method: 'POST',
                data: {selected_belt:selected_belt, id:id},
                dataType: 'json',
                beforeSend: function(){
                    $('buton[type=submit]#move').attr('disabled',true);
                    $('img.move_script_load').css('display','block');
                    
                },
                success:function(data){
                    if(data.status == '200'){
                        $('buton[type=submit]#move').attr('disabled',false);
                        $('img.move_script_load').css('display','none');
                        $('.dialog').text(data.response_msg).dialog('open');
                    }else{
                        $('buton[type=submit]#move').attr('disabled',false);
                        $('img.move_script_load').css('display','none');
                        $('.dialog2').text(data.response_msg).dialog('open');
                    }
                }
            });

        }else{
            $('.dialog2').text('Choose script(s) to move').dialog('open');
        }

    });
}
 function belt_no_not(){
    var belt_no = $('input[type=hidden][name=belt_no]').val(),
        group_code = $('input[type=hidden][name=group_code]').val();
    $.ajax({
        url: 'php/get_belt_no_not.php',
        method: 'POST',
        data: {belt_no:belt_no,group_code:group_code},
        dataType: 'json',
        success:function(data){
            $('select[name=belt_no_not] option').remove();
            if(data.status == '200'){
                $('select[name=belt_no_not]').append(
                        '<option value="" selected disabled>Choose belt</option>'
                    );
                $.each(data,function(){
                    $('select[name=belt_no_not]').append(
                        '<option value="'+this["belt_no"]+'">'+this["belt_no"]+'</option>'
                    );
                });
                $('select[name=belt_no_not] option[value=undefined]').remove();
            }
        }


    });
 }
 function delete_apportion(){
    $('button#delete').click(function(){
        var id = $('button#delete').data('id');
        $('.dialog1').text('Are you sure you want to delete centre '+id+' from the apportionment?').data('id',id).dialog('open');

    });
 }
 function delete_apportionment(centre_code){
    var subject = $('select[name=subject]').val().split(':'),
    subject_code =subject[0],
    paper = $('select[name=paper]').val(),
    belt_no = $('input[type=hidden][name=belt_no]').val(),
    group_id = $('input[type=hidden][name=id]').val();
    $.ajax({
            url: 'php/delete_apportionment.php',
            method: 'POST',
            data: {school:centre_code,subject_code:subject_code,paper:paper,belt_no:belt_no,group_id:group_id},
            dataType: 'json',
            success(data){
                if(data.status == '400'){
                    $('.dialog').text(data.response_msg).dialog('open');
                }else{
                    $('button#delete').attr('data-id','');
                    $('table#beltTable tbody tr.'+centre_code).remove();

                    $('#savediv').removeClass('d-none');
                    $('#updatediv').addClass('d-none');
                    $('#number_of_scripts').val("");
                    $('#ceter_number').val("");
                    $('#box-title').text('New Apportionment');
                    $('input[type=text][name=centre_code]').attr('readonly',false);
                    $('.school_name').text('');
                    $('input[type=number][name=script_no]').attr('title','');
                  //  location.reload();
                }
            }

        });

 }
 $('html,body').animate({
  scrollTop: $('.tableFixHead').offset().top - 50
}, 700); 

 
});
</script>
<?php }else{
    header('location: apportionments.php');
}
}else{
    header('location:../');
}
?>

</html>