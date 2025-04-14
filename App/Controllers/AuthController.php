<?php
namespace App\Controllers;

// OS recursos do Miniframework
use MF\Controller\Action;
use MF\Model\Container;

class authController extends Action{

public function autenticar(){

        $user=Container::getModel("Usuario");

        $user->__set("email", $_POST["email"]);
        $user->__set("password", md5($_POST["senha"]));

        $user->autenticar();
        
        if($user->__get("id")!="" && $user->__get("name")!= ""){
            
            session_start();

            $_SESSION["id"] = $user->__get("id");
            $_SESSION["name"] = $user->__get("name");
            $_SESSION["email"] = $user->__get("email");
            
            header("Location: /timeline");
        }else{
            header("Location: /?login=erro");
        }
}

public function sair(){
    session_start();
    session_destroy();
    header("Location: /");
}
    
}