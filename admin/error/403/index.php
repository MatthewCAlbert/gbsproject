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
    <title>403 Forbidden Access - GBS eMoney Admin</title>
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
                    <h1 class="big">403</h1>
                    <h3>Forbidden Access</h3>
                    <h4>You Don't Have Permission To Access On This Server.</h4>
                    <a class="btn btn-primary" href="<?php echo $main_directory ?>">Back to Home</a>
                </div>
            </div>
        </div>
        <?php require '../../include/structure/footer.php'; ?>
    </div>
</body>
</html>