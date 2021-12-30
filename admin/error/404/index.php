<?php 
    require "../../include/structure.php";
    require '../../include/server.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../../include/structure/header.php'; 
    ?>
    <title>404 Not Found - GBS eMoney Admin</title>
    <?php require '../../include/structure/script.php'; 
    ?>
    <style>
        body{
            overflow: hidden;
            margin:auto;
            display:table;
        }   
        .content{
            min-height:80%;
        }
        .big{
            font-size:15em;
            font-weight:bold;
            color:#9A239C;
            line-height:90%;
            cursor:default;
        }
    </style>
</head>

<body class="">
    <div class="wrapper">
        <div class="content text-center d-flex align-items-center">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="big">404</h1>
                    <h3>Content Not Found</h3>
                    <h4>Seems you have been lost.</h4>
                    <a class="btn btn-primary" href="<?php echo $main_directory ?>">Back to Home</a>
                </div>
            </div>
        </div>
        <?php require '../../include/structure/footer.php'; ?>
    </div>
</body>
</html>