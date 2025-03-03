$.getJSON('url_to_api',function(json_data){
    var data = JSON.stringify(json_data);
});
$.ajax({
    url : 'https://omes.exams-council.org.zm/omes/examiner/php/insert_examiners.php',
    method: 'POST',
    dataType: 'json',
    data: data,
    success:function(response){
        if(response.status == '200'){
            $('div').text(response.response_msg);
        }else{
            $('div').text(response.response_msg);
        }
    }
});