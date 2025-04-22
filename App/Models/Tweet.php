<?php

namespace App\Models;

use MF\Model\Database;

class Tweet extends Database{
  private $id;
  private $id_usuario;
  private $tweet;
  private $data;

  public function __get($attr){
    return $this->$attr;
}

public function __set($attr,$val){
    $this->$attr = $val;
}


// Salva 

public function registraTweet(){
    $query="INSERT INTO tweets(id_usuario,tweet) VALUES (:id_usuario,:tweet)";
    $stmt=$this->db->prepare($query);

    $stmt->bindValue(":id_usuario",$this->__get("id_usuario"));
    $stmt->bindValue(":tweet",$this->__get("tweet"));

    $stmt->execute();

    return $this;

}

// Recupera o tweet
public function recuperaTweets(){
    $query="SELECT 
                T.id,
                T.id_usuario, 
                U.nome,
                T.tweet,
                T.data 
            FROM 
                tweets as T 
            LEFT JOIN 
                usuarios as U
            ON 
                (T.id_usuario=U.id) 
            WHERE 
                T.id_usuario=:id_usuario
                or T.id_usuario in (SELECT id_usuario_seguindo FROM usuarios_seguidores WHERE id_usuario=:id_usuario)"; 
    $stmt=$this->db->prepare($query);
    $stmt->bindValue(":id_usuario",$this->__get('id_usuario'));
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function deletarTweet(){
    $query= "DELETE FROM tweets WHERE id=:id";
    $stmt=$this->db->prepare($query);

    $stmt->bindValue(":id",$this->__get("id"));

    $stmt->execute();
    return $this;
}

public function getTweetsCount(){
    $query='SELECT count(id) as qnt_tweets FROM tweets WHERE id_usuario=:id_usuario';
    $stmt=$this->db->prepare($query);
    $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
    $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

}