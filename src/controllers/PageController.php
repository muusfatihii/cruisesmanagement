<?php

require_once('src/lib/DatabaseConnection.php');
require_once('src/lib/Port.php');
require_once('src/lib/Ship.php');

spl_autoload_register(function($class){

    if (file_exists('src/model/'.$class.'.php')){
        require_once('src/model/'.$class.'.php');

    }
    
});


class PageController{

    function aboutPage(){

        require('templates/aboutpage.php');
    }

    function addShipPage(){
        
        require ('templates/addShip.php');
    }

    function addPortPage(){
        require ('templates/addPort.php');
    }

    function homepage()
    {

        $connectiondb = new DatabaseConnection();

        $cruiseRepo = new CruiseRepository();
        $cruiseRepo->connectiondb = $connectiondb;

        $shipRepo = new ShipRepository();
        $shipRepo->connectiondb = $connectiondb;

        $portRepo = new PortRepository();
        $portRepo->connectiondb = $connectiondb;

        //get Cruises
        $results = $cruiseRepo->getCruises();


        $cruises = [];

        foreach ($results as $result) {

        $cruise = new Cruise();

        $cruise->id = $result['id'];

        $cruise->ship = $shipRepo->getShipName($result['ship']);
        $cruise->pic = $result['pic'];
        $cruise->nbrNights = $result['nbrNights'];
        $cruise->departurePort = $portRepo->getPortName($result['departurePort']);
        $cruise->departureDate = $result['departureDate'];
        $cruise->minPrice = $result['minPrice'];
        
        $cruises[] = $cruise;

        }
       
        //get Destinations
        $results = $cruiseRepo->getDestinations();


        $portRepo = new PortRepository();
        $portRepo->connectiondb = $connectiondb;

        $destinations = [];

        foreach($results as $result){

            $destination = new Destination();

            // $destination->pic = $result['pic'];
            $destination->name = $portRepo->getPortName($result['departurePort']);

            $destinations [] = $destination;

        }

        require ('templates/homepage.php');
    }

    function clienthomepage()
    {

        $connectiondb = new DatabaseConnection();

        $cruiseRepo = new CruiseRepository();
        $cruiseRepo->connectiondb = $connectiondb;

        $shipRepo = new ShipRepository();
        $shipRepo->connectiondb = $connectiondb;

        $portRepo = new PortRepository();
        $portRepo->connectiondb = $connectiondb;

        //get Cruises
        $results = $cruiseRepo->getCruises();


        $cruises = [];

        foreach ($results as $result) {

        $cruise = new Cruise();

        $cruise->id = $result['id'];

        $cruise->ship = $shipRepo->getShipName($result['ship']);
        $cruise->pic = $result['pic'];
        $cruise->nbrNights = $result['nbrNights'];
        $cruise->departurePort = $portRepo->getPortName($result['departurePort']);
        $cruise->departureDate = $result['departureDate'];
        $cruise->minPrice = $result['minPrice'];
        

        $cruises[] = $cruise;
       }
       
        //get Destinations
        $results = $cruiseRepo->getDestinations();


        $portRepo = new PortRepository();
        $portRepo->connectiondb = $connectiondb;


        $destinations = [];

        foreach($results as $result){

            $destination = new Destination();


            // $destination->pic = $result['pic'];
            $destination->name = $portRepo->getPortName($result['departurePort']);

            $destinations [] = $destination;

        }

        require ('templates/clienthomepage.php');
    }

    function adminhomepage()
    {

        $connectiondb = new DatabaseConnection();

        $cruiseRepo = new CruiseRepository();
        $cruiseRepo->connectiondb = $connectiondb;

        $shipRepo = new ShipRepository();
        $shipRepo->connectiondb = $connectiondb;

        $portRepo = new PortRepository();
        $portRepo->connectiondb = $connectiondb;

        //get Cruises
        $results = $cruiseRepo->getCruisesAdmin();


        $cruises = [];

        foreach ($results as $result) {

        $cruise = new Cruise();

        $cruise->id = $result['id'];

        $cruise->ship = $shipRepo->getShipName($result['ship']);
        $cruise->pic = $result['pic'];
        $cruise->nbrNights = $result['nbrNights'];
        $cruise->departurePort = $portRepo->getPortName($result['departurePort']);
        $cruise->departureDate = $result['departureDate'];
        $cruise->minPrice = $result['minPrice'];
        

        $cruises[] = $cruise;
       }
       
        //get Destinations
        $results = $cruiseRepo->getDestinations();


        $portRepo = new PortRepository();
        $portRepo->connectiondb = $connectiondb;


        $destinations = [];

        foreach($results as $result){

            $destination = new Destination();


            // $destination->pic = $result['pic'];
            $destination->name = $portRepo->getPortName($result['departurePort']);

            $destinations [] = $destination;

        }

        require ('templates/adminhomepage.php');
    }



    function cruisesDashboard()
    {
        require ('templates/cruisesDashboard.php');
    }

    function portsDashboard()
    {
        require ('templates/portsDashboard.php');
    }

    function shipsDashboard(){

        require ('templates/shipsDashboard.php');

    }

    function adminDashboard()
    {

        require ('templates/adminDashboard.php');
    }


    function signinPage(string $em){

        require('templates/signinPage.php');
    }

    function signupPage(string $em){

        require('templates/signupPage.php');
    }


    function modifyPage(string $identifier){

        require_once ('templates/modifyitem.php');
    }


    function errorPage(Exception $e){

        $errorMessage = $e->getMessage();
        require ('templates/error.php');

    }


    function addCruisePage(){

        $connectiondb = new DatabaseConnection();

        //     Ports

        $portRepo = new PortRepository();
        $portRepo->connectiondb = $connectiondb;
        
        $results = $portRepo->getPorts();

        $ports = [];

        foreach($results as $result){

            $port = new Port();
            $port->id = $result['id'];
            $port->name = $result['name'];
            $port->country = $result['country'];

            $ports [] = $port;
        }

        //end ports

        //    ships

        $shipRepo = new ShipRepository();
        $shipRepo->connectiondb = $connectiondb;
        
        $results = $shipRepo->getShips();

        $ships = [];

        foreach($results as $result){

            $ship = new Ship();

            $ship->id = $result['id'];
            $ship->name = $result['name'];

            $ships [] = $ship;
        }


        //     end ships

        require_once ('templates/addCruise.php');

    }



    function modifyCruisePage($idCruise){


        $connectiondb = new DatabaseConnection();

        //     get Cruise Infos

        $cruiseRepo = new CruiseRepository();
        $cruiseRepo->connectiondb = $connectiondb;

        
        $result = $cruiseRepo->getCruise($idCruise);

        $cruise = new Cruise();

        $cruise->id = $result['id'];
        $cruise->nbrNights = $result['nbrNights'];
        $cruise->departureDate = $result['departureDate'];
        $cruise->minPrice = $result['minPrice'];

        //  ships 
        $shipRepo = new ShipRepository();
        $shipRepo->connectiondb = $connectiondb;


        $ship = new Ship();

        $ship->id = $result['ship'];

        $ship->name = $shipRepo->getShipName($result['ship']);


        $resultShips = $shipRepo->getDiffShips($result['ship']);

        $ships = [];

        foreach($resultShips as $resultSh){

            $othership = new Ship();

            $othership->id = $resultSh['id'];

            $othership->name = $resultSh['name'];

            $ships [] =  $othership;
        }


        //  ports
        $portRepo = new PortRepository();
        $portRepo->connectiondb = $connectiondb;


        $port = new Port();

        $port->id = $result['departurePort'];

        $port->name = $portRepo->getPortName($result['departurePort']);

        $resultPorts = $portRepo->getDiffPorts($result['departurePort']);

        $ports = [];

        foreach($resultPorts as $resultP){

            $otherport = new Port();

            $otherport->id = $resultP['id'];

            $otherport->name = $resultP['name'];

            $ports [] =  $otherport;
        }

        require_once ('templates/modifyCruise.php');

    }

}


