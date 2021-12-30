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
    .tab-wrapper{
        text-align: center;
        padding:10px !important;
        font-size: 1.1em;
    }
    .tab-wrapper:hover{
        background-color: rgba(0,0,0,0.1);
        transition: .3s;
    }
    .tab-wrapper:not(:last-child){
        border-width: 0 0 1px 0;
        border-style: solid;
        border-color: rgba(0,0,0,0.3);
    }
    </style>
</head>
<body>
    <?php require '../include/structure/loader.php';?>
    <?php require '../include/structure/header.php';?>
    <div id="content">
        <p class="section">Account</p>
        <div class="section section-white d-flex flex-column">
            <a href="../account" class="p-1 tab-wrapper flex-fill">
                View Profile
            </a>
            <a href="../edit" class="p-1 tab-wrapper flex-fill">
                Edit Profile
            </a>
        </div>
        <p class="section">Security</p>
        <div class="section section-white d-flex flex-column">
            <?php
                if( $user_row['pin'] == "" ){
                    echo '
                    <a href="../edit/create-pin.php" class="p-1 tab-wrapper flex-fill">Create PIN</a>';
                }else{
                    echo '
                    <a href="../edit/pin.php" class="p-1 tab-wrapper flex-fill">Change PIN</a>';
                }
            ?>
        </div>
        <p class="section">Others</p>
        <div class="section section-white d-flex flex-column">
            <a href="../cs" class="p-1 tab-wrapper flex-fill">
                Customer Service
            </a>
            <a href="../tnc" class="p-1 tab-wrapper flex-fill">
                Terms & Conditions
            </a>
            <a href="../faq" class="p-1 tab-wrapper flex-fill">
                FAQ
            </a>
            <a href="../contact" class="p-1 tab-wrapper flex-fill">
                Contact
            </a>
            <a href="../about" class="p-1 tab-wrapper flex-fill">
                About
            </a>
            <a href="https://gbsproject.com" class="p-1 tab-wrapper flex-fill">
                Go to Our Main Site
            </a>
        </div>
        <div id="logout" class="section section-white btn-waves" onclick="window.location='<?php echo $main_directory.'include/backend/logout.php'; ?>'"><i class="fas fa-sign-out-alt hide"></i> Log Out</div>
    </div>
    <?php require '../include/structure/nav.php';?>
</body>
<?php require '../include/structure/bottom-script.php';?>
<script>
</script>
</html>