<?php
    require '../include/config.php'; 
    require '../include/server.php';
    require '../include/backend/session.checker.php'; 
    require '../include/backend/getuserdata.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require '../include/structure/head.php';?>
    <title>Account Settings<?php echo $main_title; ?></title>
    <style>
    #logout{
        color:black;
        font-size: 1.2em;
        color: red !important;
        padding:10px 20px;
        position: relative;
        top:-20px;
    }
    #logout:hover{
        color: white !important;
        background-color: rgba(0,0,0,.3) !important;
        transition: .3s ease-in-out;
        text-decoration: none;
    }
    .tab-link{
        cursor:pointer;
        font-size: 1.1em;
        color: black;
    }
    .tab-wrapper{
        text-align: center;
    }
    #edit{
        position: absolute;
        top:10px;
        right:15px;
        cursor:pointer;
        color:green;
    }
    </style>
</head>
<body>
    <?php require '../include/structure/loader.php';?>
    <?php require '../include/structure/header.php';?>
    <div id="content">
        <div class="section section-white" style="padding: 0px 20px 20px 20px;">
            <br>
            <h5><?php echo $user_row['name']; ?></h5>
            <h5><label class="label label-primary"><?php echo ucfirst($_SESSION['status']); ?> ID</label> <?php echo $user_row['id']; ?></h5>
            <table>
                <tr>
                    <td style="width:30px;"><i class="far fa-envelope"></i></td>
                    <td><h6>: <?php if($user_row['email']!="") {echo $user_row['email'];} else { echo 'No Registered Email'; } ?></h6></td>
                </tr>
                <tr>
                    <td><i class="fas fa-mobile-alt" style="margin-left:3px;"></i></td>
                    <td><h6>: <?php if($user_row['phone']!="") {echo '+62 '.$user_row['phone'];} else { echo 'No Registered Phone Number'; } ?></h6></td>
                </tr>
            </table>
            <button class="btn btn-success" style="float:right;margin:0 5px;" onclick="href('../edit')"><i class="fas fa-edit"></i></button>
            <?php
                if( $user_row['pin'] == "" ){
                    echo '
                    <button class="btn btn-primary" style="float:right;" onclick="href('."'../edit/create-pin.php'".');">Create PIN</button>';
                }else{
                    echo '
                    <button class="btn btn-primary" style="float:right;" onclick="href('."'../edit/pin.php'".');">Change PIN</button>';
                }
            ?>
        </div>
    </div>
    <?php require '../include/structure/nav.php';?>
</body>
<?php require '../include/structure/bottom-script.php';?>
<script>
    $(document).ready(function(){
        $("#setting").addClass("active").attr('onclick','');
    });
</script>
</html>