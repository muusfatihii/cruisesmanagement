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
                <a class="nav-link text-dark" href="#">Dashboard</a>
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