<?php

spl_autoload_register(function($class){

    require_once('../app/lib/'.$class.'.php');

});


class Ship extends Controller{


    public function add($params=[]){

        $connectiondb = new DatabaseConnection();

        $shipRepo = $this->model('ShipRepo');
        $shipRepo->connectiondb = $connectiondb;


        if (empty($_POST['nameShip'])) {
            
            throw new Exception('Les données du formulaire sont invalides.');

        }
        
        $totalRooms = 0;
        $nbrPlaces = 0;

        //calculate nbr rooms

        if(!empty($_POST['nbrRoomsS']) && $_POST['nbrRoomsS']>0 &&
        !empty($_POST['priceRoomS']) && $_POST['priceRoomS']>0
        ){

            $totalRooms+=$_POST['nbrRoomsS'];
            $nbrPlaces+=$_POST['nbrRoomsS'];

        }
        if(!empty($_POST['nbrRoomsD']) && $_POST['nbrRoomsD']>0 &&
        !empty($_POST['priceRoomD']) && $_POST['priceRoomD']>0){

            $totalRooms+=$_POST['nbrRoomsD'];
            $nbrPlaces+=$_POST['nbrRoomsD']*2;

        }
        if(!empty($_POST['nbrRoomsF']) && !empty($_POST['maxFR']) && $_POST['nbrRoomsF']>0 &&
        !empty($_POST['priceRoomF']) && $_POST['priceRoomF']>0 && $_POST['maxFR']>0){

            $maxFR=$_POST['maxFR'];

            $totalRooms+=$_POST['nbrRoomsF'];
            $nbrPlaces+=$_POST['nbrRoomsF']*$maxFR;

        }

        
        if($totalRooms!=0){

            $input['nameShip'] = $_POST['nameShip'];
            $input['nbrRooms'] = $totalRooms;
            $input['nbrPlaces'] = $nbrPlaces;

            $idShip = $shipRepo->addShip($input);

        }else{

            throw new Exception("il faut absolument specifier le nombre et le prix de chaque chambre!!");
        }
    

        $connectiondb = new DatabaseConnection();
        $roomRepo = $this->model('RoomRepo');
        $roomRepo->connectiondb = $connectiondb;


        if(!empty($_POST['nbrRoomsS']) && !empty($_POST['priceRoomS']) &&
        $_POST['nbrRoomsS']>0 && $_POST['priceRoomS']>0){

            $nbrSRooms = $_POST['nbrRoomsS'];
            $priceSRoom = $_POST['priceRoomS'];


            $roomRepo->addRooms($idShip,$nbrSRooms,1,1,$priceSRoom);

        }

        if(!empty($_POST['nbrRoomsD']) && !empty($_POST['priceRoomD']) &&
        $_POST['nbrRoomsD']>0 && $_POST['priceRoomD']>0
        ){

            $nbrDRooms = $_POST['nbrRoomsD'];
            $priceDRoom = $_POST['priceRoomD'];

            $roomRepo->addRooms($idShip,$nbrDRooms,2,2,$priceDRoom);

        }

        if(!empty($_POST['nbrRoomsF']) && !empty($_POST['priceRoomF']) && !empty($_POST['maxFR']) &&
        $_POST['nbrRoomsF']>0 && $_POST['priceRoomF']>0 && $_POST['maxFR']>0
        ){

            $nbrFRooms = $_POST['nbrRoomsF'];
            $priceFRoom = $_POST['priceRoomF'];

            $roomRepo->addRooms($idShip,$nbrFRooms,3,$maxFR,$priceFRoom);

        }

            header('Location: /cruises/public/page/shipsDet');

    }


    public function modify($params=[]){


        // $this->view('shipsDet',[]);

    }


    public function delete($params=[]){

        $idShip = $_POST['idShip'];

        $connectiondb = new DatabaseConnection();

        $shipRepo = $this->model('ShipRepo');
        $shipRepo->connectiondb = $connectiondb;

        $shipRepo->deleteShip($idShip);

        $ships = $shipRepo->getShips();

        echo json_encode($ships);

        exit();


    }

}