<?php

spl_autoload_register(function($class){

    require_once('../app/lib/'.$class.'.php');

});


class Reservation extends Controller{


    public function show($params=[]){

        if (isset($_SESSION['idClient']) && !empty($_SESSION['idClient'])) {

            $idClient = $_SESSION['idClient'];

            $connectiondb = new DatabaseConnection();

            $reservationRepo = $this->model('ReservationRepo');
            $reservationRepo->connectiondb = $connectiondb;

            $results  = $reservationRepo->getMyReservations($idClient);


            $cruiseRepo = $this->model('CruiseRepo');
            $cruiseRepo->connectiondb = $connectiondb;

            $portRepo = $this->model('PortRepo');
            $portRepo->connectiondb = $connectiondb;

            $shipRepo = $this->model('ShipRepo');
            $shipRepo->connectiondb = $connectiondb;

            $roomRepo = $this->model('RoomRepo');
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

            $data = [];

            $data [] = $reservations; 

            $this->view('myReservations',$data);


        }else{

            throw new Exception("La page que vous recherchez n'existe pas.");

        }

    }



    public function cancel($params=[]){

        if(isset($_POST['idRes']) && $_POST['idRes']>=0){

        $reservationId=$_POST['idRes'];

        $connectiondb = new DatabaseConnection();


        $reservationRepo = $this->model('ReservationRepo');
        $reservationRepo->connectiondb = $connectiondb;

        $cruiseRepo = $this->model('CruiseRepo');
        $cruiseRepo->connectiondb = $connectiondb;

        $cruiseId = $reservationRepo->getIdCruise($reservationId);

        if($cruiseRepo->canBeCancelled($cruiseId)){

            $success = $reservationRepo->cancelReservation($reservationId);

            if(!$success){

                throw new Exception("Erreur lors de l'annulation de la reservation !");

            }else{

                $success = $cruiseRepo->unsetfull($cruiseId);

                if (!$success) {

                    throw new Exception("Erreur lors de la mise à jour de l'état de la croisière !");
        
                } else {

                    //Update data using ajax

                    $myRes = $reservationRepo->getMyReservations($_SESSION['idClient']);

                    $portRepo = $this->model('PortRepo');
                    $portRepo->connectiondb = $connectiondb;

                    $shipRepo = $this->model('ShipRepo');
                    $shipRepo->connectiondb = $connectiondb;


                    $roomRepo = $this->model('RoomRepo');
                    $roomRepo->connectiondb = $connectiondb;

                    $reservations = [];
                    

                    foreach($myRes as $res){


                        $infosCruise = $cruiseRepo->getInfosCruise($res['cruise']);

                        $res['departureDate'] = $infosCruise['departureDate'];
                        $res['pic'] = $infosCruise['pic'];
                        $res['departurePort'] = $portRepo->getPortName($infosCruise['departurePort']);
                        $res['shipName'] = $shipRepo->getShipName($infosCruise['ship']);
                        $res['roomNbr'] = $roomRepo->getRoomNbr($res['room']);

                        $reservations [] = $res;

                    }

                        echo json_encode($reservations);
                        exit();


                }


            }

        }else{

            echo (1);
            exit();

        }

       }else{

        throw new Exception("aucun identifiant de croisière n'a été spécifié!!");

       }

    }



}