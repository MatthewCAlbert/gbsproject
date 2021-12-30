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
    <title>Access Level - GBS eMoney Admin</title>
    <?php require '../../include/structure/script.php'; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('Access Level')").addClass('active');
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
                        <div class="card-header card-header-warning">
                            <h4 class="card-title">Access Level</h4>
                            <p class="card-category">Information</p>
                        </div>
                        <div class="card-body">
                            <div class="card-title">
                                <h2></h2>
                            </div>
                            <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Level</th>
                                        <th class="text-center">Features</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">
                                            1 (Customer Service)
                                        </td>
                                        <td class="text-center">
                                            Help Desk.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            2 (Moderator)
                                        </td>
                                        <td class="text-center">
                                            Help Desk, View Users and Session, Reset Password, Change Info.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            3 (Booth Admin)
                                        </td>
                                        <td class="text-center">
                                            Do Transaction, Create User Account.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            4 (Supervisor)
                                        </td>
                                        <td class="text-center">
                                            Manage Other Admin + Access to all level 1-3 features.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            5 (Admin Master)
                                        </td>
                                        <td class="text-center">
                                            All features.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
            <?php require '../../include/structure/footer.php'; ?>
        </div>
    </div>
</body>
</html>
