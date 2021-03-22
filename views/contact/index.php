<?php

$viewPath = "../views";
include_once $viewPath . '/partials/_header.php';

?>

<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5">
        <h1 class="display-4 font-weight-normal">Contact</h1>
        <p class="lead font-weight-normal">Send us a message</p>

        <?php include_once $viewPath . '/contact/form.php'; ?>

    </div>
    <div class="product-device box-shadow d-none d-md-block"></div>
    <div class="product-device product-device-2 box-shadow d-none d-md-block"></div>
</div>

<?php include_once $viewPath . '/partials/_footer.php'; ?>

