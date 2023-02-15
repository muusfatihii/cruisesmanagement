<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="/cruises/public/css/style.css">
    <link rel="stylesheet" href="/cruises/public/css/footer.css">

    <script
    src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
    crossorigin="anonymous"></script>

    <script src="/cruises/public/js/filter.js"></script>

    <title>Cruises</title>

</head>
<body>

<nav class="navbar navbar-expand-md bg-dark bg-transparent navbar-dark" id="mynav">
    <div class="container">
        <a class="navbar-brand text-uppercase fw-bold" href="/cruises/public/">
            <span class="bg-dark px-2 py-1 rounded-3 text-light">Ship</span>
            <span class="text-dark"> Cruise</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <ul class="collapse navbar-collapse justify-content-end fw-bold" id="navbarNav" style="list-style: none;">
            <li class="nav-item active">
                <a class="nav-link text-dark" href="/cruises/public/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="/cruises/public/cruise/all/1">Croisières</a>
            </li>
            <?php if(isset($_SESSION['idClient'])):?>
            <li class="nav-item">
                <a class="nav-link text-dark" href="/cruises/public/reservation/show">Mes Reservations</a>
            </li>
            <?php endif;?>
            <?php if(isset($_SESSION['admin']) && $_SESSION['admin']==1):?>
            <li class="nav-item">
                <a class="nav-link text-dark" href="/cruises/public/page/dashboard">Dashboard</a>
            </li>
            <?php endif;?>
            <?php if((isset($_SESSION['admin']) && $_SESSION['admin']=1) || (isset($_SESSION['idClient']))):?>
            <li class="nav-item">
                <a class="nav-link text-dark" href="/cruises/public/auth/logout">Log out</a>
            </li>
            <?php else:?>
            <li class="nav-item">
                <a class="nav-link text-dark" href="/cruises/public/page/signup">Sign Up</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="/cruises/public/page/signin">Sign In</a>
            </li>
            <?php endif;?>
        </ul>
  </div>
</nav>



<?php
$cruises = $data[0];
$ports = $data[1];
$ships = $data[2];
?>

<div style="margin-left: 20px;margin-top: 60px;">

      <select 
      name="portID" 
      id="portName" 
      
      required>
              <option value="">Port</option>
              <?php
            
                  foreach($ports as $port){
              ?>
              <option  value="<?=$port->id;?>"><?=$port->name; ?></option>
              <?php
              }
              ?>
      </select>
      <select 
      name="shipID" 
      id="shipName" 
      required>
              <option value="">Navire</option>
              <?php
                  foreach($ships as $ship){
              ?>
              <option  value="<?=$ship->id;?>"><?=$ship->name; ?></option>
              <?php
              }
              ?>
      </select>

      <select 
      name="departureMonth" 
      id="departureMonth" 
      required>
              <option value="">Mois</option>
              <?php
                  for($i=1;$i<=12;$i++){
              ?>
              <option  value="<?=$i?>"><?=$i?></option>
              <?php
              }
              ?>
      </select>

    </div>




<div class="cruises container">
    <h2 class="cruises__title">Démarrent bien<span>tôt</span> </h2>
    <div class="row" id="cruises">

       <?php
        foreach($cruises as $cruise){?>
        <div class="card col-12 col-md-6 col-lg-4 col-xl-3 item">
            <img src="/cruises/public/uploads/<?=$cruise->pic?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?=$cruise->departurePort?></h5>
                <p class="card-text">A Partir de <strong><?=$cruise->minPrice?></strong></p>
                
                <?php if(isset($_SESSION['idClient'])):?>

                    <a href="/cruises/public/cruise/description/<?=$cruise->id?>" class="btn btn-primary item__btn" >Je reserve ma place</a>

               <?php elseif(isset($_SESSION['admin']) && $_SESSION['admin']=1):?>

                    <a href="/cruises/public/cruise/description/<?=$cruise->id?>" class="btn btn-primary item__btn" >More Infos</a>

               <?php else:?>
                    
                    <a href="/cruises/public/page/signin" class="btn btn-primary item__btn" >Je reserve ma place</a>

               <?php endif;?>

            </div>
        </div>

        <?php
        }
        ?>

    </div>
</div>

<!--bootstrap JS Import-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>