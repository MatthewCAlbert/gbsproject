<?php
require "../../include/structure.php";
require '../../include/server.php';
if(isset($_SESSION['useradmin_id'])){
    require '../../include/getuserdata.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../../include/structure/header.php'; 
    ?>
    <title>Licenses - GBS eMoney Admin</title>
    <?php require '../../include/structure/script.php'; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('Licenses')").addClass('active');
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
            <?php require '../../include/structure/sidenav-bar-help.php'; ?>
        </div>
        <div class="main-panel">
            <?php 
                $nav_title= "Information Centre";
                if(isset($_SESSION['useradmin_id'])){
                    require '../../include/structure/navbar-help.php'; 
                }else{
                    require '../../include/structure/navbar-help.php'; 
                }
            ?>
            
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Licenses</h4>
                            <p class="card-category">Information</p>
                        </div>
                        <div class="card-body">
                            <div class="card-title">
                                <h3>Lorem Ipsum</h3>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut purus mauris, congue eu iaculis vitae, tempus eu dolor. Vestibulum euismod ut velit a pretium. Cras tempor ligula magna, ut mollis purus posuere nec. Aliquam tempor, mi vel porta congue, orci urna faucibus dolor, id tristique ipsum ligula quis justo. Nam a est eu nisl vulputate pulvinar. Aliquam sit amet volutpat lorem. Sed luctus enim quis neque egestas luctus.

                                    Ut metus diam, rhoncus ut turpis a, finibus auctor enim. Mauris et vehicula nisi. Sed dapibus nibh a magna luctus blandit. Nulla pulvinar ante metus, at sollicitudin mi accumsan ac. Vivamus sollicitudin tortor eget felis tristique rutrum. In quis lectus eu lacus sollicitudin congue. In vitae consectetur nibh. Sed sit amet arcu sit amet arcu aliquam condimentum mollis et quam. Praesent efficitur egestas laoreet. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam aliquet, orci quis ultrices fringilla, leo augue molestie erat, et dignissim metus velit hendrerit felis. Donec justo metus, ultrices quis dolor nec, vehicula tristique tortor.

                                    Donec erat nisl, consectetur at dui sed, mollis vulputate dui. Morbi bibendum ex ac velit laoreet aliquam. Pellentesque nunc ex, rhoncus sit amet sem sit amet, facilisis scelerisque erat. Suspendisse varius nisl eget risus ornare pretium. Pellentesque vitae ante vel tortor porttitor facilisis id non arcu. Pellentesque ullamcorper at dui lacinia lacinia. Mauris nibh nisl, venenatis vel venenatis et, interdum nec mauris.

                                    Nullam arcu massa, ornare et scelerisque quis, pellentesque tempor lacus. Praesent mollis finibus dui, ut vulputate diam suscipit at. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aliquam placerat malesuada nibh feugiat tristique. Ut at arcu vitae lorem lacinia feugiat ut eu lacus. Curabitur rhoncus sapien sed ipsum varius volutpat. Vivamus feugiat orci sit amet pretium commodo. Curabitur condimentum fermentum mi ac commodo. Duis mattis feugiat finibus. Aenean ipsum tortor, porttitor non venenatis eget, consequat eget nibh.

                                    Aliquam eget elit congue, euismod sapien ac, mattis nibh. Vivamus rhoncus nec nisl eu porttitor. Aliquam semper eleifend odio vel tempus. Maecenas pretium tellus at rhoncus accumsan. Nam mollis tortor id quam consequat fermentum. Praesent accumsan mollis quam, non sodales quam hendrerit at. Aliquam nibh nulla, sagittis nec consequat vel, vulputate quis ligula. Vivamus varius tempus urna, ultricies auctor lectus ultricies nec. Donec rutrum ante et pharetra consectetur. Nunc rhoncus, lorem eget gravida consectetur, tellus dolor molestie erat, eu porta est dolor in ligula. Suspendisse laoreet, justo non mattis ullamcorper, massa elit lobortis nisl, vitae dignissim libero urna ac nunc. Suspendisse sed eleifend massa.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php require '../../include/structure/footer.php'; ?>
        </div>
    </div>
</body>
</html>
