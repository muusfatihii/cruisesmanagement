<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/footer.css">
    
    <title>Ship Cruise</title>

</head>
<body>


<nav class="navbar navbar-expand-md bg-dark bg-transparent navbar-dark fixed-top" id="mynav">
    <div class="container">
        <a class="navbar-brand text-uppercase fw-bold" href="#">
            <span class="bg-dark px-2 py-1 rounded-3 text-light">Ship</span>
            <span class="text-dark"> Cruise</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <ul class="collapse navbar-collapse justify-content-end fw-bold" id="navbarNav" style="list-style: none;">
            <li class="nav-item active">
                <a class="nav-link text-dark" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="cruise/all/1">Croisières</a>
            </li>
            <?php if(isset($_SESSION['idClient'])):?>
            <li class="nav-item">
                <a class="nav-link text-dark" href="reservation/show">Mes Reservations</a>
            </li>
            <?php endif;?>
            <?php if(isset($_SESSION['admin']) && $_SESSION['admin']==1):?>
            <li class="nav-item">
                <a class="nav-link text-dark" href="/cruises/public/page/dashboard">Dashboard</a>
            </li>
            <?php endif;?>
            <?php if((isset($_SESSION['admin']) && $_SESSION['admin']=1) || (isset($_SESSION['idClient']))):?>
            <li class="nav-item">
                <a class="nav-link text-dark" href="auth/logout">Log out</a>
            </li>
            <?php else:?>
            <li class="nav-item">
                <a class="nav-link text-dark" href="page/signup">Sign Up</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="page/signin">Sign In</a>
            </li>
            <?php endif;?>
        </ul>
  </div>
</nav>


<section>
    <div class="imgBack">
        <h3 class="imgBack__title">If you are into <span>Seas & Oceans</span><br>What are you still waiting for?<br><a href="/cruises/public/cruise/all/1" style="text-decoration: none;"><span class="bg-white bg-gradient rounded-2">Join us</span></a> on this journey</h3>
    </div>
</section>


<div class="cruises container">
    <h2 class="cruises__title">Démarrent bien<span>tôt</span> </h2>
    <div class="row">
        <?php
        $cruises = $data[0];
        foreach($cruises as $cruise){
        ?>
        <div class="card col-12 col-md-6 col-lg-4 col-xl-3 item">
            <img src="uploads/<?=$cruise->pic?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?=$cruise->departurePort?>, Le <?=$cruise->departureDate?></h5>
                <p class="card-text"><?=$cruise->nbrNights?> Nuits à partir de <strong><?=$cruise->minPrice?>$</strong> chacune</p>
                <?php if(isset($_SESSION['admin']) && $_SESSION['admin']=1):?>
                <a href="/cruises/public/cruise/description/<?=$cruise->id?>" class="btn btn-primary item__btn">More infos</a>
                <?php elseif(isset($_SESSION['idClient'])):?>
                <a href="/cruises/public/cruise/description/<?=$cruise->id?>" class="btn btn-primary item__btn">Je reserve ma place</a>
                <?php else:;?>
                <a href="/cruises/public/page/signin" class="btn btn-primary item__btn">Je reserve ma place</a>
                <?php endif;?>
            </div>
        </div>
        <?php
        }
        ?>
        

    </div>


    <div class="cruises container">
        <h2 class="cruises__title"><span>Nos</span> départs</h2>
        <div class="row">

            <?php
            $destinations = $data[1];
            foreach($destinations as $destination){

            ?>

            <div class="card col-12 col-md-6 col-lg-4 col-xl-3 item">
                <img src="https://picsum.photos/300/150?random=1" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?=$destination->name?></h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary item__btn">Prochaine date</a>
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






