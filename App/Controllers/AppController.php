<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {

	public function validaAutenticacao() {

        session_start();

        if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {
            header('Location: /?login=login&aut=erro');
        }
    }

	public function logado() {

		$this->validaAutenticacao();

		$this->view->nome = $_SESSION['nome'];

		$this->render('logado');
		
		// $this->view->senhaConf = true;

	}

	public function procurarListaLogado() {

		$this->validaAutenticacao();

		$this->view->nome = $_SESSION['nome'];
		$this->view->lista = array();
		
		$this->render('procurarListaLogado');
		

	}

	public function minhaConta() {

		$this->validaAutenticacao();
		$this->view->nome = $_SESSION['nome'];
		$this->view->usuario = array(
			'nome' => $_SESSION['nome'],
			'email' => $_SESSION['email'],
			'senha' => '',
			'cpf' => $_SESSION['cpf'],
			'confSenha' => '',
			'telefone' => $_SESSION['telefone']
		);
		$this->view->certoSenha = '';
		$this->view->erroSenha = '';

		$this->render('minhaConta');

	}

	public function atualizarUsuario() {

			$this->validaAutenticacao();
			$usuario = Container::getModel('Usuario');

			$usuario->__set('nome', $_POST['nome']);
			$usuario->__set('email', $_POST['email']);
			$usuario->__set('cpf', $_POST['cpf']);
			$usuario->__set('telefone', $_POST['telefone']);
			$usuario->atualizarUsuario($_SESSION['email']);

			$this->view->usuario = array(
				'nome' => $usuario->__get('nome'),
				'email' => $usuario->__get('email'),
				'senha' => '',
				'cpf' => $usuario->__get('cpf'),
				'confSenha' => '',
				'telefone' => $usuario->__get('telefone')
			);
			$this->view->certoSenha = '';
			$this->view->erroSenha = '';
			$this->view->nome = $_SESSION['nome'];
			$this->render('minhaConta');

	}

	public function atualizarSenhaUsuario() {
		$this->validaAutenticacao();

		$this->view->nome = $_SESSION['nome'];
		$this->view->lista = array();

		$usuario = Container::getModel('Usuario');
		$usuario->__set('senhaConfirmar', md5($_POST['senhaAntiga']));
		$usuario->__set('senha', md5($_POST['novaSenha']));
		$usuario->__set('email', $_SESSION['email']);

		if($usuario->verificarSenhaAntiga()){

			$usuario->atualizarSenhaUsuario();
	
			$this->view->usuario = array(
				'nome' => $_SESSION['nome'],
				'email' => $_SESSION['email'],
				'senha' => '',
				'cpf' => $_SESSION['cpf'],
				'confSenha' => '',
				'telefone' => $_SESSION['telefone']
			);
			
			$this->view->certoSenha = true;
			$this->view->erroSenha = false;	
			$this->render('minhaConta');
		}else{
			$this->view->usuario = array(
				'nome' => $_SESSION['nome'],
				'email' => $_SESSION['email'],
				'senha' => '',
				'cpf' => $_SESSION['cpf'],
				'confSenha' => '',
				'telefone' => $_SESSION['telefone']
			);
			$this->view->certoSenha = false;	
			$this->view->erroSenha = true;	
			$this->render('minhaConta');


		}
	}

	public function escolherLista() {

		$this->validaAutenticacao();

		$this->view->nome = $_SESSION['nome'];

		$this->render('escolherLista');
		
		// $this->view->senhaConf = true;
		// $this->view->senhaConf = true;

	}

	public function criarLista() {

		$this->validaAutenticacao();
		$this->view->nome = $_SESSION['nome'];
		$this->view->tamanhosIncorreto = false;
		$this->view->inserido = false;
		$this->view->opc = false;

		$titulo = $_GET['link'];

		switch ($titulo) {
			case 1:
				$this->view->titulo = "Lista de Casamento";
				break;
			case 2:
				$this->view->titulo = "Lista de Aniversário";
				break;
			case 3:
				$this->view->titulo = "Lista Chá de Bebê";
				break;
			case 4:
				$this->view->titulo = "Lista Chá de Cozinha";
				break;
			case 5:
				$this->view->titulo = "Lista";
				break;	
		}

		$this->render('criarLista');
		

	}

	public function salvarListas(){
		
		$this->validaAutenticacao();
		$lista = Container::getModel('Lista');
		$this->view->tamanhosIncorreto = false;
		$this->view->inserido = false;
		$this->view->opc = false;
		$this->view->nome = $_SESSION['nome'];

		$lista->__set('nome', $_POST['nome']);
		$lista->__set('texto', $_POST['texto']);
		$lista->__set('data', $_POST['data']);
		$lista->__set('local', $_POST['local']);
		// $lista->__set('arquivo', isset($_POST['arq']) ? $_POST['arq'] : '');
		$lista->__set('arquivo', $_FILES['arq']['name']);
		$lista->__set('url', $_FILES['arq']['tmp_name']);
		$lista->__set('id', $_SESSION['id']);
		$arq = $_FILES['arq'];

		// $arquivo = $_FILES['arq']['tmp_name'];

		// echo $arquivo;

		// $nome = $lista->__get('nome');
		// $texto = $lista->__get('texto');
		// $data = $lista->__get('data');
		// $local = $lista->__get('local');
		// $arq = $lista->__get('arquivo');
		// $id = $lista->__get('id');
		// $url = $lista->__get('url');


		$this->view->lista = array(
			'nome'    => $lista->__get('nome'),
			'data'    => $lista->__get('data'),
			'local'   => $lista->__get('local'),
			'texto'   => $lista->__get('texto'),
			'arquivo' => $lista->__get('arquivo'),
			'id'      => $_SESSION['id']
		);
		
		if($lista->__get('nome') and $lista->__get('data') and  $lista->__get('local') and $lista->__get('texto') and $lista->__get('arquivo') and $lista->__get('url')){
			
			$this->view->camposCrt = true;
			// Pasta onde o arquivo vai ser salvo
			$_UP['pasta'] = 'img/fotosListas/';
		
			//Tamanho máximo do arquivo em Bytes
			$_UP['tamanho'] = 1024*1024*5; //5mb
			
			//Array com a extensões permitidas
			$_UP['extensoes'] = array('png', 'jpg', 'jpeg', 'gif');
			
			//Renomeiar
			$_UP['renomeia'] = true;
			
			//Array com os tipos de erros de upload do PHP
			$_UP['erros'][0] = 'Não houve erro';
			$_UP['erros'][1] = 'O arquivo no upload é maior que o limite do PHP';
			$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especificado no HTML';
			$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
			$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

			// var_dump($arq);

			if(!preg_match("/\b(\.jpg|\.JPG|\.png|\.PNG|\.gif|\.GIF)\b/", $arq["type"])){

				//Faz a verificação do tamanho do arquivo
				if ($_UP['tamanho'] < $arq['size']){
					$this->view->tamanhosIncorreto = true;
					$this->render('criarLista');
					// echo ' <br> erro';	
				}					
				else{ //O arquivo passou em todas as verificações, hora de tentar move-lo para a pasta foto

					
					// var_dump($arq);
				//Primeiro verifica se deve trocar o nome do arquivo
					if($_UP['renomeia'] == true){

						preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arq["name"], $ext);
						//Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg

						// Gera um nome único para a imagem
						$nome_final = md5(uniqid(time())) . $ext[0];
						$lista->__set('img',$nome_final);

					}else{
						//mantem o nome original do arquivo
						$nome_final = $lista->__get('arquivo');
						$lista->__set('img', $nome_final);

					}

					// Verificar se é possivel mover o arquivo para a pasta escolhida
					
					if(move_uploaded_file($lista->__get('url'), $_UP['pasta']. $nome_final)){
						// Upload efetuado com sucesso, exibe a mensagem
						$this->view->inserido = true;
						
						$lista->inserirLista();

						// var_dump($lista->__get('idLista'));

						$_SESSION['idLista'] = $lista->__get('idLista');
						
						$this->render('categorias'); 
									
							
					}else{
						// echo '<br> foi não'
						$titulo = $lista->__get('nomeLista');

						switch ($titulo) {
							case 1:
								$this->view->titulo = "Lista de Casamento";
								break;
							case 2:
								$this->view->titulo = "Lista de Aniversário";
								break;
							case 3:
								$this->view->titulo = "Lista Chá de Bebê";
								break;
							case 4:
								$this->view->titulo = "Lista Chá de Cozinha";
								break;
							case 5:
								$this->view->titulo = "Lista";
								break;	
						}
						$this->view->inserido = false;		
						$this->render('criarLista');

					}
				}		
				
			}
			else{
				echo"passei aqui";
			}
			

		}
		else{


			$this->view->opc = true;

			$titulo = $_POST['link'];

			switch ($titulo) {
				case 1:
					$this->view->titulo = "Lista de Casamento";
					break;
				case 2:
					$this->view->titulo = "Lista de Aniversário";
					break;
				case 3:
					$this->view->titulo = "Lista Chá de Bebê";
					break;
				case 4:
					$this->view->titulo = "Lista Chá de Cozinha";
					break;
				case 5:
					$this->view->titulo = "Lista";
					break;	
			}
	
			$this->render('criarLista');


		}
						
	}

	public function buscarListaApp(){

		$this->validaAutenticacao();
		$lista = Container::getModel('Lista');
		$this->view->nome = $_SESSION['nome'];
		$this->view->lista = array();

		$lista->__set('nome', $_POST['nome']);

		// $totalDePagina = 9;

		// $count = $lista->contarListaPorId();

		// $this->view->totalDePaginas = ceil($count['total']/$totalDePagina);

		// $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

		// $deslocamento = ($pagina - 1) * $totalDePagina;

		// $this->view->paginaAtiva = $pagina;

		// $itens = $lista->buscarLista($totalDePagina,$deslocamento);

		// $this->view->itens = $itens;

		$totalDePagina = 6;

		$count = $lista->contarListaPorId();
	
		$this->view->totalDePaginas = ceil($count['total']/$totalDePagina);
	
		$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
	
		$deslocamento = ($pagina - 1) * $totalDePagina;
	
		$listas = $lista->buscarLista($totalDePagina,$deslocamento);
	
		$this->view->paginaAtiva = $pagina;

		$this->view->lista = $listas;
		$this->render('procurarListaLogado');

	}

	public function buscarListaAppPorId(){

		$this->validaAutenticacao();
		$lista = Container::getModel('Lista');
		$this->view->nome = $_SESSION['nome'];

		$this->view->lista = array();

		$lista->__set('id', $_SESSION['id']);

		$totalDePagina = 6;

		$count = $lista->contarListaPorId();

		$this->view->totalDePaginas = ceil($count['total']/$totalDePagina);

		$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

		$deslocamento = ($pagina - 1) * $totalDePagina;

		$listas = $lista->buscarListaPorId($totalDePagina,$deslocamento);

		$this->view->paginaAtiva = $pagina;

		$this->view->lista = $listas;
		$this->render('minhaLista');


	}

	public function itensLista(){

		$this->validaAutenticacao();
		$lista = Container::getModel('Lista');
		$this->view->nome = $_SESSION['nome'];

		$this->render('itensLista');
		

	}

	public function abrirLista(){

		$this->validaAutenticacao();
		$lista = Container::getModel('Lista');
		$this->view->nome = $_SESSION['nome'];

		$lista->__set('id', $_GET['id']);

		$this->view->id = $lista->__get('id');
		
		$this->render('abrirLista');
		

	}

	public function categorias(){
		$this->validaAutenticacao();
		$lista = Container::getModel('Lista');
		$this->view->nome = $_SESSION['nome'];

		$this->render('categorias');
	}

	public function lojas(){
		$this->validaAutenticacao();
		$lista = Container::getModel('Lista');
		$this->view->nome = $_SESSION['nome'];

		$link = $_GET['link'];

		switch ($link) {
			case 1:
				$lista->__set('categoria', 'Beleza e Cuidado Pessoal');
				break;
			case 2:
				$lista->__set('categoria', 'Eletrodomésticos');
				break;
			case 3:
				$lista->__set('categoria', 'Eletroportáteis');
				break;
			case 4:
				$lista->__set('categoria', 'Ferramentas');
				break;
			case 5:
				$lista->__set('categoria', 'Informática');
				break;
			case 6:
				$lista->__set('categoria', 'Moda e acessórios');
				break;
			case 7:
				$lista->__set('categoria', 'Móveis e decorações');
				break;
			case 8:
				$lista->__set('categoria', 'Saúde');
				break;
			case 9:
				$lista->__set('categoria', 'Utilidades domésticas');
				break;
				
		}

		$lojas = $lista->buscarLojas();

		$this->view->lojas = $lojas;

		$this->render('lojas');
	}

	public function produtos(){
		$this->validaAutenticacao();
		$lista = Container::getModel('Lista');
		$this->view->nome = $_SESSION['nome'];

		$lista->__set('categoria', $_GET['categoria']);
		$lista->__set('nomeEmpresa', $_GET['empresa']);
		// $lista->__set('nomeEmpresa', $_GET['link']);


		$produto = $lista->buscarProdutos();

		$this->view->produtos = $produto;
		$this->render('produtos');
	}

	public function adicionarNaLista(){
		$this->validaAutenticacao();
		$lista = Container::getModel('Lista');
		$this->view->nome = $_SESSION['nome'];

		$lista->__set('valor', $_POST['valorProduto']);
		$lista->__set('nome', $_POST['nomeProduto']);
		$lista->__set('quantidade', $_POST['quantidadeProduto']);
		$lista->__set('url', $_POST['linkProduto']);
		$lista->__set('idUser', $_SESSION['id']);
		$lista->__set('idLista', $_SESSION['idLista']);

		// var_dump($_SESSION['idLista']);

		$lista->adicionarNaLista();

		$totalDePagina = 6;

		$count = $lista->contaritemPorId();

		$this->view->totalDePaginas = ceil($count['total']/$totalDePagina);

		$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

		$deslocamento = ($pagina - 1) * $totalDePagina;

		// $listas = $lista->buscarListaPorId($totalDePagina,$deslocamento);

		$this->view->paginaAtiva = $pagina;

		$itens = $lista->verMeusProdutos($totalDePagina,$deslocamento);

		// var_dump($itens);

		$this->view->itens = $itens;

		$this->render('verMeusProdutos');
	}

	public function verMeusProdutos(){
		$this->validaAutenticacao();
		$lista = Container::getModel('Lista');
		$this->view->nome = $_SESSION['nome'];

		$lista->__set('idUser', $_SESSION['id']);
		

		if($_GET['id'] == ""){
		
			$lista->__set('idLista', $_SESSION['idLista']);
		
		}else{

			$lista->__set('idLista', $_GET['id']);
			$_SESSION['idLista'] = $_GET['id'];
		}

		$totalDePagina = 6;

		$count = $lista->contaritemPorId();

		$this->view->totalDePaginas = ceil($count['total']/$totalDePagina);

		$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

		$deslocamento = ($pagina - 1) * $totalDePagina;

		// $listas = $lista->buscarListaPorId($totalDePagina,$deslocamento);

		$this->view->paginaAtiva = $pagina;

		$itens = $lista->verMeusProdutos($totalDePagina,$deslocamento);

		$this->view->itens = $itens;

		$this->render('verMeusProdutos');

	}

	public function excluirLista(){
		$this->validaAutenticacao();
		$lista = Container::getModel('Lista');
		$this->view->nome = $_SESSION['nome'];

		$lista->__set('id', $_GET['id']);		

		$lista->excluirItemParaLista();

		$lista->excluirLista();

		$this->view->lista = array();

		$lista->__set('id', $_SESSION['id']);

		$totalDePagina = 6;

		$count = $lista->contarListaPorId();

		$this->view->totalDePaginas = ceil($count['total']/$totalDePagina);

		$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

		$deslocamento = ($pagina - 1) * $totalDePagina;

		$listas = $lista->buscarListaPorId($totalDePagina,$deslocamento);

		$this->view->paginaAtiva = $pagina;

		$this->view->lista = $listas;

		$this->render('minhaLista');
	}
	
	public function excluirItem(){
		$this->validaAutenticacao();
		$lista = Container::getModel('Lista');
		$this->view->nome = $_SESSION['nome'];

		$lista->__set('id', $_GET['id']);		

		$lista->excluirItem();

		$lista->__set('idUser', $_SESSION['id']);
		$lista->__set('idLista', $_SESSION['idLista']);

		$totalDePagina = 6;

		$count = $lista->contaritemPorId();

		$this->view->totalDePaginas = ceil($count['total']/$totalDePagina);

		$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

		$deslocamento = ($pagina - 1) * $totalDePagina;

		// $listas = $lista->buscarListaPorId($totalDePagina,$deslocamento);

		$this->view->paginaAtiva = $pagina;

		$itens = $lista->verMeusProdutos($totalDePagina,$deslocamento);

		$this->view->itens = $itens;

		$this->render('verMeusProdutos');

    }

	public function alterarItem(){
		$this->validaAutenticacao();
		$lista = Container::getModel('Lista');
		$this->view->nome = $_SESSION['nome'];

		$lista->__set('idUser', $_SESSION['id']);
		
		if($_GET['id'] == ""){
		
			$lista->__set('idLista', $_SESSION['idLista']);
		
		}else{

			$lista->__set('idLista', $_GET['id']);
			$_SESSION['idLista'] = $_GET['id'];
		}

		$totalDePagina = 6;

		$count = $lista->contaritemPorId();

		$this->view->totalDePaginas = ceil($count['total']/$totalDePagina);

		$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

		$deslocamento = ($pagina - 1) * $totalDePagina;

		// $listas = $lista->buscarListaPorId($totalDePagina,$deslocamento);

		$this->view->paginaAtiva = $pagina;

		$itens = $lista->verMeusProdutos($totalDePagina,$deslocamento);

		$this->view->itens = $itens;		
		
		$this->render('alterarItem');
		
	}

	public function alterarItemPermanente(){
		$this->validaAutenticacao();
		$lista = Container::getModel('Lista');
		$this->view->nome = $_SESSION['nome'];

		$lista->__set('idLista', $_SESSION['idLista']);
		$lista->__set('quantidade', $_POST['qtd']);
		$lista->__set('valor', $_POST['id']);

		$lista->alterarItem();

		$lista->__set('idUser', $_SESSION['id']);

		$totalDePagina = 6;

		$count = $lista->contaritemPorId();

		$this->view->totalDePaginas = ceil($count['total']/$totalDePagina);

		$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

		$deslocamento = ($pagina - 1) * $totalDePagina;

		// $listas = $lista->buscarListaPorId($totalDePagina,$deslocamento);

		$this->view->paginaAtiva = $pagina;

		$itens = $lista->verMeusProdutos($totalDePagina,$deslocamento);

		$this->view->itens = $itens;		
		
		$this->render('alterarItem');
	}

	public function alterarLista(){
		$this->validaAutenticacao();
		$lista = Container::getModel('Lista');
		$this->view->nome = $_SESSION['nome'];

		$lista->__set('id', $_SESSION['id']);
		$lista->__set('idLista', $_SESSION['idLista']);

		$listas = $lista->selecionarTabela();

		$this->view->lista = $listas;

		$this->render('alterarLista');
	}

	public function alterarListaPermanente(){
		$this->validaAutenticacao();
		$lista = Container::getModel('Lista');
		$this->view->nome = $_SESSION['nome'];

		$lista->__set('nome', $_POST['nome']);
		$lista->__set('texto', $_POST['texto']);
		$lista->__set('data', $_POST['data']);
		$lista->__set('local', $_POST['local']);
		$lista->__set('arquivo', $_FILES['arq']['name']);
		$lista->__set('url', $_FILES['arq']['tmp_name']);
		$lista->__set('id', $_SESSION['id']);
		$arq = $_FILES['arq'];
		$lista->__set('idLista',$_SESSION['idLista']);


		$this->view->lista = array(
			'nome'    => $lista->__get('nome'),
			'data'    => $lista->__get('data'),
			'local'   => $lista->__get('local'),
			'texto'   => $lista->__get('texto'),
			'arquivo' => $lista->__get('arquivo'),
			'id'      => $_SESSION['id']
		);
		
		if($lista->__get('nome') and $lista->__get('data') and  $lista->__get('local') and $lista->__get('texto') and $lista->__get('arquivo') and $lista->__get('url')){
			
			$this->view->camposCrt = true;
			// Pasta onde o arquivo vai ser salvo
			$_UP['pasta'] = 'img/fotosListas/';
		
			//Tamanho máximo do arquivo em Bytes
			$_UP['tamanho'] = 1024*1024*5; //5mb
			
			//Array com a extensões permitidas
			$_UP['extensoes'] = array('png', 'jpg', 'jpeg', 'gif');
			
			//Renomeiar
			$_UP['renomeia'] = true;
			
			//Array com os tipos de erros de upload do PHP
			$_UP['erros'][0] = 'Não houve erro';
			$_UP['erros'][1] = 'O arquivo no upload é maior que o limite do PHP';
			$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especificado no HTML';
			$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
			$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

			// var_dump($arq);

			if(!preg_match("/\b(\.jpg|\.JPG|\.png|\.PNG|\.gif|\.GIF)\b/", $arq["type"])){

				//Faz a verificação do tamanho do arquivo
				if ($_UP['tamanho'] < $arq['size']){
					$this->view->tamanhosIncorreto = true;
					echo ' <br>1';
					$this->render('alterarLista');
						
				}					
				else{ //O arquivo passou em todas as verificações, hora de tentar move-lo para a pasta foto

					
					// var_dump($arq);
				//Primeiro verifica se deve trocar o nome do arquivo
					if($_UP['renomeia'] == true){

						preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arq["name"], $ext);
						//Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg

						// Gera um nome único para a imagem
						$nome_final = md5(uniqid(time())) . $ext[0];
						$lista->__set('img',$nome_final);

					}else{
						//mantem o nome original do arquivo
						$nome_final = $lista->__get('arquivo');
						$lista->__set('img', $nome_final);

					}

					// Verificar se é possivel mover o arquivo para a pasta escolhida
					
					if(move_uploaded_file($lista->__get('url'), $_UP['pasta']. $nome_final)){
						// Upload efetuado com sucesso, exibe a mensagem
						$this->view->inserido = true;

						
						
						$lista->alterarLista();

						$this->view->lista = array();

						$lista->__set('id', $_SESSION['id']);

						$totalDePagina = 6;

						$count = $lista->contarListaPorId();

						$this->view->totalDePaginas = ceil($count['total']/$totalDePagina);

						$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

						$deslocamento = ($pagina - 1) * $totalDePagina;

						$listas = $lista->buscarListaPorId($totalDePagina,$deslocamento);

						$this->view->paginaAtiva = $pagina;

						$this->view->lista = $listas;

						// var_dump($lista->__get('idLista'));
						
						$this->render('minhaLista'); 
									
							
					}else{
						// echo '<br> foi não'
						$titulo = $lista->__get('nomeLista');

						switch ($titulo) {
							case 1:
								$this->view->titulo = "Lista de Casamento";
								break;
							case 2:
								$this->view->titulo = "Lista de Aniversário";
								break;
							case 3:
								$this->view->titulo = "Lista Chá de Bebê";
								break;
							case 4:
								$this->view->titulo = "Lista Chá de Cozinha";
								break;
							case 5:
								$this->view->titulo = "Lista";
								break;	
						}
						$this->view->inserido = false;		
						echo ' <br>2';	

						$this->render('alterarLista');

					}
				}		
				
			}
			else{
				echo"passei aqui";
			}
			

		}
		else{


			$this->view->opc = true;

			$titulo = $_POST['link'];

			switch ($titulo) {
				case 1:
					$this->view->titulo = "Lista de Casamento";
					break;
				case 2:
					$this->view->titulo = "Lista de Aniversário";
					break;
				case 3:
					$this->view->titulo = "Lista Chá de Bebê";
					break;
				case 4:
					$this->view->titulo = "Lista Chá de Cozinha";
					break;
				case 5:
					$this->view->titulo = "Lista";
					break;	
			}
				echo ' <br>3';
				$this->render('alterarLista');


		}

	}

	public function SoVerMeusProdutos(){
		$this->validaAutenticacao();
		$lista = Container::getModel('Lista');
		$this->view->nome = $_SESSION['nome'];

		$lista->__set('idUser', $_SESSION['id']);
		

		if($_GET['id'] == ""){
		
			$lista->__set('idLista', $_SESSION['idLista']);
		
		}else{

			$lista->__set('idLista', $_GET['id']);
			$_SESSION['idLista'] = $_GET['id'];
		}

		$totalDePagina = 6;

		$count = $lista->contaritemPorId();

		$this->view->totalDePaginas = ceil($count['total']/$totalDePagina);

		$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

		$deslocamento = ($pagina - 1) * $totalDePagina;

		$listas = $lista->buscarLista($totalDePagina,$deslocamento);

		$this->view->paginaAtiva = $pagina;

		$itens = $lista->verMeusProdutos($totalDePagina,$deslocamento);

		// var_dump($listas);

		$this->view->itens = $itens;
		$this->view->listas = $listas;

		$this->render('SoVerMeusProdutos');
	}
	
}

?>