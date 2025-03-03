$(document).ready(function(){
        check_examiner_details();
        function check_examiner_details(){
                $.ajax({
                        url: 'php/update_examiners.php',
                        method: 'POST',
                        dataType: 'json',
                        success:function(data){

                        }
                });
        }
});