<?php
require "../../include/structure.php";
require '../../include/server.php';
require '../../include/session.checker.php';
require '../../include/getuserdata.php';
if( $user_row['level'] < 5 ){
    header("Location: $main_directory/error/403");
    exit();
}
$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = $url_array[0];

require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';
$client = new Google_Client();
$client->setClientId('743381051314-mpdh74117415farip2lphp84vi34b439.apps.googleusercontent.com');
$client->setClientSecret('j9LMwmpbdrU_foC2VuEquaC2');
$client->setRedirectUri($url);
$client->setScopes(array('https://www.googleapis.com/auth/drive'));
if (isset($_GET['code'])) {
    $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
    header('location:'.$url);exit;
} elseif (!isset($_SESSION['accessToken'])) {
    $client->authenticate();
}

if( !empty($_FILES) && isset($_POST['submit']) ){
    // Read files from post
    $files = $_FILES['file'];
}

if (!empty($_POST) && isset($_POST['auth']) ) {
    if( $_POST['auth'] == true ){
        //GDrive Token
        $client->setAccessToken($_SESSION['accessToken']);
        $service = new Google_DriveService($client);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file = new Google_DriveFile();
        foreach ($files as $file_name) {
            $file_path = 'files/'.$file_name;
            $mime_type = finfo_file($finfo, $file_path);
            $file->setTitle($file_name);
            $file->setDescription('This is a '.$mime_type.' document');
            $file->setMimeType($mime_type);
            $service->files->insert(
                $file,
                array(
                    'data' => file_get_contents($file_path),
                    'mimeType' => $mime_type
                )
            );
        }
        finfo_close($finfo);
        header('location:'.$url);exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../../include/structure/header.php'; ?>
    <title>Google Drive Back Up - GBS eMoney Maintenance</title>
    <?php require '../../include/structure/script.php'; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('Maintenance')").addClass('active');
        });
    </script>
</head>

<body class="">
    <div class="wrapper">
        <div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
            <?php require "../../include/structure/sidenav-bar.php"; ?>
        </div>
        <div class="main-panel">
            <?php require "../../include/structure/navbar.php"; ?>
            <div class="content">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header card-chart card-header-info">
                                <h4 class="card-title">Upload to Google Drive</h4>
                                <p class="card-category">Maintenance</p>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                <form method="post" action="index.php" enctype="multipart/form-data">
                                    <input type="file" name="file" class="form-control-file border" style="width:50%;" required><br>
                                    <input type="submit" class="btn btn-primary" value="Select Files" name="submit">
                                </form>
                                <div class="hr hr-60"></div>
                                <ul>
                                <?php 
                                    echo '<li>'.$files.'</li>';
                                ?>
                                </ul>
                                <form method="post" action="<?php echo $url; ?>" enctype="multipart/form-data">
                                    <input type="hidden" value="true" name="auth" hidden>
                                    <input type="submit" class="btn btn-primary" value="Upload" name="submit">
                                </form>
                                    <button class="btn btn-light" onclick="window.history.back()"><i class="material-icons">arrow_back_ios</i>Back</button>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
            <?php require '../../include/structure/footer.php'; ?>
        </div>
    </div>
</body>
</html>