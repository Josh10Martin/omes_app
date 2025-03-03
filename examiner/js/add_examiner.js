$(document).ready(function(){
        
        $('#regForm').submit(function(e){
                e.preventDefault();
                var first_name = $('input[type=text]{name=first_name}').val(),
                 last_name = $('input[type=text]{name=last_name}').val(),
                 nrc_number = $('input[type=text]{name=nrc_number}').val(),
                 tpin = $('input[type=text]{name=tpin}').val(),
                 phone_number = $('input[type=text]{name=phone_number}').val(),
                 email = $('input[type=text]{name=email}').val(),
                 name_regex = '^/[a-zA-Z \']/$',
                 tpin_redex = '^[1*9]{10}$',
                 phone_regex = '^[0-9]{10}$',
                 email_regex = '\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\b.',
                 nrc_regex = '/^([1-9]{7}) / ([1-9]{2}) / ([1-1]{1})$/';

                 if(!name_regex.test(first_name) || !name_regex.test(last_name)){
                        $('.dioalog').text('Please enter correct name or surname').dialog('open');
                 }else if(!nrc_number.test(nrc_regex)){
                        $('.dioalog').text('Please enter NRC in the format 00000/00/0').dialog('open');
                 }else if(!tpin.test(tpin_redex)){
                        $('.dioalog').text('Please enter 10 digit TPIN').dialog('open');
                 }else if(!phone_number.test(phone_regex)){
                        $('.dioalog').text('Please enter 10 digit phone number').dialog('open');
                 }else if(!email.test(email_regex)){
                        $('.dioalog').text('EPlease eter correct email address').dialog('open');
                 }else{

                 
                $.ajax({
                        url: 'php/add_examiner.php',
                        method: 'POST',
                        data: $('#regForm').serialize(),
                        dataType: 'json',
                        beforeSend:function(){
                                $('button').attr('disabled',true);
                                $('button[id=nextBtn]').html('../images/loading.gif');
                        },
                        success:function(data){
                                if(data.status == '200'){
                                        $('.dialog').text(data.response_msg).dialog('open');
                                        $('button').attr('disabled',false);
                                        $('button[id=nextBtn]').text('Submit');
                                        $('#regForm').trigger('reset');
                                }
                        }
                });

        }
        });
});