<?php


class RoomTypeRepository{



    public function getRoomTypesInfos(){

        $statement = $this->connectiondb->getConnection()->prepare(
            "SELECT `id`,`name` FROM `roomtype` WHERE 1"
        );

        $statement->execute();

        $results = $statement->fetchAll();


        return $results;
    }

}