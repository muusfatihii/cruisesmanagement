<?php


spl_autoload_register(function($class){
    
        require_once('src/lib/'.$class.'.php');
    

});



class RoomRepo
{

    public DatabaseConnection $connectiondb;


    public function getAvlNbrRooms($shipId,$roomTypeId)
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT COUNT(id) as avlNbrRooms FROM `room` WHERE ship=? AND roomType=?"
        );

        $statement->execute([$shipId,$roomTypeId]);

        $result = $statement->fetch();

        return $result['avlNbrRooms'];
    }


    public function getRoomPrice($shipId,$roomTypeId)
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT price FROM `room` WHERE ship=? AND roomType=?"
        );

        $statement->execute([$shipId,$roomTypeId]);

        $result = $statement->fetch();

        return $result['price'];
    }

    public function getRoomType($roomId)
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT roomType FROM `room` WHERE id=?"
        );

        $statement->execute([$roomId]);

        $result = $statement->fetch();

        return $result['roomType'];
    }

    public function getTotRooms($idShip){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT COUNT(`id`) as nbrRooms FROM `room` WHERE `ship`=?"
        );

        $statement->execute([$idShip]);

        $row = $statement->fetch();

        return $row['nbrRooms'];
    }

    public function getAvlRoomsIds($shipId,$roomTypeId){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT  `id` FROM `room` WHERE `ship`=? AND `roomType`=? ORDER BY `roomNbr`"
        );
        
        $statement->execute([$shipId,$roomTypeId]);

        $rooms = $statement->fetchAll();

        return $rooms;

    }

    public function getRoomNbr($idRoom){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `roomNbr` FROM `room` WHERE `id`=?"
        );
        
        $statement->execute([$idRoom]);

        $row = $statement->fetch();

        return $row['roomNbr'];

    }

    public function minPrice($shipId){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT MIN(price) as minPrice FROM `room` WHERE ship=?"
        );
        $statement->execute([$shipId]);

        $result = $statement->fetch();
    
        return $result['minPrice'];
    }

    public function addRooms($idShip,$nbrRooms,$roomType,$capacity,$priceRoom){

        for($i=0;$i<$nbrRooms;$i++){

            $statement = $this->connectiondb->getConnection()->prepare(
                "INSERT INTO `room`(`ship`, `roomNbr`, `roomType`, `capacity`, `price`) VALUES (?,?,?,?,?)"
            );

            $statement->execute([$idShip,$i,$roomType,$capacity,$priceRoom]);

        }

    }


}