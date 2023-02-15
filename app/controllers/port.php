<?php

spl_autoload_register(function($class){

    require_once('../app/lib/'.$class.'.php');

});


class Port extends Controller{


    public function add($params=[]){

        $connectiondb = new DatabaseConnection();

        $portRepo = $this->model('PortRepo');
        $portRepo->connectiondb = $connectiondb;


        if (empty($_POST['namePort']) || empty($_POST['country'])) {
            
            throw new Exception('Les données du formulaire sont invalides.');

            
        }

        $success = $portRepo->addPort($_POST);

        if (!$success) {

            throw new Exception("Impossible d\'ajouter le port !");

        } else {

            header('Location: /cruises/public/page/portsdet');

        }


    }

    public function modify($params=[]){


        $idPort = $_POST['idPort'];



        $connectiondb = new DatabaseConnection();

        $portRepo = $this->model('PortRepo');
        $portRepo->connectiondb = $connectiondb;


        if (empty($_POST['namePort']) || empty($_POST['country'])) {
            
            throw new Exception('Les données du formulaire sont invalides.');

            
        }

        $success = $portRepo->modifyPort($idPort,$_POST);

        if (!$success) {

            throw new Exception("Impossible de modifier le port !");

        } else {

            header('Location: /cruises/public/page/portsdet');
        }

    }


    public function delete($params=[]){

        $idPort = $_POST['idPort'];

        $connectiondb = new DatabaseConnection();

        $portRepo = $this->model('PortRepo');
        $portRepo->connectiondb = $connectiondb;

        $portRepo->deletePort($idPort);

        $ports = $portRepo->getPorts();

        echo json_encode($ports);

        exit();

    }


    

}