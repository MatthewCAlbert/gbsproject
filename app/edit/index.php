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
    <title>Account Edit<?php echo $main_title; ?></title>
    <style>
        input[type=password]{
            margin-bottom:10px;
        }
        .menu-cover-sm > button:not(.custom-close-btn){
            margin-right: 10px;
            float:right;
        }
    </style>
</head>
<body>
    <?php require '../include/structure/loader.php';?>
    <?php require '../include/structure/header.php';?>
    <div id="trigger-menu">
        <div class="menu-wrapper">
            <div id="black-cover" onclick="closeMenuTab();">
            </div>
            <div class="menu-cover-sm menu-slide retract" style="padding:30px;">
                <button class="btn custom-close-btn" onclick="closeMenuTab();"><i class="material-icons">close</i></button>
                <h4>Are You Sure?</h4>
                <h6>This action cannot be undone !</h6>
                <br>
                <button class="btn btn-danger" onclick="closeMenuTab()">No</button>
                <button class="btn btn-success" onclick="enableEnter();$('#pass-click').click()">Yes</button>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="section section-white" style="padding: 0 20px 20px 20px;">
            <br>
            <h5><?php echo $user_row['name']; ?></h5>
            <h5><label class="label label-primary">ID</label> <?php echo $user_row['id']; ?></h5>
            <div class="hr" style="margin:20px 0;"></div>
            <form action="edit.php" method="post">
                <h5>Email</h5>
                <input type="email" name="email" class="form-control" value="<?php echo $user_row['email']; ?>" maxlength="100" />
                <br>
                <h5>Phone No</h5>
                <input type="text" name="phone" class="form-control" value="<?php echo $user_row['phone']; ?>" maxlength="20" />
                <br>
                <button type="submit" name="submit" class="btn btn-primary" style="float:right;" onclick="">Save</button>
                <button type="button" class="btn btn-danger" style="float:right;margin:0 5px;" onclick="href('../account')">Cancel</button>
            </form>
            <div class="hr" style="margin:60px 0 20px 0;"></div>
            <form action="edit.php" method="post" id="form">
                <h6>Old Password</h6>
                <input type="password" class="form-control" name="old-password" minlength="6" maxlength="32" required />
                <span id="strength" style="font-size:.8em;position:absolute;right:20px;"></span>
                <h6>New Password</h6>
                <input type="password" id="password" class="form-control" name="new-password" minlength="8" maxlength="32" onkeyup="passwordChanged()" required />
                <h6>Retype New Password</h6>
                <input type="password" class="form-control" name="re-password" minlength="8" maxlength="32" required />
                <br>
                <button type="button" class="btn btn-primary" style="float:right;" onclick="openMenuTab();">Change Password</button>
                <button type="submit" name="submit" class="hide" id="pass-click"></button>
            </form>
        </div>
    </div>
    <?php require '../include/structure/nav.php';?>
</body>
<?php require '../include/structure/bottom-script.php';?>
<script>
    $(document).ready(function(){
        disableEnter();
        $("#setting").addClass("active");
    });
</script>
</html>