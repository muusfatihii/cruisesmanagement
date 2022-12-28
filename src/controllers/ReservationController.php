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

        require ('templates/myReservation.php');
    }





    public function cancelReservation(string $reservationId){


        $connectiondb = new DatabaseConnection();


        $reservationRepo = new ReservationRepository();
        $reservationRepo->connectiondb = $connectiondb;

        $cruiseRepo = new CruiseRepository();
        $cruiseRepo->connectiondb = $connectiondb;

        $cruiseId = $reservationRepo->getCruiseId($reservationId);


        if($cruiseRepo->canBeCancelled($cruiseId)){

            $success = $reservationRepo->cancelReservation($reservationId);

            if (!$success) {

                throw new Exception("Erreur lors de l'annulation de la reservation !");
    
            } else {


                $success = $cruiseRepo->unsetfull($cruiseId);

                if (!$success) {

                    throw new Exception("Erreur lors de la mise à jour de l'état de la croisière !");
        
                } else {
        
                    header('Location: index.php?action=myReservations');
                }
    
            }

        }else{

            $em = "la réservation ne peut plus etre annulée";
            header ('Location: index.php?action=myReservations&em='.$em);
            
        }

        
    }

    public function reserve(string $cruiseId, string $roomTypeId){

        $connectiondb = new DatabaseConnection();


        $reservationRepo = new ReservationRepository();
        $reservationRepo->connectiondb = $connectiondb;

        $roomRepo = new RoomRepository();
        $roomRepo->connectiondb = $connectiondb;

        $cruiseRepo = new CruiseRepository();
        $cruiseRepo->connectiondb = $connectiondb;

        //getting ship id
        
        $shipId = $cruiseRepo->getShipId($cruiseId);

        //getting available rooms from room table 
        $allRooms = $roomRepo->getTotRooms($shipId);

        

        $allReservedRooms = $reservationRepo->reservedRooms($cruiseId);

        $diff = $allRooms - $allReservedRooms;

        if($diff==1){

            $cruiseRepo->setfull($cruiseId);

        }




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

                // if($diff==1){

                //     $success = $cruiseRepo->setfull($cruiseId);

                // }

                if (!$success) {

                    throw new Exception("Erreur lors de la mise à jour de l'état de la croisière !");
        
                } else {
        
                    header('Location: index.php?action=myReservations');
                }
    
                
            }
            
        }else{

            throw new Exception("La croisière est pleine");

        }
        

    }

}