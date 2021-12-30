<?php
    require '../include/config.php'; 
    require '../include/server.php';
    require '../include/backend/session.checker.php'; 
    require '../include/backend/getuserdata.php'; 
    if( $user_row['pin'] != "" ){
        header('Location: ../account');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require '../include/structure/head.php';?>
    <title>Create PIN<?php echo $main_title; ?></title>
    <style>
    </style>
</head>
<body>
    <?php require '../include/structure/loader.php';?>
    <?php require '../include/structure/pin.php';?>
    <form action="create_pin.php" method="post" class="hide" id="form">
        <input type="text" maxlength="6" name="create_pin" val="" />
        <input type="text" maxlength="6" name="create_re_pin" val="" />
        <input type="submit" value="" />
    </form>
</body>
<?php require '../include/structure/bottom-script.php';?>
<script>
    var current_steps = 0;
    function changeSteps(x){
        current_steps = x;
    } 
    $(document).ready(function(){
        disableEnter();
        changePinHeader("Create New PIN",false);
    });
    cancelPin = ()=>{
        href('../account');
    }
    pinCallback = ()=>{
        pinCallbackState(true);
        loader_display(true);
        switch(current_steps){
            case 0 :
            $("#form input[name=create_pin]").val(getPinValue());
            changePinHeader("Re-Enter Your PIN",false);
            setTimeout(() => {
                changeSteps(1);
                resetPinValue();
                pinCallbackState(false);
                loader_display(false);
            }, 1000);
            break;
            case 1 : 
            $("#form input[name=create_re_pin]").val(getPinValue());
            if( $("#form input[name=create_pin]").val() == $("#form input[name=create_re_pin]").val() ){
                $("#form input[type=submit]").click();
            }else{
                setTimeout(() => {
                    changePinHeader("Create New PIN",false);
                    setPinInfo("Mismatch PIN",true);
                    changeSteps(0);
                    resetPinValue();
                    pinCallbackState(false);
                    loader_display(false);
                }, 1000);
            }
            break;
        }
    }
</script>
</html>