<?php
session_start();

if (isset($_SESSION['coust_NIC'])) {
    header("location:../index.php");
    exit();
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
              crossorigin="anonymous">
        <link rel="stylesheet" href="login.css">
    </head>
    <body>
    <div id="alertContainer"></div>
    <div id="spinner" style="display: none;">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="text-light">Loading<span class="dot-animation">...</span></div>
    </div>

    <div id="container">
        <div id="row1" class="row justify-content-center">
            <div id="imgSection" class="col-sm-4 col-md-4 col-lg-4 text-center">
                <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="image" src="../images/login-slider-1.jpeg" alt="slider3">
                        </div>
                        <div class="carousel-item">
                            <img src="../images/login-slider-2.jpeg" alt="slider1">
                        </div>
                        <div class="carousel-item">
                            <img src="../images/login-slider-3.jpeg" alt="slider2">
                        </div>
                    </div>
                </div>
            </div>
            <div id="loginSection" class="col-sm-5 col-md-5 col-lg-5 text-center">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <div class="text-center mb-4">
                                <img class="mt-4" src="../images/movie-rental-system-logo.png" alt="BootstrapBrain Logo"
                                     width="175" height="25">
                            </div>
                            <h3 id="signIn" class="text-start">SIGN IN</h3>
                        </div>
                    </div>
                </div>
                <form class="movieLogin">
                    <div id="row2" class="row gy-3 overflow-hidden">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" name="email" id="email"
                                       placeholder="name@example.com" required>
                                <label for="email" class="form-label">Email</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating mb-2">
                                <input type="password" class="form-control" name="password" id="password" value=""
                                       placeholder="Password" required>
                                <label for="password" class="form-label">Password</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-column flex-md-row justify-content-md-center">
                                <a href="movieRentalSystemForgotPassword.php"
                                   class="link-secondary text-decoration-none">Forgot password</a>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-grid mt-2 mb-3">
                                <button class="btn btn-dark btn-lg" type="submit">Log in now</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-12">
                        <hr class="w-75 mx-auto">
                        <p class="text-center">Or sign in with</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center">
                            <a href="movieRentalSystemRegistration.php" class="link-secondary text-decoration-none">Create
                                new account</a>
                            <a href="../login.php" class="link-secondary text-decoration-none">Admin Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container2 mx-auto w-75 ">
        <div class="secondForm w-75 mx-auto pt-2">
            <h4 class="text-center">SIGN IN</h4>
            <form class="row g-3 needs-validation movieLogin" novalidate>
                <div class="col-11 mx-auto">
                    <label for="validationCustom01" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="validationCustom01" required>
                    <div class="valid-feedback">Looks good!</div>
                </div>
                <div class="col-11 mx-auto">
                    <label for="validationCustom02" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="validationCustom02" required>
                    <div class="valid-feedback">Looks good!</div>
                </div>
                <label class="ms-3" id="forgotPasswordSecondForm"><a href="movieRentalSystemForgotPassword.php">Forgot
                        Password</a></label>
                <div class="col-11 mx-auto">
                    <button class="btn btn-primary secondFormSubmit mx-auto" type="submit">Submit form</button>
                </div>
                <hr class="w-75 mx-auto">
                <label class="text-center">Or </label>
                <label class="ms-3 mb-3"><a href="movieRentalSystemRegistration.php">Create new account</a></label>
            </form>
        </div>
    </div>

    <script src="login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    </body>
    </html>

    <?php
} ?>