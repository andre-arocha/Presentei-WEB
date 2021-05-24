<?php

namespace App\Models;

use MF\Model\Model;

class Usuario extends Model {
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $cpf;
    private $telefone;
    private $senhaConfirmar;

    public function __get($atributo) {
        return $this->$atributo;  
    }

    public function __set($atributo, $valor) {
       $this->$atributo = $valor;
    }

    public function salvar() {
        $query = "insert into tb_usuario(nome_usuario, email_usuario, senha_usuario, senhaOriginal_usuario, telefone, cpf_usuario)
        values(:nome_usuario, :email_usuario, :senha_usuario, :senhaOriginal_usuario, :telefone, :cpf_usuario)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome_usuario', $this->__get('nome'));
        $stmt->bindValue(':email_usuario', $this->__get('email'));
        $stmt->bindValue(':senha_usuario', $this->__get('senha'));
        $stmt->bindValue(':senhaOriginal_usuario', $this->__get('senha'));
        $stmt->bindValue(':telefone', $this->__get('telefone'));
        $stmt->bindValue(':cpf_usuario', $this->__get('cpf'));

        $stmt->execute();

		return $this;

    }

    public function validarCadastro() {
        $valido = true;

        if(strlen($this->__get('nome')) < 3) {
            $valido = true;
        }

        if(strlen($this->__get('email')) < 3) {
            $valido = false;
        }

        if(strlen($this->__get('senha')) < 3) {
            $valido = false;
        }

        if(strlen($this->__get('cpf')) < 3) {
            $valido = false;
        }

        if(strlen($this->__get('telefone')) < 3) {
            $valido = false;
        }

        if(strlen($this->__get('senhaConfirmar')) < 3) {
            $valido = false;
        }

        return $valido;
    }

    public function validarCadastroTxt() {
        $valido = array();

        if(strlen($this->__get('nome')) < 3) {
            $valido['nome'] = true;
        }

        if(strlen($this->__get('email')) < 3) {
            $valido['email'] = true;
        }

        if(strlen($this->__get('senha')) < 3) {
            $valido['senha'] = 1;
        }

        if(strlen($this->__get('cpf')) < 3) {
            $valido['cpf'] = true;
        }

        if(strlen($this->__get('telefone')) < 3) {
            $valido['telefone'] = true;
        }

        if(strlen($this->__get('senhaConfirmar')) < 3) {
            $valido['senhaConfirmar'] = 1;
        }

        return $valido;
    }

    public function confSenha() {
        $senhaCorreta = false;
        $senha = $this->__get('senha');
        $senhaC = $this->__get('senhaConfirmar');


        if($senhaC == $senha){
            $senhaCorreta= true;
        }

        return $senhaCorreta;
    }


    public function getUsuarioPorEmail() {
        $query = "select nome_usuario ,email_usuario, cpf_usuario from tb_usuario where email_usuario = :email and cpf_usuario = :cpf";
        $stmt = $this->db->prepare($query);
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->bindValue(':cpf', $this->__get('cpf'));

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function autenticar() {
		$query = "select id_usuario, nome_usuario, email_usuario, cpf_usuario, telefone from tb_usuario where email_usuario = :email and senha_usuario = :senha";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->bindValue(':senha', $this->__get('senha'));
		$stmt->execute();

		$usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if($usuario['id_usuario'] != '' && $usuario['nome_usuario'] != '') {
            $this->__set('id', $usuario['id_usuario']);
            $this->__set('nome', $usuario['nome_usuario']);
            $this->__set('cpf', $usuario['cpf_usuario']);
            $this->__set('telefone', $usuario['telefone']);
            $this->__set('email', $usuario['email_usuario']);
        }

        return $this;

    }

    public function verificarSenhaAntiga() {
		$query = "select senha_usuario from tb_usuario where email_usuario = :email";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->execute();

		$usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($usuario['senha_usuario'] == $this->__get('senhaConfirmar')) {
            return true;
        } else{
            return false;
        }
    
    }

    public function atualizarUsuario($email) {

            $query = "update 
                        tb_usuario 
                    set 
                        nome_usuario=:nome,
                        email_usuario=:email,
                        telefone=:telefone,
                        cpf_usuario=:cpf
                    where 
                        email_usuario = :emailVelho";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':telefone', $this->__get('telefone'));
            $stmt->bindValue(':cpf', $this->__get('cpf'));
            $stmt->bindValue(':emailVelho', $email);

            $stmt->execute();
    
            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if($usuario['id_usuario'] != '' && $usuario['nome_usuario'] != '') {
                $this->__set('id', $usuario['id_usuario']);
                $this->__set('nome', $usuario['nome_usuario']);
                $this->__set('cpf', $usuario['cpf_usuario']);
                $this->__set('telefone', $usuario['telefone']);
                $this->__set('email', $usuario['email_usuario']);
            }
    
            return $this;

    }

    public function atualizarSenhaUsuario() {

        $query = "update 
                    tb_usuario 
                set 
                    senha_usuario=:senha,
                    senhaOriginal_usuario= :senha
                where 
                    email_usuario = :email";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->bindValue(':email', $this->__get('email'));

        $stmt->execute();

        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if($usuario['id_usuario'] != '' && $usuario['nome_usuario'] != '') {
            $this->__set('id', $usuario['id_usuario']);
            $this->__set('nome', $usuario['nome_usuario']);
            $this->__set('cpf', $usuario['cpf_usuario']);
            $this->__set('telefone', $usuario['telefone']);
            $this->__set('email', $usuario['email_usuario']);
        }

        return $this;
    }

	public function esqueciSenha(){
    
        $query = "select email_usuario FROM tb_usuario WHERE email_usuario =:email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function recuperarSenhaAlterar(){
    
        $query = "update 
                    tb_usuario 
                set 
                    senha_usuario=md5(:senha)
                where 
                    email_usuario = :email";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', $this->__get('senha'));

        $stmt->execute();

        return $this;

    }

    public function confirmarEmail(){
    
        $query = "select email_usuario from tb_usuario where email_usuario = :email";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':email', $this->__get('email'));
        
        $stmt->execute();

        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);


        if($usuario['email_usuario'] == $this->__get('email') && !empty($this->__get('email'))) {
            return true;
        } else{
            return false;
        }

    }

    

}



?>
