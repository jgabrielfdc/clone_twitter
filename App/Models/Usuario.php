<?php

namespace App\Models;

use MF\Model\Database;

class Usuario extends Database{
    private $id;
    private $name;
    private $email;
    private $password;

    public function __get($attr){
        return $this->$attr;
    }

    public function __set($attr,$val){
        $this->$attr = $val;
    }

    //salvar

    public function save(){
        $query="INSERT INTO usuarios(nome,email,senha)VALUES(:nome,:email,:senha)";
        $stmt=$this->db->prepare($query);
        $stmt->bindValue(":nome",$this->__get("name"));
        $stmt->bindValue(":email",$this->__get("email"));
        $stmt->bindValue(":senha",$this->__get("password"));//md5() -> hash 32 caracteres

        $stmt->execute();
        
        return $this;
    }

    //validar se um cadastro pode ser efetuado
    public function validateSave(){
        $validate=true;

        if(strlen($this->__get("name"))< 3){
            $validate=false;
        }

        if(strlen($this->__get("email"))< 3){
     
            $validate=false;
        }

        if(strlen($this->__get("password"))< 3){
            $validate=false;
        }

        return $validate;
    }

    //recuperar usuario por email
    public function getUserByEmail(){
        $query="SELECT nome,email FROM usuarios WHERE email=:email";
        $stmt=$this->db->prepare($query);
        $stmt->bindValue(":email",$this->__get("email"));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function autenticar(){
        $query="SELECT id, nome, email FROM usuarios WHERE email=:email AND senha=:senha";
        $stmt=$this->db->prepare($query);

        $stmt->bindValue(":email",$this->__get("email"));
        $stmt->bindValue(":senha",$this->__get("password"));

        $stmt->execute();

        $usuario=$stmt->fetch(\PDO::FETCH_ASSOC);

        if($usuario["id"]!="" && $usuario['nome'] !=""){
            $this->__set("id", $usuario["id"]);
            $this->__set("name", $usuario["nome"]);
            $this->__set("email", $usuario["email"]);
        }

        return $this;

    }

    public function getAll(){
        $query="SELECT 
				u.id, 
				u.nome, 
				u.email,
				(
					SELECT
						count(id)
					from
						usuarios_seguidores as us 
					where
						us.id_usuario = :id_usuario and us.id_usuario_seguindo = u.id
				) as seguindo_sn
			from  
				usuarios as u
			where 
				u.nome like :nome and u.id != :id_usuario";
        $stmt=$this->db->prepare($query);
        $stmt->bindValue(":nome",'%'.$this->__get('name').'%');
        $stmt->bindValue(":id_usuario",$this->__get('id'));
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getFollowingCount(){
        $query='SELECT count(id) as qnt_seguindo FROM usuarios_seguidores WHERE id_usuario=:id_usuario';
        $stmt=$this->db->prepare($query);
        $stmt->bindValue(':id_usuario',$this->__get('id'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getFollowerCount(){
        $query='SELECT count(id) as qnt_seguidores FROM usuarios_seguidores WHERE id_usuario_seguindo=:id_usuario';
        $stmt=$this->db->prepare($query);
        $stmt->bindValue(':id_usuario',$this->__get('id'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function seguirUsuario($id_usuario_seguindo){
        $query='INSERT INTO usuarios_seguidores(id_usuario,id_usuario_seguindo) VALUES (:id_usuario,:id_usuario_seguindo)';
        $stmt=$this->db->prepare($query);
        $stmt->bindValue(":id_usuario",$this->__get('id'));
        $stmt->bindValue(":id_usuario_seguindo",$id_usuario_seguindo);

        $stmt->execute();
        return true;
    }

    public function deixarSeguirUsuario($id_usuario_seguindo) {
		$query = "delete from usuarios_seguidores where id_usuario = :id_usuario and id_usuario_seguindo = :id_usuario_seguindo";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->__get('id'));
		$stmt->bindValue(':id_usuario_seguindo', $id_usuario_seguindo);
		$stmt->execute();

		return true;
	}
}