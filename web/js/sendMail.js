$('#sendButton').click(function(){
    var email = $('#emailContact').val();
    var objet = $('#objet').val();
    var message = $('#message').html();
    var verifyMailUrl = 'http://apilayer.net/api/check?access_key=994574dc2339ee1ea93047d53b868c78&email='+email+'&smtp=1&format=1';
    $.getJSON(verifyMailUrl,function (response) {
        if(response.smtp_check){
            $.post({
                url:'/sendMail',
                data: {
                    email : email,
                    objet : objet,
                    message : message
                },
                success: function (data, status, jqXHR) {
                    console.log(data);
                    console.log(status);
                    console.log(jqXHR);
                }
            });
            console.log('ok');
        }else {
            console.log('adresse email introuvable');
        }
    });
});

