<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

Class AuthController extends Action {

    public function logado() {

		$this->render('logado');
	}

    public function logar() {

		$usuario = Container::getModel('Usuario');

		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', md5($_POST['senha']));
        
        $usuario->autenticar();

        if($usuario->__get('id') != '' && $usuario->__get('nome')) {

            session_start();

            $_SESSION['id'] = $usuario->__get('id');
            $_SESSION['nome'] = $usuario->__get('nome');
            $_SESSION['email'] = $usuario->__get('email');
            $_SESSION['cpf'] = $usuario->__get('cpf');
            $_SESSION['telefone'] = $usuario->__get('telefone');


            header('Location: /logado');

        } else {
            $this->view->loginErro = true;
            header('Location: /?login=login&loginErro=erro&esqueci=false&senhaTrue=false&senhafalse=false&senhaErroTotal=false&vazio=true&listaInvalido=false');

        }

    }

    public function sair(){
        session_start();
        session_destroy();
        header('Location: /');
    }



}



?>