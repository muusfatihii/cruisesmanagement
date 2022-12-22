<?php


require_once('src/lib/DatabaseConnection.php');
require_once('src/lib/Reservation.php');

spl_autoload_register(function($class){

    if (file_exists('src/model/'.$class.'.php')){
        require_once('src/model/'.$class.'.php');

    }
    
});



class ReservationController{


    public function getReservations(string $idClient){

        $connectiondb = new DatabaseConnection();

        $reservationRepo = new ReservationRepository();
        $reservationRepo->connectiondb = $connectiondb;



        $results  = $reservationRepo->getMyReservations($idClient);


        $cruiseRepo = new CruiseRepository();
        $cruiseRepo->connectiondb = $connectiondb;

        $portRepo = new PortRepository();
        $portRepo->connectiondb = $connectiondb;

        $shipRepo = new ShipRepository();
        $shipRepo->connectiondb = $connectiondb;


        $roomRepo = new RoomRepository();
        $roomRepo->connectiondb = $connectiondb;

        $reservations = [];
        

        foreach($results as $result){

            $reservation = new Reservation();
            
            $reservation->id = $result['id'];
            $reservation->reservationDate = $result['reservationDate'];
            $reservation->reservationPrice = $result['reservationPrice'];

            $infosCruise = $cruiseRepo->getInfosCruise($result['cruise']);

            $reservation->departureDate = $infosCruise['departureDate'];
            $reservation->cruisePic = $infosCruise['pic'];
            $reservation->departurePort = $portRepo->getPortName($infosCruise['departurePort']);
            $reservation->shipName = $shipRepo->getShipName($infosCruise['ship']);

            $reservation->roomNbr = $roomRepo->getRoomNbr($result['room']);

            $reservations [] = $reservation;

        }

        require ('templates/myDashboard.php');
    }





    public function cancelReservation(string $reservationId){


        $connectiondb = new DatabaseConnection();


        $userRepo = new ReservationRepository();
        $userRepo->connectiondb = $connectiondb;


        if($userRepo->canBeCancelled($reservationId)){
            $userRepo->cancelReservation($reservationId,$_SESSION['idClient']);
        }else{
            $em = "la reservation ne sera plus annulée time!!";
            require ('index.php?action=myDashboard&em='.$em);
            
        }

        
    }

    public function reserve(string $cruiseId, string $roomTypeId){

        $connectiondb = new DatabaseConnection();


        $reservationRepo = new ReservationRepository();
        $reservationRepo->connectiondb = $connectiondb;

        
        $success = $reservationRepo->reserve($cruiseId, $roomTypeId);

        if (!$success) {

            throw new Exception("Impossible de reserver cette croisière !");

        } else {

            header('Location: index.php?action=myDashboard');
        }

    }




    



}