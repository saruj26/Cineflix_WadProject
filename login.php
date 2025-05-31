<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Login</title>
    <style>
        .AdminLogin{
            margin-top: 200px;
        }
        .AdminLogin{
            box-shadow: 2px 2px 2px 2px #cccccc;
            padding: 80px;
            border-radius: 20px;
            display: block;
            align-items: center;
            justify-content: center;
        }

        .AdminLogin form{
            padding: 50px;
        }
        .AdminLogin h2{
            margin-left: 170px;
        }
        .container{
            width: 100%;
            min-height:94vh ;
            height: 100%;
        }
    </style>
</head>
<body>
<div class="container">
    <?php include'adminLoginNavigate.php'?>
    <div class="row justify-content-center">
        <div class="col-md-6 AdminLogin">
            <h2>Admin Login</h2>
            <form action="loginProcess.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</div>
<?php include 'footerNav.php'?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
