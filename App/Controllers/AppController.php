<?php
namespace App\Controllers;

// OS recursos do Miniframework
use MF\Controller\Action;
use MF\Model\Container;

class appController extends Action{

public function timeline(){
   
    session_start();

    if(!empty($_SESSION["id"] && !empty($_SESSION["name"]))){
        
        $tweet = Container::getModel("Tweet");
        $this->view->tweets=$tweet->recuperaTweets();

        $this->render("timeline");

    }else{
        header("Locate: /?login=erro");
    }

   
}

public function tweet(){
    session_start();

    if(!empty($_SESSION["id"]) && !empty($_SESSION["name"])){
        $tweet=Container::getModel("Tweet");

        $tweet->__set("tweet",$_POST['tweet']);
        $tweet->__set("id_usuario",$_SESSION['id']);

        $tweet->registraTweet();

        header("Location: /timeline");
    }else{
        header("Location: /?login=erro");
    }
}

public function deletar(){

    print_r($_POST);
    if(isset($_POST['id']) && !empty($_POST['id'])){
        $tweet=Container::getModel('Tweet');
        $tweet->__set('id',$_POST['id']);
        $tweet->deletarTweet();
    }

    header("Location: /timeline");
}
    
}