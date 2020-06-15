
$(document).ready(function(){
    $('#submit').click(function(event){
        event.preventDefault();
        ajax();
    });

    function ajax(){

        var id = $('#categorie').val();
        console.log(id);

        var parameters = "id="+id;
        console.log(parameters);

        $.post("ajax_annonce.php", parameters, function(data){
            $('#resultat').html(data.resultat);
        }, 'json');
    }
});