<?php


require_once('src/lib/DatabaseConnection.php');

require_once('src/controllers/PageController.php');

spl_autoload_register(function($class){

    if (file_exists('src/model/'.$class.'.php')){
    require_once('src/model/'.$class.'.php');
    }
    
});




class ConnectionController{

    

function signin($input){

    $connectiondb = new DatabaseConnection();

    $userRepo = new UserRepository();
    $userRepo->connectiondb = $connectiondb;

    $auth = $userRepo->checkUser($input);

    if(!$auth){
    $em="Ce compte n’existe pas";
    require('templates/signinPage.php');
    }else{

        if($auth['role']!='admin'){

            $idClient = $userRepo->getClientId($_SESSION['email']);
            $_SESSION['idClient']=$idClient;


        }else{
            $_SESSION['admin']=1;
        }

        header ('location: index.php');
    }

}


    function signup($input){

        $connectiondb = new DatabaseConnection();

        $userRepo = new UserRepository();
        $userRepo->connectiondb = $connectiondb;


        $success = $userRepo->addUser($input);


        if (!$success) {

            $em = "Impossible d\'ajouter l'utilisateur !";
            (new PageController())->signupPage($em);

        } else {

            $idClient = $userRepo->getClientId($_SESSION['email']);
            $_SESSION['idClient']=$idClient;
            header ('location: index.php');
        }

        

    }


}