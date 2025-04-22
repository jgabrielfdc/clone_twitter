<?php
namespace App\Controllers;

// OS recursos do Miniframework
use MF\Controller\Action;
use MF\Model\Container;

class appController extends Action{

public function timeline(){
   
    $usuario=Container::getModel('Usuario');
    $tweet=Container::getModel('Tweet');

    session_start();

    if(!empty($_SESSION["id"] && !empty($_SESSION["name"]))){

        $usuario->__set('id',$_SESSION['id']);
        $tweet->__set('id_usuario',$_SESSION['id']);
        $qntdSeguindo=$usuario->getFollowingCount();
        $qntdSeguidores=$usuario->getFollowerCount() ? $usuario->getFollowerCount() : 0;
        $qntdTweets=$tweet->getTweetsCount();
    
        $this->view->tweetCount=$qntdTweets['qnt_tweets'];
        $this->view->followingCount=$qntdSeguindo['qnt_seguindo'];
        $this->view->followersCount=$qntdSeguidores['qnt_seguidores'];
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

public function validaAutenticacao(){
    session_start();

    if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['name']) || $_SESSION['name']==''){
        header('Location:/?login=erro');
    }else{
        header('Location/timeline');
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
    

public function quem_seguir(){
    $this->validaAutenticacao();
    $usuario=Container::getModel('Usuario');
    $tweet=Container::getModel('Tweet');

    $usuario->__set('id',$_SESSION['id']);
    $tweet->__set('id_usuario',$_SESSION['id']);
    
    $pesquisarPor=isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : "";
    $usuarios=[];

    if($pesquisarPor!=''){
        $usuario->__set('name',$pesquisarPor);
        $usuarios=$usuario->getAll();
    }

        
        $qntdSeguindo=$usuario->getFollowingCount();
        $qntdSeguidores=$usuario->getFollowerCount() ? $usuario->getFollowerCount() : 0;
        $qntdTweets=$tweet->getTweetsCount();
    
    $this->view->tweetCount=$qntdTweets['qnt_tweets'];
    $this->view->followingCount=$qntdSeguindo['qnt_seguindo'];
    $this->view->followersCount=$qntdSeguidores['qnt_seguidores'];
    $this->view->users=$usuarios;
    $this->render('quemSeguir');
}

public function acao(){
    $this->validaAutenticacao();

    # Acao
    $acao=isset($_GET['acao']) ? $_GET['acao'] : "";
    $id_usuario_seguindo=isset($_GET['id_usuario']) ? $_GET['id_usuario'] : "";

    # id_usuario
    $usuario=Container::getModel("Usuario");
    $usuario->__set("id",$_SESSION['id']);

    if($acao=="seguir"){
        $usuario->seguirUsuario($id_usuario_seguindo);
    }else if($acao=="deixar_de_seguir"){
        $usuario->deixarSeguirUsuario($id_usuario_seguindo);
    }

    header("Location:/quem_seguir?pesquisarPor=".$_GET['pesquisarPor']);
}

}