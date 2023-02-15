<?php


spl_autoload_register(function($class){

        require_once('../app/lib/'.$class.'.php');
   
});


class ShipRepo
{

    public DatabaseConnection $connectiondb;

    public function getShips(){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `id`, `name`, `nbrRooms`, `nbrPlaces` FROM `ship`"
        );

        $statement->execute();

        $results = $statement->fetchAll();


        return $results;
    }


    public function getShipName($idShip):string
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `name` FROM `ship` WHERE id=?"
        );
    
        $statement->execute([$idShip]);
    
        $row = $statement->fetch();
    
        return $row['name'];
    }

    public function getShipsList():array
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `id`, `name` FROM `ship` WHERE 1"
        );

        $statement->execute([]);

        $results = $statement->fetchAll();

        return $results;
    }

    public function addShip(array $input)
    {

        $name = $input['nameShip'];
        $nbrRooms = $input['nbrRooms'];
        $nbrPlaces = $input['nbrPlaces'];

        $statement1 = $this->connectiondb->getConnection()->prepare(
            "INSERT INTO `ship`(`name`, `nbrRooms`, `nbrPlaces`) VALUES (?,?,?)"
        );

        $statement1->execute([$name, $nbrRooms, $nbrPlaces]);

        $statement2 = $this->connectiondb->getConnection()->prepare(
            "SELECT MAX(id) as idShip FROM `ship`"
        );

        $statement2->execute([]);
        $row = $statement2->fetch();

        return $row['idShip'];
    }

    public function addRooms($idShip,$nbrRooms,$roomType,$capacity,$priceRoom){

        for($i=0;$i<$nbrRooms;$i++){

            $statement = $this->connectiondb->getConnection()->prepare(
                "INSERT INTO `room`(`ship`, `roomNbr`, `roomType`, `capacity`, `price`) VALUES (?,?,?,?,?)"
            );

            $statement->execute([$idShip,$i,$roomType,$capacity,$priceRoom]);

        }

    }

    public function getDiffShips(string $shipId){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `id`, `name` FROM `ship` WHERE id!=?"
        );

        $statement->execute([$shipId]);

        $results = $statement->fetchAll();


        return $results;
    }


    public function getShip($identifier){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `id`, `name`, `nbrRooms`, `nbrPlaces` FROM `ship` WHERE id=?"
        );

        $statement->execute([$identifier]);

        $result = $statement->fetch();


        return $result;
    }


    public function deleteShip(string $idShip)
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "DELETE FROM `ship` WHERE id = ?"
        );
        
        $affectedLines = $statement->execute([$idShip]);

        return ($affectedLines > 0);

    }


}