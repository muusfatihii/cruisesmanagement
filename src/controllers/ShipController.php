<?php

require_once('src/lib/DatabaseConnection.php');

spl_autoload_register(function($class){
    if (file_exists('src/model/'.$class.'.php')){
        require_once('src/model/'.$class.'.php');
    }
    
    
});


class ShipController{


    public function addShip(array $input)
   {
    $connectiondb = new DatabaseConnection();

    $shipRepo = new ShipRepository();
    $shipRepo->connectiondb = $connectiondb;


    if (empty($input['nameShip']) || empty($input['nbrRooms']) || empty($input['nbrPlaces'])) {
        
        throw new Exception('Les données du formulaire sont invalides.');

        
    }

    $success = $shipRepo->addShip($input);

    if (!$success) {

        throw new Exception("Impossible d\'ajouter le navire !");

    } else {

        header('Location: index.php');
    }

  }



  public function modifyShip(string $idShip, array $input)
   {
    $connectiondb = new DatabaseConnection();

    $shipRepo = new ShipRepository();
    $shipRepo->connectiondb = $connectiondb;


    if (empty($input['nameShip']) || empty($input['nbrRooms']) || empty($input['nbrPlaces'])) {
        
        throw new Exception('Les données du formulaire sont invalides.');

        
    }

    $success = $shipRepo->modifyShip($idShip,$input);

    if (!$success) {

        throw new Exception("Impossible de modifier le navire !");

    } else {

        header('Location: index.php');
    }

  }



  public function deleteShip(string $idShip)
   {
    $connectiondb = new DatabaseConnection();

    $shipRepo = new ShipRepository();
    $shipRepo->connectiondb = $connectiondb;


    $success = $shipRepo->deleteShip($idShip);

    if (!$success) {

        throw new Exception("Impossible de supprimer le navire !");

    } else {

        header('Location: index.php');
    }

  }
  
}