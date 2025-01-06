<?php 
namespace App\Models;
use MF\Model\Database;
class Produto extends Database{

    public function getProdutos(){
        $query="SELECT id, descricao, preco FROM tb_produtos";
        return $this->db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }
}