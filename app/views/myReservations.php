<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <script
    src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
    crossorigin="anonymous"></script>


    <title>Mes reservations</title>

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
            <li class="nav-item">
                <a class="nav-link text-dark" href="#">Mes Reservations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="/cruises/public/auth/logout">Log Out</a>
            </li>
        </ul>
  </div>
</nav>

<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Photo de la croisière</th>
      <th scope="col">Port de départ</th>
      <th scope="col">Date de départ</th>
      <th scope="col">Réservée le </th>
      <th scope="col">Prix de réservation ($)</th>
      <th scope="col">Numéro de chambre</th>
      <th scope="col">Annuler</th>
    </tr>
  </thead>
  <tbody id="reservs">
    <?php
    $reservations = $data[0];
        foreach($reservations as $reservation){
    ?>
    <tr>
        <th scope="row"><img src="<?='/cruises/public/uploads/'.$reservation->cruisePic?>" style="height:32px;width:32px;" alt=""></th>
        <td><?=$reservation->departurePort?></td>
        <td><?=$reservation->departureDate?></td>
        <td><?=$reservation->reservationDate?></td>
        <td><?=$reservation->reservationPrice?></td>
        <td><?=$reservation->roomNbr?></td>
        <td><i id="<?=$reservation->id?>" class="cancelRes bi bi-x"></i></td>
    </tr>
    <?php
        }
    ?>
  </tbody>
</table>


<!--bootstrap JS Import-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="/cruises/public/js/reservations.js" ></script>
</body>
</html>





