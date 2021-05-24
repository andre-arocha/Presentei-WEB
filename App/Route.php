<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['cadastro'] = array(
			'route' => '/cadastro',
			'controller' => 'indexController',
			'action' => 'cadastro'
		);

		$routes['registrar'] = array(
			'route' => '/registrar',
			'controller' => 'indexController',
			'action' => 'registrar'
		);

		$routes['login'] = array(
			'route' => '/login',
			'controller' => 'indexController',
			'action' => 'login'
		);
		
		$routes['logar'] = array(
			'route' => '/logar',
			'controller' => 'AuthController',
			'action' => 'logar'
		);

		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);

		$routes['logado'] = array(
			'route' => '/logado',
			'controller' => 'AppController',
			'action' => 'logado'
		);

		$routes['minhaConta'] = array(
			'route' => '/minhaConta',
			'controller' => 'AppController',
			'action' => 'minhaConta'
		);

		$routes['minhaLista'] = array(
			'route' => '/minhaLista',
			'controller' => 'AppController',
			'action' => 'buscarListaAppPorId'
		);

		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);

		$routes['atualizarUsuario'] = array(
			'route' => '/atualizarUsuario',
			'controller' => 'AppController',
			'action' => 'atualizarUsuario'
		);

		$routes['atualizarSenhaUsuario'] = array(
			'route' => '/atualizarSenhaUsuario',
			'controller' => 'AppController',
			'action' => 'atualizarSenhaUsuario'
		);
		
		$routes['perguntasFrequentes'] = array(
			'route' => '/perguntasFrequentes',
			'controller' => 'indexController',
			'action' => 'perguntasFrequentes'
		);

		$routes['criarLista'] = array(
			'route' => '/criarLista',
			'controller' => 'indexController',
			'action' => 'criarLista'
		);

		$routes['procurarLista'] = array(
			'route' => '/procurarLista',
			'controller' => 'indexController',
			'action' => 'procurarLista'
		);

		$routes['procurarListaLogado'] = array(
			'route' => '/procurarListaLogado',
			'controller' => 'AppController',
			'action' => 'procurarListaLogado'
		);

		$routes['escolherLista'] = array(
			'route' => '/escolherLista',
			'controller' => 'AppController',
			'action' => 'escolherLista'
		);

		$routes['criarLista'] = array(
			'route' => '/criarLista',
			'controller' => 'AppController',
			'action' => 'criarLista'
		);

		$routes['salvarListas'] = array(
			'route' => '/salvarListas',
			'controller' => 'AppController',
			'action' => 'salvarListas'
		);

		$routes['buscarListaApp'] = array(
			'route' => '/buscarListaApp',
			'controller' => 'AppController',
			'action' => 'buscarListaApp'
		);

		$routes['categorias'] = array(
			'route' => '/categorias',
			'controller' => 'AppController',
			'action' => 'categorias'
		);

		$routes['lojas'] = array(
			'route' => '/lojas',
			'controller' => 'AppController',
			'action' => 'lojas'
		);

		$routes['esqueciSenha'] = array(
			'route' => '/esqueciSenha',
			'controller' => 'indexController',
			'action' => 'esqueciSenha'
		);

		$routes['buscarListaIndex'] = array(
			'route' => '/buscarListaIndex',
			'controller' => 'indexController',
			'action' => 'buscarListaIndex'
		);

		$routes['recuperarSenha'] = array(
			'route' => '/recuperarSenha',
			'controller' => 'indexController',
			'action' => 'recuperarSenha'
		);

		$routes['recuperarSenhaAlterar'] = array(
			'route' => '/recuperarSenhaAlterar',
			'controller' => 'indexController',
			'action' => 'recuperarSenhaAlterar'
		);

		$routes['confirmarEmail'] = array(
			'route' => '/confirmarEmail',
			'controller' => 'indexController',
			'action' => 'confirmarEmail'
		);

		$routes['produtos'] = array(
			'route' => '/produtos',
			'controller' => 'AppController',
			'action' => 'produtos'
		);
		
		$routes['adicionarNaLista'] = array(
			'route' => '/adicionarNaLista',
			'controller' => 'AppController',
			'action' => 'adicionarNaLista'
		);

		$routes['verMeusProdutos'] = array(
			'route' => '/verMeusProdutos',
			'controller' => 'AppController',
			'action' => 'verMeusProdutos'
		);

		$routes['SoVerMeusProdutos'] = array(
			'route' => '/SoVerMeusProdutos',
			'controller' => 'AppController',
			'action' => 'SoVerMeusProdutos'
		);

		$routes['excluirItem'] = array(
			'route' => '/excluirItem',
			'controller' => 'AppController',
			'action' => 'excluirItem'
		);

		$routes['excluirLista'] = array(
			'route' => '/excluirLista',
			'controller' => 'AppController',
			'action' => 'excluirLista'
		);

		$routes['alterarItem'] = array(
			'route' => '/alterarItem',
			'controller' => 'AppController',
			'action' => 'alterarItem'
		);

		$routes['alterarItemPermanente'] = array(
			'route' => '/alterarItemPermanente',
			'controller' => 'AppController',
			'action' => 'alterarItemPermanente'
		);		

		$routes['alterarLista'] = array(
			'route' => '/alterarLista',
			'controller' => 'AppController',
			'action' => 'alterarLista'
		);

		$routes['alterarListaPermanente'] = array(
			'route' => '/alterarListaPermanente',
			'controller' => 'AppController',
			'action' => 'alterarListaPermanente'
		);
				
		$this->setRoutes($routes);
	}

}

?>