<?php
    require '../include/config.php'; 
    require '../include/server.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require '../include/structure/head.php';?>
    <title>Frequently Asked Questions<?php echo $main_title; ?></title>
</head>
<body>
    <?php require '../include/structure/loader.php';?>
    <?php require '../include/structure/header.php';?>
    <div id="content">
        <h5 style="padding:2% 5%;">Frequently Asked Questions (FAQ)</h5>
        <div id="faq" style="">

        </div>
    </div>
    <?php  
    if(isset($_SESSION['user_id'])){
        include '../include/structure/nav.php';
    }
    ?>
</body>
<?php require '../include/structure/bottom-script.php';?>
<script src="faq.js"></script>
<script>
    for( let i = 0 ; i < faq.length ; i++ ){
        let faq_code = '<p onclick="toggleSlide('+i+')" id="slide-toggler-'+i+'" class="slide-toggler faq"><i class="fas fa-angle-right"></i> '+faq[i].question+'</p><div id="slide-'+i+'" class="slide-hide slide-faq">'+faq[i].answer+'</div>';
        $("#faq").append(faq_code);
    }
</script>
</html>