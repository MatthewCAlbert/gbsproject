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
    <title>Overview<?php echo $main_title; ?></title>
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
        <div class="section section-white" style="padding:20px;">
            <h3>Sales Overall <small id="date"></small> </h3>
            <div class="row">
                <div class="col-6">
                <select id="range" class="form-control" onchange="decideData()">
                    <option value="all">All Time</option>
                    <option value="weekly">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="annually">Annually</option>
                    <option value="last week">Last Week</option>
                    <option value="past 3 months">Past 3 Months</option>
                    <option value="past 6 months">Past 6 Months</option>
                </select>
                </div>
                <div class="col-6">
                <input type="month" name="month" id="" class="form-control"/>
                </div>
            </div>

            <div id="overall"></div>
        </div>
    </div>
    <?php require '../include/structure/nav.php';?>
</body>
<?php require '../include/structure/bottom-script.php';?>
<script>
    $(document).ready(()=>{
        decideData();
    });
    function decideData(){
        var value = $('#range').val();
        if( value != "monthly" || value != "annually" ){
            $('input[name=month]').attr("disabled",true);
        }else{
            $('input[name=month]').attr("disabled",false);
        }
        getData(value);
    }
    function getData(r="all",m="",y=""){
        //kasih loader spesial
        $.ajax({
            url: '<?php echo $api_directory; ?>web/analytics/vendor_analytics.php',
            method: 'POST',
            dataType: 'text',
            data: {
                username: "gbsapp",
                key: "pw2nbm9mKie8pW2O",
                id: <?php echo $uid; ?>,
                range: r,
                month: m,
                year: y,
            },
            success: function(response){
                let resp = JSON.parse(response);
                if( resp.success == true ){
                    $("#overall").html("<p>Total : Rp "+resp.message['sum']+"</p>");
                    $("#overall").append("<p>Average per Transaction : Rp "+resp.message['average']+"</p>");
                    $("#overall").append("<p>Transaction Count : "+resp.message['length']+"</p>");
                }else{
                    $("#overall").html("No Data");
                }
            }
        });
    }
</script>
</html>