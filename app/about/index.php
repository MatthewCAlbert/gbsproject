<?php
    require '../include/config.php'; 
    require '../include/server.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require '../include/structure/head.php';?>
    <title>About<?php echo $main_title; ?></title>
</head>
<body>
    <?php require '../include/structure/loader.php';?>
    <?php require '../include/structure/header.php';?>
    <div id="content">
        <div class="section section-white" style="padding: 5%;">
            <h4>About</h4>
            <div class="hr" style="width:70px;"></div>
            <div style="padding: 20px 0;">
                <h6>App Version : WebApp 1.3.1 (Build 20190213)</h6>
                <br>
                <h5>Built using</h5>
                <ul>
                    <li>Language: Javascript, PHP, SQL, HTML, CSS, LESS</li>
                    <li>MySQL</li>
                    <li>PHP 7</li>
                    <li>Bootstrap 4 - <a href="https://getbootstrap.com" target="_blank">(getbootstrap.com)</a></li>
                    <li>jQuery 3.3.1 - <a href="https://jquery.com" target="_blank">(jquery.com)</a></li>
                    <li>Less.js - <a href="http://lesscss.org/" target="_blank">(lesscss.org)</a></li>
                    <li>Google Fonts - <a href="https://fonts.google.com" target="_blank">(fonts.google.com)</a></li>
                    <li>Google Material.io - <a href="https://material.io" target="_blank">(material.io)</a></li>
                    <li>Font Awesome 5 - <a href="https://fontawesome.com" target="_blank">(fontawesome.com)</a></li>
                    <li>LazyLoad - <a href="https://github.com/verlok/lazyload" target="_blank">(github.com/verlok/lazyload)</a></li>
                    <li>Slick - <a href="http://http://kenwheeler.github.io/slick/" target="_blank">(kenwheeler.github.io/slick/)</a> </li>
                    <li>Waves - <a href="http://fian.my.id/Waves" target="_blank">(fian.my.id/Waves)</a> </li>
                    <li>Midtrans - <a href="https://midtrans.com/" target="_blank">(midtrans.com)</a></li>
                </ul>
            </div>
            </div>
        </div>
    </div>
    <?php  
    if(isset($_SESSION['user_id'])){
        include '../include/structure/nav.php';
    }
    ?>
</body>
<?php require '../include/structure/bottom-script.php';?>
<script>
</script>
</html>