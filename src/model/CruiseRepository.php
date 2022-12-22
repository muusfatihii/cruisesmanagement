<?php


spl_autoload_register(function($class){
    if (file_exists('src/lib/'.$class.'.php')){
        require_once('src/lib/'.$class.'.php');
    }
    

});






class CruiseRepository
{

    public DatabaseConnection $connectiondb;

    public function getCruises():array
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`, `ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE 1"
    );
    $statement->execute();

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

public function minPrice($identifier){

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT MIN(price) AS minPrice FROM `room` WHERE id=?"
    );
    $min = $statement->execute([$identifier]);

return $min['minPrice'];
}



public function getPortName($identifier){

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `name` FROM `port` WHERE id=?"
    );

    $statement->execute([$identifier]);

    $row = $statement->fetch();

    return $row['name'];
}



public function getRecentCruises():array
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`, `ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE 1 ORDER BY departureDate LIMIT 3"
    );
    $statement->execute();

    $cruises = [];
    while (($row = $statement->fetch())) {
        $cruise = new Cruise();
        $cruise->id = $row['id'];
        $cruise->ship = $row['ship'];
        $cruise->pic = $row['pic'];
        $cruise->nbrNights = $row['nbrNights'];
        $cruise->departurePort = $row['departurePort'];
        $cruise->departureDate = $row['departureDate'];
        $cruise->minPrice = $row['minPrice'];
        

        $cruises[] = $cruise;
    }

    return $cruises;
}



public function getFilteredCruises($departurePort):array
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`, `ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE departurePort=?"
    );
    $statement->execute([$departurePort]);

    $cruises = [];
    while (($row = $statement->fetch())) {
        $cruise = new Cruise();
        $cruise->id = $row['id'];
        $cruise->ship = $row['ship'];
        $cruise->pic = $row['pic'];
        $cruise->nbrNights = $row['nbrNights'];
        $cruise->departurePort = $row['departurePort'];
        $cruise->departureDate = $row['departureDate'];
        $cruise->minPrice = $row['minPrice'];
        

        $cruises[] = $cruise;
    }

    return $cruises;
}



public function getCruise(string $identifier)
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`, `ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE id=?"
    );
    $statement->execute([$identifier]);

    $result = $statement->fetch();
    
    return $result;
}




public function createCruise(array $input)
{

    $shipID = $input['shipID'];
    $pic = $input['pic'];
    $nbrNights = $input['nbrNights'];
    $departurePort = $input['departurePort'];
    $departureDate = $input['departureDate'];
    $minPrice = $input['minPrice'];

    $statement = $this->connectiondb->getConnection()->prepare(
        "INSERT INTO `cruise`(`ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice`) VALUES (?,?,?,?,?,?)"
    );
    $affectedLines = $statement->execute([$shipID, $pic, $nbrNights, $departurePort, $departureDate, $minPrice]);


    

    return ($affectedLines > 0);
}



public function deleteCruise(string $identifier)
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "DELETE FROM `cruise` WHERE id = ?"
    );
    $affectedLines = $statement->execute([$identifier]);

    return ($affectedLines > 0);

}


public function modifyCruisePic(string $identifier, array $input)
{
    $name = $input['ship'];
    $pic = $input['pic'];
    $nbrNights = $input['nbrNights'];
    $departurePort = $input['departurePort'];
    $departureDate = $input['departureDate'];
    $minPrice = $input['minPrice'];
    

    $statement = $this->connectiondb->getConnection()->prepare(

        "UPDATE `cruise` SET `name`='$name',`pic`='$pic',`nbrNights`='$nbrNights',`departurePort`='$departurePort',`departureDate`='$departureDate',`minPrice`='$minPrice' WHERE id= ?"
    );
    $affectedLines =  $statement->execute([$identifier]);

    return ($affectedLines > 0);
}



public function modifyCruise(string $identifier, array $input)
{
    $name = $input['ship'];
    $nbrNights = $input['nbrNights'];
    $departurePort = $input['departurePort'];
    $departureDate = $input['departureDate'];
    $minPrice = $input['minPrice'];
    

    $statement = $this->connectiondb->getConnection()->prepare(

        "UPDATE `cruise` SET `name`='$name',`nbrNights`='$nbrNights',`departurePort`='$departurePort',`departureDate`='$departureDate',`minPrice`='$minPrice' WHERE id= ?"
    );
    $affectedLines =  $statement->execute([$identifier]);

    return ($affectedLines > 0);
}


public function getInfosCruise(string $identifier):array
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `pic`,`ship`,`departurePort`,`departureDate` FROM `cruise` WHERE id=?"
    );
    $statement->execute([$identifier]);

    $row = $statement->fetch();
    
    
    return $row;
}


public function getDestinations(){

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT distinct `departurePort`, `pic` FROM `cruise` WHERE 1"
    );
    
    $statement->execute();

    $row = $statement->fetchAll();
    
    
    return $row;

}




}

