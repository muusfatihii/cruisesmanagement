<?php


spl_autoload_register(function($class){

    require_once('../app/lib/'.$class.'.php');

});

class Cruise extends Controller{

    public function add($params=[]){

           //get itinerary 

            $i=1;

            $portsIds = [];

            while(isset($_POST['portId'.$i])){

                $portsIds[] = $_POST['portId'.$i];

                $i++;
            }

            $connectiondb = new DatabaseConnection();

            $cruiseRepo = $this->model('CruiseRepo');
            $cruiseRepo->connectiondb = $connectiondb;

            if (!empty($_POST['shipID']) && !empty($_POST['nbrNights']) && !empty($_POST['departurePortID']) && !empty($_POST['departureDate'])) {

                $input['shipID'] = $_POST['shipID'];
                $input['nbrNights'] = $_POST['nbrNights'];
                $input['departurePortID'] = $_POST['departurePortID'];
                $input['departureDate'] = $_POST['departureDate'];
                
                $roomRepo = $this->model('roomRepo');
                $roomRepo->connectiondb = $connectiondb;

                $input['minPrice'] = $roomRepo->minPrice($_POST['shipID']);

                if(isset($_FILES['picCruise']) && !empty($_FILES['picCruise']) && $_FILES['picCruise']['size']>0){

                    $input['pic'] = $this->addImage($_FILES['picCruise']);

                }else{

                    $input['pic'] = "default.jpg";

                }
                
                
            } else {

                throw new Exception('Les données du formulaire sont invalides.');
            }

            $idCruise = $cruiseRepo->createCruise($input);

            $itineraryRepo =  $this->model('ItineraryRepo');
            $itineraryRepo->connectiondb = $connectiondb;

            $itineraryRepo->addItinerary($idCruise,$portsIds);
            
            
            header('Location: /cruises/public/cruise/all/1');

    }

    public function modify($params=[]){

        if($params>0){

            $idCruise = $params;

        }else{

            throw new Exception("id cruise non conforme");
        }

        $connectiondb = new DatabaseConnection();

        $cruiseRepo = $this->model('CruiseRepo');
        $cruiseRepo->connectiondb = $connectiondb;

        

        //get itinerary 


        $i=1;

        $portsIds = [];

        while(isset($_POST['portId'.$i])){

            $portsIds[] = $_POST['portId'.$i];

            $i++;
        }


        if (!empty($_POST['shipID']) && !empty($_POST['nbrNights']) && !empty($_POST['departurePortID']) && !empty($_POST['departureDate'])) {

            $input['shipID'] = $_POST['shipID'];
            $input['nbrNights'] = $_POST['nbrNights'];
            $input['departurePortID'] = $_POST['departurePortID'];
            $input['departureDate'] = $_POST['departureDate'];
            
            $roomRepo = $this->model('roomRepo');
            $roomRepo->connectiondb = $connectiondb;

            $input['minPrice'] = $roomRepo->minPrice($_POST['shipID']);

            if(!isset($_FILES['picCruise']) || empty($_FILES['picCruise']) || $_FILES['picCruise']['size']==0){
                  
                $success = $cruiseRepo->modifyCruisePic($idCruise, $input);

            }else{

                $input['pic'] = $this->addImage($_FILES['picCruise']);
                $success = $cruiseRepo->modifyCruise($idCruise, $input);


            }
            
        } else {

            throw new Exception('Les données du formulaire sont invalides.');

        }


        if($success){

            $itineraryRepo =  $this->model('ItineraryRepo');
            $itineraryRepo->connectiondb = $connectiondb;

            $itineraryRepo->modifyItinerary($idCruise,$portsIds);

        }
        
        header('Location: /cruises/public/cruise/all/1');

    }

    public function loadMore($params=[]){

        $page = $_POST['page'];
        $limit = $_POST['limit'];
        $startFrom = ($page-1)*$limit;


        $connectiondb = new DatabaseConnection();

        $cruiseRepo = $this->model('CruiseRepo');
        $cruiseRepo->connectiondb = $connectiondb;
        

        $results = $cruiseRepo->getCruises($startFrom,$limit);


        $cruises = $this->cruisesObj($results);



        if(count($cruises)>0){
            
            $crz = json_encode($cruises);
            
            echo $crz;
            exit();

        }else{

            echo 1;
            exit();

        }

    }

    private function cruisesObj($results){

        $cruises = [];
        
        $connectiondb = new DatabaseConnection();

        $shipRepo = $this->model('ShipRepo');
        $shipRepo->connectiondb = $connectiondb;
       

        $portRepo = $this->model('PortRepo');
        $portRepo->connectiondb = $connectiondb;

       for($i=0;$i<count($results);$i++)
       {

        $cruise = new Cruise();

        $cruise->id = $results[$i]['id'];
        $cruise->ship = $shipRepo->getShipName($results[$i]['ship']);
        $cruise->pic = $results[$i]['pic'];
        $cruise->minPrice = $results[$i]['minPrice'];
        $cruise->nbrNights = $results[$i]['nbrNights'];
        $cruise->departurePort = $portRepo->getPortName($results[$i]['departurePort']);
        $cruise->departureDate = $results[$i]['departureDate'];

        $cruises[]=$cruise;

       }

       return $cruises;

    }


    public function cancel($params=[]){

        

    $idCruise = $_POST['idCruise'];
    $page = $_POST['page'];
    $limit = $_POST['limit'];


    $connectiondb = new DatabaseConnection();

    $reservationRepo = $this->model('ReservationRepo');
    $reservationRepo->connectiondb = $connectiondb;

    $cruiseRepo = $this->model('CruiseRepo');
    $cruiseRepo->connectiondb = $connectiondb;



    if($reservationRepo->canBeCancelled($idCruise)){

        $success = $cruiseRepo->deleteCruise($idCruise);

        if (!$success) {

            throw new Exception("Erreur lors de l'annulation de la croisière !");

        } else {


                $CruisZ = $cruiseRepo->getCruises(0,$page*$limit);



                $portRepo = $this->model('PortRepo');
                $portRepo->connectiondb = $connectiondb;

                $shipRepo = $this->model('ShipRepo');
                $shipRepo->connectiondb = $connectiondb;


                $cruises = [];
                

                foreach($CruisZ as $cruise){


                    $crz['departureDate'] = $cruise['departureDate'];
                    $crz['id'] = $cruise['id'];
                    $crz['pic'] = $cruise['pic'];
                    $crz['nbrNights'] = $cruise['nbrNights'];
                    $crz['minPrice'] = $cruise['minPrice'];
                    $crz['departurePort'] = $portRepo->getPortName($cruise['departurePort']);
                    $crz['ship'] = $shipRepo->getShipName($cruise['ship']);
                    

                    $cruises [] = $crz;

                }

                    echo json_encode($cruises);
                    exit();


        }

        }else{

            echo (1);
            exit();
            
        }

    }


    

    public function addImage(array $picture):string
    {

        $new_img_name = "default.jpg";
    
        if(isset($picture) && !empty($picture) && $picture['size']>0){
    
            $picname=$picture['name'];
            $pictmpname=$picture['tmp_name'];
    
    
    
            if($picture['size']>1000000){

                $em = "sorry your file is too large";
                header("Location: /cruises/public/page/addCruise");

            }else{

                $img_ex = pathinfo($picname, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
        
                $allowed_exs=array("jpg","jpeg","png");
        
                if(in_array($img_ex_lc,$allowed_exs)){
        
                    $new_img_name=uniqid("IMG-",true).'.'.$img_ex_lc;
                    $img_upload_path='uploads/'.$new_img_name;
                    move_uploaded_file($pictmpname,$img_upload_path);

                }else{
        
                    $em="only jpg,jpeg,png extensions are allowed";
                    header("Location: /cruises/public/page/addCruise");
                }

            }
        }
    
        return $new_img_name;
    
    }



    public function all($params){

      $page = $params;

      $limit = 10;

      $startFrom = ($page-1)*$limit;

      
      $connectiondb = new DatabaseConnection();

      $cruises = $this->getCruisesList($connectiondb,$startFrom,$limit);

      $ports = $this->getPorts($connectiondb);

      $ships = $this->getShips($connectiondb);

      
       
       $data = [];
       $data[]=$cruises;
       $data[]=$ports;
       $data[]=$ships;


       $this->view('cruises',$data);
        
    } 


    public function getCruisesList(DatabaseConnection $connectiondb,$startFrom,$limit):array
    {

        $cruiseRepo = $this->model('CruiseRepo');
        $cruiseRepo->connectiondb = $connectiondb;


        $portRepo = $this->model('PortRepo');
        $portRepo->connectiondb = $connectiondb;


        // Getting Cruises

        $results = $cruiseRepo->getCruisesList($startFrom,$limit);


        $cruises = [];

        foreach ($results as $result) {

        $cruise = new Cruise();

        $cruise->id = $result['id'];
        $cruise->pic = $result['pic'];
        $cruise->nbrNights = $result['nbrNights'];
        $cruise->departurePort = $portRepo->getPortName($result['departurePort']);
        $cruise->departureDate = $result['departureDate'];
        $cruise->minPrice = $result['minPrice'];
        
        $cruises[] = $cruise;

        }
        //End Getting Cruises

        return $cruises;

    }


    public function getPorts(DatabaseConnection $connectiondb):array
    {

        //Get ports
        
        $portRepo = $this->model('PortRepo');
        $portRepo->connectiondb = $connectiondb;
        
        $results = $portRepo->getPorts(); 

        $ports = [];

        foreach($results as $result){

            $port = new Port();
            
            $port->id = $result['id'];
            $port->name = $result['name'].'-'.$result['country'];

            $ports [] = $port;

        }
        //End Getting Ports

        return $ports;

    }



    public function getShips(DatabaseConnection $connectiondb):array
    {

        //Get ships
        
        $shipRepo = $this->model('ShipRepo');
        $shipRepo->connectiondb = $connectiondb;
        
        $results = $shipRepo->getShipsList(); 

        $ships = [];

        foreach($results as $result){

            $ship = new Ship();
            
            $ship->id = $result['id'];
            $ship->name = $result['name'];

            $ships [] = $ship;

        }
        //End Getting ships

        return $ships;

    }


    public function description($idCruise){

        if(!$idCruise>=0){


            $connectiondb = new DatabaseConnection();

            $cruiseRepo = $this->model('CruiseRepo');
            $cruiseRepo->connectiondb = $connectiondb;

            $shipRepo = $this->model('ShipRepo');
            $shipRepo->connectiondb = $connectiondb;

            $portRepo = $this->model('PortRepo');
            $portRepo->connectiondb = $connectiondb;

            //Get Cruise


            $result = $cruiseRepo->getCruise($idCruise);

            $cruise = new Cruise();

            $cruise->id = $result['id'];
            $cruise->ship = $shipRepo->getShipName($result['ship']);
            $cruise->pic = $result['pic'];
            $cruise->nbrNights = $result['nbrNights'];
            $cruise->departurePort = $portRepo->getPortName($result['departurePort']);
            $cruise->departureDate = $result['departureDate'];

            //End Getting Cruise



            //Getting Itinerary

            $itinerary = $this->getItinerary($connectiondb,$idCruise);

            //End getting Itinerary
            
            $roomTypeRepo = $this->model('roomTypeRepo');
            $roomTypeRepo->connectiondb = $connectiondb;

            $roomTypesInfos = $roomTypeRepo->getRoomTypesInfos();

            $roomRepo = $this->model('roomRepo');
            $roomRepo->connectiondb = $connectiondb;


            $roomTypes = [];

            foreach($roomTypesInfos as $roomTypeInfos){

                $roomType = new RoomType();
                $roomType->id = $roomTypeInfos['id'];
                $roomType->name = $roomTypeInfos['name'];

                $avlNbrRooms = $roomRepo->getAvlNbrRooms($result['ship'],$roomTypeInfos['id']);

                if($avlNbrRooms>0){

                    $roomType->price = $roomRepo->getRoomPrice($result['ship'],$roomTypeInfos['id']);
            
                }

                $reservationRepo = $this->model('reservationRepo');
                $reservationRepo->connectiondb = $connectiondb;

                $ReservedRoomsIds = $reservationRepo->getReservedRoomsIds($idCruise);


                $reservedRooms=0;

                foreach($ReservedRoomsIds as $ReservedRoomId){

                    if($roomTypeInfos['id'] == $roomRepo->getRoomType($ReservedRoomId['room'])){
                        $reservedRooms++;
                    }

                }
                $roomType->available = 0;
    
                if($avlNbrRooms>$reservedRooms){
                    $roomType->available = 1;
                }

                $roomTypes[]= $roomType;

            }

            $data = [];
            $data[]=$cruise;
            $data[]=$itinerary;
            $data[]=$roomTypes;

            $this->view('cruiseDescription',$data);


        }


    }


    public function getItinerary(DatabaseConnection $connectiondb,$cruiseId){

        $itineraryRepo = $this->model('ItineraryRepo');
        $itineraryRepo->connectiondb = $connectiondb;
        
        $portsIds = $itineraryRepo->getItinerary($cruiseId);
        
        $ports = [];
    
        foreach($portsIds as $portId){
    
            $portRepo = new PortRepo();
            $portRepo->connectiondb = $connectiondb;
            
            $port = new Port();

            $port->id = $portId['port'];
            $port->name = $portRepo->getPortName($portId['port']);
    
            $ports[] = $port;
        }
    
        return $ports;
    
       }


       public function reserve($params){


        if (isset($_SESSION['idClient']) && !empty($_SESSION['idClient'])) {
                
            if ($params!='' && $params >= 0 &&
            isset($_POST['roomType']) && !empty($_POST['roomType']) 
            && $_POST['roomType']>0) {

                $cruiseId = $params;
                $roomTypeId = $_POST['roomType'];

                $connectiondb = new DatabaseConnection();
                $cruiseRepo = $this->model('cruiseRepo');
                $cruiseRepo->connectiondb = $connectiondb;


                $reservationRepo = $this->model('reservationRepo');
                $reservationRepo->connectiondb = $connectiondb;

                $roomRepo = $this->model('roomRepo');
                $roomRepo->connectiondb = $connectiondb;

                //Getting ship id


        
                $shipId = $cruiseRepo->getShipId($cruiseId);



                //Getting available rooms from room table 

                $allRooms = $roomRepo->getTotRooms($shipId);
                $allReservedRooms = $reservationRepo->reservedRooms($cruiseId);


                $diff = $allRooms - $allReservedRooms;



                $avlRooms = $roomRepo->getAvlNbrRooms($shipId,$roomTypeId);

                if($avlRooms>0){

                $roomTypePrice = $roomRepo->getRoomPrice($shipId,$roomTypeId);

                }else{

                    throw new Exception("Ce type de chambre n'est pas disponible sur ce navire pour le moment");

                }

                $reservedRoomsIds = $reservationRepo->getReservedRoomsIds($cruiseId);


                $reservedRooms=0;

                foreach($reservedRoomsIds as $reservedRoomId){

                    if($roomTypeId==$roomRepo->getRoomType($reservedRoomId['room'])){
                        $reservedRooms++;
                    }

                }

                if($reservedRooms<$avlRooms){


                    $avlRoomsIds = $roomRepo->getAvlRoomsIds($shipId,$roomTypeId);
        
                    
                    foreach($avlRoomsIds as $avlRoomId){
        
                        if(!$reservationRepo->isreserved($cruiseId,$avlRoomId['id'])){
        
                            $reservedRoomId = $avlRoomId['id'];
        
                            break;
        
                        }
                    }


                    $success = $reservationRepo->reserve($cruiseId,$roomTypePrice,$reservedRoomId);
                    
                    if (!$success) {

                        throw new Exception("Impossible de reserver cette croisière !");
            
                    } else {

                        if($diff==1){

                            $cruiseRepo->setfull($cruiseId);
        
                        }

                        
                        header('Location: /cruises/public');
                        
                    }

                }else{

                    throw new Exception("Ce type de chambre n'est plus disponible sur ce navire pour le moment");
                }

            }else{
                
                throw new Exception("aucun identifiant n'est indiqué!!");
            }

          }else{

            $data["em"]= "";
            $this->view('signinPage',$data);

          }
       }

       
       
       public function filter($params=[]){


        $connectiondb = new DatabaseConnection();

        $cruiseRepo = $this->model('CruiseRepo');
        $cruiseRepo->connectiondb = $connectiondb;

        $shipRepo = $this->model('ShipRepo');
        $shipRepo->connectiondb = $connectiondb;

        $portRepo = $this->model('PortRepo');
        $portRepo->connectiondb = $connectiondb;

        
        $tot = '';
        $page = $_POST['page'];


       


        $limit = 5;
        $startFrom = ($page-1)*$limit;

        if(!empty($_POST['portNameId']) && !empty($_POST['shipNameId']) && !empty($_POST['departureMonthId'])){

            $nbrResults = $cruiseRepo->countfilteredCruises($_POST['portNameId'],$_POST['shipNameId'],$_POST['departureMonthId']);
            $nbrPages = ceil($nbrResults/$limit);

            $results = $cruiseRepo->getfilteredCruises($_POST['portNameId'],$_POST['shipNameId'],$_POST['departureMonthId'],$startFrom,$limit);
            

            foreach($results as $result){
                    $tot.='<div class="card col-12 col-md-6 col-lg-4 col-xl-3 item">
                        <img src="/cruises/public/uploads/'.$result['pic'].'" class="card-img-top" alt="...">
                        <div class="card-body">
                        <h5 class="card-title">'.$portRepo->getPortName($result['departurePort']).'</h5>
                            <p class="card-text">A partir de '.$result['minPrice'].'</p>';';';
                            if(isset($_SESSION['idClient'])){

                                $tot.='<a href="/cruises/public/cruise/description/'.$result['id'].'" class="btn btn-primary item__btn" >Je reserve ma place</a>';

                            }else if(isset($_SESSION['admin']) && ($_SESSION['admin']==1)){

                                $tot.='<a href="/cruises/public/cruise/description/'.$result['id'].'" class="btn btn-primary item__btn" >More Infos</a>';

                            }else{

                                $tot.='<a href="/cruises/public/page/signin/" class="btn btn-primary item__btn" >Je reserve ma place</a>';


                            }
                            
                    $tot.='</div>
                        </div>';

            }


                $tot.='<div class="container my-5">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">';

                if($page>1){
                    $tot.='<li class="page-item" ><a class="page-link" id="1">First</a></li>';
                }

                if($page>2){
                    $currentPage = $page;
                    $previous = $currentPage-1;
                    $tot.='<li class="page-item" ><a class="page-link" id="'.$previous.'">Previous</a></li>';
                }
                

                for($i=1;$i<=$nbrPages;$i++){
                    $tot.='<li class="page-item"><a class="page-link" id="'.$i.'">'.$i.'</a></li>';
                }

                if($page<$nbrPages-1){
                    $currentPage = $page;
                    $next = $currentPage+1;
                    $tot.='<li class="page-item" ><a class="page-link" id="'.$next.'">Next</a></li>';
                }

                if($page<$nbrPages){
                    $tot.='<li class="page-item" ><a class="page-link" id="'.$nbrPages.'">Last</a></li>';
                }

                $tot.='</ul>
                </nav>
            </div>';

                echo $tot;

                exit();

                        
        }else{

            if(empty($_POST['portNameId']) && empty($_POST['shipNameId']) && empty($_POST['departureMonthId'])){

            $nbrResults = $cruiseRepo->countCruises();
            $nbrPages = ceil($nbrResults/$limit);

            $results = $cruiseRepo->getFCruises($startFrom,$limit);


                foreach($results as $result){
                    $tot.='<div class="card col-12 col-md-6 col-lg-4 col-xl-3 item">
                        <img src="/cruises/public/uploads/'.$result['pic'].'"class="card-img-top" alt="...">
                        <div class="card-body">
                        <h5 class="card-title">'.$portRepo->getPortName($result['departurePort']).'</h5>
                            <p class="card-text">A partir de '.$result['minPrice'].'</p>';
                            if(isset($_SESSION['idClient'])){

                                $tot.='<a href="/cruises/public/cruise/description/'.$result['id'].'" class="btn btn-primary item__btn" >Je reserve ma place</a>';

                            }else if(isset($_SESSION['admin']) && ($_SESSION['admin']==1)){

                                $tot.='<a href="/cruises/public/cruise/description/'.$result['id'].'" class="btn btn-primary item__btn" >More Infos</a>';

                            }else{

                                $tot.='<a href="/cruises/public/page/signin/" class="btn btn-primary item__btn" >Je reserve ma place</a>';


                            }
                            $tot.='</div>
                        </div>';

                }

                $tot.='<div class="container my-5">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">';

                if($page>1){
                    $tot.='<li class="page-item"><a class="page-link" id="1">First</a></li>';
                }

                if($page>2){
                    $currentPage = $page;
                    $previous = $currentPage-1;
                    $tot.='<li class="page-item"><a id="'.$previous.'" class="page-link">Previous</a></li>';
                }
                

                for($i=1;$i<=$nbrPages;$i++){
                    $tot.='<li class="page-item"><a id="'.$i.'" class="page-link">'.$i.'</a></li>';
                }

                if($page<$nbrPages-1){
                    $currentPage = $page;
                    $next = $currentPage+1;
                    $tot.='<li class="page-item"><a id="'.$next.'" class="page-link">Next</a></li>';
                }

                if($page<$nbrPages){
                    $tot.='<li class="page-item"><a id="'.$nbrPages.'" class="page-link">Last</a></li>';
                }



                $tot.='</ul>
                </nav>
            </div>';

                echo $tot;

                exit();

            }

            if(!empty($_POST['portNameId']) && !empty($_POST['shipNameId'])){

                $nbrResults = $cruiseRepo->countCruisesPortShip($_POST['portNameId'],$_POST['shipNameId']);
                $nbrPages = ceil($nbrResults/$limit);

                $results = $cruiseRepo->getfilteredCruisesShipPort($_POST['portNameId'],$_POST['shipNameId'],$startFrom,$limit);

                foreach($results as $result){
                    $tot.='<div class="card col-12 col-md-6 col-lg-4 col-xl-3 item">
                        <img src="/cruises/public/uploads/'.$result['pic'].'"class="card-img-top" alt="...">
                        <div class="card-body">
                        <h5 class="card-title">'.$portRepo->getPortName($result['departurePort']).'</h5>
                            <p class="card-text">A partir de '.$result['minPrice'].'</p>';
                            if(isset($_SESSION['idClient'])){

                                $tot.='<a href="/cruises/public/cruise/description/'.$result['id'].'" class="btn btn-primary item__btn" >Je reserve ma place</a>';

                            }else if(isset($_SESSION['admin']) && ($_SESSION['admin']==1)){

                                $tot.='<a href="/cruises/public/cruise/description/'.$result['id'].'" class="btn btn-primary item__btn" >More Infos</a>';

                            }else{

                                $tot.='<a href="/cruises/public/page/signin/" class="btn btn-primary item__btn" >Je reserve ma place</a>';


                            }
                            $tot.='</div>
                        </div>';

                }

                $tot.='<div class="container my-5">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">';

                if($page>1){
                    $tot.='<li class="page-item" ><a class="page-link" id="1">First</a></li>';
                }

                if($page>2){
                    $currentPage = $page;
                    $previous = $currentPage-1;
                    $tot.='<li class="page-item" ><a class="page-link" id="'.$previous.'">Previous</a></li>';
                }
                

                for($i=1;$i<=$nbrPages;$i++){
                    $tot.='<li class="page-item"><a class="page-link" id="'.$i.'">'.$i.'</a></li>';
                }

                if($page<$nbrPages-1){
                    $currentPage = $page;
                    $next = $currentPage+1;
                    $tot.='<li class="page-item" ><a class="page-link" id="'.$next.'">Next</a></li>';
                }

                if($page<$nbrPages){
                    $tot.='<li class="page-item" ><a class="page-link" id="'.$nbrPages.'">Last</a></li>';
                }



                $tot.='</ul>
                </nav>
            </div>';

                echo $tot;

                exit();


            }

            if(!empty($_POST['portNameId']) && !empty($_POST['departureMonthId'])){
        

                $nbrResults = $cruiseRepo->countCruisesPortMonth($_POST['portNameId'],$_POST['departureMonthId']);
                $nbrPages = ceil($nbrResults/$limit);

                $results = $cruiseRepo->getfilteredCruisesPortMonth($_POST['portNameId'],$_POST['departureMonthId'],$startFrom,$limit);


                foreach($results as $result){
                    $tot.='<div class="card col-12 col-md-6 col-lg-4 col-xl-3 item">
                        <img src="/cruises/public/uploads/'.$result['pic'].'"class="card-img-top" alt="...">
                        <div class="card-body">
                        <h5 class="card-title">'.$portRepo->getPortName($result['departurePort']).'</h5>
                            <p class="card-text">A partir de '.$result['minPrice'].'</p>';
                            if(isset($_SESSION['idClient'])){

                                $tot.='<a href="/cruises/public/cruise/description/'.$result['id'].'" class="btn btn-primary item__btn" >Je reserve ma place</a>';

                            }else if(isset($_SESSION['admin']) && ($_SESSION['admin']==1)){

                                $tot.='<a href="/cruises/public/cruise/description/'.$result['id'].'" class="btn btn-primary item__btn" >More Infos</a>';

                            }else{

                                $tot.='<a href="/cruises/public/page/signin/" class="btn btn-primary item__btn" >Je reserve ma place</a>';


                            }
                            $tot.='</div>
                        </div>';

                }

                $tot.='<div class="container my-5">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">';

                if($page>1){
                    $tot.='<li class="page-item" id="1"><a class="page-link">First</a></li>';
                }

                if($page>2){
                    $currentPage = $page;
                    $previous = $currentPage-1;
                    $tot.='<li class="page-item"><a id="'.$previous.'" class="page-link">Previous</a></li>';
                }
                

                for($i=1;$i<=$nbrPages;$i++){
                    $tot.='<li class="page-item"><a id="'.$i.'" class="page-link">'.$i.'</a></li>';
                }

                if($page<$nbrPages-1){
                    $currentPage = $page;
                    $next = $currentPage+1;
                    $tot.='<li class="page-item"><a id="'.$next.'" class="page-link">Next</a></li>';
                }

                if($page<$nbrPages){
                    $tot.='<li class="page-item"><a id="'.$nbrPages.'" class="page-link">Last</a></li>';
                }



                $tot.='</ul>
                </nav>
            </div>';

                echo $tot;

                exit();

                
            }

            if(!empty($_POST['shipNameId']) && !empty($_POST['departureMonthId']))
            {
                

                $nbrResults = $cruiseRepo->countCruisesShipMonth($_POST['shipNameId'],$_POST['departureMonthId']);
                $nbrPages = ceil($nbrResults/$limit);

                $results = $cruiseRepo->getfilteredCruisesShipMonth($_POST['shipNameId'],$_POST['departureMonthId'],$startFrom,$limit);

                foreach($results as $result){
                    $tot.='<div class="card col-12 col-md-6 col-lg-4 col-xl-3 item">
                        <img src="/cruises/public/uploads/'.$result['pic'].'"class="card-img-top" alt="...">
                        <div class="card-body">
                        <h5 class="card-title">'.$portRepo->getPortName($result['departurePort']).'</h5>
                            <p class="card-text">A partir de '.$result['minPrice'].'</p>';
                            if(isset($_SESSION['idClient'])){

                                $tot.='<a href="/cruises/public/cruise/description/'.$result['id'].'" class="btn btn-primary item__btn" >Je reserve ma place</a>';

                            }else if(isset($_SESSION['admin']) && ($_SESSION['admin']==1)){

                                $tot.='<a href="/cruises/public/cruise/description/'.$result['id'].'" class="btn btn-primary item__btn" >More Infos</a>';

                            }else{

                                $tot.='<a href="/cruises/public/page/signin/" class="btn btn-primary item__btn" >Je reserve ma place</a>';


                            }
                            $tot.='</div>
                        </div>';

                }

                
                $tot.='<div class="container my-5">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">';

                if($page>1){
                    $tot.='<li class="page-item"><a id="1" class="page-link">First</a></li>';
                }

                if($page>2){
                    $currentPage = $page;
                    $previous = $currentPage-1;
                    $tot.='<li class="page-item"><a id="'.$previous.'" class="page-link">Previous</a></li>';
                }
                

                for($i=1;$i<=$nbrPages;$i++){
                    $tot.='<li class="page-item"><a id="'.$i.'" class="page-link">'.$i.'</a></li>';
                }

                if($page<$nbrPages-1){
                    $currentPage = $page;
                    $next = $currentPage+1;
                    $tot.='<li class="page-item"><a id="'.$next.'" class="page-link">Next</a></li>';
                }

                if($page<$nbrPages){
                    $tot.='<li class="page-item"><a id="'.$nbrPages.'" class="page-link">Last</a></li>';
                }



                $tot.='</ul>
                </nav>
            </div>';

                echo $tot;

                exit();
            }


            if(!empty($_POST['shipNameId'])){
                
                $nbrResults = $cruiseRepo->countfilteredCruisesShip($_POST['shipNameId']);
                $nbrPages = ceil($nbrResults/$limit);

                $results = $cruiseRepo->getfilteredCruisesShip($_POST['shipNameId'],$startFrom,$limit);


                foreach($results as $result){
                    $tot.='<div class="card col-12 col-md-6 col-lg-4 col-xl-3 item">
                        <img src="/cruises/public/uploads/'.$result['pic'].'"class="card-img-top" alt="...">
                        <div class="card-body">
                        <h5 class="card-title">'.$portRepo->getPortName($result['departurePort']).'</h5>
                            <p class="card-text">A partir de '.$result['minPrice'].'</p>';
                            if(isset($_SESSION['idClient'])){

                                $tot.='<a href="/cruises/public/cruise/description/'.$result['id'].'" class="btn btn-primary item__btn" >Je reserve ma place</a>';

                            }else if(isset($_SESSION['admin']) && ($_SESSION['admin']==1)){

                                $tot.='<a href="/cruises/public/cruise/description/'.$result['id'].'" class="btn btn-primary item__btn" >More Infos</a>';

                            }else{

                                $tot.='<a href="/cruises/public/page/signin/" class="btn btn-primary item__btn" >Je reserve ma place</a>';


                            }
                            $tot.='</div>
                        </div>';

                }

                $tot.='<div class="container my-5">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">';

                if($page>1){
                    $tot.='<li class="page-item"><a id="1" class="page-link">First</a></li>';
                }

                if($page>2){
                    $currentPage = $page;
                    $previous = $currentPage-1;
                    $tot.='<li class="page-item"><a id="'.$previous.'" class="page-link">Previous</a></li>';
                }
                

                for($i=1;$i<=$nbrPages;$i++){
                    $tot.='<li class="page-item"><a id="'.$i.'" class="page-link">'.$i.'</a></li>';
                }

                if($page<$nbrPages-1){
                    $currentPage = $page;
                    $next = $currentPage+1;
                    $tot.='<li class="page-item"><a id="'.$next.'" class="page-link">Next</a></li>';
                }

                if($page<$nbrPages){
                    $tot.='<li class="page-item"><a id="'.$nbrPages.'" class="page-link">Last</a></li>';
                }



                $tot.='</ul>
                </nav>
            </div>';

                echo $tot;

                exit();
            
            }
            if(!empty($_POST['departureMonthId'])){

                $nbrResults = $cruiseRepo->countfilteredCruisesDepartureMonth($_POST['departureMonthId']);
                $nbrPages = ceil($nbrResults/$limit);

                $results = $cruiseRepo->getfilteredCruisesDepartureMonth($_POST['departureMonthId'],$startFrom,$limit);

                foreach($results as $result){
                    $tot.='<div class="card col-12 col-md-6 col-lg-4 col-xl-3 item">
                        <img src="/cruises/public/uploads/'.$result['pic'].'"class="card-img-top" alt="...">
                        <div class="card-body">
                        <h5 class="card-title">'.$portRepo->getPortName($result['departurePort']).'</h5>
                            <p class="card-text">A partir de '.$result['minPrice'].'</p>';
                            if(isset($_SESSION['idClient'])){

                                $tot.='<a href="/cruises/public/cruise/description/'.$result['id'].'" class="btn btn-primary item__btn" >Je reserve ma place</a>';

                            }else if(isset($_SESSION['admin']) && ($_SESSION['admin']==1)){

                                $tot.='<a href="/cruises/public/cruise/description/'.$result['id'].'" class="btn btn-primary item__btn" >More Infos</a>';

                            }else{

                                $tot.='<a href="/cruises/public/page/signin/" class="btn btn-primary item__btn" >Je reserve ma place</a>';


                            }
                            $tot.='</div>
                        </div>';

                }

                $tot.='<div class="container my-5">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">';

                if($page>1){
                    $tot.='<li class="page-item"><a id="1" class="page-link">First</a></li>';
                }

                if($page>2){
                    $currentPage = $page;
                    $previous = $currentPage-1;
                    $tot.='<li class="page-item"><a id="'.$previous.'" class="page-link">Previous</a></li>';
                }
                

                for($i=1;$i<=$nbrPages;$i++){
                    $tot.='<li class="page-item"><a id="'.$i.'" class="page-link">'.$i.'</a></li>';
                }

                if($page<$nbrPages-1){
                    $currentPage = $page;
                    $next = $currentPage+1;
                    $tot.='<li class="page-item"><a id="'.$next.'" class="page-link">Next</a></li>';
                }

                if($page<$nbrPages){
                    $tot.='<li class="page-item"><a id="'.$nbrPages.'" class="page-link">Last</a></li>';
                }



                $tot.='</ul>
                </nav>
            </div>';

                echo $tot;

                exit();
                
            }
            if(!empty($_POST['portNameId'])){

                $nbrResults = $cruiseRepo->countfilteredCruisesPort($_POST['portNameId']);
                $nbrPages = ceil($nbrResults/$limit);

                $results = $cruiseRepo->getfilteredCruisesPort($_POST['portNameId'],$startFrom,$limit);

                foreach($results as $result){
                    $tot.='<div class="card col-12 col-md-6 col-lg-4 col-xl-3 item">
                        <img src="/cruises/public/uploads/'.$result['pic'].'"class="card-img-top" alt="...">
                        <div class="card-body">
                        <h5 class="card-title">'.$portRepo->getPortName($result['departurePort']).'</h5>
                            <p class="card-text">A partir de '.$result['minPrice'].'</p>';
                            if(isset($_SESSION['idClient'])){

                                $tot.='<a href="/cruises/public/cruise/description/'.$result['id'].'" class="btn btn-primary item__btn" >Je reserve ma place</a>';

                            }else if(isset($_SESSION['admin']) && ($_SESSION['admin']==1)){

                                $tot.='<a href="/cruises/public/cruise/description/'.$result['id'].'" class="btn btn-primary item__btn" >More Infos</a>';

                            }else{

                                $tot.='<a href="/cruises/public/page/signin/" class="btn btn-primary item__btn" >Je reserve ma place</a>';


                            }
                            $tot.='</div>
                        </div>';

                }

                $tot.='<div class="container my-5">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">';

                if($page>1){
                    $tot.='<li class="page-item"><a id="1" class="page-link">First</a></li>';
                }

                if($page>2){
                    $currentPage = $page;
                    $previous = $currentPage-1;
                    $tot.='<li class="page-item"><a id="'.$previous.'" class="page-link">Previous</a></li>';
                }
                

                for($i=1;$i<=$nbrPages;$i++){
                    $tot.='<li class="page-item"><a id="'.$i.'" class="page-link">'.$i.'</a></li>';
                }

                if($page<$nbrPages-1){
                    $currentPage = $page;
                    $next = $currentPage+1;
                    $tot.='<li class="page-item"><a id="'.$next.'" class="page-link">Next</a></li>';
                }

                if($page<$nbrPages){
                    $tot.='<li class="page-item"><a id="'.$nbrPages.'" class="page-link">Last</a></li>';
                }



                $tot.='</ul>
                </nav>
            </div>';

                echo $tot;

                exit();

            }

        }

            }


}