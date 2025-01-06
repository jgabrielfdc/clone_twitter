<?php 
namespace App\Models;

use MF\Model\Database;
class Info extends Database{
    public function getInfo(){
        $query="SELECT titulo, descricao FROM tb_info";
        return $this->db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }
}