<?php 
    require "../../include/structure.php";
    require '../../include/server.php';
    require '../../include/session.checker.php';
    require '../../include/getuserdata.php';
    if( $user_row['level'] < 4 ){
        header("Location: $main_directory/error/403");
        exit();
    }
    $title = "Not Found";
    $verified = false;
    if( isset($_GET['file']) ){
        $data = json_decode(getData($_GET['file']));
        $status = $data->success;
        if( $status == true ){
            $data = $data->message;
            $verified = true;
        }
        // /echo $data;
        $title = $_GET['file'];

    }else{
        header("Location: ../log");
        exit();
    }
    function getData($param){
        //$log_text = implode("\n",$log_text);
        $data = array('param' => "$param",'key'=>"kT2K78fKXsSA6BPh");
        
        $url = 'http://192.168.100.14:8080/gbs-api/sc/logs_reader.php';
        //$url = 'http://api.gbsproject.ga/sc/logs_reader.php';
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch,CURLOPT_POST, count($data));
        curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $head = curl_exec($ch); 
        curl_close($ch); 
        return $head;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../../include/structure/header.php'; 
    require 'search.php';
    ?>
    <title>View Bot Log - GBS eMoney Admin</title>
    <?php require "../../include/structure/script.php"; ?>
    <script>
        var passreset = false;
        var deleteaccount = false;
        var banning = false;
        $(document).ready(function(){
            $(".nav .nav-item:contains('Midtrans')").addClass('active');
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-chart card-header-rose">
                                <h4 class="card-title"><?php echo $title; ?></h4>
                                <p class="card-category">Bot Log Viewer</p>
                            </div>
                            <div class="card-body">
                            <?php
                                if( $verified == true ){
                                    echo '<pre>'.$data.'</pre>';
                                }
                            ?>
                            </div>
                            <div class="card-footer">
                            <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <?php require "../../include/structure/footer.php"; ?>
        </div>
    </div>
</body>
<script>
</script>
</html>
