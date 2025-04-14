<?php
namespace App\Controllers;

// OS recursos do Miniframework
use MF\Controller\Action;
use MF\Model\Container;

class indexController extends Action{

public function index(){


    $this->view->login=isset($_GET["login"])?$_GET["login"]:"";
    
    $this->render("index");
}
public function inscreverse(){

    $this->view->errorCadastro=false;
    $this->render("inscreverse");
}

public function cadastro(){
   
    //sucesso
        $user=Container::getModel("Usuario");
        $user->__set("name", $_POST["nome"]);
        $user->__set("email", $_POST["email"]);
        $user->__set("password", md5($_POST["senha"]));
        

    if($user->validateSave()){

        if(!count($user->getUserByEmail()) > 0){
           
            $user->save();
            $this->render("cadastro");
        }else{
            $this->view->errorCadastro=true;
            $this->view->feedback="Erro ao realizar o cadastro, o email inserido já está registrado, tente novamente utilizando outro email";
            $this->render("inscreverse");
        };

    }else{
        //erro
        $this->view->errorCadastro=true;
        $this->view->feedback="Erro ao tentar realizar o cadastro, verifique se os campos foram preenchidos corretamente";
        $this->render("inscreverse");
    }

}
    
}