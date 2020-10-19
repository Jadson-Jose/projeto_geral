/** Hide error menssages */
$("error-message").fadeOut(2000, "swing");

// generate random password
// $('#btn-password').click(
//     function(){
        
//         let chars = 'abcdefghijklmnopqrstuvwyzABCDEFGHIJKLMNOPQRSTUVWYZ0123456789';
//         let pass = '';
//         let num_chars = 12;

//         for(let i=0; i < num_chars; i++){
//             pass += chars.charAt(Math.floor(Math.random() * chars.length));
//         }

//         $('input[name=text_password]').val(pass);
//         $('input[name=text_password_repetir]').val(pass);
//     }
// )

function btn_password(size = 12) 
{
    const numbers = '0123456789';
    const upperChars = 'ABCDEFGHIJKLMNOPQRSTUVXYKZ';
    const lowerChars = 'abcdefghijklmnopqrstuvxykz';
    const especialChars = '!@#$%¨&*()_';
    const chars = [numbers, upperChars, lowerChars, especialChars ].join('').split('')
    let pass = '';
    for(let i = 0; i < size; i++) {
        pass += chars[parseInt(Math.random() * chars.length)];
    }

    return pass;
}

const button = document.querySelector('btn_password');
button.addEventListener('click', () => {
button.innerHTML = btn_password()
})

$('#btn-limpar').click(
    function(){
        $("input[name=text_password]").Val('');
        $('input[name=text_password_repetir]').val('')
    }
)