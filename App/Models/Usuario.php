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

        if(strlen($this->__get("name"))< 4){
            $validate=false;
        }

        if(strlen($this->__get("email"))< 4){
     
            $validate=false;
        }

        if(strlen($this->__get("password"))< 4){
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

}