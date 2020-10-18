/** Hide error menssages */
$("error-message").fadeOut(2000, "swing");

// generate random password
$('#btn-password').click(
    function(){
        
        let chars = 'abcdefghijklmnopqrstuvwyzABCDEFGHIJKLMNOPQRSTUVWYZ0123456789';
        let pass = '';
        let num_chars = 12;

        for(let i=0; i < num_chars; i++){
            pass += chars.charAt(Math.floor(Math.random() * chars.length));
        }

        $('input[name=text_password]').val(pass);
        $('input[name=text_password_repetir]').val(pass);
    }
)