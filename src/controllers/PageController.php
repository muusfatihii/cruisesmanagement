<?php

require_once('src/lib/DatabaseConnection.php');

spl_autoload_register(function($class){

    if (file_exists('src/model/'.$class.'.php')){
        require_once('src/model/'.$class.'.php');

    }
    
});


class PageController{

    function aboutPage(){



        require('templates/aboutpage.php');
    }

    function addPage(){

    
    
        require_once ('templates/additem.php');
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


            $destination->pic = $result['pic'];
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

        $cruises = $cruiseRepo->getRecentCruises();

        require ('templates/clienthomepage.php');
    }

    function adminhomepage()
    {

        $connectiondb = new DatabaseConnection();

        $cruiseRepo = new CruiseRepository();
        $cruiseRepo->connectiondb = $connectiondb;

        $cruises = $cruiseRepo->getRecentCruises();

        require ('templates/adminhomepage.php');
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
        require('templates/error.php');
    }

}


