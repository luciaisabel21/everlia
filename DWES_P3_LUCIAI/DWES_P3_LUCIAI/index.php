<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Everlia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="./views/estilo.css">
    
  </head>
<body>
    <!-- Menú dinámico -->
    <?php include_once "./views/menu.php"; ?>

    
    <main>
       
  <!-- seccion 1 -->
  <div class="seccion1">
    <div class="text-center">
      <h1>Diseña tu boda soñada</h1>
      <p>Todo lo que necesitas para tu día especial y más allá.</p>
      <a href="#shop" class="btn btn-custom btn-lg"> Explora ahora </a>
    </div>
  </div>


  <!-- Productos a la venta-->
  <section id="shop" class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center mb-4"> A la venta </h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card">
            <img src="./imagenes/decoracion.jpg" class="card-img-top" alt="Product 1">
            <div class="card-body">
              <h5 class="card-title">Decoración </h5>
              <p class="card-text">Decora a tu gusto tu gran dia</p>
              <a href="./productos.php" class="btn btn-custom">Comprar </a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <img src="./imagenes/trajeBoda.jpg" class="card-img-top" alt="Product 2">
            <div class="card-body">
              <h5 class="card-title">Vestidos y Trajes</h5>
              <p class="card-text">Elija el vestido que mejor se adapte a ti</p>
              <a href="./productos.php" class="btn btn-custom">Comprar</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <img src="./imagenes/ramoFlores.jpg" class="card-img-top" alt="Product 3">
            <div class="card-body">
              <h5 class="card-title">Ramos de flores</h5>
              <p class="card-text"> Elija entre nuestra amplia variedad de flores y colores</p>
              <a href="./productos.php" class="btn btn-custom">Comprar</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

      <!-- Carrusel de viajes -->
      <section id="trips" >
        <div class="container py-5">
          <h2 class="text-center">Nuestros Viajes</h2>
      
          <div id="tripCarousel" class="carousel slide h-100" data-bs-ride="carousel">
            <div class="carousel-inner h-100">
              <div class="carousel-item active">
                <img src="./imagenes/BALI.jpeg" class="d-block w-100 h-100" alt="Viaje 1">
                <div class="carousel-caption d-none d-md-block">
                  <h5><strong>BALI (INDONESIA)</strong></h5>
                  <p><strong>Descubre sus arrecifes de coral y disfruta de su clima tropical</strong></p>
                </div>
              </div>
              <div class="carousel-item">
                <img src="./imagenes/REPUBLICADOMINICANA.jpg" class="d-block w-100 h-100" alt="Viaje 2">
                <div class="carousel-caption d-none d-md-block">
                  <h5><strong>REPÚBLICA DOMINICANA</strong></h5>
                  <p><strong>Relájate en sus magníficas playas de arena blanca y aguas cristalinas</strong></p>
                </div>
              </div>
              <div class="carousel-item">
                <img src="./imagenes/ISLANDIA.jpg" class="d-block w-100 h-100" alt="Viaje 3">
                <div class="carousel-caption d-none d-md-block">
                  <h5><strong>ISLANDIA</strong></h5>
                  <p><strong>Encuentra la paz que necesitas en sus impresionantes montañas y lagos</strong></p>
                </div>
              </div>
            </div>
            <a class="carousel-control-prev" href="#tripCarousel" role="button" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#tripCarousel" role="button" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Siguiente</span>
            </a>
          </div>
        </div>
      </section>

   
      </main>

    <!-- Pie de página -->
    <?php include_once "./views/pie.php"; ?>
</body>
</html>