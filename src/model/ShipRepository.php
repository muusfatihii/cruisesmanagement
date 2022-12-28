<?php



spl_autoload_register(function($class){
    if (file_exists('src/lib/'.$class.'.php')){
        require_once('src/lib/'.$class.'.php');
    }
    

});






class ShipRepository
{

    public DatabaseConnection $connectiondb;


    public function getShips(){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `id`, `name`, `nbrRooms`, `nbrPlaces` FROM `ship` WHERE 1"
        );

        $statement->execute();

        $results = $statement->fetchAll();


        return $results;
    }


    public function getDiffShips(string $shipId){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `id`, `name` FROM `ship` WHERE id!=?"
        );

        $statement->execute([$shipId]);

        $results = $statement->fetchAll();


        return $results;
    }

    public function getShipName($identifier){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `name` FROM `ship` WHERE id=?"
        );
    
        $statement->execute([$identifier]);
    
        $row = $statement->fetch();
    
        return $row['name'];
    }



    public function addShip(array $input)
   {

    $name = $input['nameShip'];
    $nbrRooms = $input['nbrRooms'];
    $nbrPlaces = $input['nbrPlaces'];

    $statement = $this->connectiondb->getConnection()->prepare(
        "INSERT INTO `ship`(`name`, `nbrRooms`, `nbrPlaces`) VALUES (?,?,?)"
    );

    $affectedLines = $statement->execute([$name, $nbrRooms, $nbrPlaces]);

    return ($affectedLines > 0);
  }


   public function modifyShip(string $idShip, array $input)
   {

    $name = $input['nameShip'];
    $nbrRooms = $input['nbrRooms'];
    $nbrPlaces = $input['nbrPlaces'];

    $statement = $this->connectiondb->getConnection()->prepare(

        "UPDATE `ship` SET (`name`, `nbrRooms`, `nbrPlaces`) VALUES (?,?,?) WHERE id=?"
    );

    $affectedLines = $statement->execute([$name, $nbrRooms, $nbrPlaces, $idShip]);

    return ($affectedLines > 0);

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

