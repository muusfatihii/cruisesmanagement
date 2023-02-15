<?php


spl_autoload_register(function($class){

    require_once('../app/lib/'.$class.'.php');

});


class RoomTypeRepo{

    public DatabaseConnection $connectiondb;



    public function getRoomTypesInfos(){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `id`,`name` FROM `roomtype` WHERE 1"
        );

        $statement->execute();

        $results = $statement->fetchAll();

        return $results;
    }

}