var url = "http://127.0.0.1/Red_Instagram/proyecto-instagram/public/";
window.addEventListener("load", function(){
    
    $('.btn-like').css('cursor', 'pointer');
    $('.btn-dislike').css('cursor', 'pointer');
    
    function like(){
        $('.btn-like').unbind('click').click(function(){
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src', url+'img/hearts-red.png');
            
            $.ajax({
                url: url+'/like/'+$(this).data('id'),
                type: 'get',
                success: function(response){
                    
                    if(response.like){
                        console.log("Has dado like");
                    }else{
                        console.log("Error al dar like");
                    }
                    
                }
            });
            
            dislike();
        })
    }
    
    like();
    
    function dislike(){
        $('.btn-dislike').unbind('click').click(function(){
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src', url+'img/hearts-black.png');
            
            $.ajax({
                url: url+'/dislike/'+$(this).data('id'),
                type: 'get',
                success: function(response){
                    
                    if(response.like){
                        console.log("Has dado dislike");
                    }else{
                        console.log("Error al dar dislike")
                    }
                    
                }
            });
            
            like();
        })
    }
    
    dislike();
    
    // Buscador
    
    $('#buscador').submit(function(){
        
       $(this).attr('action', url+'gente/'+$('#buscador #search').val());
       
    });
    
});


