<?php


spl_autoload_register(function($class){

        require_once('../app/lib/'.$class.'.php');
   
});


class ItineraryRepo
{

    public DatabaseConnection $connectiondb;
    
    public function getItinerary($cruiseId)
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `port` FROM `itinerary` WHERE `cruiseId`=?"
        );

        $statement->execute([$cruiseId]);
    
        $row = $statement->fetchAll();

        return $row;

    }

    public function addItinerary($cruiseId,$portsIds){

        $nbrPorts = count($portsIds);

        for($i=0;$i<$nbrPorts;$i++){

            $statement = $this->connectiondb->getConnection()->prepare(
                "INSERT INTO `itinerary` (`cruiseId`, `port`) VALUES (?,?)"
            );

            $statement->execute([$cruiseId, $portsIds[$i]]);


        }
        
    }

    public function modifyItinerary($cruiseId,$portsIds){

        $nbrPorts = count($portsIds);



        $statement1 = $this->connectiondb->getConnection()->prepare(
            "DELETE FROM `itinerary` WHERE cruiseId=?"
        );

        $statement1->execute([$cruiseId]);


        for($i=0;$i<$nbrPorts;$i++){

            $statement2 = $this->connectiondb->getConnection()->prepare(
                "INSERT INTO `itinerary` (`cruiseId`, `port`) VALUES (?,?)"
            );

            $statement2->execute([$cruiseId, $portsIds[$i]]);


        }
        
    }


}