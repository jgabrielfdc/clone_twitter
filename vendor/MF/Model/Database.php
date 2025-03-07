<?php 

namespace MF\Model;

class Database{

    protected $db;
    public function __construct(\PDO $db){
        $this->db=$db;
    }
}