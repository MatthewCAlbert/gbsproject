<?php
    require '../include/config.php'; 
    require '../include/server.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require '../include/structure/head.php';?>
    <title>Browser Info<?php echo $main_title; ?></title>
    <script src="<?php echo $main_directory; ?>assets/js/mobile-detect.min.js"></script>
    <script>
        var md = new MobileDetect(window.navigator.userAgent);
    </script>
</head>
<body>
    <?php require '../include/structure/loader.php';?>
    <?php require '../include/structure/header.php';?>
    <div id="content">
        <div class="section section-white" style="padding: 5%;">
            <h4>Browser Info</h4>
            <div class="hr" style="width:145px;"></div>
            <div style="padding:20px 0;" id="browser">
            </div>
            <div>
            <a href="http://hgoebl.github.io/mobile-detect.js/" style="color:purple;" target="_blank">Mobile Detect JS</a>
            <br><br>
            <iframe src="http://hgoebl.github.io/mobile-detect.js/" frameborder="0" width="100%" height="300px"></iframe>
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
    function appendNewLine(title,content){
        $("#browser").append("<p>"+title+" : "+content+"</p>");
    }
    appendNewLine("UA",md.ua);
    appendNewLine("Max Phone Width",md.maxPhoneWidth);
    appendNewLine("Mobile",md.mobile());
    appendNewLine("Phone",md.phone());
    appendNewLine("Tablet",md.tablet());
    appendNewLine("Mobile Grade",md.mobileGrade());
    appendNewLine("User Agent",md.userAgent());
    appendNewLine("Operating System",md.os());
    appendNewLine("isiPhone",md.is('iPhone'));
    appendNewLine("isBot",md.is('bot'));
    appendNewLine("Webkit",md.version('Webkit'));
    appendNewLine("Build",md.versionStr('Build'));
    appendNewLine("isConsole",md.match('playstation|xbox'));
</script>
</html>