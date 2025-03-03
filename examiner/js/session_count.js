$(document).ready(function(){
    var timeoutPeriod = 10 * 60 * 1000;
    var timer;
    
    function resetTimer(){
        clearTimeout(timer);

        timer = setTimeout(logout,timeoutPeriod);
    }
    function logout() {
        alert('Session has expired. You need to login');
        window.location.href = "../php/logout.php";
    }
    $(document).on('keypress mousemove', resetTimer);

    resetTimer();
});