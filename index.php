<?php   session_start();?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Website</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

</head>
<body>

    <header>
        <a href="#home" class="logo">
            <i class='bx bxs-movie'></i>CineFlix
        </a>
        <div class="bx bx-menu" id="menu-icon"></div>

        <ul class="navbar">
            <li><a href="#home" class="home-active">Home</a></li>
            <li><a href="#coming">UpComing</a></li>
            <li><a href="#movies">Category</a></li>
            <li><a href="#aboutus">aboutus</a></li>
            <li><a href="#contact">Contactus</a></li>
        </ul>
        <?php
        if(isset($_SESSION['coust_NIC'])):

        ?>
        <a href="HTML/logout.php" class="btn">Log Out</a>
          <?php else: ?>
        <a href="HTML/movieRentalSystemLogin.php" class="btn">Sign In</a>
        <?php endif;?>
    </header>

    <section class="home swiper" id="home">
        <div class="swiper-wrapper">
            <div class="swiper-slide container">
                <img src="./img/home1.jpg" alt="">
                <div class="home-text">
                    <span>Your Ultimate Movie Destination</span>
                    <h1>CineFlix</h1>
                    <a href="" class="btn">Rent Now</a>
                    <a href="" class="play">
                        <i class='bx bx-play' ></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide container">
                <img src="./img/home2.png" alt="">
                <div class="home-text">
                    <span>Your Ultimate Movie Destination</span>
                    <h1>CineFlix</h1>
                    <a href="" class="btn">Rent Now</a>
                    <a href="" class="play">
                        <i class='bx bx-play' ></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide container">
                <img src="./img/home3.jpg" alt="">
                <div class="home-text">
                    <span>Your Ultimate Movie Destination</span>
                    <h1>CineFlix</h1>
                    <a href="" class="btn">Rent Now</a>
                    <a href="" class="play">
                        <i class='bx bx-play' ></i>
                    </a>
                </div>
            </div>
            <div class="swiper-slide container">
                <img src="./img/home4.png" alt="">
                <div class="home-text">
                    <span>Your Ultimate Movie Destination</span>
                    <h1>CineFlix</h1>
                    <a href="" class="btn">Rent Now</a>
                    <a href="" class="play">
                        <i class='bx bx-play' ></i>
                    </a>
                </div>
            </div>

          </div>
          <div class="swiper-pagination"></div>
    </section>

    <section class="coming" id="coming">
        <h2 class="heading">Coming Soon</h2>

        <div class="coming-container swiper">
            <div class="swiper-wrapper">

                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="img/c1.jpg" alt="">
                    </div>
                    <h3>Ant-Man and the Wasp:Quantumania</h3>
                </div>

                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="img/c2.jpg" alt="">
                    </div>
                    <h3>The Flash</h3>
                </div>

                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="img/c3.jpg" alt="">
                    </div>
                    <h3>Guardians of the Galaxy Vol.3</h3>
                </div>

                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="img/c4.jpg" alt="">
                    </div>
                    <h3>Shazam! Fury of the Gods</h3>
                </div>

                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="img/c5.jpg" alt="">
                    </div>
                    <h3>Aquaman and the Lost Kingdom</h3>
                </div>
                <!-- box-6  -->
                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="img/c6.jpg" alt="">
                    </div>
                    <h3>John Wick:Chapter 4</h3>
                </div>
                <!-- box-7 -->
                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="img/c7.jpg" alt="">
                    </div>
                    <h3>Transformer rise of the beasts</h3>
                </div>
                <!-- box-8  -->
                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="img/c8.jpg" alt="">
                    </div>
                    <h3>Mission: Impossible 7</h3>
                </div>
                <!-- box-9  -->
                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="img/c9.png" alt="">
                    </div>
                    <h3>Deadpool 3</h3>
                </div>
                <!-- box-10  -->
                <div class="swiper-slide box">
                    <div class="box-img">
                        <img src="img/c10.jpg" alt="">
                    </div>
                    <h3>Dune: Part two</h3>
                </div>
            </div>
        </div>
    </section>
    <!--  Category  -->
    <div class="movies" id="movies">
        <h2 class="heading">Select Your Category</h2>
        <!-- Movies container  -->
        <div class="movies-container">
            <!-- box-1  -->
            <a href="moviespage.php?category=Action"><div class="box" >
                <div class="box-img">
                    <img src="./img/m1.jpg" alt="">
                </div>
                <h3>Action</h3>

                </div></a>
            <!-- box-2  -->
            <a href="moviespage.php?category=Adventure"><div class="box">
                <div class="box-img">
                    <img src="./img/m2.jpg" alt="">
                </div>
                <h3>Adventure</h3>

            </div></a>
            <!-- box-3  -->
            <a href="moviespage.php?category=Drama"><div class="box">
                <div class="box-img">
                    <img src="./img/m3.jpg" alt="">
                </div>
                <h3>Drama</h3>
                </div></a>
            <!-- box-4  -->
            <a href="moviespage.php?category=Thriller"><div class="box">
                <div class="box-img">
                    <img src="./img/m4.jpg" alt="">
                </div>
                <h3>Thriller</h3>

            </div></a>
            <!-- box-5  -->
            <a href="moviespage.php?category=Animation"><div class="box">
                <div class="box-img">
                    <img src="./img/m5.jpg" alt="">
                </div>
                <h3>Animated</h3>
                </div></a>
            <!-- box-6  -->
            <a href="moviespage.php?category=Sci-Fi"><div class="box">
                <div class="box-img">
                    <img src="./img/m6.jpg" alt="">
                </div>
                <h3>Science Fiction (Sci-Fi)</h3>
            </div></a>
            <!-- box-7  -->
            <a href="moviespage.php?category=Thriller"><div class="box">
                <div class="box-img">
                    <img src="./img/m7.jpg" alt="">
                </div>
                <h3>Fantasy</h3>
            </div></a>
            <!-- box-8  -->
            <a href="moviespage.php?category=Comedy"><div class="box">
                <div class="box-img">
                    <img src="./img/m8.jpg" alt="">
                </div>
                <h3>Comedy</h3>
            </div></a>
            <!-- box-9  -->
            <a href="moviespage.php?category=Romance"><div class="box">
                <div class="box-img">
                    <img src="./img/m9.jpg" alt="">
                </div>
                <h3>Romance</h3>
            </div></a>
            <!-- box-10  -->
            <a href="moviespage.php?category=Horror"><div class="box">
                <div class="box-img">
                    <img src="./img/m10.jpg" alt="">
                </div>
                <h3>Horror</h3>
            </div></a>
        </div>
    </div>
       <!--aboutus-->
       <section class="aboutus" id="aboutus">
        <div class="container-2">
            <div class="about">
                <h2 class="heading">About Us</h2><br>
                <h2>CineFlix </h2><br>
                <p>Welcome to CineFlix , your number one source for all things movies. We're dedicated to giving you the very best of movie rentals, with a focus on customer service, convenience, and a wide selection of titles. Founded in 2020, CineFlix has come a long way from its beginnings. When we first started out, our passion for providing the best movie rental experience drove us to do intense research,
                    so that CineFlix can offer you the world's most popular movies. We now serve customers all over the country, and are thrilled that we're able to turn our passion into our own website. We hope you enjoy our products as much as we enjoy offering them to you. If you have any questions or comments, please don't hesitate to contact us.</p>
            </div>
            <div class="ab_images">
                <div>
                    <img src="img/a1.jpg" alt="1">
                </div>
                <div id="img2">
                    <img src="img/a2.jpg" alt="2">
                </div>

            </div>
        </div>
       </section>
    <!--contactus-->
    <section class="contact" id="contact">
        <div class="container">
        <div class="row input-container">
            <h2 class="heading">contact us</h2><br><br>
                <div class="col-xs-12">
                    <div class="styled-input wide">
                        <input type="text" required />
                        <label>Name</label>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="styled-input">
                        <input type="text" required />
                        <label>Email</label>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="styled-input" style="float:right;">
                        <input type="text" required />
                        <label>Phone Number</label>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="styled-input wide">
                        <textarea required></textarea>
                        <label>Message</label>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="btn-lrg submit-btn">Send Message</div>
                </div>
        </div>
    </div>

    </section>


    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="main.js"></script>
</body>
</html>