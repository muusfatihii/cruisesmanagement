<?php

spl_autoload_register(function($class){

    require_once('../app/lib/'.$class.'.php');

});


class Auth extends Controller{

    public function signin($params=[]){

        if(isset($_POST['email']) && isset($_POST['password']) 
        && !empty($_POST['email']) && !empty($_POST['password']))
        {

            $connectiondb = new DatabaseConnection();

            $userRepo = $this->model('UserRepo');
            $userRepo->connectiondb = $connectiondb;

            $auth=$userRepo->checkUser($_POST);

            if(!$auth){

            $data["em"]="Ce compte n’existe pas";

            $this->view('signinPage',$data);
            
            }else{

                if($auth['role']!='admin'){

                    $idClient = $userRepo->getClientId($_SESSION['email']);
                    $_SESSION['idClient'] = $idClient;

                }else{

                    $_SESSION['admin']=1;
                    
                }

                header ('Location: /cruises/public/');
            }

            
        }else{

            header ('Location: /cruises/public/page/signin');

        }

    } 



    public function logout($params=[]){

        session_destroy();

        header ('Location: /cruises/public/');

    }

    public function signup($params=[]){

        if(isset($_POST['firstname']) && !empty($_POST['firstname']) 
        && isset($_POST['lastname']) && !empty($_POST['lastname']) 
        && isset($_POST['email']) && !empty($_POST['email']) 
        && isset($_POST['password']) && !empty($_POST['password'])){
        
        $connectiondb = new DatabaseConnection();

        $userRepo = $this->model('UserRepo');
        $userRepo->connectiondb = $connectiondb;

        $input['firstname']=$_POST['firstname'];
        $input['lastname']=$_POST['lastname'];
        $input['email']=$_POST['email'];


        $input['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $success = $userRepo->addUser($input);


        if (!$success) {

            $data["em"]="Impossible d'ajouter l'utilisateur !";

            $this->view('signupPage',$data);

        } else {

            $idClient = $userRepo->getClientId($_SESSION['email']);
            $_SESSION['idClient']=$idClient;

            header ('Location: /cruises/public/');
        }

    }else{

        $data["em"]="Un des champs requis est vide!!";

        $this->view('signupPage',$data);

    }

    } 

}