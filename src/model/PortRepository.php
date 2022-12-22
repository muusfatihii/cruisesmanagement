<?php



spl_autoload_register(function($class){
    if (file_exists('src/lib/'.$class.'.php')){
        require_once('src/lib/'.$class.'.php');
    }
    

});






class PortRepository
{

    public DatabaseConnection $connectiondb;


    public function getPortName($identifier){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `name`, `country` FROM `port` WHERE `id`=?"
        );
        $statement->execute([$identifier]);

        $row = $statement->fetch();

        $portName = $row['name'].', '.$row['country'];

        return $portName;

    }

}

