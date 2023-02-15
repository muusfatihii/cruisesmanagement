<?php


spl_autoload_register(function($class){

    require_once('../app/lib/'.$class.'.php');

});

class Home extends Controller{

    public function index($params=[]){
        
       
       $connectiondb = new DatabaseConnection();

       $cruises = $this->getCruises($connectiondb);

       $destinations = $this->getDestinations($connectiondb);
       
       $data = [];
       $data[]=$cruises;
       $data[]=$destinations;

       $this->view('home/index',$data);

    } 


    public function getCruises(DatabaseConnection $connectiondb):array
    {

        $cruiseRepo = $this->model('CruiseRepo');
        $cruiseRepo->connectiondb = $connectiondb;


        $portRepo = $this->model('PortRepo');
        $portRepo->connectiondb = $connectiondb;


        // Getting Cruises

        $results = $cruiseRepo->getCruisesHome();


        $cruises = [];

        foreach ($results as $result) {

        $cruise = new Cruise();

        $cruise->id = $result['id'];
        $cruise->pic = $result['pic'];
        $cruise->nbrNights = $result['nbrNights'];
        $cruise->departurePort = $portRepo->getPortName($result['departurePort']);
        $cruise->departureDate = $result['departureDate'];
        $cruise->minPrice = $result['minPrice'];
        
        $cruises[] = $cruise;

        }
        //End Getting Cruises

        return $cruises;

    }



    public function getDestinations(DatabaseConnection $connectiondb):array
    {

        //Get Destinations
        
        $portRepo = new PortRepo();
        $portRepo->connectiondb = $connectiondb;
        
        $results = $portRepo->getPorts(); 

        $destinations = [];

        foreach($results as $result){

            $destination = new Destination();

            $destination->name = $result['name'].', '.$result['country'];

            $destinations [] = $destination;

        }
        //End Getting Destinations

        return $destinations;

    }

}
