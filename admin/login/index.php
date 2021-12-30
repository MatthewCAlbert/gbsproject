<?php
require '../include/structure.php';
if(isset($_SESSION['useradmin_id'])){
   header("Location: ../index.php?login=login-detected");
   exit();
}else if(isset($_COOKIE['admin_login'])){
   $_SESSION["useradmin_id"] = $_COOKIE['admin_login'];
   header("Location: ../index.php?login=remember-detected");
   exit();
}

require '../include/server.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../include/structure/header.php'; 
    require '../include/structure/script.php'; ?>
    <title>Login - GBS eMoney Admin</title>
    <style>
        *{
            margin:0;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            margin-top:-60px;
            height: 60px; /* Set the fixed height of the footer here */
            padding-top:5px;
            opacity: 1;
        }
    </style>
</head>

<body class="">
    <div class="wrapper">
        <div class="top">
            <p><img src="../assets/img/favicon.png" alt="favicon" width="30px"> GBS eMoney Admin</p>
        </div>
        <div class="login-wrapper col-sm-12 col-md-6 col-lg-4">
            <div class="login">
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="exampleInput1" class="bmd-label-floating">Username</label>
                        <input class="form-control" type="text" name="username" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInput1" class="bmd-label-floating">Password</label>
                        <input class="form-control" type="password" name="password" placeholder="">
                    </div><br>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="remember" value="">
                            Remember Me
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                        </label>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary" style="width:100%;">Login</button>
                </form>
            </div>
        </div>
    </div>
        <?php require '../include/structure/footer.php'; ?>
</body>
    <?php require '../include/structure/script.php'; ?>
</html>
