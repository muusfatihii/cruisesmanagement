<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    
    <title>Document</title>
</head>
<body>

<nav class="navbar navbar-expand-md bg-dark bg-transparent navbar-dark" id="mynav">
    <div class="container">
        <a class="navbar-brand text-uppercase fw-bold" href="/cruises/public">
            <span class="bg-dark px-2 py-1 rounded-3 text-light">Ship</span>
            <span class="text-dark"> Cruise</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <ul class="collapse navbar-collapse justify-content-end fw-bold" id="navbarNav" style="list-style: none;">
            <li class="nav-item active">
                <a class="nav-link text-dark" href="/cruises/public">Home</a>
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




<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Nom</th>
      <th scope="col">Nombre de chambres</th>
      <th scope="col">Nombre de places</th>
      <th scope="col">Modifier</th>
      <th scope="col">Supprimer</th>
    </tr>
  </thead>
  <tbody id="ships">

    <?php
        $ships = $data;

        foreach($ships as $ship){
        
    ?>
    <tr>
        <td><?=$ship->name?></td>
        <td><?=$ship->nbrRooms?></td>
        <td><?=$ship->nbrPlaces?></td>
        <td><a href="/cruises/public/page/modifyship/<?=$ship->id?>"><i class="bi bi-x"></i></a></td>
        <td><i id="<?=$ship->id?>" class="deleteShip bi bi-x"></i></td>
    </tr>
    <?php
        }
    ?>
    
  </tbody>
</table>
        
<script src="/cruises/public/js/deleteShip.js" ></script>
</body>
</html>


