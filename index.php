

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <title>Login</title>
</head>
<body>
<!-- ทดสอบ javascrip -->
<!-- <script src="js/test.js"></script> -->
<div class="container">
        <div class="card card-container">
        
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <span id ="admin"><h3>Admin</h3></span>
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" method="post" action="checklogin.php">
                <span id="reauth-email" class="reauth-email"></span>
                <input type="text" id="inputUsername" class="form-control" placeholder="Username" name="inputUsername" required autofocus >
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="inputPassword"  required>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Login</button>
            </form><!-- /form -->

            <!-- <a href="#" class="forgot-password">
                Forgot the password?
            </a> -->
        </div><!-- /card-container -->
    </div><!-- /container -->
<script src="node_modules/jquery/dist/jquery.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</body>
</html>