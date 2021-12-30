<?php
    require '../include/config.php'; 
    require '../include/server.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require '../include/structure/head.php';?>
    <title>Contact<?php echo $main_title; ?></title>
</head>
<body>
    <?php require '../include/structure/loader.php';?>
    <?php require '../include/structure/header.php';?>
    <div id="content">
        <div class="section section-white" style="padding: 5%;">
            <h4>Contact Us</h4>
            <div class="hr" style="width:130px;"></div>
            <div style="padding:20px 0;"><p>
                <i class="fas fa-envelope"></i> Email : emoney.gbs@gmail.com <span onclick="copyToClipboard('emoney.gbs@gmail.com')" class="copy-clipboard" title="Copy To Clipboard" data-toggle="tooltip"><i class="far fa-clone"></i></span><span class="copy-clipboard" onclick="href('mailto:emoney.gbs@gmail.com');"><i class="far fa-envelope"></i></span></p>
                <p><i class="fas fa-phone"></i> Phone Number : +62 XXX XXX XXX (Sean) <span onclick="copyToClipboard('62xxxxxxxxx')" class="copy-clipboard" title="Copy To Clipboard" data-toggle="tooltip"><i class="far fa-clone"></i></span></p>
                <p><i class="fas fa-map-marker-alt"></i> Address : Dursasana <a href="https://www.google.com/maps/place/SMAK+1+BPK+Penabur+Bandung/@-6.9037804,107.5946772,17z/data=!3m1!4b1!4m5!3m4!1s0x2e68e66a9e40f8cd:0xce6dca59f95077f7!8m2!3d-6.9037804!4d107.5968659" target="_blank" title="Open in Maps" data-toggle="tooltip" class="copy-clipboard"><i class="fas fa-map-marked-alt"></i></a></p>
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