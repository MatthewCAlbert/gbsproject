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
    <title>Top Up<?php echo $main_title; ?></title>
    <link rel="stylesheet/less" href="../assets/css/checkcross_animation.less" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js" ></script>
    <style>
        body{
            background-color: #009688;
        }
        h2, h3, h4{
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
        #result{
            height:45vh;
        }
        #result p.text-center{
            font-size: 1.2em;
        }
        #result-loader, #result-result, #result-reject{
            display:none;
        }
        #result-loader > img{
            max-width:100px;
            margin:auto;
            display:table;
        }
        @media screen and (max-width: 700px) {
            #result{
                height:60vh;
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
                <div style="padding: 10%;">
                <h5><b>Transfer to</b></h5>
                <h6>Recipient ID : <span id="ind"></span></h6>
                <h6>Recipient Name : <span id="name"></span></h6>
                <h6>Transfer Amount : <b>Rp</b> <span id="final-value"></span></h6>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="section" style="padding:8% 10% 0 10%;">
            <form action="checkout.php" method="post" name="transfer" id="form" autocomplete="off">
                <h2>Top Up</h2>
                <div class="hr-invert hr" style="margin:5px 0 15px 0;height:2px;width:95px;"></div>
                <div style="white-space: nowrap;">
                <h3>Value</h3>
                <span id="rupiah">Rp</span><input type="text" name="value" id="amount" value="" placeholder="0" maxlength="7" />
                <input type="hidden" name="real-amount" id="real-amount" />
                </div>
                <br>
                <button type="button" class="btn btn-success" style="float:right;" onclick="continueToPay()">Continue to Payment</button>
                <button type="button" name="submit" id ="pay-button" hidden></button>
                <div style="padding:40px 0 0 0;">
                    <p>* Maximum Top Up value is Rp 500.000,-</p>
                    <p>* Minimum Top Up value is Rp 10.000,-</p>
                </div>
            </form>
            <div id="result" class="d-flex justify-content-center">
                <div id="result-loader" class="align-self-center">
                <p class="text-center">Your Transaction is being processed...</p>
                <img src="../assets/img/loading.gif" alt="loader">
                <p class="label label-warning" style="padding:10px;font-size:1em;line-height:1.2em;display:none;" id="notice-payment">Note: If you haven't reach the final process of the ordering process. The order will be cancelled and you will have to refresh this page in order to get a new order form.</p>
                </div>
                <div id="result-result" class="align-self-center">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                    <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                    <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                    </svg>
                    <p class="text-center">Your placement order has been finished.</p>
                </div>
                <div id="result-reject" class="align-self-center">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                    <circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                    <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/>
                    <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/>
                    </svg>
                    <p class="text-center">Your placement order is cancelled.</p>
                </div>
            </div>
        </div>
    </div>
    <?php require '../include/structure/nav.php';?>
</body>
<?php require '../include/structure/bottom-script.php';?>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-9vMWYor8uxCLvIGL"></script>
<script type="text/javascript">
    $(document).ready(function(){
        disableEnter();
        let email = "<?php echo $user_row['email'] ?>";
        if(email==""){
            $('.section').html('<h4>Please add your email first!</h4><a class="btn btn-primary" href="../account">Add Here</a>');
        }
        $("#amount").focus();
    });
  var response = '';
    function continueToPay(){
        var value = $('input[name=real-amount]').val();
        if( value <= 500000 && value >=10000 ){
            $("#form").hide();
            $("#result-loader").show();
            let order_index ='T-'+new Date().getTime();
            $.ajax({
                url: '<?php echo $api_directory; ?>sc/tracker.php',
                method: 'POST',
                crossDomain: true,
                dataType: 'text',
                data: {
                    id: '<?php echo $user_row['id'] ?>',
                    order_id: order_index,
                    value: value,
                },
                success: function(response){
                    let res = JSON.parse(response);
                    let message = res['message'];
                    let success = res['success'];
                    if( success == true ){
                        processToPayment(order_index,value,message);
                        $("#notice-payment").show();
                    }else{
                        alert('Error');
                    }
                }
            });
        }else if( value < 10000 ){
            alert("Minimum Top Up is Rp 10K!");
        }else if( value < 500000 ){
            alert("Maximum Top Up is Rp 500K!");
        }else{
            alert("Please enter a value!");
        }
    }
    async function processToPayment(index,value,result){
        var requestBody = 
        {
        transaction_details: {
            gross_amount: value,
            // as example we use timestamp as order ID
            order_id: index
        },
        customer_details: {
            first_name: '<?php echo $user_row['name'] ?>',
            last_name: '<?php echo $user_row['id'] ?>',
            email: '<?php echo $user_row['email'] ?>',
            phone: '<?php echo $user_row['phone'] ?>'
        }
        }

        if( result=="success" ){
                console.log("Ok");
                getSnapToken(requestBody, function(response){
                var response = JSON.parse(response);
                console.log("new token response", response);
                // Open SNAP payment popup, please refer to docs for all available options: https://snap-docs.midtrans.com/#snap-js
                snap.pay(response.token);
                });
        }else{
            console.log("Ignored");
            $("#result-reject").show();
            await new Promise((resolve,reject)=>{
                setTimeout(() => {
                $("#result-reject").hide();
                resolve();
                }, 2000);
            });
            $("#result-loader").hide();
            $("#form").show();
        }
    }
  /**
  * Send AJAX POST request to checkout.php, then call callback with the API response
  * @param {object} requestBody: request body to be sent to SNAP API
  * @param {function} callback: callback function to pass the response
  */

  function getSnapToken(requestBody, callback) {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
      if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        callback(xmlHttp.responseText);
      }
    }
    xmlHttp.open("post", "checkout.php");
    xmlHttp.send(JSON.stringify(requestBody));
  }

  $(".header-back").on("click",function(){
    console.log("clicked");
    $("#result-reject").show();
  });
  <?php
    if(isset($_GET['success'])){
        echo '$("#form").hide();$("#result-result").show();';
    }
  ?>
</script>
</html>