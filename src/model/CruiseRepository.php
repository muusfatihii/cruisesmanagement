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
        "SELECT `id`, `ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE departureDate>=NOW() AND isfull=0 ORDER BY departureDate"
    );
    $statement->execute();

    $results = $statement->fetchAll();

    return $results;
}


public function getCruisesAdmin():array
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`, `ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE departureDate>=NOW() ORDER BY departureDate"
    );
    $statement->execute();

    $results = $statement->fetchAll();

    return $results;
}



public function getfilteredCruisesPort(string $idDeparturePort):array
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`, `ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE departurePort=? AND departureDate>=NOW()"
    );
    $statement->execute([$idDeparturePort]);

    $results = $statement->fetchAll();

    return $results;
}

public function getfilteredCruisesShip(string $idShip):array
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`, `ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE ship=? AND departureDate>=NOW()"
    );
    $statement->execute([$idShip]);

    $results = $statement->fetchAll();

    return $results;
}


public function getfilteredCruisesMonth(string $month):array
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`, `ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE departureDate=?"
    );
    $statement->execute([$month]);

    $results = $statement->fetchAll();

    return $results;
}


public function getShipId($identifier){

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `ship` FROM `cruise` WHERE id=?"
    );

    $statement->execute([$identifier]);

    $row = $statement->fetch();
    
    return $row['ship'];
}


public function getRecentCruises():array
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`, `ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice` 
        FROM `cruise` WHERE departureDate>=NOW() ORDER BY `departureDate` DESC LIMIT 8"
    );
    $statement->execute();

    $results = $statement->fetchAll();

    return $results;
}







public function getCruise(string $idCruise)
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`, `ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE id=?"
    );
    $statement->execute([$idCruise]);

    $result = $statement->fetch();
    
    return $result;
}




public function createCruise(array $input)
{

    $shipID = $input['shipID'];
    $pic = $input['pic'];
    $nbrNights = $input['nbrNights'];
    $departurePort = $input['departurePortID'];
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


public function modifyCruisePic(string $cruiseId, array $input)
{
    $shipID = $input['shipID'];
    $pic = $input['pic'];
    $nbrNights = $input['nbrNights'];
    $departurePort = $input['departurePortID'];
    $departureDate = $input['departureDate'];
    $minPrice = $input['minPrice'];
    

    $statement = $this->connectiondb->getConnection()->prepare(

        "UPDATE `cruise` SET `ship`='$shipID',`pic`='$pic',`nbrNights`='$nbrNights',`departurePort`='$departurePort',`departureDate`='$departureDate',`minPrice`='$minPrice' WHERE id= ?"
    );

    $affectedLines =  $statement->execute([$cruiseId]);

    return ($affectedLines > 0);
}



public function modifyCruise(string $cruiseId, array $input)
{
    $shipID = $input['shipID'];
    $nbrNights = $input['nbrNights'];
    $departurePort = $input['departurePortID'];
    $departureDate = $input['departureDate'];
    $minPrice = $input['minPrice'];
    

    $statement = $this->connectiondb->getConnection()->prepare(

        "UPDATE `cruise` SET `ship`='$shipID',`nbrNights`='$nbrNights',`departurePort`='$departurePort',`departureDate`='$departureDate',`minPrice`='$minPrice' WHERE id= ?"
    );

    $affectedLines =  $statement->execute([$cruiseId]);

    return ($affectedLines > 0);
}


public function getInfosCruise(string $cruiseId):array
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `pic`,`ship`,`departurePort`,`departureDate` FROM `cruise` WHERE id=?"
    );
    $statement->execute([$cruiseId]);

    $row = $statement->fetch();
    
    
    return $row;
}


public function getDestinations(){

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT DISTINCT `departurePort` FROM `cruise` WHERE 1"
    );
    
    $statement->execute();

    $row = $statement->fetchAll();
    
    
    return $row;

}


public function canBeCancelled(string $cruiseId)
    {

        $statement = $this->connectiondb->getConnection()->prepare(

            "SELECT `departureDate` FROM  cruise WHERE `id`=?" 
        );
        
        $statement->execute([$cruiseId]);

        $row = $statement->fetch();


        if($row['departureDate']>date('Y-m-d', strtotime(date('Y-m-d'). ' + 2 days'))){

            return true;

        }else{
            
            return false;
        }

    }


    public function setfull($cruiseId){

        $statement = $this->connectiondb->getConnection()->prepare(

            "UPDATE `cruise` SET `isfull`='1' WHERE id= ?"
        );
    
        $affectedLines =  $statement->execute([$cruiseId]);
    
        return ($affectedLines > 0);

    }

    public function unsetfull($cruiseId){

        $statement = $this->connectiondb->getConnection()->prepare(

            "UPDATE `cruise` SET `isfull`='0' WHERE id= ?"
        );
    
        $affectedLines =  $statement->execute([$cruiseId]);
    
        return ($affectedLines > 0);


    }




}

