$(function(){
    $(".navbar a, footer a").click(function(event){
        event.preventDefault();
        var hash = this.hash;
        
        $('body, html').animate({scrollTop: $(hash).offset().top}, 900, function(){window.location.hash = hash})
    })

    $('#formulaire').submit(function (e) {
        e.preventDefault();
        $('.comments').empty();
        var postData = $('#formulaire').serialize();

        $.ajax({
            type: 'POST',
            url: 'php/contact.php',
            data: postData,
            dataType: 'json',
            success: function (result) {
                if (result.isSuccess) {
                    $("#formulaire").append("<p class='thanks''>Votre message a bien été envoyé. Merci de m'avoir contacté !</p>");
                    $("#formulaire")[0].reset();
                } else {
                    $("#prenom + .comments").html(result.prenomError);
                    $("#nom + .comments").html(result.nomError);
                    $("#email + .comments").html(result.emailError);
                    $("#phone + .comments").html(result.phoneError);
                    $("#message + .comments").html(result.messageError);
                }
            }
        });
    });
})
