<?php



spl_autoload_register(function($class){
    if (file_exists('src/lib/'.$class.'.php')){
        require_once('src/lib/'.$class.'.php');
    }
    

});






class RoomRepository
{

    public DatabaseConnection $connectiondb;


    public function getRoomNbr($identifier){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `roomNbr` FROM `room` WHERE `id`=?"
        );
        $statement->execute([$identifier]);

        $row = $statement->fetch();

        $roomNbr = $row['roomNbr'];

        return $roomNbr;

    }



    



    

}

