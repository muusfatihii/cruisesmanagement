<?php


spl_autoload_register(function($class){
    
    require_once('src/lib/'.$class.'.php');


});


class reservationRepo{
    


    public DatabaseConnection $connectiondb;

    public function getMyReservations(string $Idclient):array
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `id`, `cruise`, `reservationDate`, `reservationPrice`, `room` FROM `reservation` WHERE `client`=? ORDER BY reservationDate DESC"
        );

        $statement->execute([$Idclient]);

        $results = $statement->fetchAll();

        return $results;
    }


    public function getReservedRoomsIds($cruiseId){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT  `room` FROM `reservation` WHERE `cruise`=?"
        );
        
        $statement->execute([$cruiseId]);
        
        $rooms = $statement->fetchAll();
        
        return $rooms;
        
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


    public function isreserved($cruiseId,$roomId){


        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT  `id` FROM `reservation` WHERE `cruise`=? AND `room`=?"
        );
        
        $statement->execute([$cruiseId,$roomId]);

        $reserved = $statement->fetch();

        return $reserved;

    }


    public function reserve(string $cruiseId, string $roomPrice, string $reservedRoomId)
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "INSERT INTO `reservation` (`client`, `cruise`, `reservationDate`, `reservationPrice`, `room`) VALUES (?,?,NOW(),?,?)"
        );
        $affectedLines = $statement->execute([$_SESSION['idClient'], $cruiseId, $roomPrice, $reservedRoomId]);

        return ($affectedLines > 0);

    }


    public function cancelReservation(string $ReservationId)
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "DELETE FROM `reservation` WHERE id = ? AND client = ?"
        );

        $affectedLines = $statement->execute([$ReservationId,$_SESSION['idClient']]);

        return ($affectedLines > 0);

    }


    public function getIdCruise($reservationId){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT  `cruise` FROM `reservation` WHERE `id`=?"
        );
        
        $statement->execute([$reservationId]);

        $row = $statement->fetch();

        return $row['cruise'];
    }

    public function canBeCancelled($cruiseId){


        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT  `id` FROM `reservation` WHERE `cruise`=?"
        );
        
        $statement->execute([$cruiseId]);

        $canBeCancelled = $statement->fetch();

        if($canBeCancelled==false){

            return true;

        }else{

            return false;

        }

        
    }

}




