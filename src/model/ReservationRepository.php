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




    public function cancelReservation(string $Reservationidentifier)
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "DELETE FROM `reservation` WHERE id = ? AND client = ?"
        );
        $affectedLines = $statement->execute([$Reservationidentifier,$_SESSION['idClient']]);

        return ($affectedLines > 0);

    }




    public function canBeCancelled(string $identifier)
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `reservationDate` FROM `reservation` WHERE `id`=?"
        );
        $statement->execute([$identifier]);

        

        $row = $statement->fetch();

        if($row['reservationDate']>date('Y-m-d H:i:s')){
            return true;
        }else{
            return false;
        }



    }

    public function canBeReserved(string $identifier){


        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `reservationDate` FROM `reservation` WHERE `id`=?"
        );
        $statement->execute([$identifier]);


    }


    public function reserve(string $cruiseId){

        $statement = $this->connectiondb->getConnection()->prepare(
            "INSERT INTO `reservation` (`client`, `cruise`, `reservationDate`, `reservationPrice`, `room`) VALUES (?,?,NOW,?,?)"
        );
        $affectedLines = $statement->execute([$_SESSION['idClient'], $cruiseId, 100, 77]);


        

        return ($affectedLines > 0);

    }


    public function reservedRooms(string $cruiseId)
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT COUNT(id) FROM `reservation` WHERE `cruise`=?"
        );
        $reservedRooms = $statement->execute([$cruiseId]);


        return $reservedRooms;
    }

}
