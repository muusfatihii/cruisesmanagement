<?php

spl_autoload_register(function($class){

    if (file_exists('src/controllers/'.$class.'.php')){
        require_once('src/controllers/'.$class.'.php');

    }

});


session_start();





try {
    if (isset($_GET['action']) && $_GET['action'] !== '') {


        switch($_GET['action']) {

            case 'signupPage':
                $em = "";
                (new PageController())->signupPage($em);
 
                break;

            case 'signup':

                if(isset($_POST['firstname']) && !empty($_POST['firstname']) 
                && isset($_POST['lastname']) && !empty($_POST['lastname']) 
                && isset($_POST['email']) && !empty($_POST['email']) 
                && isset($_POST['password']) && !empty($_POST['password'])){

                    (new ConnectionController())->signup($_POST);

                }else{

                    $em = "Un des champs requis est vide!!";
                    (new PageController())->signupPage($em);

                }
                break;

            case 'signinPage':
                $em = "";
                (new PageController())->signinPage($em);

                break;

            case 'signin':

                if(isset($_POST['email']) && !empty($_POST['email']) 
                && isset($_POST['password']) && !empty($_POST['password'])){
                    (new ConnectionController())->signin($_POST);
                }else{
                    $em = "Un des champs requis est vide!!";
                    (new PageController())->signinPage($em);

                }
                break;

            case 'logout':

                $_SESSION['admin']='';
                $_SESSION['email']='';
                $_SESSION['idClient']='';
                (new PageController())->homepage();

                break;

            case 'cruises':

                if(isset($_SESSION['admin']) && $_SESSION['admin']==1){

                    (new CruiseController())->cruisesAdmin();
        
                }else{
        
                    if(isset($_SESSION['idClient']) && !empty($_SESSION['idClient'])){
        
                        (new CruiseController())->cruisesClient();
        
                    }else{
        
                        (new CruiseController())->cruises();
        
                    }
                    
                }
                break;
            
            case 'cruise':

                if (isset($_GET['id']) && $_GET['id'] > 0) {

                    $idCruise = $_GET['id'];
                    
                    (new CruiseController())->cruise($idCruise);

                } else {

                    throw new Exception("Aucun identifiant de cruise n'est indiqué");
                }

                break;
              
              
            case 'addCruise':

                (new CruiseController())->addCruise($_POST, $_FILES['pic']);

              break;

            case 'modifyCruise':

                if (isset($_GET['idCruise']) && $_GET['idCruise'] > 0) {

                    $Cruiseid = $_GET['idCruise'];
            
                    (new CruiseController())->modifyCruise($Cruiseid, $_POST, $_FILES['pic']);
                } else {
                    throw new Exception("Aucun identifiant de cruise n'est indiqué");
                }
                break;

            case 'deleteCruise':

                if (isset($_GET['idCruise']) && $_GET['idCruise'] > 0) {

                    $Cruiseid = $_GET['idCruise'];
            
                    (new CruiseController())->deleteCruise($Cruiseid);

                } else {

                    throw new Exception("Aucun identifiant de cruise n'est indiqué");
                }
            
            case 'filter':

                if (isset($_POST['categoryid']) && !empty($_POST['categoryid'])) {

                    $idcategory = $_POST['categoryid'];

                    if (isset($_GET['user']) && $_GET['user'] == 'admin'){

                        (new CruiseController())->filterCruisesAdmin($idcategory);

                    }else{

                        (new CruiseController())->filterCruises($idcategory);
                    }
                    
                } else {

                    if (isset($_GET['user']) && $_GET['user']=='admin') {
            
                        (new CruiseController())->cruisesAdmin();
    
                    }else{

                        (new CruiseController())->cruises();
                    }
                }

                break;


            case 'addPage':

                if(isset($_SESSION['admin']) && $_SESSION['admin']==1){

                (new PageController())->addPage();

                }else{

                    throw new Exception("La page que vous recherchez n'existe pas.");

                }

                break;
                
            case 'modifyPage':

                if(isset($_SESSION['admin']) && $_SESSION['admin']==1){

                if (isset($_GET['id']) && $_GET['id'] > 0) {

                    $identifier = $_GET['id'];
            
                    (new PageController())->modifyPage($identifier);

                } else {

                    throw new Exception("Aucun identifiant de cruise n'est indiqué");
                }

                }else{
                
                throw new Exception("La page que vous recherchez n'existe pas.");
                }

                break;




            case 'dashBoard':

                if (isset($_SESSION['idClient']) && !empty($_SESSION['idClient'])) {

                (new ReservationController())->getReservations($_SESSION['idClient']);

                }else{

                    throw new Exception("Aucun client n'est indiqué!!");
                }

                break;

                

            case 'cancelReservation':

                if (isset($_GET['id']) && $_GET['id'] > 0) {

                    $identifier = $_GET['id'];

                (new ReservationController())->cancelReservation($identifier);

                }else{

                    throw new Exception("Aucune Reservation n'est indiqué!!");
                }

                break;
            
            case 'reserve':

             if (isset($_SESSION['idClient']) && !empty($_SESSION['idClient'])) {
                
                if (isset($_GET['id']) && $_GET['id'] > 0 &&
                isset($_GET['roomtype']) && $_GET['roomtype'] > 0 ) {

                    $cruiseId = $_GET['id'];
                    $roomTypeId = $_GET['roomtype'];
                    
                (new ReservationController())->reserve($cruiseId,$roomTypeId);

                }else{
                    
                    throw new Exception("Aucune croisière n'est indiquée!!");
                }

              }else{

                throw new Exception("La page que vous recherchez n'existe pas.");

              }

              break;

            default:
            throw new Exception("La page que vous recherchez n'existe pas.");
          }

    } else {

        if(isset($_SESSION['admin']) && $_SESSION['admin']==1){

            (new PageController())->adminhomepage();

        }else{

            if(isset($_SESSION['idClient']) && !empty($_SESSION['idClient'])){

                (new PageController())->clienthomepage();

            }else{

                (new PageController())->homepage();

            }
            
        }
    }
} catch (Exception $e) {
    
    (new PageController())->errorPage($e);
}
