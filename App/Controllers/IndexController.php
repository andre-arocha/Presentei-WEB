<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class IndexController extends Action {

	public function index() {

		$this->view->btnLogin = isset($_GET['login']) ? $_GET['login'] : '';
		$this->view->loginErro = isset($_GET['aut']) ? $_GET['aut'] : '';
		$this->view->senhaErroTotal = false;
		$this->view->senhafalse = false;
		$this->view->senhaTrue = false;

		$this->render('index');
	}


	public function cadastro() {

		$this->view->login = false;
		$this->view->txtFalta = false;
		$this->view->txt = false;
		$this->view->senhaConf = false;
		$this->view->loginErro = false;
		
		$this->view->usuario = array(
			'nome' => '',
			'email' => '',
			'senha' => '',
			'cpf' => '',
			'confSenha' => '',
			'telefone' => '',
		);


		$this->render('cadastro');
	}

	public function login() {
		$this->view->senhaErroTotal = false;
		$this->view->senhafalse = false;
		$this->view->senhaTrue = false;
		header('Location: /?login=login&loginErro=login&esqueci=false&senhaTrue=false&senhafalse=false&senhaErroTotal=false&vazio=false&listaInvalido=false');

	}

	public function registrar(){
		$usuario = Container::getModel('Usuario');

		$this->view->login = false; 
		$this->view->txtFalta = false;
		$this->view->txt = false;
		$this->view->senhaConf = false;
		$this->view->loginErro = false;

		$usuario->__set('nome', $_POST['nome']);
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', md5($_POST['senha']));
		$usuario->__set('cpf', $_POST['cpf']);
		$usuario->__set('telefone', $_POST['telefone']);
		$usuario->__set('senhaConfirmar', md5($_POST['confSenha']));

		if($usuario->validarCadastro()) {

			$pkCount = (is_array($usuario->getUsuarioPorEmail()) ? count($usuario->getUsuarioPorEmail()) : 0);

			if($pkCount == 0) {

				if($_POST['senha'] == $_POST['confSenha']) {
					$this->view->usuario = array(
						'nome' => '',
						'email' => '',
						'senha' => '',
						'cpf' => '',
						'confSenha' => '',
						'telefone' => '',
					);
	
					$usuario->salvar();

					$this->view->login = true;				
			
					$this->render('cadastro');

				} else {

					$this->view->usuario = array (
						'nome' =>$_POST['nome'],
						'email' =>$_POST['email'],
						'senha' =>$_POST['senha'],
						'cpf' =>$_POST['cpf'],
						'confSenha' => '',
						'telefone' => $_POST['telefone']
					);

					$this->view->senhaConf = true;

					$this->render('cadastro');
				}

			} else {


				$this->view->usuario = array (
					'nome' =>$_POST['nome'],
					'email' =>$_POST['email'],
					'senha' =>$_POST['senha'],
					'cpf' =>$_POST['cpf'],
					'confSenha' => '',
					'telefone' => $_POST['telefone']
				);

				$this->view->loginErro = true;
	
				$this->render('cadastro');

			}

		

		} else {

			$this->view->usuario = array (
				'nome' =>$_POST['nome'],
				'email' =>$_POST['email'],
				'senha' =>$_POST['senha'],
				'cpf' =>$_POST['cpf'],
				'confSenha' => '',
				'telefone' => $_POST['telefone']
			);

			$txt = $usuario->validarCadastroTxt();

			$this->view->txt = $txt;

			$this->view->txtFalta = true;

			$this->render('cadastro');

		}

	}

	public function perguntasFrequentes(){
		$this->render('perguntasFrequentes');
	}

	public function criarLista(){
		$this->render('criarLista');
	}

	public function procurarLista(){
		$this->render('procurarLista');
	}

	public function esqueciSenha(){

		$usuario = Container::getModel('Usuario');

		$usuario->__set('email', $_POST['email']);

		if(isset($_POST['email'])){

			if($usuario->confirmarEmail() == true){

				if($usuario->esqueciSenha()){
					require_once('src/PHPMailer.php');
					require_once('src/SMTP.php');
					require_once('src/Exception.php');
					
					$mail = new PHPMailer(true);
		
					try {
						$mail->SMTPDebug = SMTP::DEBUG_SERVER;
						$mail->isSMTP();
						$mail->Host = 'smtp.gmail.com';
						$mail->SMTPAuth = true;
						$mail->Username = 'presenteisenac@gmail.com';
						$mail->Password = 'presentei123';
						$mail->Port = 587;
					
						$mail->setFrom('presenteisenac@gmail.com');
						$mail->addAddress($usuario->__get('email'));
			
						$mail->isHTML(true);
						$mail->Subject = 'Redefinir senha';
						$mail->Body = 'Para redefinir sua senha acesse o link abaixo<br>
						<a href="http://localhost:8080/recuperarSenha">Trocar Senha</a>';
						// $mail->AltBody = 'Chegou o email teste do Andre :3';
					
						if($mail->send()) {
		
							$this->view->senhaTrue = true;
							header('Location: /?login=login&loginErro=login&esqueci=true&senhaTrue=true&vazio=false&vazio=false&listaInvalido=false');
							// echo "1";
		
		
						} else {
							$this->view->senhafalse = true;
							header('Location: /?login=login&loginErro=login&esqueci=true&senhafalse=true&vazio=false&vazio=false&listaInvalido=false');
							// echo "2";
		
		
						}
					} catch (Exception $e) {
						$this->view->senhaErroTotal = true;
						header('Location: /?login=login&loginErro=login&esqueci=true&senhaErroTotal=true&vazio=false&senhaErroTotal=false&vazio=false&listaInvalido=false');
						// echo "3";
		
					}
				}
			}
			else{
				header('Location: /?login=login&loginErro=login&esqueci=true&senhaTrue=false&senhafalse=false&senhaErroTotal=false&vazio=false&emailInvalido=true&listaInvalido=false');
			}
			

		}
		else{
			
			header('Location: /?login=login&loginErro=login&esqueci=true&senhaTrue=false&senhafalse=false&senhaErroTotal=false&vazio=false&listaInvalido=false');

		}

	}
		
	public function recuperarSenha(){
		
			$this->view->senhaNaoAlterado = false;
			$this->view->senhaAlterado = false;
			$this->view->emailErrado = false;

			$this->render('recuperarSenha');
	}

	public function recuperarSenhaAlterar(){
		$usuario = Container::getModel('Usuario');

		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', $_POST['senha']);

		if(isset($_POST['email']) && isset($_POST['senha'])){
			

			$usuario->recuperarSenhaAlterar();

			if($usuario->recuperarSenhaAlterar()){
				$this->view->senhaAlterado = true;
			
				$this->render('recuperarSenha');
			}else{

				$this->view->emailErrado = true;
				
				$this->render('recuperarSenha');
	
			}

		}else{

			$this->view->senhaNaoAlterado = true;
			
			$this->render('recuperarSenha');

		}


	}

	public function buscarListaIndex(){

		header('Location: /?login=login&loginErro=false&esqueci=false&senhaTrue=false&senhafalse=false&senhaErroTotal=false&vazio=false&listaInvalido=false');

	}
	


}

?>

