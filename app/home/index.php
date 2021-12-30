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
    <title>Home<?php echo $main_title; ?></title>
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
            </div>
        </div>
    </div>
    <div id="content">
        <div class="section section-green">
            <div class="section-head">
                <span>My Wallet</span>
                <span style="float:right;"><i class="fas fa-wallet"></i> Rp <?php echo number_format($user_row['balance'],0,",","."); ?></span>
            </div>
            <div class="main-tab">
                <div style="margin:auto;display:table;">
                <button class="btn <?php if($status != "vendor"){echo 'hide';} ?>" onclick="href('../overview');"><i class="fas fa-chart-pie"></i><p>Overview</p></button>
                <button class="btn" onclick="href('../transfer');"><i class="fas fa-exchange-alt"></i><p>Transfer</p></button>
                <button class="btn" onclick="href('../history');"><i class="fas fa-list-alt"></i><p>History</p></button>
                <button class="btn" onclick="href('../account');"><i class="fas fa-user-circle"></i><p>Account</p></button>
                </div>
            </div>
        </div>
        <div class="section section-primary">
            <div class="section-head">
                Midtrans
            </div>
            <div class="main-tab">
                <div style="margin:auto;display:table;">
                <button class="btn" onclick="href('../topup');"><i class="fas fa-plus-circle"></i><p>Top Up</p></button>
                <button class="btn" onclick="href('../midtrans');"><i class="fas fa-info-circle"></i><p>Status</p></button>
                </div>
            </div>
        </div>
        <div class="section section-blue">
            <div class="section-head">
                Recent Activity
                <i id="slide-toggler-1" onclick="slider(1,false)" class="slide-toggler fas fa-chevron-down" style="position:absolute;top:0;right:0;padding:15px;"></i>
            </div>
            <div id="slide-toggle-1">
            <?php
                $curl_res = new \MyApp\Http\Curl($api_directory.'web/users/get_recent_activity.php', array(
                    CURLOPT_POSTFIELDS => array("key"=>$_SESSION['api_key'],"id"=>$user_row['id'],"status"=>$user_row['status'],"number"=>5)
                ));
                try {
                    $curl_res = json_decode($curl_res);
                    $transactions = $curl_res->message;
                    if( count($transactions) > 0 ){
                        foreach($transactions as $transaction){
                            $status = "";$plusmin = "";
                            switch($transaction->status){
                                case 'success': $status='<span class="text-success">'.ucfirst($transaction->status).'</span>';break;
                                case 'failed': $status='<span class="text-danger">'.ucfirst($transaction->status).'</span>';break;
                                case 'error': $status='<span class="text-warning">'.ucfirst($transaction->status).'</span>';break;
                            }
                            $value = number_format($transaction->value,0,",",".");
                            if($transaction->status == "success"){
                                switch($transaction->type){
                                    case "Withdraw": $plusmin = '<span class="text-danger">- Rp '.$value.'</span>';break;
                                    case "Top Up": $plusmin = '<span class="text-success">+ Rp '.$value.'</span>';break;
                                    default: if( $transaction->aswhat == "sender" ){
                                        $plusmin = '<span class="text-danger">- Rp '.$value.'</span>';
                                    }else{
                                        $plusmin = '<span class="text-success">+ Rp '.$value.'</span>';
                                    } break;
                                }
                            }else{
                                $plusmin = '<span class="text-secondary"> Rp '.$value.'</span>';
                            }
                            //date("d F Y H:i",strtotime($transaction->date))
                            $format = '
                            <div class="scroll-list row" onclick="href('."'../transaction?id=$transaction->id'".')">
                            <div class="col-6">
                                <p>'.ucfirst($transaction->name).'</p>
                                <p style="font-size:0.85em;opacity:.6;">'.$transaction->type.' - '.$status.'</p>
                            </div>
                            <div class="col-6">
                                <p>'.$plusmin.'</p>
                                <p style="font-size:.8em;opacity:.6;">'.date("d M Y",strtotime($transaction->date)).'</p>
                            </div>
                            </div>';
                            echo $format;
                        }
                    }else{
                        $format = '
                        <div class="scroll-list row">
                        <div class="col-12">
                            <p class="text-center">No Transaction Found.</p>
                        </div>
                        </div>';
                        echo $format;
                    }
                } catch (\RuntimeException $ex) {}
            ?>
            </div>
        </div>
        <div class="section">
            <div class="slider news hide">
            <?php
                $curl_res = new \MyApp\Http\Curl($api_directory.'web/news/getnews.php', array(
                    CURLOPT_POSTFIELDS => array()
                ));
                try {
                    $curl_res = json_decode($curl_res);
                    $news = json_decode(json_encode($curl_res->message),true);
                    foreach($news as $new){
                        echo '<div><img class="lazy" data-src="'.$new["image"].'" alt="'.$new["title"].'" /></div>';
                    }
                } catch (\RuntimeException $ex) {
                    //die(sprintf('Http error %s with code %d', $ex->getMessage(), $ex->getCode()));
                }
            ?>
            </div>
        </div>
    </div>
    <?php require '../include/structure/nav.php';?>
</body>
<?php require '../include/structure/bottom-script.php';?>
<script>
    $(document).ready(function(){
        $("#home").addClass("active").attr('onclick','');
    });

    $('.news').slick({
    dots: true,
    infinite: true,
    speed: 300,
    slidesToShow: 2,
    slidesToScroll: 2,
    arrows: false,
    responsive: [
        {
        breakpoint: 600,
        settings: {
            slidesToShow: 1,
            slidesToScroll: 1
        }
        }
    ]
    });
</script>
</html>