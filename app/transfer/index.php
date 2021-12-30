<?php
    require '../include/config.php'; 
    require '../include/server.php';
    require '../include/backend/session.checker.php'; 
    require '../include/backend/getuserdata.php'; 
    if( $user_row['pin'] == "" ){
        header('Location: ../edit/create-pin.php');
        exit();
    }
    $_SESSION['verified_transfer_pin'] = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require '../include/structure/head.php';?>
    <title>Transfer<?php echo $main_title; ?></title>
    <style>
        body{
            background-color: #0277bd;
        }
        h2, h3{
            color:white;
        }
        #amount, #amount:focus{
            border:none;
            background-color:transparent;
            outline:none;
        }
        #amount::placeholder, .rp{
            color:rgba(255,255,255,0.5);
        }
        #rupiah{
            margin-right:10px;
        }
        #rupiah, #amount{
            font-size:1.3em;
            color:white;
        }
        #content p{
            color:rgba(255,255,255,0.7);
            margin: 10px 0;
        }
        h6>span{
            font-weight:bold;
        }
        #pin-wrapper{
            display:none;
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
            <div class="menu-cover menu-slide retract">
                <button class="btn custom-close-btn" onclick="closeMenuTab();"><i class="material-icons">close</i></button>
                <div style="padding: 10%;">
                <h5><b>Transfer to</b></h5>
                <h6>Recipient ID : <span id="ind"></span></h6>
                <h6>Recipient Name : <span id="name"></span></h6>
                <h6>Transfer Amount : <b>Rp</b> <span id="final-value"></span></h6>
                <button class="btn btn-success" onclick="enablePin(true);">Continue</button>
                <button class="btn btn-danger" onclick="closeMenuTab();">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="section" style="padding:8% 10% 0 10%;">
            <h2>Transfer</h2>
            <div class="hr-invert hr" style="margin:5px 0 15px 0;height:2px;width:115px;"></div>
            <h3>Pay To</h3>
            <form action="transfer.php" method="post" name="transfer" id="form" autocomplete="off">
                <input type="text" name="id" value="" placeholder="ID/NIS" class="form-control" maxlength="16" required />
                <br>
                <div style="white-space: nowrap;">
                <h3>Value</h3>
                <span id="rupiah">Rp</span><input type="text" name="value" id="amount" value="" placeholder="0" maxlength="9" required />
                <input type="hidden" name="real-amount" id="real-amount" />
                </div>
                <br>
                <button type="button" class="btn btn-success" style="float:right;" onclick="checkNames()">Transfer</button>
                <button type="submit" name="submit" class="hide"></button>
            </form>
            <div style="padding:40px 0 0 0;">
                <p>* Maximum Transfer value is Rp 1.000.000,-</p>
                <p>* Minimum Transfer value is Rp 2.000,-</p>
            </div>
        </div>
    </div>
    <?php require '../include/structure/pin.php';?>
    <?php require '../include/structure/nav.php';?>
</body>
<?php require '../include/structure/bottom-script.php';?>
<script>
    $(document).ready(function(){
        $("#transfer").addClass("active").attr('onclick','');
        $("#amount").focus();
        disableEnter();
        enablePin(false);
        <?php
        if( isset($_GET['warning']) ){
            echo 'alert("'.$_GET['warning'].'");';
        }
        ?>
    });
    function checkNames(){
        if( $('input[name=real-amount]').val() < 2000 || $('input[name=real-amount]').val() > 1000000 ){
            alert('Please follow requirements!');
        }else if($('input[name=id]').val() == "" ){
            alert('Please fill recepient ID!');
        }else if($("input[name=id]").val() == '<?php echo $user_row["id"]; ?>'){
            alert('Cannot transfer to your own ID!');
        }else{
            $.ajax({
                url: '<?php echo $api_directory; ?>web/users/get_user_data.php',
                method: 'POST',
                crossDomain: true,
                dataType: 'text',
                data: {
                    id: $('input[name=id]').val(),
                    key: <?php echo $_SESSION['api_key']; ?>,
                },
                success: function(response){
                    let res = JSON.parse(response);
                    let message = res['message'];
                    let success = res['success'];
                    if( success == true ){
                        $('#ind').html(message['id']);
                        $('#name').html(message['name']);
                        $('#final-value').html($('#amount').val());
                        openMenuTab();
                    }else{
                        alert('Error');
                    }
                },
                error: function(response){
                    alert('Not Found!');
                }
            });
        }
    }
    cancelPin = ()=>{
        href('../transfer');
    }
    pinCallback = ()=>{

            $.ajax({
                url: '../include/backend/verify_transfer_pin.php',
                method: 'POST',
                dataType: 'text',
                data: {
                    pin: getPinValue(),
                },
                success: function(response){
                    if( response == true ){
                        setPinInfo("",false);
                        enableEnter();
                        $("#form button[name=submit]").click();
                    }else{
                        setPinInfo("PIN Mismatch", true);
                        resetPinValue();
                        pinCallbackState(false);
                        loader_display(false);
                    }
                },
                error: function(response){
                    setPinInfo("Error",true);
                    resetPinValue();
                    pinCallbackState(false);
                    loader_display(false);
                }
            });
    }
</script>
</html>