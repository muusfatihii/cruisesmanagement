<?php



require_once('src/lib/DatabaseConnection.php');
spl_autoload_register(function($class){
    if (file_exists('src/model/'.$class.'.php')){
        require_once('src/model/'.$class.'.php');
    }
    
    
});





class CruiseController{




    public function addImage(array $picture){

        $new_img_name = "default.png";
    
        if(isset($picture) && !empty($picture)){
    
            $picname=$picture['name'];
            $pictmpname=$picture['tmp_name'];
    
    
    
            if($picture['size']>1000000){
                $em = "sorry your file is too large";
                header("Location: index.php?action=addPage&error=$em");
            }else{
                $img_ex = pathinfo($picname, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
        
                $allowed_exs=array("jpg","jpeg","png");
        
                if(in_array($img_ex_lc,$allowed_exs)){
        
                    $new_img_name=uniqid("IMG-",true).'.'.$img_ex_lc;
                    $img_upload_path='uploads/'.$new_img_name;
                    move_uploaded_file($pictmpname,$img_upload_path);
                }else{
        
                    $em="only jpg,jpeg,png extensions are allowed";
                    header("Location: index.php?action=addPage&error=$em");
                }
            }
        }
    
        return $new_img_name;
    
    }




    public function cruises()
  {
    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;

    $shipRepo = new ShipRepository();
    $shipRepo->connectiondb = $connectiondb;

    $portRepo = new PortRepository();
    $portRepo->connectiondb = $connectiondb;



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


    require('templates/cruisesUser.php');

  }

  public function cruisesClient(){

    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;



    $cruises = $cruiseRepo->getCruises();


    require('templates/cruisesClient.php');


  }


   public function cruisesAdmin()
  {
    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;



    $cruises = $cruiseRepo->getCruises();



    require('templates/cruisesAdmin.php');

  }

  public function modifyImage(array $picture){

    $new_img_name = "";


    if(isset($picture) && !empty($picture)){

        $picname=$picture['name'];
        $pictmpname=$picture['tmp_name'];



        if($picture['size']>100000000){
            $em = "sorry your file is too large";
            header("Location: add.php?error=$em");
        }else{
            $img_ex = pathinfo($picname, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
    
            $allowed_exs=array("jpg","jpeg","png");
    
            if(in_array($img_ex_lc,$allowed_exs)){
    
                $new_img_name=uniqid("IMG-",true).'.'.$img_ex_lc;
                $img_upload_path='uploads/'.$new_img_name;
                move_uploaded_file($pictmpname,$img_upload_path);
            }else{
    
                $em="only jpg,jpeg,png extensions are allowed";
                header("Location: add.php?error=$em");
            }
        }
    }

    return $new_img_name;

}


public function modifyCruise(string $identifier, array $input, array $pic)
{
    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;


    if (empty($input['name']) || empty($input['price']) || empty($input['quantity']) || empty($input['idCategory'])) {
        
        throw new Exception('Les données du formulaire sont invalides.');
    } 

    if($this->modifyImage($pic)!=""){
        $input['pic'] = $this->modifyImage($pic);
        $success = $cruiseRepo->modifyCruisePic($identifier, $input);
    }else{
        $success = $cruiseRepo->modifyCruise($identifier, $input);
    }
    
    if (!$success) {
        throw new Exception("Impossible de modifier l'article !");
    } else {
        header('Location: index.php?action=items&user=admin');
    }
}

public function cruise(string $identifier)
{
    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;

    $shipRepo = new ShipRepository();
    $shipRepo->connectiondb = $connectiondb;

    $portRepo = new PortRepository();
    $portRepo->connectiondb = $connectiondb;




    $result = $cruiseRepo->getCruise($identifier);

    $cruise = new Cruise();

    $cruise->id = $result['id'];
    $cruise->ship = $shipRepo->getShipName($result['ship']);
    $cruise->pic = $result['pic'];
    $cruise->nbrNights = $result['nbrNights'];
    $cruise->departurePort = $portRepo->getPortName($result['departurePort']);
    $cruise->departureDate = $result['departureDate'];
    $cruise->minPrice = $result['minPrice'];

    require('templates/itemDescription.php');
}


public function filterCruises(string $idcategory)
{
    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;

    


    $cruises = $cruiseRepo->getfilteredCruises($idcategory);

    require('templates/galleryuser.php');


}



public function filterCruisesAdmin(string $idcategory)
{
    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;



    $cruises = $cruiseRepo->getfilteredCruises($idcategory);
    
    require('templates/galleryadmin.php');


}

public function deleteCruise(string $identifier)
{
    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;

    $success = $cruiseRepo->deleteCruise($identifier);

    if (!$success) {
        throw new Exception("Impossible de supprimer la croisière !");
    } else {
        header('Location: index.php?action=items&user=admin');
    }

}


public function addCruise(array $input, array $pic)
{
    $connectiondb = new DatabaseConnection();

    $cruiseRepo = new CruiseRepository();
    $cruiseRepo->connectiondb = $connectiondb;

    if (!empty($input['shipID']) && !empty($input['nbrNights']) && !empty($input['departurePortID']) && !empty($input['departureDate'])) {
        
        $shipRepo = new ShipRepository();
        $shipRepo->connectiondb = $connectiondb;

        $input['minPrice'] = $shipRepo->minPrice($input['shipID']);

        $input['pic'] = $this->addImage($pic);
        
    } else {

        throw new Exception('Les données du formulaire sont invalides.');
    }

    $success = $cruiseRepo->createCruise($input);
    
    if (!$success) {

        throw new Exception("Impossible d\'ajouter la croisière !");

    } else {

        header('Location: index.php?action=addCruise');
    }
}




}