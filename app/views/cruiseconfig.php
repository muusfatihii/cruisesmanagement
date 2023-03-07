<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="/cruises/public/css/dashboard.css">
</head>
<body>

<nav class="navbar navbar-expand-md bg-dark bg-transparent navbar-dark fixed-top" id="mynav">
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

    <div class="gallery">
        
        <div class="content">
            <img src="templates/img/cruise.jpg" alt="">
            <h3>Ajouter une croisière</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero ratione assumenda corporis quidem in ipsum repudiandae earum eius impedit distinctio tempora soluta ad nisi accusantium debitis dolor beatae, ullam voluptatibus.</p>
            <button class="buy-1" onclick="window.location.href='/cruises/public/page/addCruise';"></button>
        </div>



        <div class="content">
            <img src="templates/img/cruise.jpg" alt="">
            <h3>Modifier une croisière</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero ratione assumenda corporis quidem in ipsum repudiandae earum eius impedit distinctio tempora soluta ad nisi accusantium debitis dolor beatae, ullam voluptatibus.</p>
            <button class="buy-1" onclick="window.location.href='/cruises/public/page/cruisesdet';"></button>
        </div>
    </div>

</body>
</html>