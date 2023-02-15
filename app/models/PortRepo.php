<?php


spl_autoload_register(function($class){

        require_once('../app/lib/'.$class.'.php');
   
});


class PortRepo
{

    public DatabaseConnection $connectiondb;


    public function getPortName($idPort):string
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `name`, `country` FROM `port` WHERE `id`=?"
        );
        $statement->execute([$idPort]);

        $row = $statement->fetch();

        $portName = $row['name'].', '.$row['country'];

        return $portName;

    }


    public function getPorts():array
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `id`, `name`, `country` FROM `port` WHERE 1"
        );

        $statement->execute();

        $results = $statement->fetchAll();

        return $results;
    }

    public function getPort($identifier){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `id`, `name`, `country` FROM `port` WHERE id=?"
        );

        $statement->execute([$identifier]);

        $result = $statement->fetch();


        return $result;
    }


    public function addPort(array $input){

        $namePort = $input['namePort'];
        $country = $input['country'];

        $statement = $this->connectiondb->getConnection()->prepare(
            "INSERT INTO `port`(`name`, `country`) VALUES (?,?)"
        );
        
        $affectedLines = $statement->execute([$namePort, $country]);

        return ($affectedLines > 0);

    }


    public function getDiffPorts(string $portId){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `id`, `name`, `country` FROM `port` WHERE id!=?"
        );

        $statement->execute([$portId]);

        $results = $statement->fetchAll();


        return $results;
    }


    public function modifyPort(string $idPort, array $input)
   {

    $namePort = $input['namePort'];
    $country = $input['country'];

    $statement = $this->connectiondb->getConnection()->prepare(

        "UPDATE `port` SET `name`=? ,`country`=? WHERE id=?"
    );
    
    $affectedLines = $statement->execute([$namePort, $country, $idPort]);

    return ($affectedLines > 0);
  }

    public function deletePort(string $idPort)
    {

        $statement = $this->connectiondb->getConnection()->prepare(
            "DELETE FROM `port` WHERE id = ?"
        );
        
        $affectedLines = $statement->execute([$idPort]);

        return ($affectedLines > 0);

    }

}