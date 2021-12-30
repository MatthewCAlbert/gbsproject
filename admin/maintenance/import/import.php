<?php
    require "../../include/structure.php";
    require '../../include/server.php';
    require '../../include/session.checker.php';
    require '../../include/getuserdata.php';
    if( $user_row['level'] < 5 ){
        header("Location: $main_directory/error/403");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../../include/structure/header.php'; ?>
    <title>Import CSV Result - GBS eMoney Maintenance</title>
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
                                <h4 class="card-title">Import Users CSV Files</h4>
                                <p class="card-category">Maintenance</p>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <?php 
                                    $conn->close();
                                    include("csv.php"); 
                                    $csv = new csv();
                                    if(isset($_POST['submit'])){
                                        $target = $_POST['target'];
                                        $filename= $_POST['filename'].'.csv';
                                        echo $target;
                                        if(isset($_FILES['file'])){
                                            $csv->import($_FILES['file']['tmp_name']);
                                        }else{
                                            echo "No CSV Found!";
                                        }
                                    }else{
                                        header("Location: ..");
                                        exit();
                                    }
                                    ?>
                                    <button class="btn btn-primary" id="must" onclick="href('import.res.php')">Generate CSV</button><br>
                                    <button class="btn btn-light" onclick="href('../import')"><i class="material-icons">arrow_back_ios</i>Back</button>
                                    <script>$('#must').click();</script>
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
