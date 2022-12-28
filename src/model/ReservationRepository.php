<?php



spl_autoload_register(function($class){

    require_once('src/lib/'.$class.'.php');

});





class ReservationRepository
{

    public DatabaseConnection $connectiondb;



    public function getMyReservations(string $clientId):array
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `id`, `cruise`, `reservationDate`, `reservationPrice`, `room` FROM `reservation` WHERE `client`=?"
        );
        $statement->execute([$clientId]);

        $results = $statement->fetchAll();


        
        return $results;
    }




    public function cancelReservation(string $ReservationId)
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "DELETE FROM `reservation` WHERE id = ? AND client = ?"
        );
        $affectedLines = $statement->execute([$ReservationId,$_SESSION['idClient']]);

        return ($affectedLines > 0);

    }



    public function canBeReserved(string $identifier){


        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `reservationDate` FROM `reservation` WHERE `id`=?"
        );
        $statement->execute([$identifier]);


    }


    public function reserve(string $cruiseId, string $roomPrice, string $reservedRoomId){

        $statement = $this->connectiondb->getConnection()->prepare(
            "INSERT INTO `reservation` (`client`, `cruise`, `reservationDate`, `reservationPrice`, `room`) VALUES (?,?,NOW(),?,?)"
        );
        $affectedLines = $statement->execute([$_SESSION['idClient'], $cruiseId, $roomPrice, $reservedRoomId]);


        

        return ($affectedLines > 0);

    }


    public function reservedRooms(string $cruiseId)
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT COUNT(id) as totRooms FROM `reservation` WHERE `cruise`=?"
        );
        $statement->execute([$cruiseId]);

        $reservedRooms = $statement->fetch();



        return $reservedRooms['totRooms'];
    }



    public function countReservedRooms(string $cruiseId,string $roomTypeId){


        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT COUNT(reservation.id) FROM reservation 
            INNER JOIN room ON reservation.room = room.id  
            WHERE reservation.cruise=? AND room.roomType=?"
        );

        $reservedRooms = $statement->execute([$cruiseId,$roomTypeId]);


        return $reservedRooms;
    }



    public function getRoom($cruiseId,$roomTypeId){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT room.id FROM room 
            LEFT JOIN reservation ON room.id = reservation.room  
            WHERE room.roomType=? AND reservation.cruise=?"
        );

        $statement->execute([$roomTypeId,$cruiseId]);

        $roomId = $statement->fetch();


        return $roomId;

    }


    public function getCruiseId($reservationId){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT  `cruise` FROM `reservation` WHERE `id`=?"
        );
        
        $statement->execute([$reservationId]);

        $row = $statement->fetch();


        return $row['cruise'];

    }

    public function getReservedRoomsIds($cruiseId){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT  `room` FROM `reservation` WHERE `cruise`=?"
        );
        
        $statement->execute([$cruiseId]);

        $rooms = $statement->fetchAll();

        return $rooms;

    }


    public function isreserved($cruiseId,$roomId){


        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT  `id` FROM `reservation` WHERE `cruise`=? AND `room`=?"
        );
        
        $statement->execute([$cruiseId,$roomId]);

        $reserved = $statement->fetch();

        return $reserved;

    }

}

