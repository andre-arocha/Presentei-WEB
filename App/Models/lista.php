<?php

namespace App\Models;

use MF\Model\Model;

class Lista extends Model {
    private $id;
    private $idUser;
    private $idLista;
    private $nome;
    private $img;
    private $data;
    private $texto;
    private $local;
    private $arquivo;
    private $quantidade;
    private $url;
    private $nomeLista;
    private $categoria;
    private $nomeEmpresa;
    private $valor;

    public function __get($atributo) {
        return $this->$atributo;  
    }

    public function __set($atributo, $valor) {
       $this->$atributo = $valor;
    }

    public function inserirLista() {

        $query = "insert into tb_criarlista(nome_lista, data_lista, local_lista, descricao_lista, img_lista, id_usuario)
        values(:nome, :data, :local, :texto, :img, :id)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':data', $this->__get('data'));
        $stmt->bindValue(':local', $this->__get('local'));
        $stmt->bindValue(':texto', $this->__get('texto'));
        $stmt->bindValue(':img', $this->__get('img'));
        $stmt->bindValue(':id', $this->__get('id'));

        $stmt->execute();

        // $lista = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // $ultimoID = ;

		$this->__set('idLista',$this->db->lastInsertId());
        // print_r($this->__get('idLista'));

        return $this;
    }

    public function buscarLista($limit, $offset) {

        $query = "select lista.nome_lista, lista.img_lista, usuario.nome_usuario, lista.id_lista, lista.data_lista from
        tb_criarlista lista inner join tb_usuario usuario on lista.id_usuario = usuario.id_usuario where
        (id_lista like :nome) or (nome_lista like :nome) order by nome_lista asc limit $limit offset $offset";
 
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':nome', '%'.$this->__get('nome').'%');

        $stmt->execute();
    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        
    }

    public function buscarListaPorId($limit, $offset) {

        $query = "select * from  tb_criarlista where id_usuario = :id order by nome_lista asc limit $limit offset $offset";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id', $this->__get('id'));

        $stmt->execute();
    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        
    }

    public function contarListaPorId(){

        $query = "select count(*) as total from tb_criarlista where id_usuario = :id";

        
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id', $this->__get('id'));

        $stmt->execute();
    
        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

    public function contaritemPorId(){

        $query = "select count(*) as total from tb_listavariados where id_lista = :idLista";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':idLista', $this->__get('idLista'));

        $stmt->execute();
    
        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

    public function buscarLojas(){

        // $query = "select nome_empresa, logo_empresa from tb_empresa where id_usuario = :id order by nome_lista asc limit $limit offset $offset";

        $query = "select empresa.nome_empresa, empresa.logo_empresa, item.categoria_produto from
        tb_empresa empresa inner join tb_produtosempresas item where
        categoria_produto = :categoria and status_empresa = 1 order by nome_empresa asc";
        // echo "nome";
        // limit $limit offset $offset
        
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':categoria', $this->__get('categoria'));

        $stmt->execute();
    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function buscarProdutos(){

        $query = "select produto.id_produto, produto.nome_produto, produto.valor_produto, produto.link_produto, produto.imagem_produto, produto.imagem_produto from
        tb_produtosempresas produto inner join tb_empresa empresa where
        categoria_produto = :categoria and empresa.nome_empresa = :nomeEmpresa and status_empresa = 1 order by produto.nome_produto asc";

        // limit $limit offset $offset
        
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':categoria', $this->__get('categoria'));
        $stmt->bindValue(':nomeEmpresa', $this->__get('nomeEmpresa'));


        $stmt->execute();
    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function adicionarNaLista(){
        $query = "insert into tb_listavariados(id_variados, nome_variados, valor_variados, site_variados, quantidade_variados, id_usuario, id_lista)
        values(null, :nome, :valor, :url, :quantidade, :id, :idLista)";

        // limit $limit offset $offset
        
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':valor', $this->__get('valor'));
        $stmt->bindValue(':quantidade', $this->__get('quantidade'));
        $stmt->bindValue(':url', $this->__get('url'));
        $stmt->bindValue(':id', $this->__get('idUser'));
        $stmt->bindValue(':idLista', $this->__get('idLista'));

        $stmt->execute();
    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function verMeusProdutos($limit, $offset){

        $query = "select lista.id_variados, lista.nome_variados, lista.valor_variados, lista.site_variados, lista.quantidade_variados, produto.imagem_produto from
        tb_produtosempresas produto inner join tb_listavariados lista where id_usuario = :idUsuario and id_lista = :idLista 
        order by nome_variados asc limit $limit offset $offset";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':idUsuario', $this->__get('idUser'));
        $stmt->bindValue(':idLista', $this->__get('idLista'));

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function excluirLista(){
        $query = "delete from tb_criarlista WHERE id_lista = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id', $this->__get('id'));

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function excluirItemParaLista(){
        $query = "delete from tb_listavariados WHERE id_lista = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id', $this->__get('id'));

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }
    
    public function excluirItem(){
        $query = "delete from tb_listavariados WHERE id_variados = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id', $this->__get('id'));

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function alterarItem(){
        $query = "update tb_listavariados 
                    SET quantidade_variados = :qtd  
                    WHERE id_lista = :idLista and id_variados = :idV";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':idLista', $this->__get('idLista'));
        $stmt->bindValue(':qtd', $this->__get('quantidade'));
        $stmt->bindValue(':idV', $this->__get('valor'));

        $stmt->execute();

        return $this;

    }

    public function alterarLista(){
        $query = "update tb_criarlista 
                    SET nome_lista = :nome, data_lista = :data, local_lista = :local, descricao_lista = :texto, img_lista = :img    
                    WHERE id_lista = :idLista";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':data', $this->__get('data'));
        $stmt->bindValue(':local', $this->__get('local'));
        $stmt->bindValue(':texto', $this->__get('texto'));
        $stmt->bindValue(':img', $this->__get('img'));
        $stmt->bindValue(':idLista', $this->__get('idLista'));

        $stmt->execute();

        return $this;

    }

    public function selecionarTabela(){
        $query = "select * from  tb_criarlista where id_usuario = :id and id_lista = :idLista";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->bindValue(':idLista', $this->__get('idLista'));

        $stmt->execute();
    
        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

}

?>
