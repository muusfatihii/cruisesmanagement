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

<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col"><i class="bi bi-image"></i></th>
      <th scope="col"><i class="bi bi-flag"></i></th>
      <th scope="col"><i class="bi bi-water"></i></th>
      <th scope="col"><i class="bi bi-moon-stars"></i></th>
      <th scope="col"><i class="bi bi-cash"></i></th>
      <th scope="col"><i class="bi bi-calendar"></i></th>
      <th scope="col"><i class="bi bi-gear"></i></th>
      <th scope="col"><i class="bi bi-trash3"></i></th>
    </tr>
  </thead>
  <tbody id="cruises">
    <?php
        $cruises = $data;
        foreach($cruises as $cruise){
    ?>
    <tr>
        <th scope="row"><img src="<?='/cruises/public/uploads/'.$cruise->pic?>" style="height:32px;width:32px;" alt=""></th>
        <td><?=$cruise->departurePort?></td>
        <td><?=$cruise->ship?></td>
        <td><?=$cruise->nbrNights?></td>
        <td><?=$cruise->minPrice?></td>
        <td><?=$cruise->departureDate?></td>
        <td><a href="/cruises/public/page/modifycruise/<?=$cruise->id?>"><i class="bi bi-gear"></i></a></td>
        <td><i id="<?=$cruise->id?>" class="cancelCruise bi bi-trash3"></i></td>
    </tr>
    <?php
        }
    ?>
  </tbody>
</table>

<div class="row col-2 mx-auto my-2 color-orange">

<button class="btn btn-primary" type="button" id="loadMoreBtn">More</button>

</div>

  
  <script src="/cruises/public/js/loadMoreCruises.js"></script>

</body>
</html>


