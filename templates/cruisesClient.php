<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="templates/styles/style.css">

    <script src="templates/js/index.js"></script>
    
    <title>Cruises</title>
</head>
<body>





<nav class="navbar navbar-expand-md bg-dark bg-transparent navbar-dark fixed-top" id="mynav">
    <div class="container">
        <a class="navbar-brand text-uppercase fw-bold" href="index.php">
            <span class="bg-dark px-2 py-1 rounded-3 text-light">Ship</span>
            <span class="text-dark"> Cruise</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <ul class="collapse navbar-collapse justify-content-end fw-bold" id="navbarNav" style="list-style: none;">
            <li class="nav-item active">
                <a class="nav-link text-dark" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="index.php?action=cruises">Croisières</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="index.php?action=myReservations">My Reservation</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="index.php?action=logout">Log Out</a>
            </li>
        </ul>
  </div>
</nav>


<center style="position: absolute;bottom:0px;left:0px;">

      <select 
      name="portID" 
      id="portName" 
      required>
              <option value=""></option>
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
              <option value=""></option>
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
              <option value=""></option>
              <?php
                  for($i=1;$i<=12;$i++){
              ?>
              <option  value="<?=$i?>"><?=$i?></option>
              <?php
              }
              ?>
      </select>
</center>


<div class="cruises container">
    <h2 class="cruises__title">Démarrent bien<span>tot</span> </h2>
    <div class="row">
        <?php
        foreach($cruises as $cruise){?>
        <div class="card col-12 col-md-6 col-lg-4 col-xl-3 item">
            <img src="uploads/<?=$cruise->pic?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?=$cruise->departurePort?></h5>
                <p class="card-text">A partir de <?= $cruise->minPrice?></p>
                <a href="index.php?action=cruise&id=<?=$cruise->id?>" class="btn btn-primary item__btn" >Je reserve ma place</a>
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