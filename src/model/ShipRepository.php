<?php



spl_autoload_register(function($class){
    if (file_exists('src/lib/'.$class.'.php')){
        require_once('src/lib/'.$class.'.php');
    }
    

});






class ShipRepository
{

    public DatabaseConnection $connectiondb;



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

    $name = $input['name'];
    $nbrRooms = $input['nbrRooms'];
    $nbrPlaces = $input['nbrPlaces'];

    $statement = $this->connectiondb->getConnection()->prepare(
        "INSERT INTO `ship`(`name`, `nbrRooms`, `nbrPlaces`) VALUES (?,?,?)"
    );
    $affectedLines = $statement->execute([$name, $nbrRooms, $nbrPlaces]);


    

    return ($affectedLines > 0);
  }


  public function deleteShip(string $identifier)
 {

    $statement = $this->connectiondb->getConnection()->prepare(
        "DELETE FROM `ship` WHERE id = ?"
    );
    $affectedLines = $statement->execute([$identifier]);

    return ($affectedLines > 0);

 }


 public function minPrice($identifier){

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT MIN(price) AS minPrice FROM `room` WHERE id=?"
    );
    $min = $statement->execute([$identifier]);

return $min['minPrice'];
}

    


}

