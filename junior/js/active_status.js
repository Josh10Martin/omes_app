$(document).ready(function(){
    
    var active_status = setInterval(set_active_status,500);
    function set_active_status(){
        $.ajax({
            url: 'php/active_status.php',
            method: 'POST',
            dataType: 'json',
            success: function(data){
                if(data.status == '400'){
                    clearInterval(active_status);
                    alert('This account is not active .Get in touch with the administrator')
                    location.href="../php/logout.php";
                }
            }
        });
    }
});