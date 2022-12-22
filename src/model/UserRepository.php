<?php



spl_autoload_register(function($class){

    require_once('src/lib/'.$class.'.php');

});





class UserRepository
{

    public DatabaseConnection $connectiondb;




   public function addUser(array $input)
{

    $firstname = $input['firstname'];
    $lastname = $input['lastname'];
    $email = $input['email'];
    $password = $input['password'];
    

    $statement = $this->connectiondb->getConnection()->prepare(
        "INSERT INTO `user` (`firstname`, `lastname`, `email`, `password`) VALUES (?,?,?,?)"
    );
    $affectedLines = $statement->execute([$firstname, $lastname, $email, $password]);
    

    if($affectedLines > 0){
        $_SESSION['email'] = $email;
    }
    return ($affectedLines > 0);
}


public function getClientId(string $email){

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id` FROM `user` WHERE `email` = ?"
    );
    $statement->execute([$email]);

    $row = $statement->fetch();

    return $row['id'];

}



public function checkUser(array $input)
   {
    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`,`role` FROM `user` WHERE `email` = ? AND `password` = ?"
    );
    $statement->execute([$input['email'],$input['password']]);

    $auth = $statement->fetch();


    if($auth){
        $_SESSION['email'] = $input['email'];
    }


    return $auth;

   }



        public function getMyReservations(string $clientId):array
        {

            $statement = $this->connectiondb->getConnection()->prepare(
                "SELECT `id`, `cruise`, `reservationDate`, `reservationPrice`, `room` FROM `reservation` WHERE `client`=?"
            );
            $statement->execute([$clientId]);

            $reservations = [];

            while(($row = $statement->fetch())){

                $reservation = new Reservation();

                $reservation->id = $row['id'];
                $reservation->idCruise = $row['cruise'];
                $reservation->reservationDate = $row['reservationDate'];
                $reservation->reservationPrice = $row['reservationPrice'];
                $reservation->idRoom = $row['room'];

                
                $reservations [] = $reservation;
            }
            
            return $reservations;
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


public function reserve(string $cruiseIdentifier){

    $statement = $this->connectiondb->getConnection()->prepare(
        "INSERT INTO `reservation` (`client`, `cruise`, `reservationDate`, `reservationPrice`, `room`) VALUES (?,?,NOW,?,?)"
    );
    $affectedLines = $statement->execute([$_SESSION['idUser'], $cruiseIdentifier, 100, 77]);


    

    return ($affectedLines > 0);

}







}
