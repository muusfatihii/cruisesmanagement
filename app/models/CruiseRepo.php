<?php


spl_autoload_register(function($class){

        require_once('../app/lib/'.$class.'.php');
   
});


class CruiseRepo
{

    public DatabaseConnection $connectiondb;

    
    public function getCruisesHome():array
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `id`,`nbrNights`, `pic`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE departureDate>NOW() AND isfull=0 ORDER BY departureDate LIMIT 8"
        );

        $statement->execute();

        $results = $statement->fetchAll();

        return $results;
    }


    public function getCruisesList($startFrom,$limit):array
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `id`,`nbrNights`, `pic`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE departureDate>NOW() AND isfull=0 ORDER BY departureDate LIMIT $startFrom,$limit"
        );

        $statement->execute([]);

        $results = $statement->fetchAll();

        return $results;
    }


    public function getCruises($startFrom,$limit):array
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `id`,`nbrNights`, `ship`, `pic`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` ORDER BY departureDate DESC LIMIT $startFrom,$limit"
        );

        $statement->execute([]);

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


    public function getShipId($idCruise)
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `ship` FROM `cruise` WHERE id=?"
        );
    
        $statement->execute([$idCruise]);
    
        $row = $statement->fetch();
        
        return $row['ship'];
    }


    public function setfull($cruiseId){

        $statement = $this->connectiondb->getConnection()->prepare(

            "UPDATE `cruise` SET `isfull`='1' WHERE id= ?"
        );
    
        $statement->execute([$cruiseId]);

    }

    public function unsetfull($cruiseId){

        $statement = $this->connectiondb->getConnection()->prepare(

            "UPDATE `cruise` SET `isfull`='0' WHERE id= ?"
        );
    
        $affectedLines =  $statement->execute([$cruiseId]);
    
        return ($affectedLines > 0);

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


    public function getInfosCruise(string $Idcruise):array
   {

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `pic`,`ship`,`departurePort`,`departureDate` FROM `cruise` WHERE id=?"
    );
    $statement->execute([$Idcruise]);

    $row = $statement->fetch();

    return $row;
   }


   public function countfilteredCruises(string $idDeparturePort,string $idShip,string $departureMonth)
{
    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT COUNT(`id`) as nbrEls FROM `cruise` WHERE departurePort=? AND ship=? AND MONTH(departureDate)=? AND isfull=0 ORDER BY departureDate"
    );

    $statement->execute([$idDeparturePort,$idShip,$departureMonth]);

    $nbrResults = $statement->fetch();

    return $nbrResults['nbrEls'];
}

public function getfilteredCruises(string $idDeparturePort,string $idShip,string $departureMonth,$startFrom,$limit):array
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`, `ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE departurePort=? AND ship=? AND MONTH(departureDate)=? AND isfull=0 ORDER BY departureDate LIMIT $startFrom,$limit"
    );

    $statement->execute([$idDeparturePort,$idShip,$departureMonth]);

    $results = $statement->fetchAll();

    return $results;
}

public function countCruises()
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT COUNT(`id`) as nbrCruises FROM `cruise` WHERE departureDate>=NOW() AND isfull=0"
    );

    $statement->execute();

    $result = $statement->fetch();

    return $result['nbrCruises'];
}

public function getFCruises($startFrom,$limit):array
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`, `ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE departureDate>=NOW() AND isfull=0 ORDER BY departureDate LIMIT $startFrom,$limit"
    );

    $statement->execute();

    $results = $statement->fetchAll();

    return $results;
}

public function countCruisesPortShip($idDeparturePort,$idShip){

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT COUNT(`id`) as nbrCruises FROM `cruise` WHERE departurePort=? AND ship=? AND isfull=0"
    );
    
    $statement->execute([$idDeparturePort,$idShip]);

    $result = $statement->fetch();

    return $result['nbrCruises'];

}

public function getfilteredCruisesShipPort(string $idDeparturePort,string $idShip,$startFrom,$limit):array
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`, `ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE departurePort=? AND ship=? AND isfull=0 ORDER BY departureDate LIMIT $startFrom,$limit"
    );
    
    $statement->execute([$idDeparturePort,$idShip]);

    $results = $statement->fetchAll();

    return $results;
}

public function countCruisesPortMonth($idDeparturePort,$departureMonth){

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT COUNT(`id`) as nbrCruises FROM `cruise` WHERE departurePort=? AND MONTH(departureDate)=? AND isfull=0"
    );
    
    $statement->execute([$idDeparturePort,$departureMonth]);

    $result = $statement->fetch();

    return $result['nbrCruises'];

}

public function getfilteredCruisesPortMonth(string $idDeparturePort,string $departureMonth,$startFrom,$limit){

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`, `ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE departurePort=? AND MONTH(departureDate)=? AND isfull=0 ORDER BY departureDate LIMIT $startFrom,$limit"
    );
    
    $statement->execute([$idDeparturePort,$departureMonth]);

    $results = $statement->fetchAll();

    return $results;

}


public function countCruisesShipMonth(string $idShip,string $departureMonth){

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT COUNT(`id`) as nbrCruises FROM `cruise` WHERE ship=? AND MONTH(departureDate)=? AND isfull=0"
    );
    
    $statement->execute([$idShip,$departureMonth]);

    $result = $statement->fetch();

    return $result['nbrCruises'];
}


public function getfilteredCruisesShipMonth(string $idShip,string $departureMonth,$startFrom,$limit){

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`, `ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE ship=? AND MONTH(departureDate)=? AND isfull=0 ORDER BY departureDate LIMIT $startFrom,$limit"
    );
    
    $statement->execute([$idShip,$departureMonth]);

    $results = $statement->fetchAll();

    return $results;

}

public function countfilteredCruisesShip($idShip){

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT COUNT(`id`) as nbrCruises FROM `cruise` WHERE ship=? AND departureDate>=NOW() AND isfull=0"
    );
    $statement->execute([$idShip]);

    $result = $statement->fetch();

    return $result['nbrCruises'];

}
public function getfilteredCruisesShip($idShip,$startFrom,$limit):array
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`, `ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE ship=? AND departureDate>=NOW() AND isfull=0 ORDER BY departureDate LIMIT $startFrom,$limit"
    );
    $statement->execute([$idShip]);

    $results = $statement->fetchAll();

    return $results;
}

public function getfilteredCruisesDepartureMonth($departureMonth,$startFrom,$limit):array
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`, `ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE MONTH(departureDate)=? AND isfull=0 ORDER BY departureDate LIMIT $startFrom,$limit"
    );
    $statement->execute([$departureMonth]);

    $results = $statement->fetchAll();

    return $results;
}

public function countfilteredCruisesDepartureMonth($departureMonth){

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT COUNT(`id`) as nbrResults FROM `cruise` WHERE MONTH(departureDate)=? AND isfull=0"
    );
    $statement->execute([$departureMonth]);

    $result = $statement->fetch();

    return $result['nbrResults'];

}

public function getfilteredCruisesPort($idDeparturePort,$startFrom,$limit):array
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`, `ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice` FROM `cruise` WHERE departurePort=? AND departureDate>=NOW() AND isfull=0 ORDER BY departureDate LIMIT $startFrom,$limit"
    );
    $statement->execute([$idDeparturePort]);

    $results = $statement->fetchAll();

    return $results;
}
public function countfilteredCruisesPort($idDeparturePort)
{

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT COUNT(`id`) as nbrCruises FROM `cruise` WHERE departurePort=? AND departureDate>=NOW() AND isfull=0"
    );
    $statement->execute([$idDeparturePort]);

    $result = $statement->fetch();

    return $result['nbrCruises'];
}


public function createCruise(array $input)
{

    $shipID = $input['shipID'];
    $pic = $input['pic'];
    $nbrNights = $input['nbrNights'];
    $departurePort = $input['departurePortID'];
    $departureDate = $input['departureDate'];
    $minPrice = $input['minPrice'];

    $statement1 = $this->connectiondb->getConnection()->prepare(
        "INSERT INTO `cruise`(`ship`, `pic`, `nbrNights`, `departurePort`, `departureDate`, `minPrice`) VALUES (?,?,?,?,?,?)"
    );
    
    $statement1->execute([$shipID, $pic, $nbrNights, $departurePort, $departureDate, $minPrice]);
    
    $statement2 = $this->connectiondb->getConnection()->prepare(
        "SELECT MAX(id) as insertedId FROM `cruise`"
    );
    
    $statement2->execute();
    $row = $statement2->fetch();

    return ($row['insertedId']);
}

public function modifyCruisePic(string $cruiseId, array $input)
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

public function modifyCruise(string $cruiseId, array $input)
{
    $shipID = $input['shipID'];
    $pic = $input['pic'];
    $nbrNights = $input['nbrNights'];
    $departurePort = $input['departurePortID'];
    $departureDate = $input['departureDate'];
    $minPrice = $input['minPrice'];
    

    $statement = $this->connectiondb->getConnection()->prepare(

        "UPDATE `cruise` SET `ship`='$shipID',`pic`='$pic', `nbrNights`='$nbrNights',`departurePort`='$departurePort',`departureDate`='$departureDate',`minPrice`='$minPrice' WHERE id= ?"
    );

    $affectedLines =  $statement->execute([$cruiseId]);

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

public function getStats(){

    $stats = [];

    $statement1 = $this->connectiondb->getConnection()->prepare(
        "SELECT COUNT(`id`) as nbrCr FROM `cruise`"
    );

    $statement1->execute([]);

    $result = $statement1->fetch();
    
    $stats['nbrCr'] = $result['nbrCr'];

    $statement2 = $this->connectiondb->getConnection()->prepare(
        "SELECT COUNT(`id`) as nbrFCr FROM `cruise` WHERE departureDate>NOW()"
    );

    $statement2->execute([]);

    $result = $statement2->fetch();
    
    $stats['nbrFCr'] = $result['nbrFCr'];


    return $stats;

}



}