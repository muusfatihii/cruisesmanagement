<?php

require_once('src/lib/DatabaseConnection.php');

spl_autoload_register(function($class){
    if (file_exists('src/model/'.$class.'.php')){
        require_once('src/model/'.$class.'.php');
    }
    
    
});


class PortController{


    public function addPort(array $input)
   {
    $connectiondb = new DatabaseConnection();

    $portRepo = new PortRepository();
    $portRepo->connectiondb = $connectiondb;


    if (empty($input['namePort']) || empty($input['country'])) {
        
        throw new Exception('Les données du formulaire sont invalides.');

        
    }

    $success = $portRepo->addPort($input);

    if (!$success) {

        throw new Exception("Impossible d\'ajouter le port !");

    } else {

        header('Location: index.php');
    }

   }


   public function modifyPort(string $idPort, array $input)
   {
    $connectiondb = new DatabaseConnection();

    $portRepo = new PortRepository();
    $portRepo->connectiondb = $connectiondb;


    if (empty($input['namePort']) || empty($input['country'])) {
        
        throw new Exception('Les données du formulaire sont invalides.');

        
    }

    $success = $portRepo->modifyPort($idPort,$input);

    if (!$success) {

        throw new Exception("Impossible de modifier le port !");

    } else {

        header('Location: index.php');
    }

   }



   public function deletePort(string $identifier)
   {

    $connectiondb = new DatabaseConnection();

    $portRepo = new PortRepository();
    $portRepo->connectiondb = $connectiondb;


    $success = $portRepo->deletePort($identifier);

    if (!$success) {

        throw new Exception("Impossible de supprimer le port !");

    } else {

        header('Location: index.php');
    }

   }
}