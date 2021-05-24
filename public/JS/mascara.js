
        function mascaraTEl(telefone){ 
            // if(telefone.value.length == 0)
            //     telefone.value = '(' + telefone.value; // Quando começamos a digitar, o script irá inserir um parênteses no começo do campo.
            // if(telefone.value.length == 3)
            //     telefone.value = telefone.value + ') '; // Quando o campo já tiver 3 caracteres (um parênteses e 2 números) o script irá inserir mais um parênteses, fechando assim o código de área.
            // if(telefone.value.length == 10)
            v=v.replace(/D/g,"");             //Remove tudo o que não é dígito
            v=v.replace(/^(d{2})(d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
            v=v.replace(/(d)(d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
            return v;
        }

        function mascaraTelefone( campo ) {
      
            function trata( valor,  isOnBlur ) {
               
               valor = valor.replace(/\D/g,"");                      
               valor = valor.replace(/^(\d{2})(\d)/g,"($1)$2");       
               
               if( isOnBlur ) {
                  
                  valor = valor.replace(/(\d)(\d{4})$/,"$1-$2");   
               } else {
   
                  valor = valor.replace(/(\d)(\d{3})$/,"$1-$2"); 
               }
               return valor;
            }
            
            campo.onkeypress = function (evt) {
                
               var code = (window.event)? window.event.keyCode : evt.which;   
               var valor = this.value
               
               if(code > 57 || (code < 48 && code != 8 ))  {
                  return false;
               } else {
                  this.value = trata(valor, false);
               }
            }
            
            campo.onblur = function() {
               
               var valor = this.value;
               if( valor.length < 13 ) {
                  this.value = ""
               }else {      
                  this.value = trata( this.value, true );
               }
            }
            
            campo.maxLength = 14;
         }

        function mascaraCPF(cpf){
            if(cpf.value.length == 3)
                cpf.value = cpf.value + '.'; // Quando começamos a digitar, o script irá inserir um ponto depois de trÊs digitos digitado.
            if(cpf.value.length == 7)
                cpf.value = cpf.value + '.';  // Quando o campo já estiver 3 digitos, o script irá inserir mais um ponto dividindo entre eles.
            if(cpf.value.length == 11)
                cpf.value = cpf.value + '-';  // Quando o campo já estiver 9 digitos, o script irá inserir um traço separando entre eles.
    }
