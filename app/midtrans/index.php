<?php
    require '../include/config.php'; 
    require '../include/server.php';
    require '../include/backend/session.checker.php'; 
    require '../include/backend/getuserdata.php'; 
    require '../include/backend/curl.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require '../include/structure/head.php';?>
    <title>Midtrans Order History<?php echo $main_title; ?></title>
    <style>
    #load-more{
        font-size:1.2em;
        cursor:pointer;
    }
    #detail{
        padding: 5%;
    }
    @media screen and (max-width: 700px) {
        #detail{
            padding: 15% 5%;
        }
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
                <div id="detail">
                
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="section section-blue">
            <div class="section-head">
                Midtrans Order History
            </div>
            <div id="list-area">
            </div>
        </div>
        <div class=" d-flex justify-content-center hide" style="height:40vh;opacity:.6;" id="not-found">
            <div class="align-self-center">
            <i class="far fa-frown" style="font-size:20vh;margin:auto;display:table;line-height:20vh;opacity:.3;"></i>
            <p style="max-width:80%;margin:10px auto;display:table;" class="text-center">It seems that you haven't done any order yet.</p>
            </div>
        </div>
        <div style="margin:auto;display:table;" id="load-more-wrapper">
        <p onclick="getData()" class="un" id="load-more">Load more <i class="fas fa-chevron-down"></i></p>
        </div>
    </div>
    <?php require '../include/structure/nav.php';?>
</body>
<?php require '../include/structure/bottom-script.php';?>
<script>
    $(document).ready(function(){
        getData();
    });
    var start = 0;
    var limit = 10;
    var reachedMax = false;
    var no_data_appended = false;
    var data_available = false;
    /*
    $(window).scroll(function(){
        if($(window).scrollTop() >= ($(document).height() - $(window).height())-100 ){
            getData();
        }
    });
    */
    function getData(){
        if( reachedMax ){
            return;
        }
        loader_display(true);

        $.ajax({
            url: '<?php echo $api_directory; ?>web/users/get_midtrans_history.php',
            method: 'POST',
            dataType: 'text',
            data: {
                id: <?php echo $user_row['id']; ?>,
                key: <?php echo $_SESSION['api_key']; ?>,
                getData: 1,
                start:start,
                limit:limit
            },
            success: function(response){
                loader_display(false);
                if(response == "reachedMax"){
                    $("#load-more-wrapper").html('<div class="hr" style="margin:20px 0;width:30vw;"></div>');
                    reachedMax = true;
                    if( data_available == false ){
                    if( no_data_appended == false ){
                        no_data_appended = true;
                        $("#not-found").removeClass('hide');
                    }
                    }
                }else{
                    data_available = true;
                    start += limit;
                    $('#list-area').append(response);
                }
            }
        });
    }
    function getDetail(id){
        $.ajax({
            url: '<?php echo $api_directory; ?>web/users/get_midtrans_data.php',
            method: 'POST',
            dataType: 'text',
            data: {
                id: id,
                key: <?php echo $_SESSION['api_key']; ?>,
            },
            success: function(response){
                let resp = JSON.parse(response);
                if( resp.success == true ){
                    let message = resp.message;
                    let html ="<p>Order ID : "+message.id+"</p><p>User : "+message.name+"</p><p>Status : "+message.status+"</p><p>Time : "+message.time+"</p><p>Value : Rp "+message.value+"</p><p>Message :</p><p class=\"text-justify\" style=\"padding:5%;background-color:rgba(0,0,0,0.05);border-radius:5px;\">"+message.message+"</p>";
                    $("#detail").html(html);
                    openMenuTab();
                } 
            }
        });
    }
</script>
</html>