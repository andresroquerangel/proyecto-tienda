<div id="carouselExample" class="carousel slide">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="images/imagen2.jpg" class="d-block w-100" style="height: 500px; width: 200px;" alt="...">
        </div>
        <div class="carousel-item">
            <img src="images/imagen1.jpg" class="d-block w-100" style="height: 500px; width: 200px;" alt="...">
        </div>
        <div class="carousel-item">
            <img src="images/imagen3.jpg" class="d-block w-100" style="height: 500px; width: 200px;" alt="...">
        </div>
        <div class="carousel-item">
            <img src="images/imagen4.jpg" class="d-block w-100" style="height: 500px; width: 200px;" alt="...">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<section class="container py-5">
    <div class="row">
        <?php foreach($data2 as $key => $articulo): ?>
        <div class="col-3 col-md-2 p-4 mt-3">
            <a href="#"><img src="<?php echo isset($articulo['IMAGEN'])?'data:image/png;base64,'.base64_encode($articulo['IMAGEN']):'images/no_image.svg'; ?>" style="height: 150px;" class="rounded-circle img-fluid border"></a>
            <h5 class="text-center mt-3 mb-3"><?php echo $articulo['NOMBRE']; ?></h5>
            <p class="text-center"><a href="carrito.php?action=agregar&id=<?php echo $articulo['ARTICULO_ID']; ?>" class="btn btn-success">Añadir al carrito</a></p>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Ofertas</h1>
                <p>
                    Revisa nuestras mejores ofertas que ofrecemos aqui en Maxix Abarrotes
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4 mb-4">
                <div class="card h-100">
                    <a href="shop-single.html">
                        <img src="images/descuento1.jpg" class="card-img-top" alt="...">
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4">
                <div class="card h-100">
                    <a href="shop-single.html">
                        <img src="images/descuento2.jpg" class="card-img-top" alt="...">
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4">
                <div class="card h-100">
                    <a href="shop-single.html">
                        <img src="images/descuento3.jpg" class="card-img-top" alt="...">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="row">
        <?php foreach($data as $key => $articulo): ?>
        <div class="col-3 col-md-2 p-4 mt-3">
            <a href="#"><img src="<?php echo isset($articulo['IMAGEN'])?'data:image/png;base64,'.base64_encode($articulo['IMAGEN']):'images/no_image.svg'; ?>" style="height: 150px;" class="rounded-circle img-fluid border"></a>
            <h5 class="text-center mt-3 mb-3"><?php echo $articulo['NOMBRE']; ?></h5>
            <p class="text-center"><a href="carrito.php?action=agregar&id=<?php echo $articulo['ARTICULO_ID']; ?>" class="btn btn-success">Añadir al carrito</a></p>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!-- End Categories of The Month -->
