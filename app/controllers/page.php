<?php


spl_autoload_register(function($class){

    require_once('../app/lib/'.$class.'.php');

});


class Page extends Controller{


    public function signin($params=[]){
        

        $this->view('signinPage',[]);

    } 

    public function signup($params=[]){
        

        $this->view('signupPage',[]);

    }
    
    
    public function dashboard($params=[]){
        

        $this->view('dashboard',[]);

    }

    public function cruiseconfig($params=[]){
        

        $this->view('cruiseconfig',[]);

    }

    public function shipconfig($params=[]){
        

        $this->view('shipconfig',[]);

    }
    public function portconfig($params=[]){
        

        $this->view('portconfig',[]);

    }


    public function stats($params=[]){

        $connectiondb = new DatabaseConnection();

        $cruiseRepo = $this->model('CruiseRepo');

        $cruiseRepo->connectiondb = $connectiondb;

        $stats = $cruiseRepo->getStats();

        $this->view('stats',$stats);

    }

    public function addCruise($params=[]){


        $connectiondb = new DatabaseConnection();

        $ports = $this->getPorts($connectiondb);

        $ships = $this->getShips($connectiondb);

        $data = [];

        $data[] = $ports;
        $data[] = $ships;


        $this->view('addcruise',$data);

    }

    public function getPorts(DatabaseConnection $connectiondb):array
    {

        //Get ports
        
        $portRepo = $this->model('PortRepo');
        $portRepo->connectiondb = $connectiondb;
        
        $results = $portRepo->getPorts(); 

        $ports = [];

        foreach($results as $result){

            $port = new Port();
            
            $port->id = $result['id'];
            $port->name = $result['name'].'-'.$result['country'];

            $ports [] = $port;

        }
        //End Getting Ports

        return $ports;

    }

    public function getShips(DatabaseConnection $connectiondb):array
    {

        //Get ships
        
        $shipRepo = $this->model('ShipRepo');
        $shipRepo->connectiondb = $connectiondb;
        
        $results = $shipRepo->getShipsList(); 

        $ships = [];

        foreach($results as $result){

            $ship = new Ship();
            
            $ship->id = $result['id'];
            $ship->name = $result['name'];

            $ships [] = $ship;

        }
        //End Getting ships

        return $ships;

    }


    public function cruisesDet($params=[]){

        $connectiondb = new DatabaseConnection();

        $cruiseRepo = $this->model('CruiseRepo');
        $cruiseRepo->connectiondb = $connectiondb;
        

        $results = $cruiseRepo->getCruises(0,2);


        $cruises = $this->cruisesObj($results);


        $this->view('cruisesDet',$cruises);

    }

    public function modifycruise($params=[]){

        

        if($params>0){

            $idCruise = $params;

        }else{

            throw new Exception("id cruise non conforme");
        }


        $connectiondb = new DatabaseConnection();

        //     get Cruise Infos

        $cruiseRepo = $this->model('CruiseRepo');
        $cruiseRepo->connectiondb = $connectiondb;

        
        $result = $cruiseRepo->getCruise($idCruise);

        $cruise = new Cruise();

        $cruise->id = $result['id'];
        $cruise->nbrNights = $result['nbrNights'];
        $cruise->departureDate = $result['departureDate'];
        $cruise->minPrice = $result['minPrice'];

        //  ships 
        $shipRepo = $this->model('ShipRepo');
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
        $portRepo = $this->model('PortRepo');
        $portRepo->connectiondb = $connectiondb;


        $port = new Port();

        $port->id = $result['departurePort'];

        $port->name = $portRepo->getPortName($result['departurePort']);

        $resultPorts = $portRepo->getDiffPorts($result['departurePort']);

        $ports = [];

        foreach($resultPorts as $resultP){

            $otherport = new Port();

            $otherport->id = $resultP['id'];

            $otherport->name = $resultP['name'].', '.$resultP['country'];

            $ports [] =  $otherport;
        }


        //itinerary

        $itineraryRepo = $this->model('ItineraryRepo');
        $itineraryRepo->connectiondb = $connectiondb;

        $resultI = $itineraryRepo->getItinerary($idCruise);

        

        $Itinerary = [];

        for($i=0;$i<count($resultI);$i++){

            $it = new Itinerary();

            $it->idPort = $resultI[$i][0];
            $it->namePort = $portRepo->getPortName($resultI[$i][0]);

            $Itinerary[]=$it;

        }

        

        $data = [];

        $data[] = $cruise;
        $data[] = $ship;
        $data[] = $ships;
        $data[] = $port;
        $data[] = $ports;
        $data[] = $Itinerary;

        $this->view('modifycruise',$data);

    }

    private function cruisesObj($results){

        $cruises = [];
        
        $connectiondb = new DatabaseConnection();

        $shipRepo = $this->model('ShipRepo');
        $shipRepo->connectiondb = $connectiondb;
       

        $portRepo = $this->model('PortRepo');
        $portRepo->connectiondb = $connectiondb;

       for($i=0;$i<count($results);$i++)
       {

        $cruise = new Cruise();

        $cruise->id = $results[$i]['id'];
        $cruise->ship = $shipRepo->getShipName($results[$i]['ship']);
        $cruise->pic = $results[$i]['pic'];
        $cruise->minPrice = $results[$i]['minPrice'];
        $cruise->nbrNights = $results[$i]['nbrNights'];
        $cruise->departurePort = $portRepo->getPortName($results[$i]['departurePort']);
        $cruise->departureDate = $results[$i]['departureDate'];

        $cruises[]=$cruise;

       }

       return $cruises;

    }

    public function addShip(){

        $this->view('addship',[]);
    }

    public function shipsdet($params=[]){

        $connectiondb = new DatabaseConnection();

        $shipRepo = $this->model('ShipRepo');
        $shipRepo->connectiondb = $connectiondb;

        $ships=[];

        $results = $shipRepo->getShips();

        foreach($results as $result){

            $ship = new Ship();

            $ship->id = $result['id'];
            $ship->name = $result['name'];
            $ship->nbrRooms = $result['nbrRooms'];
            $ship->nbrPlaces = $result['nbrPlaces'];

            $ships[] = $ship;

        }

        $this->view('shipsDet',$ships);

    }

    public function addPort(){

        $this->view('addport',[]);
    }

    public function portsdet($params=[]){


        $connectiondb = new DatabaseConnection();

        $portRepo = $this->model('PortRepo');
        $portRepo->connectiondb = $connectiondb;

        $ports = [];

        $results = $portRepo->getPorts();

        foreach($results as $result){

            $port = new Port();

            $port->id = $result['id'];
            $port->name = $result['name'];
            $port->country = $result['country'];

            $ports [] = $port;


        }

        $this->view('portsDet',$ports);

    }

    public function modifyship($params=[]){

        $idship = $params;


        $connectiondb = new DatabaseConnection();


        $shipRepo = $this->model('ShipRepo');
        $shipRepo->connectiondb = $connectiondb;

        $result  = $shipRepo->getShip($idship);

        $ship = new Ship();
        
        $ship->id = $result['id'];
        $ship->name = $result['name'];
        $ship->nbrRooms = $result['nbrRooms'];
        $ship->nbrPlaces = $result['nbrPlaces'];

        $data [] = $ship;


        $this->view('modifyship',$data);


    }

    public function modifyport($params=[]){

        if($params>0){

            $idPort = $params;

        }else{


        }

        $connectiondb = new DatabaseConnection();


        $portRepo = $this->model('PortRepo');
        $portRepo->connectiondb = $connectiondb;

        $result  = $portRepo->getPort($idPort);

        $port = new Port();
        
        $port->id = $result['id'];
        $port->name = $result['name'];
        $port->country = $result['country'];

        $data [] = $port;
       
        $this->view('modifyport',$data);

    }



}