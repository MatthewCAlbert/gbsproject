<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        require '../include/head.php';
    ?>
    <title>GBS Project - School Cashless Solution</title>
</head>
<body>
    <div id="main-container">
        <?php 
            require '../include/header.php';
        ?>
        <div id="main-wrapper">
            <div class="container-fluid page-header">
                <div class="row">
                    <div class="col-12">
                        <h2>Frequently Asked Question (FAQ)</h2><br>
                        <p>Here's a few of information or question about our products. </p>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="section" id="section-1">
                    <div class="row">
                        <div class="col-12" id="faq">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            require '../include/footer.php';
        ?>
    </div>
</body>
<script src="faq.js"></script>
<script>
    for( let i = 0 ; i < faq.length ; i++ ){
        let faq_code = '<p onclick="toggleSlide('+i+')" id="slide-toggler-'+i+'" class="slide-toggler"><i class="fas fa-angle-right"></i> '+faq[i].question+'</p><div id="slide-'+i+'" class="slide-hide">'+faq[i].answer+'</div>';
        $("#faq").append(faq_code);
    }
</script>
</html>