<?php
require 'DbConnector.php';

$display_message = "";

$dbcon = new DbConnector();
$conn = $dbcon->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = htmlspecialchars(trim($_POST['email']));
  $comment = htmlspecialchars(trim($_POST['comment']));
  $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;

  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $query = "INSERT INTO feedback (email,comment,rating) VALUES(:email,:comment,:rating)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':comment', $comment);
    $stmt->bindParam(':rating', $rating,PDO::PARAM_INT);

    $a = $stmt->execute();

    if ($a > 0) {
      $display_message = "Thank You!";
    } else {
      $display_message = "Try again.";
    }
  } else {
    $display_message = "Invalid email address.";
  }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>footer</title>
  <link rel="stylesheet" href="footer.css">
  <!-- <script src="https://kit.fontawesome.com/a076d05399.js"></script> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script>
    document.addEventListener('DOMContentLoaded', (event) => {
      const currentYear = new Date().getFullYear();
      document.getElementById('currentYear').textContent = currentYear;
    });
  </script>
</head>

<body>
  <footer class="footer bg-dark pt-5 pb-4">
    <div class="container text-md-left">
      <div class="row text-md-left">
        <div class="col-md-3 col-lg-3 col-xl-4 mx-auto mt-3">
          <h5 class="text-uppercase mb-4 font-weight-bold">CineFlix</h5>
          <p>CineFlix is your ultimate destination for seamless online movie rentals, offering a vast collection of
            films for every taste and preference.</p>
        </div>
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3 quick-links">
          <h5 class="text-uppercase mb-4 font-weight-bold">Quick Links</h5>
          <p><a href="#">Home</a></p>
          <p><a href="#">Services</a></p>
          <p><a href="#"></a>Movies</p>
          <p><a href="#">About Us</a></p>
          <p><a href="#">Contact</a></p>
        </div>
        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3 contact">
          <h5 class="text-uppercase mb-4 font-weight-bold">Contact</h5>
          <p><i class="fas fa-envelope mr-3"></i> info@CineFlix.com</p>
          <p><i class="fas fa-phone mr-3"></i> +94 11 345 7859</p>
          <p><i class="fas fa-print mr-3"></i> +94 11 345 7860</p>
          <div class="wrapper">
            <a href="https://facebook.com" class="button">
              <div class="icon">
                <i class="fab fa-facebook-f"></i>
              </div>
            </a>
            <a href="https://tiktok.com" class="button">
              <div class="icon">
                <i class="fab fa-tiktok"></i>
              </div>
            </a>
            <a href="https://instagram.com" class="button">
              <div class="icon">
                <i class="fab fa-instagram"></i>
              </div>
            </a>
            <a href="https://youtube.com" class="button">
              <div class="icon">
                <i class="fab fa-youtube"></i>
              </div>
            </a>
          </div>
        </div>
        <div class="review col-md-4 col-lg-4 col-xl-3 d-flex  mx-auto mt-3">
          <div class='fb-form'>
            <form action='' method='POST' class='form-group'>
              <h5 class="text-uppercase mb-4 font-weight-bold">Share your Experience</h5>
              <input class='form-control' name='email' placeholder='Email' type='email' required>
              <textarea class='form-control' id='fb-comment' name='comment' placeholder='Tell us what you think'
              ></textarea>
              <div class='rating'>
                <i class='fa fa-star' data-rating='1'></i>
                <i class='fa fa-star' data-rating='2'></i>
                <i class='fa fa-star' data-rating='3'></i>
                <i class='fa fa-star' data-rating='4'></i>
                <i class='fa fa-star' data-rating='5'></i>
              </div>
              <input type='hidden' name='rating' value='0' required>
              <!-- message display -->
              <?php
              if (isset($display_message)) {
                echo "<div class='display_message'>
            <span>
                $display_message
            </span>
        </div>";
              }
              ?>
              
              <input class='form-control btn btn-primary' type='submit' value='Submit'>
            </form>
          </div>
        </div>
      </div>
      <hr class="mb-4" />
      <div class="row align-items-center">
        <div class="col-md-7 col-lg-8">
          <p class="text-center text-md-left">© <span id="currentYear"></span> CineFlix. All Rights Reserved.</p>
        </div>
        <div class="col-md-5 col-lg-4">
          <p class="text-center text-md-right">Designed by CST_WAD_GROUP-F</p>
        </div>
      </div>
    </div>
  </footer>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const stars = document.querySelectorAll('.rating .fa-star');
      stars.forEach(star => {
        star.addEventListener('click', function() {
          stars.forEach(s => s.classList.remove('selected'));
          this.classList.add('selected');
          for (let i = 0; i < parseInt(this.getAttribute('data-rating')); i++) {
            stars[i].classList.add('selected');
          }
          document.querySelector('input[name="rating"]').value = this.getAttribute('data-rating');
        });
      });
    });
  </script>
</body>

</html>