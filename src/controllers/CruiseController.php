<?php



require_once('src/lib/DatabaseConnection.php');
require_once('src/lib/RoomType.php');

spl_autoload_register(function($class){
    if (file_exists('src/model/'.$class.'.php')){
        require_once('src/model/'.$class.'.php');
    }
    
    
});





class CruiseController{



    public function addImage(array $picture):string
    {

        $new_img_name = "default.png";
    
        if(isset($picture) && !empty($picture)){
    
            $picname=$picture['name'];
            $pictmpname=$picture['tmp_name'];
    
    
    
            if($picture['size']>1000000){

                $em = "sorry your file is too large";
                header("Location: index.php?action=addPage&error=$em");

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
                    header("Location: index.php?action=addPage&error=$em");
                }
            }
        }
    
        return $new_img_name;
    
    }
    
    public function cruises()
  {
    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;

    $shipRepo = new ShipRepository();
    $shipRepo->connectiondb = $connectiondb;

    $portRepo = new PortRepository();
    $portRepo->connectiondb = $connectiondb;


    

    // getting cruises
    $results = $cruiseRepo->getCruises();


    $cruises = [];

    $nbrRows=0;
    foreach ($results as $result) {

        $nbrRows++;

    $cruise = new Cruise();

    $cruise->id = $result['id'];

    $cruise->ship = $shipRepo->getShipName($result['ship']);
    $cruise->pic = $result['pic'];
    $cruise->nbrNights = $result['nbrNights'];
    $cruise->departurePort = $portRepo->getPortName($result['departurePort']);
    $cruise->departureDate = $result['departureDate'];
    $cruise->minPrice = $result['minPrice'];
    

    $cruises[] = $cruise;

    }
    //end getting cruises

    //getting ports
    $resultsPorts = $portRepo->getPorts();

    $ports = [];

    foreach ($resultsPorts as $result) {

    $port = new Port();

    $port->id = $result['id'];
    $port->name = $result['name'];
    
    $ports[] = $port;
    }
    //end getting ports

    //getting ship

    $resultsShips = $shipRepo->getShips();

    $ships = [];

    foreach ($resultsShips as $result) {

        $ship = new Ship();

        $ship->id = $result['id'];
        $ship->name = $result['name'];
        
        $ships[] = $ship;
        //end getting ships

    }
    
    require('templates/cruisesUser.php');

  }

   public function cruisesClient(){

    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;


    $shipRepo = new ShipRepository();
    $shipRepo->connectiondb = $connectiondb;

    $portRepo = new PortRepository();
    $portRepo->connectiondb = $connectiondb;



    $results = $cruiseRepo->getCruises();


    $cruises = [];

    foreach ($results as $result) {

    $cruise = new Cruise();

    $cruise->id = $result['id'];

    $cruise->ship = $shipRepo->getShipName($result['ship']);
    $cruise->pic = $result['pic'];
    $cruise->nbrNights = $result['nbrNights'];
    $cruise->departurePort = $portRepo->getPortName($result['departurePort']);
    $cruise->departureDate = $result['departureDate'];
    $cruise->minPrice = $result['minPrice'];
    

    $cruises[] = $cruise;
    }

    //end getting cruises

    //getting ports
    $resultsPorts = $portRepo->getPorts();

    $ports = [];

    foreach ($resultsPorts as $result) {

    $port = new Port();

    $port->id = $result['id'];
    $port->name = $result['name'];
    
    $ports[] = $port;
    }
    //end getting ports

    //getting ship

    $resultsShips = $shipRepo->getShips();

    $ships = [];

    foreach ($resultsShips as $result) {

        $ship = new Ship();

        $ship->id = $result['id'];
        $ship->name = $result['name'];
        
        $ships[] = $ship;
        //end getting ships

    }


    require('templates/cruisesClient.php');


  }


   public function cruisesAdmin()
  {
    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;


    $shipRepo = new ShipRepository();
    $shipRepo->connectiondb = $connectiondb;

    $portRepo = new PortRepository();
    $portRepo->connectiondb = $connectiondb;



    $results = $cruiseRepo->getCruisesAdmin();


    $cruises = [];

    foreach ($results as $result) {

    $cruise = new Cruise();

    $cruise->id = $result['id'];

    $cruise->ship = $shipRepo->getShipName($result['ship']);
    $cruise->pic = $result['pic'];
    $cruise->nbrNights = $result['nbrNights'];
    $cruise->departurePort = $portRepo->getPortName($result['departurePort']);
    $cruise->departureDate = $result['departureDate'];
    $cruise->minPrice = $result['minPrice'];
    

    $cruises[] = $cruise;
    }



    require('templates/cruisesAdmin.php');

  }






  public function modifyImage(array $picture):string
  {

    $new_img_name = "";


    if(isset($picture) && !empty($picture)){

        $picname=$picture['name'];
        $pictmpname=$picture['tmp_name'];



        if($picture['size']>100000000){

            $em = "sorry your file is too large";
            header("Location: add.php?error=$em");

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
                header("Location: index.php?action=modifyPage&error=$em");
            }
        }
    }

    return $new_img_name;

}


public function modifyCruise(string $cruiseId, array $input, array $pic)
{
    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;


    if (empty($input['shipID']) || empty($input['nbrNights']) || empty($input['departurePortID']) || empty($input['departureDate'])) {
        
        throw new Exception('Les données du formulaire sont invalides.');
    } 

    $roomRepo = new RoomRepository();
    $roomRepo->connectiondb = $connectiondb;

    $input['minPrice'] = $roomRepo->minPrice($input['shipID']);
    
    if($this->modifyImage($pic)!=""){

        $input['pic'] = $this->modifyImage($pic);
        $success = $cruiseRepo->modifyCruisePic($cruiseId, $input);

    }else{

        $success = $cruiseRepo->modifyCruise($cruiseId, $input);
    }
    
    if (!$success) {

        throw new Exception("Impossible de modifier l'article !");

    } else {

        header('Location: index.php');
    }
}

public function cruise(string $cruiseId)
{
    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;

    $shipRepo = new ShipRepository();
    $shipRepo->connectiondb = $connectiondb;

    $portRepo = new PortRepository();
    $portRepo->connectiondb = $connectiondb;

    $roomRepo = new RoomRepository();
    $roomRepo->connectiondb = $connectiondb;

    $roomTypeRepo = new RoomTypeRepository();
    $roomTypeRepo->connectiondb = $connectiondb;

    $reservationRepo = new ReservationRepository();
    $reservationRepo->connectiondb = $connectiondb;

    




    $result = $cruiseRepo->getCruise($cruiseId);

    $cruise = new Cruise();

    $cruise->id = $result['id'];
    $cruise->ship = $shipRepo->getShipName($result['ship']);
    $cruise->pic = $result['pic'];
    $cruise->nbrNights = $result['nbrNights'];
    $cruise->departurePort = $portRepo->getPortName($result['departurePort']);
    $cruise->departureDate = $result['departureDate'];


    $roomTypesInfos = $roomTypeRepo->getRoomTypesInfos();


    $roomTypes = [];

    foreach($roomTypesInfos as $roomTypeInfos){


    $roomType = new RoomType();
    $roomType->id = $roomTypeInfos['id'];
    $roomType->name = $roomTypeInfos['name'];


    $avlNbrRooms = $roomRepo->getAvlNbrRooms($result['ship'],$roomTypeInfos['id']);
     
    if($avlNbrRooms>0){

        $roomType->price = $roomRepo->getRoomPrice($result['ship'],$roomTypeInfos['id']);

    }
    


    
    

    
    $ReservedRoomsIds = $reservationRepo->getReservedRoomsIds($cruiseId);


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




    require('templates/itemDescription.php');
}


public function filterCruisesPort(string $idDeparturePort)
{
    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;


    $shipRepo = new ShipRepository();
    $shipRepo->connectiondb = $connectiondb;

    $portRepo = new PortRepository();
    $portRepo->connectiondb = $connectiondb;

    

    $results = $cruiseRepo->getfilteredCruisesPort($idDeparturePort);


    $cruises = [];

    foreach ($results as $result) {

    $cruise = new Cruise();

    $cruise->id = $result['id'];

    $cruise->ship = $shipRepo->getShipName($result['ship']);
    $cruise->pic = $result['pic'];
    $cruise->nbrNights = $result['nbrNights'];
    $cruise->departurePort = $portRepo->getPortName($result['departurePort']);
    $cruise->departureDate = $result['departureDate'];
    $cruise->minPrice = $result['minPrice'];
    

    $cruises[] = $cruise;
    }

    require('templates/cruisesUser.php');


}


public function filterCruisesShip(string $idShip)
{
    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;


    $shipRepo = new ShipRepository();
    $shipRepo->connectiondb = $connectiondb;

    $portRepo = new PortRepository();
    $portRepo->connectiondb = $connectiondb;

    

    $results = $cruiseRepo->getfilteredCruisesShip($idShip);


    $cruises = [];

    foreach ($results as $result) {

    $cruise = new Cruise();

    $cruise->id = $result['id'];

    $cruise->ship = $shipRepo->getShipName($result['ship']);
    $cruise->pic = $result['pic'];
    $cruise->nbrNights = $result['nbrNights'];
    $cruise->departurePort = $portRepo->getPortName($result['departurePort']);
    $cruise->departureDate = $result['departureDate'];
    $cruise->minPrice = $result['minPrice'];
    

    $cruises[] = $cruise;
    }

    require('templates/cruisesUser.php');


}



public function filterCruisesMonth(string $month)
{
    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;


    $shipRepo = new ShipRepository();
    $shipRepo->connectiondb = $connectiondb;

    $portRepo = new PortRepository();
    $portRepo->connectiondb = $connectiondb;

    

    $results = $cruiseRepo->getfilteredCruisesMonth($month);


    $cruises = [];

    foreach ($results as $result) {

    $cruise = new Cruise();

    $cruise->id = $result['id'];

    $cruise->ship = $shipRepo->getShipName($result['ship']);
    $cruise->pic = $result['pic'];
    $cruise->nbrNights = $result['nbrNights'];
    $cruise->departurePort = $portRepo->getPortName($result['departurePort']);
    $cruise->departureDate = $result['departureDate'];
    $cruise->minPrice = $result['minPrice'];
    

    $cruises[] = $cruise;
    }

    require('templates/cruisesUser.php');


}



public function filterCruisesAdmin(string $idcategory)
{
    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;



    //$cruises = $cruiseRepo->getfilteredCruises($idcategory);
    
    require('templates/galleryadmin.php');


}

public function deleteCruise(string $cruiseId)
{
    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;

    $success = $cruiseRepo->deleteCruise($cruiseId);

    if (!$success) {

        throw new Exception("Impossible de supprimer la croisière !");

    } else {

        header('Location: index.php?action=cruises');
    }

}


public function addCruise(array $input, array $pic)
{
    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;

    if (!empty($input['shipID']) && !empty($input['nbrNights']) && !empty($input['departurePortID']) && !empty($input['departureDate'])) {
        
        $roomRepo = new RoomRepository();
        $roomRepo->connectiondb = $connectiondb;

        $input['minPrice'] = $roomRepo->minPrice($input['shipID']);

        $input['pic'] = $this->addImage($pic);
        
    } else {

        throw new Exception('Les données du formulaire sont invalides.');
    }

    $success = $cruiseRepo->createCruise($input);
    
    if (!$success) {

        throw new Exception("Impossible d\'ajouter la croisière !");

    } else {

        header('Location: index.php?action=cruises');
    }
    
}




}