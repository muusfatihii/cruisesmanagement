<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>V Jewllery</title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Baloo+Chettan|Poppins:400,600,700&display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
</head>

<body class="sub_page">

  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="index.php">
            <img src="images/logo.png" alt="VJewellery logo">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex ml-auto flex-column flex-lg-row align-items-center">
              <ul class="navbar-nav  ">
                <li class="nav-item active">
                  <a class="nav-link" href="index.php?action=addPage"> Add item</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?action=items&user=admin"> Gallery<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php"> Log out</a>
                </li>
              </ul>

            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>


  


  <section class="price_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Our Jewellery Price
        </h2>
      </div>



      <form method="POST" action="index.php?action=filter&user=admin" class="selection-all" >
        <select class="form-select mb-3" aria-label="Default select example" name="categoryid">
            <option selected value="">All</option>
            <?php
            foreach($categories as $category){
            ?>
            <option  value="<?=$category->id;?>"><?=$category->name; ?></option>
            <?php
            }
            ?>
        </select>
        <button type="submit" class="btn btn-primary">Filtrer</button>
    </form>






      <div class="price_container">

      <?php
         foreach ($items as $item) {
      ?>

        <div class="box">
          <div class="name">
            <h6>
            <?=$item->name?>
            </h6>
          </div>
          <div class="img-box">
            <img src="uploads/<?=$item->pic?>" alt="VJewellery <?=$item->name?>">
          </div>
          <div class="detail-box">
            <h5>
              $<span><?=$item->price?></span>
            </h5>
            <a href="index.php?action=deleteItem&id=<?=$item->id?>">
            supp</i></a>
            <a href="index.php?action=modifyPage&id=<?=$item->id?>">
            modify</a>
            <a href="index.php?action=item&id=<?=$item->id?>">
              More Infos
            </a>
          </div>
        </div>

        <?php
         }?>
      </div>

    </div>
  </section>


  <!-- info section -->
  <section class="info_section ">
    <div class="container">
      <div class="info_container">
        <div class="row">
          <div class="col-md-3">
            <div class="info_logo">
              <a href="">
                <img src="images/logo.png" alt="VJewellery logo">
              </a>
            </div>
          </div>
          <div class="col-md-3">
            <div class="info_contact">
              <a href="">
                <img src="images/location.png" alt="location VJewellery">
                <span>
                  Charles II Avenue London
                </span>
              </a>
            </div>
          </div>
          <div class="col-md-3">
            <div class="info_contact">
              <a href="">
                <img src="images/phone.png" alt="VJewellery phone icon">
                <span>
                  800-872-6840
                </span>
              </a>
            </div>
          </div>
          <div class="col-md-3">
            <div class="info_contact">
              <a href="">
                <img src="images/mail.png" alt="mail icon VJewellery">
                <span>
                  contact@jewellery.com
                </span>
              </a>
            </div>
          </div>
        </div>
        <div class="info_form">
          <div class="d-flex justify-content-center">
            <h5 class="info_heading">
              Newsletter
            </h5>
          </div>
          <form action="">
            <div class="email_box">
              <label for="email2">Enter Your Email</label>
              <input type="text" id="email2">
            </div>
            <div>
              <button>
                subscribe
              </button>
            </div>
          </form>
        </div>
        <div class="info_social">
          <div class="d-flex justify-content-center">
            <h5 class="info_heading">
              Follow Us
            </h5>
          </div>
          <div class="social_box">
            <a href="">
              <img src="images/fb.png" alt="facebook icon">
            </a>
            <a href="">
              <img src="images/twitter.png" alt="twitter icon">
            </a>
            <a href="">
              <img src="images/linkedin.png" alt="linkedin icon">
            </a>
            <a href="">
              <img src="images/insta.png" alt="instagram icon">
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end info_section -->

  <!-- footer section -->
  <section class="container-fluid footer_section">
    <p>
      &copy; <span id="displayYear"></span> All Rights Reserved
    </p>
  </section>
  <!-- footer section -->

  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="js/custom.js"></script>

</body>

</html>