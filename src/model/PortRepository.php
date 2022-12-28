<?php



spl_autoload_register(function($class){
    if (file_exists('src/lib/'.$class.'.php')){
        require_once('src/lib/'.$class.'.php');
    }
    

});






class PortRepository
{

    public DatabaseConnection $connectiondb;



    public function getPorts(){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `id`, `name`, `country` FROM `port` WHERE 1"
        );

        $statement->execute();

        $results = $statement->fetchAll();


        return $results;
    }


    public function getDiffPorts(string $portId){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `id`, `name`, `country` FROM `port` WHERE id!=?"
        );

        $statement->execute([$portId]);

        $results = $statement->fetchAll();


        return $results;
    }


    public function getPortName($identifier){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `name`, `country` FROM `port` WHERE `id`=?"
        );
        $statement->execute([$identifier]);

        $row = $statement->fetch();

        $portName = $row['name'].', '.$row['country'];

        return $portName;

    }


    public function addPort(array $input)
   {

    $namePort = $input['namePort'];
    $country = $input['country'];

    $statement = $this->connectiondb->getConnection()->prepare(
        "INSERT INTO `port`(`name`, `country`) VALUES (?,?)"
    );
    $affectedLines = $statement->execute([$namePort, $country]);

    return ($affectedLines > 0);
  }


  public function modifyPort(string $idPort, array $input)
   {

    $namePort = $input['namePort'];
    $country = $input['country'];

    $statement = $this->connectiondb->getConnection()->prepare(

        "UPDATE `port` SET (`name`, `country`) VALUES (?,?) WHERE id=?"
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

