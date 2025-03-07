<?php
namespace App\Controllers;

// OS recursos do Miniframework
use MF\Controller\Action;
use MF\Model\Container;

class indexController extends Action{

public function index(){

    $this->render("index");
}
public function inscreverse(){

    $this->render("inscreverse");
}

public function cadastro(){
   
    //sucesso

    try{
        $user=Container::getModel("Usuario");
        $user->__set("name", $_POST["nome"]);
        $user->__set("email", $_POST["email"]);
        $user->__set("password", $_POST["senha"]);
      
    }catch(\Exception $e){
        echo $e->getMessage();
    }

    if($user->validateSave()){
        if(count($user->getUserByEmail())===0){
            $user->save();
            $this->render("cadastro");
        };
    }else{
        $this->render("inscreverse");
    }

    //erro
}
    
}