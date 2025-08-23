$(document).ready(function(){
    
    var session_token = setInterval(check_session_token,500)
    function check_session_token(){
        $.ajax({
            url: 'php/session_token.php',
            method: 'POST',
            dataType: 'json',
            success: function(data){
                if(data.status == '400'){
                    clearInterval(check_session_token);
                    location.reload();
                    alert('You must work in one browser window / tab. You need to login again');
                    location.href="../php/logout.php";
                }
            }
        });
    }
});