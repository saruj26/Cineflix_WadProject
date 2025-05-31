<?php

session_start();

if(isset($_SESSION['coust_NIC'])) {
    header("location:../index.php");
    exit();
}else{
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                        <div class="text-center mb-1">
                            <img class="mt-4" src="../images/movie-rental-system-logo.png" alt="BootstrapBrain Logo"
                                 width="175" height="25">
                        </div>
                        <h3 id="signIn" class="text-start">SIGN Up</h3>
                    </div>
                </div>
            </div>
            <form class="movieRegistration">
                <div id="row2" class="row gy-3 overflow-hidden">
                    <div class="col-4">
                        <div class="form-floating mb-1">
                            <input type="text" class="form-control" name="fName" id="fName" required>
                            <label for="fName" class="form-label">First Name</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-floating mb-1">
                            <input type="text" class="form-control" name="lName" id="lName" required>
                            <label for="lName" class="form-label">Last Name</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-floating mb-1">
                            <input type="text" class="form-control" name="nic" id="nic" pattern="^\d{9}[VX]$|^\d{12}$"
                                   title="NIC number must be either 9 digits followed by a letter V or X, or exactly 12 digits."
                                   required>
                            <label for="nic" class="form-label">NIC</label>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-floating mb-1">
                            <input type="date" class="form-control" name="birthday" id="birthday"  required>
                            <label for="birthday" class="form-label">Birthday</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-floating mb-1">
                            <div class="form-control" style="height: auto; padding-top: 1.25rem;">
                                <div class="d-flex justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" required>
                                        <label class="form-check-label" for="male">
                                            Male
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" required>
                                        <label class="form-check-label" for="female">
                                            Female
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-floating mb-1">
                            <input type="tel" class="form-control" name="phoneNumber" id="phoneNumber" pattern="^(?:7|0|(?:\\+94))[0-9]{9,10}$"
                                   title="Please enter a valid phone number." required>
                            <label for="phoneNumber" class="form-label">Phone Number</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating mb-1">
                            <input type="text" class="form-control" name="address" id="address" required>
                            <label for="address" class="form-label">Address</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating mb-1">
                            <input type="email" class="form-control" name="email" id="email"  required>
                            <label for="email" class="form-label">Email</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating mb-1">
                            <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$"
                                   title="Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character."
                                   required>
                            <label for="password" class="form-label">Password</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating mb-1">
                            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" value="" placeholder="Password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$"
                                   title="Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character."
                                   required>
                            <label for="confirmPassword"  class="form-label"> Confirm Password</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-grid mt-2 mb-1">
                            <button class="btn btn-dark btn-lg" type="submit">Sign Up now</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-12">
                    <hr class="w-75 mx-auto">
                    <p class="text-center">Or </p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center">
                        <a href="movieRentalSystemLogin.php" class="link-secondary text-decoration-none">Login With Existing Account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="container2 mx-auto w-100 mt-4" >
    <div class="secondForm w-75 mx-auto pt-2">
        <h4 class="text-center">SIGN Up</h4>
        <form class="row g-3 movieRegistration" >
            <div class="col-3 mx-auto">
                <label for="fName" class="form-label">First Name</label>
                <input type="text" class="form-control" name="fName" id="fName" required>

            </div>
            <div class="col-3 mx-auto">
                <label for="lName" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="lName" id="lName" required>

            </div>
            <div class="col-4 mx-auto">
                <label for="nic2" class="form-label">Nic</label>
                <input type="text" class="form-control" name="nic" id="nic" pattern="^\d{9}[VX]$|^\d{12}$"
                       title="NIC number must be either 9 digits followed by a letter V or X, or exactly 12 digits."
                       required>
            </div>
            <div class="col-3 mx-auto">
                <label for="phoneNumber" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" name="phoneNumber" id="phoneNumber" pattern="^(?:7|0|(?:\\+94))[0-9]{9,10}$"
                       title="Please enter a valid phone number." required>

            </div>
            <div class="col-3 mx-auto">
                <label for="birthday2" class="form-label">Birthday</label>
                <input type="date" name="birthday" class="form-control" id="birthday2" required>
            </div>
            <div class="col-4 mx-auto">
                <label for="gender" class="form-label">gender</label>
                <div class="form-floating ">
                    <div class="form-control" style="height: auto; padding-top: 1.25rem;">
                        <div class="d-flex justify-content-between" >
                            <div class="form-check" >
                                <input class="form-check-input" type="radio" name="gender" id="male" value="male" required>
                                <label class="form-check-label" for="male">
                                    Male
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="female" required>
                                <label class="form-check-label" for="female">
                                    Female
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5 mx-auto">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" name="address" id="address" required>

            </div>
            <div class="col-5 mx-auto">
                <label for="email2" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email2" required>
            </div>

            <div class="col-5 mx-auto">
                <label for="password2" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password2" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$"
                       title="Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character."
                       required>

            </div>
            <div class="col-5 mx-auto">
                <label for="confirmPassword2" class="form-label">Confirm Password</label>
                <input type="password" name="confirmPassword" class="form-control" id="confirmPassword2" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$"
                       title="Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character."
                       required>

            </div>

            <div class="col-11 mx-auto">
                <button class="btn btn-primary secondFormSubmit mx-auto" type="submit">Submit form</button>
            </div>
            <hr class="w-75 mx-auto">
            <label class="text-center">Or </label>
            <label class="ms-3 mb-3"><a href="movieRentalSystemLogin.php">Login with Existing Account </a></label>
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
}?>