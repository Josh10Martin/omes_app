$(document).ready(function(){
    
    var session_count = setInterval(set_session_timeout,500)
    function set_session_timeout(){
        $.ajax({
            url: 'php/set_session.php',
            method: 'POST',
            dataType: 'json',
            success: function(data){
                if(data.status == '400'){
                    clearInterval(session_count);
                    location.href="../php/logout.php";
                }
            }
        });
    }
});