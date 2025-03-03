$(document).ready(function(){
        alert('hi');
        $.ajax({
                url: 'php/get_roles.php',
                mrthod: 'POST',
                dataType: 'json',
                success:function(data){
                        $.each(data,function(){
                                $('body select[name=role]').append(
                                        '<option value="'+this['id']+':'+this['name']+'">'+this['name']+'</option>'
                                );
                        });
                }
        });
});