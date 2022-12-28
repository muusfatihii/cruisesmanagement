<?php



spl_autoload_register(function($class){
    if (file_exists('src/lib/'.$class.'.php')){
        require_once('src/lib/'.$class.'.php');
    }
    

});






class RoomRepository
{

    public DatabaseConnection $connectiondb;


    public function getRoomNbr($idRoom){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `roomNbr` FROM `room` WHERE `id`=?"
        );
        $statement->execute([$idRoom]);

        $row = $statement->fetch();

        return $row['roomNbr'];

    }


    public function countRooms($shipId, $roomTypeId){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT COUNT(id) as avlRooms ,MIN(price) as roomPrice FROM `room` 
            WHERE `ship`=? AND `roomType`=?"
        );
        $statement->execute([$shipId, $roomTypeId]);

        $row = $statement->fetch();

        return $row;

    }


    public function minPrice($shipId){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT MIN(price) as minPrice FROM `room` WHERE ship=?"
        );
        $statement->execute([$shipId]);

        $result = $statement->fetch();
    
        return $result['minPrice'];
    }



    public function getAvlNbrRooms($shipId,$roomTypeId)
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT COUNT(id) as avlNbrRooms FROM `room` WHERE ship=? AND roomType=?"
        );

        $statement->execute([$shipId,$roomTypeId]);

        $result = $statement->fetch();

        return $result['avlNbrRooms'];
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


    public function getRoomPrice($shipId,$roomTypeId)
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT price FROM `room` WHERE ship=? AND roomType=?"
        );

        $statement->execute([$shipId,$roomTypeId]);

        $result = $statement->fetch();

        return $result['price'];
    }

    public function getAvlRoomsIds($shipId,$roomTypeId){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT  `id` FROM `room` WHERE `ship`=? AND `roomType`=? ORDER BY `roomNbr`"
        );
        
        $statement->execute([$shipId,$roomTypeId]);

        $rooms = $statement->fetchAll();

        return $rooms;

    }



    public function getTotRooms($idShip){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT COUNT(`id`) as nbrRooms FROM `room` WHERE `ship`=?"
        );
        $statement->execute([$idShip]);

        $row = $statement->fetch();

        return $row['nbrRooms'];

    }




}

