function mostrarSenha(){
    var senha = document.getElementById("senha");

    if(senha.type == "password"){
        senha.type = "text";
        img = document.getElementById('imgOlho')

        img.setAttribute('src', 'img/senha/olhoAberto.svg');
    }
    else{
        senha.type = "password";
        img = document.getElementById('imgOlho')

        img.setAttribute('src', 'img/senha/olhoFechado.svg');
    }
 
}