<?php
    require '../include/config.php'; 
    require '../include/server.php';
    if(isset($_SESSION['user_id'])){
    header("Location: ../index.php?login=login-detected");
    exit();
    }else if(isset($_COOKIE['member_login'])){
    $_SESSION["user_id"] = $_COOKIE['member_login'];
    header("Location: ../index.php?login=remember-detected");
    exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require '../include/structure/head.php';?>
    <title>GBS eMoney App</title>
    <link rel="stylesheet" href="../assets/css/custom-checkbox1.css">
    <style>
    :root{
        --main-bg-color: #1976D2;
    }
    body{
        background-color: var(--main-bg-color);
    }
    *{
        color:white;
    }
    .landing{
        position:fixed;
        top:0;left:0;
        z-index:4;
        height:100vh;
        width:100%;
    }
    .land-wrap{
        width:100%;
        height:100vh;
        background-color:var(--main-bg-color);
    }
    .land-wrap:focus{
        outline: none !important;
        border: none !important;
    }
    ul.slick-dots{
        position:fixed;
        bottom:3%;
    }
    .slick-dots > li{
        margin: 0 8px;
        width:10px;height:10px;
    }
    .slick-dots > li > button{
        border: 1px solid rgba(255,255,255,0.5);
        border-radius: 10px;
        width: 10px;
        height: 10px;
        color: transparent;
    }
    .slick-dots > li > button:hover{
        transition:.3s;
    }
    .slick-dots > li > button::before{
        display: none !important;
    }
    .slick-dots > li.slick-active > button{
        background-color: white;
    }
    .skip-button{
        position:fixed;bottom:5%;right:5%;z-index:5;cursor:pointer;color:rgba(255,255,255,0.6);
        transition:.3s;
    }
    .skip-button:hover{
        color: rgba(255,255,255,0.9);
        transition:.3s;
    }
    .arrow{
        position:fixed;
        z-index:5;
        top:50%;
        bottom:50%;
        background-color: transparent;
        margin-top:-3%;
        color:rgba(255,255,255,0.4);
        font-size:2em;
        display:none;
    }
    .arrow:hover{
        color:rgba(255,255,255,0.8)
    }
    .arrow.left{
        left:1.2%;
    }
    .arrow.right{
        right:1.2%;
    }
    img[alt=logo]{
        width:100px;
        height:100px;
    }
    #m-logo{
        transform: scale(0.8);
    }
    #form{
        width: 30%;
    }
    @media screen and (max-width: 1200px) {
        #form{
            width: 50%;
        }
    }
    @media screen and (max-width: 700px) {
        .flex-fix{
            margin-top : -15%;
        }
        #form{
            width: 80%;
        }
    }
    @media screen and (max-width: 350px) {
        .flex-fix{
            margin-top : -10%;
        }
        #m-logo{
            transform: scale(0.6);
        }
    }
    </style>
</head>
<body>
    <?php require '../include/structure/loader.php';?>
    <button class="btn arrow left" onclick="$('.slick-prev').click()"><i class="fas fa-chevron-left"></i></button>
    <div class="slider landing">
        <div class="land-wrap d-flex justify-content-center">
            <div class="p-2 align-self-center flex-fix">
                <h3 class="text-center">Welcome to GBS WebApp</h3>
                <h6 class="text-center">Experience the cashless system at your canteen.</h6>
            </div>
        </div>
        <div class="land-wrap d-flex justify-content-center">
            <form action="login.php" method="post" class="p-2 align-self-center flex-fix" id="form" autocomplete="off">
                <div id="m-logo" class="d-flex justify-content-center">
                <img src="<?php echo $main_directory; ?>assets/img/favicon-alt.png" alt="logo">
                <span style="font-size:3em;color:white;line-height:100px;margin-left:10px;">gbsproject.</span>
                </div>
                <br>
                <h3>Sign In</h3><br>
                <input type="text" class="form-control" name="id" placeholder="NIS/ID" required />
                <br>
                <input type="password" class="form-control" name="password" minlength="6" maxlength="32" placeholder="Password" required />
                <div style="margin:10px 0;height:25px;">
                <label class="label" style="transform:scale(1.1);width:35px;">
                    <input  class="label__checkbox" name="remember" id="remember" type="checkbox" />
                    <span class="label__text">
                    <span class="label__check">
                        <i class="fas fa-check icon" style="font-size:1em;margin-top:3px;"></i>
                    </span>
                    </span>
                </label>
                <label for="remember" style="color:rgba(255,255,255,0.7);cursor:pointer;position:absolute;"> Remember Me </label>
                </div>
                <button type="submit" name="submit" class="btn btn-primary waves-effect waves-light m-r-10 col-12">Login</button>
                <p class="text-center" style="margin-top:10px;font-size:.9em;color:rgba(255,255,255,0.6);">Trouble signing in? 
                <span style="cursor:pointer;color:rgba(255,255,255,0.8);" onclick="window.location.href='https://userarea.gbsproject.com/contact'"><b>Get help here </b></span>
                <i class="far fa-question-circle" style="cursor:pointer;font-size:1.1rem;" data-toggle="tooltip" data-placement="top" title="Your ID is your Student/Teacher/Staff Card Number."></i>
            </form>
        </div>
    </div>
    <button class="btn arrow right" onclick="$('.slick-next').click()"><i class="fas fa-chevron-right"></i></button>
    <p class="skip-button hide" onclick="$('#slick-slide-control01').click();$(this).remove();">Skip >></p>
</body>
<script>
    $(document).ready(function(){
    <?php if(!isset($_GET['login'])){echo 'setLandingCookie();';} ?>
    var _originalSize = $(window).width() + $(window).height()
        $(window).resize(function(){ //fix slick-dots footer issue when opening mobile keyboard.
            if($(window).width() + $(window).height() != _originalSize){
            $("ul.slick-dots").css("position","relative");  
            }else{
            $("ul.slick-dots").css("position","fixed");  
            }
        });
    });
    $('.landing').slick({
    dots: true,
    infinite: false,
    initialSlide: <?php if(isset($_GET['login'])){echo 1;}else{echo 0;} ?>,
    speed: 500,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    edgeFriction: 0.05,
    easing: 'swing',
    });
    $('#slick-slide-control01').on('click',function(){
        $(".skip-button").remove();
    });
    <?php
        if(isset($_GET['login'])){
            echo '$(".skip-button").remove();';
            if( $_GET['login']=='mismatch' || $_GET['login']=='error' || $_GET['login']=='empty' ){
                switch($_GET['login']){
                    case 'mismatch': $message="Wrong Password / ID!";break;
                    case 'error': $message="Oops! Error.";break;
                    case 'empty': $message="Please fill your ID & password first.";break;
                    default: $message="";break;
                }
                echo 'alert("'.$message.'");';
            }
        }
    ?>
</script>
</html>