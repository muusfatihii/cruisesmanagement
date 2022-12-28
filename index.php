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

            case 'adminDashboard':

                (new PageController())->adminDashboard();


                break;
            
            case 'cruisesDashboard':

                (new PageController())->cruisesDashboard();

                break;
            
            case 'shipsDashboard':

                (new PageController())->shipsDashboard();

                break;
            
            case 'portsDashboard':

                (new PageController())->portsDashboard();

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

                if(isset($_SESSION['admin']) && $_SESSION['admin']==1){

                (new CruiseController())->addCruise($_POST, $_FILES['picCruise']);

                }else{

                    throw new Exception("La page que vous recherchez n'existe pas.");

                }

              break;

            case 'modifyCruise':

                if(isset($_SESSION['admin']) && $_SESSION['admin']==1){

                    if (isset($_GET['idCruise']) && $_GET['idCruise'] > 0) {

                        $Cruiseid = $_GET['idCruise'];
                
                        (new CruiseController())->modifyCruise($Cruiseid, $_POST, $_FILES['picCruise']);

                    } else {

                        throw new Exception("Aucun identifiant de cruise n'est indiqué");
                    }

                }else{

                    throw new Exception("La page que vous recherchez n'existe pas.");

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

                        //(new CruiseController())->filterCruises($idcategory);
                    }
                    
                } else {

                    if (isset($_GET['user']) && $_GET['user']=='admin') {
            
                        (new CruiseController())->cruisesAdmin();
    
                    }else{

                        (new CruiseController())->cruises($page,$start_from,$limit);
                    }
                }

                break;


            case 'addPortPage':

                if(isset($_SESSION['admin']) && $_SESSION['admin']==1){

                (new PageController())->addPortPage();

                }else{

                    throw new Exception("La page que vous recherchez n'existe pas.");

                }

                break;

            case 'addShipPage':

                if(isset($_SESSION['admin']) && $_SESSION['admin']==1){

                (new PageController())->addShipPage();

                }else{

                    throw new Exception("La page que vous recherchez n'existe pas.");

                }

                break;

            case 'addCruisePage':

                if(isset($_SESSION['admin']) && $_SESSION['admin']==1){

                      (new PageController())->addCruisePage();

                    }else{
    
                        throw new Exception("La page que vous recherchez n'existe pas.");
    
                    }

                break;

            case 'modifyCruisePage':

                if(isset($_SESSION['admin']) && $_SESSION['admin']==1){

                    if (isset($_GET['cruiseId']) && !empty($_GET['cruiseId'])) 
                    {
                        (new PageController())->modifyCruisePage($_GET['cruiseId']);

                    }else{

                        throw new Exception("Aucun identifiant de cruise n'est indiqué");
                    }
    

                }else{
    
                        throw new Exception("La page que vous recherchez n'existe pas.");
    
                }

                break;

            case 'addPort':

                if(isset($_SESSION['admin']) && $_SESSION['admin']==1){

                    if (isset($_POST['namePort']) && isset($_POST['country'])){

                        $input['namePort'] = $_POST['namePort'];
                        $input['country'] = $_POST['country'];

                        (new PortController())->addPort($input);
                    
                    }else{

                        throw new Exception("Champs requis non remplis");

                    }

                }else{

                    throw new Exception("La page que vous recherchez n'existe pas.");

                }

                break;

            case 'deletePort':

                if(isset($_SESSION['admin']) && $_SESSION['admin']==1){

                    if (isset($_GET['id']) && !empty($_POST['id'])){


                        (new PortController())->deletePort($_GET['id']);
                    
                    }else{

                        throw new Exception("Aucun identifiant de port n'est indiqué");

                    }

                }else{

                    throw new Exception("La page que vous recherchez n'existe pas.");

                }

                break;
            
            case 'addShip':

                if(isset($_SESSION['admin']) && $_SESSION['admin']==1){

                    if (isset($_POST['nameShip']) && isset($_POST['nbrRooms'])
                    && isset($_POST['nbrPlaces'])){

                        $input['nameShip'] = $_POST['nameShip'];
                        $input['nbrRooms'] = $_POST['nbrRooms'];
                        $input['nbrPlaces'] = $_POST['nbrPlaces'];


                        (new ShipController())->addShip($input);
                    
                    }else{

                        throw new Exception("Champs requis non remplis");

                    }

                }else{

                    throw new Exception("La page que vous recherchez n'existe pas.");

                }

                break;
            
            case 'deleteShip':

                if(isset($_SESSION['admin']) && $_SESSION['admin']==1){

                    if (isset($_GET['id']) && !empty($_POST['id'])){


                        (new ShipController())->deleteShip($_GET['id']);
                    
                    }else{

                        throw new Exception("Aucun identifiant de navire n'est indiqué");

                    }

                }else{

                    throw new Exception("La page que vous recherchez n'existe pas.");

                }

                break;

            
            case 'modifyPort':

                if(isset($_SESSION['admin']) && $_SESSION['admin']==1){

                if (isset($_GET['id']) && $_GET['id'] > 0) {

                    if (isset($_POST['namePort']) && isset($_POST['country'])){

                        $input['namePort'] = $_POST['namePort'];
                        $input['country'] = $_POST['country'];

                        (new PortController())->modifyPort($_GET['id'],$input);
                    
                    }else{

                        throw new Exception("Champs requis non remplis");

                    }

                } else {

                    throw new Exception("Aucun identifiant de port n'est indiqué");
                }

                }else{
                
                throw new Exception("La page que vous recherchez n'existe pas.");

                }

                break;

            case 'modifyShip':

                if(isset($_SESSION['admin']) && $_SESSION['admin']==1){

                if (isset($_GET['id']) && $_GET['id'] > 0) {

                    if (isset($_POST['nameShip']) && isset($_POST['nbrRooms'])
                    && isset($_POST['nbrPlaces'])){

                        $input['nameShip'] = $_POST['nameShip'];
                        $input['nbrRooms'] = $_POST['nbrRooms'];
                        $input['nbrPlaces'] = $_POST['nbrPlaces'];


                        (new ShipController())->modifyShip($_GET['id'],$input);
                    
                    }else{

                        throw new Exception("Champs requis non remplis");

                    }

                } else {

                    throw new Exception("Aucun identifiant de navire n'est indiqué");
                }

                }else{
                
                throw new Exception("La page que vous recherchez n'existe pas.");

                }

                break;

            case 'myReservations':

                if (isset($_SESSION['idClient']) && !empty($_SESSION['idClient'])) {

                (new ReservationController())->getReservations($_SESSION['idClient']);

                }else{

                    throw new Exception("La page que vous recherchez n'existe pas.");
                }

                break;

            case 'reserve':

             if (isset($_SESSION['idClient']) && !empty($_SESSION['idClient'])) {
                
                if (isset($_GET['idCruise']) && $_GET['idCruise'] > 0 &&
                isset($_POST['roomType']) && !empty($_POST['roomType']) ) {

                    $cruiseId = $_GET['idCruise'];
                    $roomTypeId = $_POST['roomType'];
                    
                (new ReservationController())->reserve($cruiseId,$roomTypeId);

                }else{
                    
                    throw new Exception("aucun identifiant n'est indiqué!!");
                }

              }else{

                $em = "";

                (new PageController())->signinPage($em);

              }

              break;

            case 'cancelReservation':

                if (isset($_SESSION['idClient']) && !empty($_SESSION['idClient'])) {

                    if (isset($_GET['id']) && $_GET['id'] > 0) {

                        $reservationId = $_GET['id'];

                    (new ReservationController())->cancelReservation($reservationId);

                    }else{

                        throw new Exception("Aucune Reservation n'est indiquée!!");
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
